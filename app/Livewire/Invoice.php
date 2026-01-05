<?php

namespace App\Livewire;

use App\Models\Invoice as ModelsInvoice;
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
        $invoices=collect();
        if (!empty($this->search)) {
            // dd($this->search);
            $invoices = ModelsInvoice::where('invoice_id', 'LIKE', '%' . $this->search . '%')
                ->orWhereHas('customer', function ($query) {
                    $query->where('name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('phone', 'LIKE', '%' . $this->search . '%');
                })
                ->orderByDesc('updated_at')
                ->paginate(20);
        } else {

            $invoices = ModelsInvoice::orderByDesc('updated_at')->paginate(20);

        }
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
        $invoice->delete();
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Invoice deleted successfully.'
        ]);
    }
}
