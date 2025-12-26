<?php

namespace App\Livewire;

use App\Enums\Invoice\PaymentStatus;
use App\Enums\Invoice\Status;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Livewire\Component;

class SalesPoint extends Component
{
    public $products;
    public $search = '';
    public $activeInvoice;
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

    // Add query string to preserve state
    protected $queryString = ['activeInvoiceId'];

    // Add listeners for custom events
    protected $listeners = ['refreshCart' => '$refresh'];


    public float $paidAmount = 0;
    public float $invoiceAmount = 0; // example



    public function mount()
    {
        $this->loadActiveInvoice();

        // 1. Start with EVERY product set to 1 by default
        $this->qtyInput = Product::pluck('id')
            ->mapWithKeys(fn($id) => [$id => 1])
            ->toArray();

        // 2. If there's an active invoice, OVERRIDE only the quantities for products in the cart
        if ($this->activeInvoice) {
            foreach ($this->activeInvoice->items as $item) {
                // This ensures if Product #5 has 10 in the cart, the input shows 10
                $this->qtyInput[$item->product_id] = $item->unit_qty;
            }
        }
        $this->customers = Customer::orderBy('id', 'DESC')->get();
        $this->loadDrafts();
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

    public function paymentAction()
    {
        // validate & save
        if ($this->radio == 'partial_paid') {
            $this->validate([
                'paidAmount' => 'required|numeric|min:0|max:' . $this->invoiceAmount
            ]);
            if ($this->paidAmount > $this->invoiceAmount) {


                $this->activeInvoice->status = Status::DUE->value;
                $this->activeInvoice->payment_status = PaymentStatus::PARTIAL->value;
                $this->activeInvoice->paid_amount = $this->paidAmount;
                $this->activeInvoice->save();

            } elseif ($this->paidAmount == $this->invoiceAmount) {
                $this->activeInvoice->status = Status::COMPLETED->value;
                $this->activeInvoice->payment_status = PaymentStatus::PAID->value;
                $this->activeInvoice->paid_amount = $this->paidAmount;
                $this->activeInvoice->save();
            }
        } elseif ($this->radio == 'full_paid') {
            $this->activeInvoice->status = Status::COMPLETED->value;
            $this->activeInvoice->payment_status = PaymentStatus::PAID->value;
            $this->activeInvoice->paid_amount = $this->paidAmount;
            $this->activeInvoice->save();
        } elseif ($this->radio == 'full_due') {
            $this->activeInvoice->status = Status::DUE->value;
            $this->activeInvoice->payment_status = PaymentStatus::UNPAID->value;
            $this->activeInvoice->paid_amount = $this->paidAmount;
            $this->activeInvoice->save();
        }
        $this->settledinvoiceId = $this->activeInvoice->id;
        $this->calculateTotals();

        // $this->confirmModalOpen = false;


    }

    public function loadDrafts()
    {
        $this->drafts = Invoice::where('status', 'draft')
            ->orderBy('id', 'DESC')
            ->get();


    }

    public function loadActiveInvoice()
    {
        if (!empty($this->activeInvoiceId)) {
            $this->activeInvoice = Invoice::with('items.product')->find($this->activeInvoiceId);
            if ($this->activeInvoice) {
                if ($this->activeInvoice->customer_id) {
                    $this->customer = $this->activeInvoice->customer;
                }
                $this->invoiceAmount = $this->activeInvoice->total;
            }
        } else {

            $this->activeInvoice = Invoice::where('status', 'draft')->first();
            if ($this->activeInvoice) {
                if ($this->activeInvoice->customer_id) {
                    $this->customer = $this->activeInvoice->customer;
                }
                $this->invoiceAmount = $this->activeInvoice->total;

                $this->activeInvoiceId = $this->activeInvoice->id;
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
        $this->confirmModalOpen = true;
        $this->settledinvoiceId=null;
        if ($this->radio == 'full_paid') {

            $this->paidAmount = $this->invoiceAmount;
        }

        if ($this->radio == 'full_due') {

            $this->paidAmount = 0;
        }

        if ($this->radio == 'partial_paid') {

        }

    }
    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        $quantityToAdd = $this->qtyInput[$productId] ?? 1;
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
            $this->activeInvoiceId = $this->activeInvoice->id;
        }

        // 2. Check if product already in invoice_items
        $item = InvoiceItem::where('invoice_id', $this->activeInvoice->id)
            ->where('product_id', $productId)
            ->first();

        if ($item) {
            // Update Quantity
            $item->unit_qty += $quantityToAdd;
            $item->total = $item->unit_qty * $item->price_after_adjustment;
            $item->save();
        } else {
            // Create New Item
            InvoiceItem::create([
                'invoice_id' => $this->activeInvoice->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_qty' => $quantityToAdd,
                'unit_name' => $product->unit_name,
                'regular_price' => $product->price,
                'price_after_adjustment' => $product->discount_price > 0 ? $product->discount_price : $product->price,
                'total' => ($product->discount_price > 0 ? $product->discount_price : $product->price) * $quantityToAdd,
            ]);
        }

        // 3. Refresh Totals
        $this->calculateTotals();
        $this->loadActiveInvoice(); // Refresh the relationship
        $this->loadDrafts(); // Refresh drafts list

        // Reset quantity input to 1 after adding
        $this->qtyInput[$productId] = 1;
    }
    public function newInvoice(){
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
            $this->activeInvoiceId = $this->activeInvoice->id;
        }

    }

