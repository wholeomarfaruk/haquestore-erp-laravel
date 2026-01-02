<?php

namespace App\Livewire;

use App\Models\Invoice;
use Livewire\Component;

class ViewInvoice extends Component
{
    public $invoice;
    public function mount($id)
    {
        $this->invoice = Invoice::find($id);
    }
    public function render()
    {
        return view('livewire.invoice', ['invoice' => $this->invoice])->with($this->invoice)->layout('layouts.app');
    }
}
