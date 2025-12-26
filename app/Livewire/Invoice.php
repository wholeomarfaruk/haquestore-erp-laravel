<?php

namespace App\Livewire;

use App\Models\Invoice as ModelsInvoice;
use Livewire\Component;

class Invoice extends Component
{
    public $search = '';
    public $invoices;
    public $invoice;
    public $invoice_id;
    public $editInvoice;
    public $viewInvoiceModal = false;
    public $editInvoiceModal = false;
    
    public function render()
    {
        if (!empty($this->search)) {
            // dd($this->search);
            $this->invoices = ModelsInvoice::where('invoice_id', 'LIKE', '%' . $this->search . '%')
                ->orWhereHas('customer', function ($query) {
                    $query->where('name', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('phone', 'LIKE', '%' . $this->search . '%');
                })
                ->orderByDesc('updated_at')
                ->get();
        } else {

            $this->invoices = ModelsInvoice::orderByDesc('updated_at')->get();

        }
        return view('livewire.invoice')->layout('layouts.company');
    }
}