    public function calculateTotals()
    {
        if (!$this->activeInvoice) {
            return;
        }

        $total = $this->activeInvoice->items()->sum('total');

        $this->activeInvoice->update([
            'total' => $total,
            'grand_total' => $total - ($this->activeInvoice->discount_amount ?? 0),
            'due_amount' => ($total - ($this->activeInvoice->discount_amount ?? 0)) - ($this->activeInvoice->paid_amount ?? 0),
        ]);

        // Refresh the active invoice data
        $this->activeInvoice->refresh();
    }

    public function removeFromCart($itemId)
    {
        $item = InvoiceItem::findOrFail($itemId);
        $productId = $item->product_id;
        $item->delete();

        // Reset quantity input to 1
        $this->qtyInput[$productId] = 1;

        $this->calculateTotals();
        $this->loadActiveInvoice();
        $this->loadDrafts();
    }

    public function setActiveInvoice($invoiceId)
    {
        $this->activeInvoiceId = $invoiceId;
        $this->loadDrafts();
        $this->loadActiveInvoice();

        // Update qtyInput for products in the new active invoice
        if ($this->activeInvoice) {
            foreach ($this->activeInvoice->items as $item) {
                $this->qtyInput[$item->product_id] = $item->unit_qty;
            }
        }

    }

    public function updateQty($productId, $action)
    {
        // Ensure the product exists in our input array
        if (!isset($this->qtyInput[$productId])) {
            $this->qtyInput[$productId] = 1;
        }

        if ($action === 'increase') {
            $this->qtyInput[$productId]++;
        } else {
            if ($this->qtyInput[$productId] > 1) {
                $this->qtyInput[$productId]--;
            }
        }

        // If this product is ALREADY in the cart, update the DB immediately
        $this->syncCartQuantity($productId);
    }

    protected function syncCartQuantity($productId)
    {
        if ($this->activeInvoice) {
            $item = $this->activeInvoice->items()->where('product_id', $productId)->first();
            if ($item) {
                $item->unit_qty = $this->qtyInput[$productId];
                $item->total = $item->unit_qty * $item->price_after_adjustment;
                $item->save();

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
            $this->activeInvoice->customer_id = $id;
            $this->activeInvoice->save();
        }
        $this->customer = Customer::find($id);
        $this->selectCustomerModal = false;
    }

    public function render()
    {
        // Load products based on search
        if (!empty($this->search)) {
            $this->products = Product::where('name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('id', 'LIKE', '%' . $this->search . '%')
                ->orWhere('price', 'LIKE', '%' . $this->search . '%')
                ->orWhere('discount_price', 'LIKE', '%' . $this->search . '%')
                ->orderByDesc('created_at')
                ->get();
        } else {
            $this->products = Product::orderByDesc('created_at')->get();
        }

        return view('livewire.sales-point')->layout('Layouts.company');

    }
}
