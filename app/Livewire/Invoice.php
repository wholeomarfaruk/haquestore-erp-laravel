<?php

namespace App\Livewire;

use App\Enums\Invoice\PaymentStatus;
use App\Enums\Product\StockStatus;
use App\Models\Invoice as ModelsInvoice;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Invoice extends Component
{
    public $search = '';

    public $invoice;
    public $invoice_id;
    public $editInvoice;
    public $viewInvoiceModal = false;
    public $editInvoiceModal = false;
    public $filterDue=false;
    public $filterPaid=false;
    public $filterUpaid=false;


    use WithPagination;
       // OPTIONAL: keep pagination when filtering/searching

    protected string $paginationTheme = 'tailwind';




    // 🔴 VERY IMPORTANT
    public function updatedSearch()
    {
        $this->resetPage();
    }


    public function render()
    {
        $search = $this->search;
        $invoices = ModelsInvoice::query()
            ->when($this->filterDue, function ($query) {
                return $query->where('due_amount', '>', 0);
            })
            ->when($this->filterPaid, function ($query) {
                return $query->where('due_amount', '=', 0);
            })
            ->when($this->filterUpaid, function ($query) {
                return $query->where('payment_status', '=', PaymentStatus::UNPAID->value);
            })
            ->when($this->search, function ($query) use ($search) {
                return $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('invoice_id', 'LIKE', '%' . $search . '%')
                        ->orWhereHas('customer', function ($subSubQuery) use ($search) {
                            $subSubQuery->where('name', 'LIKE', '%' . $search . '%')
                                ->orWhere('phone', 'LIKE', '%' . $search . '%');
                        });
                });
            })
            ->orderByDesc('updated_at')
            ->paginate(20);
        return view('livewire.invoice', compact('invoices'))->layout('layouts.company');
    }
    public function viewInvoice($id)
    {
        $this->invoice = ModelsInvoice::find($id);
        $this->viewInvoiceModal = true;
    }
    public function deleteInvoice($id)
    {
        $invoice = ModelsInvoice::find($id);
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
    }
     public function stockUpdate($invoiceId, string $action = 'subtract')
    {   //invoice number
        $invoice_number = $invoiceId;
        //check passed invoice
        if (!$invoice_number) {
            return false;
        }

        //check invoice
        $invoice = ModelsInvoice::find($invoice_number);
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
     public function resetFilter()
    {
        $this->reset(['filterDue']);
    }
}
