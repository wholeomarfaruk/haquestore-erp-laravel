<?php

namespace App\Livewire;

use App\Enums\Invoice\DeliveryStatus;
use App\Enums\Invoice\PaymentStatus;
use App\Enums\Invoice\Status;
use App\Enums\Product\StockStatus;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class SalesPoint extends Component
{
    public $products;
    public $search = '';

    public $qtyInput = [];
    public $customerSearch = '';
    public $customers, $customer;
    public $activeInvoiceId;
    public $drafts;
    public $newCustomerName, $newCustomerPhone, $newCustomerSecondPhone, $newCustomerEmail, $newCustomerAddress, $newCustomerStatus, $newCustomerNote;
    public $registerModal = false;
    public $selectCustomerModal = false;
    public $searchCustomer = '';
    public $confirmModalOpen = false;
    public $radio = 'full_paid';
    public $paymentMethod = 'cash';
    public $settledinvoiceId;
    public $isStockOut = false;
    public $activeInvoice = [];

    // Add query string to preserve state
    protected $queryString = ['activeInvoiceId'];

    // Add listeners for custom events
    protected $listeners = ['refreshCart' => '$refresh'];


    public float $paidAmount = 0.00;
    public float $invoiceAmount = 0.00; // example
    public float $discountAmount = 0.00; // $discountAmount
    public $discountOpen = false;
    public $checkBalance = false;


    public function mount()
    {
        // $this->makeInvoice();
        if ($this->activeInvoiceId) {
            $this->synceInvoice($this->activeInvoiceId);
        } else {
            $this->makeInvoice();
        }

        // 1. Start with EVERY product set to 1 by default
        $this->qtyInput = Product::pluck('id')
            ->mapWithKeys(fn($id) => [$id => 1])
            ->toArray();

        // 2. If there's an active invoice, OVERRIDE only the quantities for products in the cart
        if ($this->activeInvoice && count($this->activeInvoice['items']) > 0) {
            foreach ($this->activeInvoice['items'] as $item) {
                // This ensures if Product #5 has 10 in the cart, the input shows 10
                $this->qtyInput[$item['id']] = $item['quantity'] ?? 1;
            }
        }
        $this->customers = Customer::orderBy('id', 'DESC')->get();
        if ($this->activeInvoiceId) {
            $this->synceInvoice($this->activeInvoiceId);
        }

    }
    public function updatedRadio($value)
    {

        if ($value == 'full_paid') {

            $this->paidAmount = $this->invoiceAmount;
        }

        if ($value == 'full_due') {

            $this->paidAmount = 0;
        }

        if ($value == 'partial_paid') {

            $this->paidAmount = 0; // reset, user will type
        }
    }
    public function updatedQtyInput($value, $key)
    {
        $this->qtyInput[$key] = $value;
        $this->syncCartQuantity($key);

    }
    protected function rules()
    {
        return [
            'paidAmount' => 'required|numeric|min:0|max:' . floatval($this->activeInvoice['grand_total'] + $this->activeInvoice['previous_due']),
        ];
    }

    public function updatedPaidAmount()
    {

        $this->validateOnly('paidAmount');

        $paidAmount = $this->paidAmount;
        $discountAmount = $this->discountAmount;
        $grandTotal = $this->activeInvoice['grand_total'];
        $duePayment = $this->activeInvoice['previous_due'];
        if ($this->paidAmount > floatval($this->activeInvoice['grand_total'] + $this->activeInvoice['previous_due'])) {


            $this->addError('paidAmount', 'Paid amount cannot be greater than invoice amount');
            return;
        }
        $this->activeInvoice['paid_amount'] = $this->paidAmount ?? 0;
        $this->calculateTotals();

    }
    public function paymentAction()
    {
        foreach ($this->activeInvoice['items'] as $item) {
            if (!$this->isStockAvailable($item['id'])) {
                $this->isStockOut = true;
                break;
            } else {
                $this->isStockOut = false;
            }
        }

        $this->checkBalance = false;
        $this->confirmModalOpen = true;
        $this->settledinvoiceId = null;

        if ($this->activeInvoice['customer_id'] == null) {

            $this->confirmModalOpen = true;
            $this->checkBalance = true;
            return;
        }

        $this->calculateTotals();

        $paidAmount = (float) $this->paidAmount;
        $invoiceTotalDue = (float) $this->invoiceAmount;
        $balance = (float) $this->customer->balance;
        $paymentMethod = $this->paymentMethod;
        $invoiceTotal = $this->activeInvoice['total'];
        $invoiceDiscount = $this->activeInvoice['discount'];
        $invoiceGrandTotal = $this->activeInvoice['grand_total'];
        $draftDueAmount = 0;


        // validate & save
        if ($this->paymentMethod == 'balance') { {

                if ($this->paidAmount > $balance) {
                    $this->confirmModalOpen = true;
                    $this->checkBalance = true;
                    return;
                }
            }
        }

        if ($this->activeInvoice['due_amount'] == 0) { //paid in full
            $this->radio = 'full_paid';
            //Upate status
            $this->activeInvoice['status'] = Status::COMPLETED->value;
            $this->activeInvoice['payment_status'] = PaymentStatus::UNPAID->value;

        } elseif ($this->activeInvoice['due_amount'] > 0 && $this->activeInvoice['due_amount'] < ($this->activeInvoice['grand_total'] + $this->activeInvoice['previous_due'])) {
            //Partial
            $this->radio = 'partial_paid';
            $this->activeInvoice['status'] = Status::COMPLETED->value;
            $this->activeInvoice['payment_status'] = PaymentStatus::DUE->value;
        } elseif (($this->activeInvoice['grand_total'] + $this->activeInvoice['previous_due']) == $this->activeInvoice['due_amount']) {
            //Unpaid
            $this->radio = 'full_due';
            $this->activeInvoice['status'] = Status::COMPLETED->value;
            $this->activeInvoice['payment_status'] = PaymentStatus::UNPAID->value;
        }
        // dd($this->activeInvoice);
        // return;



        $this->createInvoiceOrUpdate($this->activeInvoice);
        $this->activeInvoiceId = $this->activeInvoice['id'];

        // $this->confirmModalOpen = false;

    }
    public function createInvoiceOrUpdate($invoice)
    {


        if (!$invoice) {
            return false;
        }
        //create invoice
        $lastInvoice = Invoice::latest()->first();
        $lastinvoiceId = $lastInvoice ? $lastInvoice->invoice_id : null;
        $invoiceId = intval(explode('-', $lastinvoiceId)[1]) + 1;
        $invoice_id = 'INV-' . str_pad($invoiceId, 6, '0', STR_PAD_LEFT);

        $oldInvoice = Invoice::find($invoice['id']);
        if ($oldInvoice) {

            $oldInvoice->update([
                'user_id' => auth()->user()->id,
                'status' => $invoice['status'] ?? Status::COMPLETED->value,
                'payment_status' => $invoice['payment_status'] ?? PaymentStatus::UNPAID->value,
                'delivery_status' => $invoice['delivery_status'] ?? DeliveryStatus::PENDING->value,
                'total' => $invoice['total'] ?? 0.00,
                'discount' => $invoice['discount'] ?? 0.00,
                'due_amount' => $invoice['due_amount'] ?? 0.00,
                'grand_total' => $invoice['grand_total'] ?? 0.00,
                'paid_amount' => $invoice['paid_amount'] ?? 0.00,
                'invoice_id' => $invoice['invoice_id'],
                'previous_due' => $invoice['previous_due'] ?? 0.00,
                'previous_invoice_id' => $invoice['previous_invoice_id']
            ]);
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Invoice updated successfully.'
            ]);

        } else {

            $newInvoice = Invoice::create([
                'customer_id' => $invoice['customer_id'] ?? null,
                'user_id' => auth()->user()->id,
                'status' => $invoice['status'] ?? Status::COMPLETED->value,
                'payment_status' => $invoice['payment_status'] ?? PaymentStatus::UNPAID->value,
                'delivery_status' => $invoice['delivery_status'] ?? DeliveryStatus::PENDING->value,
                'total' => $invoice['total'] ?? 0.00,
                'discount' => $invoice['discount'] ?? 0.00,
                'due_amount' => $invoice['due_amount'] ?? 0.00,
                'grand_total' => $invoice['grand_total'] ?? 0.00,
                'paid_amount' => $invoice['paid_amount'] ?? 0.00,
                'invoice_id' => $invoice_id,
                'previous_due' => $invoice['previous_due'] ?? 0.00,
                'previous_invoice_id' => $invoice['previous_invoice_id']
            ]);
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Invoice created successfully.'
            ]);
        }


        if (isset($invoice['items']) && count($invoice['items']) > 0 && !$oldInvoice) {
            foreach ($invoice['items'] as $item) {
                $newInvoice->items()->create([
                    'product_id' => $item['id'],
                    'invoice_id' => $invoice_id,
                    'product_name' => $item['name'],
                    'unit_name' => $item['unit_name'],
                    'unit_qty' => $item['quantity'],
                    'regular_price' => $item['price'],
                    'total' => $item['total'],
                ]);

            }
            $this->stockUpdate($newInvoice->id, 'subtract');
        } elseif (isset($invoice['items']) && count($invoice['items']) > 0 && $oldInvoice) {
            $invoiceItems = [];
            foreach ($invoice['items'] as $item) {
                $invoiceItems[$item['id']] = [
                    'product_id' => $item['id'],
                    'invoice_id' => $invoice_id,
                    'product_name' => $item['name'],
                    'unit_name' => $item['unit_name'],
                    'unit_qty' => $item['quantity'],
                    'regular_price' => $item['price'],
                    'total' => $item['total'],
                ];
            }
            $this->stockUpdate($oldInvoice->id, 'restore');
            $oldInvoice->items()->delete();

            $oldInvoice->items()->createMany($invoiceItems);
            $this->stockUpdate($oldInvoice->id, 'subtract');
        }

        if (isset($invoice) && !$oldInvoice) {

            $customer = Customer::find($invoice['customer_id']);
            $balance = $customer->balance;
            if ($customer) {
                $customer->balance = $invoice['customer']['balance'];
                $customer->save();
            }


            $newInvoice->transections()->create([
                'amount' => $this->paidAmount,
                'before_balance' => $balance,
                'after_balance' => $invoice['customer']['balance'],
                'payment_method' => $invoice['payment_method'] ?? 'cash',
                'invoice_id' => $invoice['id'],
                'customer_id' => $invoice['customer_id'] ?? null,
                'user_id' => auth()->user()->id,
                'status' => 'paid',
                'type' => 'credit',
            ]);

        } else {


            $oldInvoice->transections()->create([
                'amount' => $this->paidAmount,
                'before_balance' => $invoice['customer']['balance'],
                'after_balance' => $invoice['customer']['balance'],
                'payment_method' => $invoice['payment_method'] ?? 'cash',
                'invoice_id' => $invoice['id'],
                'customer_id' => $invoice['customer_id'] ?? null,
                'user_id' => auth()->user()->id,
                'status' => 'paid',
                'type' => floatval($invoice['paid_amount']) > 0 ? 'credit' : 'debit',
            ]);
        }


        $generatedInvoiceId = $oldInvoice->id ?? $newInvoice->id;
        $this->settledinvoiceId = $generatedInvoiceId;
        $this->synceInvoice($generatedInvoiceId);



    }
    public function synceInvoice($activeInvoiceId)
    {
        $invoice = Invoice::find($activeInvoiceId);
        if (!$invoice) {
            return false;
        }
        if (!$invoice->customer) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Customer not found.'
            ]);
            return false;
        }

        // dd($invoice->customer->invoices()->latest('id')->value('id'));
        // return;
        if ($invoice->customer->invoices()->latest('id')->value('id') != $invoice->id) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'You can edit only last invoice of the customer.'
            ]);
            return false;
        }
        $items = [];
        foreach ($invoice->items as $item) {
            $items[$item->product_id]['id'] = $item->product_id;
            $items[$item->product_id]['name'] = $item->product_name;
            $items[$item->product_id]['price'] = $item->regular_price;
            $items[$item->product_id]['unit_name'] = $item->unit_name;
            $items[$item->product_id]['quantity'] = $item->unit_qty;
            $items[$item->product_id]['total'] = $item->total;
            $items[$item->product_id]['image'] = $item?->product?->product_image;

        }

        $this->activeInvoice = [
            'id' => $invoice->id,
            'user_id' => $invoice->user_id,
            'invoice_id' => $invoice->invoice_id,
            'customer_id' => $invoice->customer_id,
            'customer' => $invoice->customer,
            'items' => $items,   // all products
            'total' => $invoice->total,
            'discount' => $invoice->discount,
            'grand_total' => $invoice->grand_total,
            'previous_due' => $invoice->previous_due,
            'due_amount' => $invoice->due_amount,
            'paid_amount' => $invoice->paid_amount,
            'payment_status' => $invoice->payment_status,
            'status' => $invoice->status,
            'delivery_status' => $invoice->delivery_status,
            'previous_invoice_id' => $invoice->previous_invoice_id,

        ];
        $this->discountAmount = $invoice->discount;
        $this->paidAmount = $invoice->paid_amount;
        //for new invoice
        $this->customer = $invoice->customer;
    }

    public function makeInvoice()
    {
        $this->activeInvoice = [
            'id' => 'temporary_id',
            'user_id' => auth()->user()->id,
            'invoice_id' => 'New-Invoice',
            'customer_id' => null,
            'customer' => [],
            'items' => [],   // all products
            'total' => 0,
            'discount' => 0,
            'grand_total' => 0,
            'previous_due' => 0,
            'due_amount' => 0,
            'paid_amount' => 0,
            'payment_status' => 'unpaid',
            'status' => 'draft',
            'delivery_status' => 'pending',
            'previous_invoice_id' => null,
        ];
        //for new invoice

        $this->customer = null;
        $this->activeInvoiceId = null;
        $this->discountAmount = 0.00;
        $this->paidAmount = 0.00;
    }
    public function stockUpdate($invoiceId, string $action = 'subtract')
    {   //invoice number
        $invoice_number = $invoiceId;
        //check passed invoice
        if (!$invoice_number) {
            return false;
        }
        //check invoice
        $invoice = Invoice::find($invoice_number);
        if (!$invoice) {
            return false;
        }
        if ($action == 'subtract') {
            if ($invoice->items->count() > 0) {
                foreach ($invoice->items as $item) {
                    $product = Product::find($item->product_id);
                    $product->stock -= $item->unit_qty;
                    if($product->stock <= 0){
                        $product->stock_status = StockStatus::STOCK_OUT->value;
                    }
                    $product->save();
                    $usedUnits = (float) ($product->stock / $product->value_per_unit);
                    if ($usedUnits < $product->unit_value) {
                        $product->unit_value = $usedUnits;
                        $product->save();
                    }
                }
            }
        } elseif ($action == 'restore') {
            if ($invoice->items->count() > 0) {
                foreach ($invoice->items as $item) {
                    $product = Product::find($item->product_id);
                    $product->stock += $item->unit_qty;
                    $product->stock_status = StockStatus::IN_STOCK->value;
                    $product->save();
                    $usedUnits = (float) ($product->stock / $product->value_per_unit);
                    if ($usedUnits > $product->unit_value) {
                        $product->unit_value = $usedUnits;
                        $product->save();
                    }
                }
            }
        }

    }


    public function updatedSearchCustomer($value)
    {
        if ($this->searchCustomer) {
            $this->customers = Customer::where('name', 'like', '%' . $this->searchCustomer . '%')
                ->orWhere('phone', 'like', '%' . $this->searchCustomer . '%')
                ->orWhere('email', 'like', '%' . $this->searchCustomer . '%')
                ->orWhere('second_phone', 'like', '%' . $this->searchCustomer . '%')
                ->orWhere('address', 'like', '%' . $this->searchCustomer . '%')
                ->orderBy('id', 'DESC')->get();
        } else {
            $this->customers = Customer::orderBy('id', 'DESC')->get();
        }
    }
    public function confirmModalOpenAction()
    {
        foreach ($this->activeInvoice['items'] as $item) {
            if (!$this->isStockAvailable($item['id'])) {
                $this->isStockOut = true;
                break;
            } else {
                $this->isStockOut = false;
            }


        }
        $this->checkBalance = false;
        $this->confirmModalOpen = true;
        $this->settledinvoiceId = null;


        $this->calculateTotals();

        if ($this->radio == 'full_paid') {

            $this->paidAmount = $this->invoiceAmount;
        }

        if ($this->radio == 'full_due') {

            $this->paidAmount = 0;
        }

        if ($this->radio == 'partial_paid') {

        }

    }
    public function openDiscount($action)
    {
        if ($action == 'open') {
            $this->discountOpen = true;

            $this->discountAmount = $this->activeInvoice['discount'];
        }
        if ($action == 'close') {
            $this->discountOpen = false;
            $this->activeInvoice['discount'] = $this->discountAmount ?? 0;
            $this->calculateTotals();
        }



    }
    public function updatedDiscountAmount($value)
    {
        $total = $this->activeInvoice['total'];

        if ($value < 0) {
            $this->discountAmount = 0;
            $this->addError('discountAmount', 'Discount amount cannot be negative.');
            return;
        }

        if ($value > $total) {
            $this->discountAmount = $total;
            $this->addError('discountAmount', 'Discount cannot exceed invoice total.');
            return;
        }
        $this->activeInvoice['discount'] = $this->discountAmount ?? 0;
        $this->calculateTotals();
        $this->updatedPaidAmount();
        $this->resetErrorBag('discountAmount');
    }

    public function addToCart($productId)
    {
        // find product
        $product = Product::findOrFail($productId);

        $quantityToAdd = $this->qtyInput[$productId] ?? 1;

        if($this->activeInvoice['status'] == Status::COMPLETED->value){
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Invoice already completed.'
            ]);
            return false;
        }
        $items = $this->activeInvoice['items'];

        if (isset($items[$productId])) {
            $item = $items[$productId];
            $item['quantity'] = $quantityToAdd;
        } else {
            $item = [
                'id' => $productId,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantityToAdd,
                'total' => $product->price * $quantityToAdd,
                'image' => $product->product_image,
                'unit_name' => $product->unit_name
            ];
        }
        $this->activeInvoice['items'][$productId] = $item;
        $this->calculateTotals();



    }
    public function newInvoice()
    {
        $this->activeInvoice = null;
        $nextId = (Invoice::max('id') ?? 0) + 1;

        $invoiceId = 'INV-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
        // 1. Ensure an Active Invoice exists
        if (!$this->activeInvoice) {
            $this->activeInvoice = Invoice::create([
                'user_id' => auth()->user()->id,
                'invoice_date' => now(),
                'status' => 'draft',
                'invoice_id' => $invoiceId,
            ]);
            $this->activeInvoiceId = $this->activeInvoice['id'];
        }

    }

    public function calculateTotals()
    {
        if (!$this->activeInvoice) {
            return;
        }
            //  dd($this->activeInvoice);

        $total = collect($this->activeInvoice['items'])->sum('total');
        $previous_due = 0;

        $this->activeInvoice['discount'] = $this->discountAmount ?? 0;
        $this->activeInvoice['paid_amount'] = $this->paidAmount ?? 0;
        if (!isset($this->activeInvoice['previous_invoice_id']) && $this->activeInvoice['previous_invoice_id'] == null && $this->activeInvoice['customer_id']) {
            $customer = Customer::find($this->activeInvoice['customer_id']);
            $invoice = $customer->invoices()->latest()->first();
            $lastInvoiceId = $customer->invoices()->latest('id')->first()?->id;
            $count = $customer->invoices()?->count() ?? 0;


            if ($invoice && $count >= 1 && $this->activeInvoice['id'] > $lastInvoiceId) {
                $this->activeInvoice['previous_invoice_id'] = $invoice?->invoice_id;
                $previous_due = abs($invoice->due_amount);
            } else {
                $this->activeInvoice['previous_invoice_id'] = null;
                $previous_due = 0;
            }


        } elseif ($this->activeInvoice['previous_invoice_id'] && $this->activeInvoice['status'] == Status::DRAFT->value) {
            $customer = Customer::find($this->activeInvoice['customer_id']);
            $invoice = $customer->invoices()->latest()->first();
            if ($invoice) {
                $this->activeInvoice['previous_invoice_id'] = $invoice?->invoice_id;
                $previous_due = abs($invoice->due_amount);
            } else {
                $this->activeInvoice['previous_invoice_id'] = null;
                $previous_due = 0;
            }

        } elseif ($this->activeInvoice['previous_invoice_id']) {

            // $onlyid = intval(explode('-', $this->activeInvoice['previous_invoice_id'])[1]);
            $invoice = Invoice::where('invoice_id', '=', $this->activeInvoice['previous_invoice_id'])->first();

            $this->activeInvoice['previous_invoice_id'] = $invoice?->invoice_id;
            $previous_due = abs($invoice->due_amount);
        }



        $this->activeInvoice['total'] = $total;
        $this->activeInvoice['previous_due'] = $previous_due;
        $this->activeInvoice['grand_total'] = $total - ($this->activeInvoice['discount'] ?? 0);
        $this->activeInvoice['due_amount'] = ($total - ($this->activeInvoice['discount'] ?? 0)) - ($this->activeInvoice['paid_amount'] ?? 0) + $previous_due;
        $this->invoiceAmount = $this->activeInvoice['due_amount'];
    }

    public function removeFromCart($itemId)
    {
        $item = $this->activeInvoice['items'][$itemId];
        unset($this->activeInvoice['items'][$itemId]);

        // Reset quantity input to 1
        $this->qtyInput[$itemId] = 1;

        $this->calculateTotals();

    }

    public function setActiveInvoice($invoiceId)
    {
        $this->activeInvoiceId = $invoiceId;

        // Update qtyInput for products in the new active invoice
        if ($this->activeInvoice) {
            foreach ($this->activeInvoice['items'] as $item) {
                $this->qtyInput[$item->product_id] = $item['quantity'];
            }
        }

    }

    protected function syncCartQuantity($productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            return false;
        }
        if (isset($this->qtyInput[$productId]) && $this->qtyInput[$productId] > $product->stock) {
            $this->qtyInput[$productId] = $product->stock;
        }

        if (isset($this->activeInvoice['items'][$productId])) {
            $item = $this->activeInvoice['items'][$productId];

            if ($item) {
                $this->activeInvoice['items'][$productId]['quantity'] = $this->qtyInput[$productId];

                $this->activeInvoice['items'][$productId]['total'] = floatval($item['price']) * floatval($this->activeInvoice['items'][$productId]['quantity']);
                // dd($this->activeInvoice['items'][$productId]['total']);
                $this->calculateTotals(); // Refresh the grand total
            }
        }

    }
    public function registerCustomer()
    {
        $this->validate([
            'newCustomerName' => 'required|min:3',
            'newCustomerPhone' => 'min:11',
        ]);

        $customer = new Customer();
        $customer->name = $this->newCustomerName;
        $customer->phone = $this->newCustomerPhone;
        if ($this->newCustomerSecondPhone) {
            $customer->second_phone = $this->newCustomerSecondPhone;
        }
        if ($this->newCustomerEmail) {
            $customer->email = $this->newCustomerEmail;
        }
        if ($this->newCustomerAddress) {
            $customer->address = $this->newCustomerAddress;
        }
        if ($this->newCustomerStatus) {
            $customer->status = $this->newCustomerStatus;
        }
        if ($this->newCustomerNote) {
            $customer->note = $this->newCustomerNote;
        }
        $customer->save();
        $this->customers = Customer::all();
        $this->registerModal = false;
    }
    public function addCustomerInvoice($id)
    {
        if ($this->activeInvoice) {
            $this->activeInvoice['customer_id'] = $id;
            $this->activeInvoice['customer'] = Customer::find($id)->toArray();
        }

        $this->customer = Customer::find($id);

        $this->calculateTotals();
        $this->selectCustomerModal = false;
    }
    public function isStockAvailable($id)
    {
        $product = Product::where('id', $id)->where('stock_status', StockStatus::IN_STOCK->value)->first();
        $item = $this->activeInvoice['items'][$id];
        if (!$product) {
            return false;
        }
        if ($product->unit_value <= 0) {
            return false;
        }
        if ($product->stock <= 0) {
            return false;
        }
        if ($product->stock < $item['quantity']) {
            return false;
        }
        return true;
    }
