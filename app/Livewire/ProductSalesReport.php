<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductSalesReport extends Component
{
    // public $products;
    public $search = '';
    public $customer_id;
    public $customer;
    public $customers;
    public $startDate, $endDate, $dateRange;
    public $selectCustomerModal = false, $selectedCustomer;

    public $sortby = 'total_quantity';
    use WithPagination;
    // OPTIONAL: keep pagination when filtering/searching

    protected string $paginationTheme = 'tailwind';




    // 🔴 VERY IMPORTANT
    public function mount()
    {
        $this->startDate = now()->startOfMonth()->toDateString();
        $this->endDate = now()->endOfMonth()->toDateString();

        $this->customers = Customer::orderBy('name', 'ASC')->get();
        $this->dateRange = date('Y-m-d');
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->dateRange && str_contains($this->dateRange, 'to')) {

            $ex = explode('to', $this->dateRange);
            $this->startDate = trim($ex[0]);
            $this->endDate = trim($ex[1]);


        } elseif ($this->dateRange && !str_contains($this->dateRange, 'to')) {

            $this->startDate = $this->dateRange;
            $this->endDate = $this->dateRange;
        }
        $products = $this->loadProducts();
        return view('livewire.product-sales-report', ['products' => $products])->layout('layouts.company');
    }
    public function loadProducts()
    {
        $products = Product::query()
            ->select('products.id', 'products.name','products.value_per_unit')
            ->selectRaw('SUM(invoice_items.unit_qty) as total_quantity')
            ->selectRaw('SUM(invoice_items.total) as total_amount')
            ->join('invoice_items', 'products.id', '=', 'invoice_items.product_id')
            ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
            ->when($this->search, function ($query) {
                $query->where('products.name', 'LIKE', '%' . $this->search . '%');
            })
            ->when($this->customer_id, function ($query) {
                $query->where('invoices.customer_id', $this->customer_id);
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('invoice_items.created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);
            })
            ->groupBy('products.id', 'products.name', 'products.value_per_unit')
            ->orderBy($this->sortby, 'desc')
            ->paginate(5);

        // dd($this->products->toArray());
        return $products;
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
        // dd($this->customers);
    }
    public function addCustomerInvoice($id)
    {

        $customer = Customer::find($id);
        if ($customer) {
            $this->customer = $customer;
            $this->selectedCustomer = $customer->id;
            $this->customer_id = $id;

        }

        $this->selectCustomerModal = false;
    }
    public function removeCustomer()
    {
        $this->customer = null;
        $this->selectedCustomer = null;
        $this->customer_id = null;
    }

}
