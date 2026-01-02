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

    protected $queryString = [
        'page' => ['except' => 1],
        'search' => ['except' => ''],
    ];



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
}