public function deleteInvoice($id)
    {
        $invoice = Invoice::find($id);
        if(!$invoice){
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Invoice not found.'
            ]);
            return false;
        }
        if($invoice->customer_id ==null && $invoice?->customer == null){
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Customer not found.'
            ]);
            return false;
        }
        $lastInvoice = $invoice->customer->invoices()->latest('id')->first();
        if($lastInvoice->id != $invoice->id){
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'You can delete only last invoice of the customer.'
            ]);
            return false;
        }
        if($invoice->items()->count() > 0){
           $this->stockUpdate($invoice->id, 'restore');
        }
        $invoice->delete();
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Invoice deleted successfully.'
        ]);
        $this->activeInvoiceId = null;
        
        $this->makeInvoice();

    }
    public function render()
    {
        $this->products = Product::orderByRaw('CASE WHEN stock > 0 THEN 0 ELSE 1 END') // stock >0 first
            ->orderByDesc('created_at') // then newest first
            ->get();


        if (!empty($this->search)) {
            $search = $this->search;

            $this->products = Product::where('name', 'like', "%$search%")
                ->orWhere('id', 'like', "%$search%")
                ->orWhere('price', 'like', "%$search%")
                ->orderByRaw('CASE WHEN stock > 0 THEN 0 ELSE 1 END') // stock >0 first
                ->orderByDesc('created_at') // then newest first
                ->get();
        }
        return view('livewire.sales-point')->layout('layouts.company');

    }
}
