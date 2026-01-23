<?php

namespace App\Livewire;

use App\Enums\Invoice\Status;
use App\Models\Customer;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Request;

class IndividualProductReport extends Component
{
    public $product,$total_quantity,$total_amount,$startDate,$endDate,$dateRange,$chartData,$totalSales,$monthlySales,$todaySales,$totalDue;
public $search='';
public $selectCustomerModal=false,$customer_id,$customers,$selectedCustomer,$customer;
public $openProductModal=false;
public $product_id;
public $products;
public $totalDiscount=0;
public $totalUnit=0;
public $filteredProducts;

    public function mount(Request $request){
        $this->product_id = $request->product_id ?? null;
        $this->product = Product::find($this->product_id);
         $this->startDate = now()->startOfMonth()->toDateString();
        $this->endDate = now()->endOfMonth()->toDateString();

        $this->customers = Customer::latest()->get();
        $this->dateRange = date('Y-m-d');
        $this->products = Product::latest()->get();
        $this->totalDiscount=0;
        $this->totalDue= 0;

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
        // dd($this->startDate, $this->endDate);
        $product=$this->loadProducts();

// $this->getChartDataProperty();
        return view('livewire.individual-product-report')->layout('layouts.company');
    }

    public function loadProducts()
    {
        $products = InvoiceItem::query()

            ->when($this->product_id, function ($query) {
                $query->where('invoice_items.product_id', $this->product_id);
            })
            ->when($this->customer_id, function ($query) {
                $query->wherehas('invoice', function ($q) {
                    $q->where('customer_id', $this->customer_id);
                });
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereBetween('invoice_items.created_at', [$this->startDate. ' 00:00:00' , $this->endDate. ' 23:59:59']);
            })
            ->orderBy('updated_at', 'desc')
            ->get();

            $total_quantity = $products->sum('unit_qty');
            $total_amount = $products->sum('total');

            $this->total_quantity = $total_quantity;
            $this->total_amount = $total_amount;
            $this->totalSales = $total_amount;
            $this->totalUnit = floatval($total_quantity) / floatval($this->product->value_per_unit);

            $this->filteredProducts = $products;

        // dd($this->chartData);
        // dd($products->toArray());
        return $products;
    }

    public function selectProduct($id){
        $this->product = Product::find($id);
        $this->product_id = $id;
        $this->openProductModal = true;
    }
    public function removeProduct(){
        $this->product = null;
        $this->openProductModal = false;
    }
        public function getChartDataProperty()
    {
        // dd($this->startDate, $this->endDate);

        // $chart = Invoice::where('status', '=', Status::COMPLETED->value)
        //     ->when($this->selectedCustomer, function ($q) {
        //         $q->where('customer_id', $this->selectedCustomer);
        //     })
        //     ->whereBetween('updated_at', [$this->startDate, $this->endDate])
        //     ->selectRaw('DATE_FORMAT(updated_at, "%Y-%m-%d") as date, SUM(grand_total) as total')
        //     ->groupBy('date')
        //     ->get();

        $chartData = [
            'date' => ['1', '2', '3'],
            'amount' => ['500','1000','2000']
        ];
        $this->chartData = $chartData;
        // $this->dispatch('chartRefreshed');
        $this->dispatch('chartRefreshed', [
            'type' => 'success',
            'message' => 'Chart Refreshed',
            'labels' => $chartData['date'],
            'data' => $chartData['amount'],
        ]);
        // dd(response()->json($chartData));
        return ;
    }

    public function pieChart()
    {
        return [
            'sale' => (float) $this->totalSales,
            'discount' => (float) $this->totalDiscount,
            'due' => (float) $this->totalDue,
        ];

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
            $this->selectedCustomer=$customer->id;
        $this->customer_id = $id;

        }

        $this->selectCustomerModal = false;
    }
    public function removeCustomer(){
        $this->customer=null;
        $this->selectedCustomer=null;
        $this->customer_id = null;
    }
}
