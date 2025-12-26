<?php

namespace App\Livewire;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Livewire\Component;

class POS extends Component
{
    public $products;
    public $search = '';
    public $activeInvoice;
    public $qtyInput = [];
    public $customerSearch = '';
    public $customers, $customer;
    public $activeInvoiceId;
    public $drafts;

    // Add query string to preserve state
    protected $queryString = ['activeInvoiceId'];

    // Add listeners for custom events
    protected $listeners = ['refreshCart' => '$refresh'];

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

        $this->loadDrafts();
    }

    public function loadDrafts()
    {
        $this->drafts = Invoice::where('status', 'draft')
            ->orderBy('id', 'DESC')
            ->get();

        if ($this->activeInvoice) {
            $activeInvoice = $this->activeInvoice;
            $this->drafts = $this->drafts->reject(function ($draft) use ($activeInvoice) {
                return $draft->id == $activeInvoice->id;
            });
        }
    }

    public function loadActiveInvoice()
    {
        if ($this->activeInvoiceId) {
            $this->activeInvoice = Invoice::with('items.product')->find($this->activeInvoiceId);
        } else {
            $this->activeInvoice = null;
        }
    }

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        $quantityToAdd = $this->qtyInput[$productId] ?? 1;

        // 1. Ensure an Active Invoice exists
        if (!$this->activeInvoice) {
            $this->activeInvoice = Invoice::create([
                'user_id' => auth()->user()->id,
                'invoice_date' => now(),
                'status' => 'draft',
                'invoice_id' => 'INV-' . strtoupper(uniqid()),
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
        $this->loadActiveInvoice();
        $this->loadDrafts();

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

        return view('livewire.p-o-s')->layout('Layouts.company');
    }
}
