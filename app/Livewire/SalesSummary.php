<?php

namespace App\Livewire;

use App\Enums\Invoice\Status;
use App\Models\Customer;
use App\Models\Invoice;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

use function Livewire\str;

class SalesSummary extends Component
{
    public $totalSales = 0;
    public $totalDue = 0;
    public $totalDiscount = 0;
    public $startDate;
    public $endDate;
    public $dateRange;
    public $chartData = [];
    public $selectCustomerModal = false;
    public $customerSearch = '';
    public $customers, $customer;
    public $selectedCustomer;

    public function mount()
    {
        $this->startDate = now()->toDateString();
        $this->endDate = now()->toDateString();

        $this->customers = Customer::orderBy('name', 'ASC')->get();
        $this->dateRange = date('Y-m-d');

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



        $invoiceQuery = Invoice::where('status', Status::COMPLETED->value)
            ->whereBetween('updated_at', [
                $this->startDate . ' 00:00:00',
                $this->endDate . ' 23:59:59'
            ])
            ->when($this->selectedCustomer, function ($q) {
                $q->where('customer_id', $this->selectedCustomer);
            });



        // Total Sales
        $this->totalSales = (clone $invoiceQuery)->sum('grand_total');

        // Total Discount
        $this->totalDiscount = (clone $invoiceQuery)->sum('discount');

        // Total Due (latest invoice per customer)
        $this->totalDue = Customer::whereHas('invoices', function ($q) {
            $q->where('status', Status::COMPLETED->value)
                ->whereBetween('updated_at', [
                    $this->startDate . ' 00:00:00',
                    $this->endDate . ' 23:59:59'
                ]);
        })
            ->when($this->selectedCustomer, function ($q) {
                $q->where('id', $this->selectedCustomer);
            })
            ->with([
                'invoices' => function ($q) {
                    $q->latest()->limit(1);
                }
            ])
            ->get()
            ->sum(fn($customer) => optional($customer->invoices->first())->due_amount ?? 0);

        $customers = Customer::whereHas('invoices', function ($query) {
            $query->where('status', '=', Status::COMPLETED->value);
        })->with([
                    'invoices' => function ($query) {
                        $query->latest()->limit(1);
                    }
                ])->get();
        $this->getChartDataProperty();

        $this->dispatch('pieChartRefreshed', $this->pieChart());

        // dd($this->chartData);
        return view('livewire.sales-summary')->layout('layouts.company');
    }
    public function getChartDataProperty()
    {
        // dd($this->startDate, $this->endDate);

        $chart = Invoice::where('status', '=', Status::COMPLETED->value)
            ->when($this->selectedCustomer, function ($q) {
                $q->where('customer_id', $this->selectedCustomer);
            })
            ->whereBetween('updated_at', [$this->startDate, $this->endDate])
            ->selectRaw('DATE_FORMAT(updated_at, "%Y-%m-%d") as date, SUM(grand_total) as total')
            ->groupBy('date')
            ->get();

        $chartData = [
            'date' => $chart->pluck('date')->toArray(),
            'amount' => $chart->pluck('total')->toArray()
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
        return $chartData;
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
        }

        $this->selectCustomerModal = false;
    }
    public function removeCustomer(){
        $this->customer=null;
        $this->selectedCustomer=null;
    }
}
