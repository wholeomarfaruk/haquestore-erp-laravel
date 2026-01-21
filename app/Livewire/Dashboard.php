<?php

namespace App\Livewire;
use App\Enums\Invoice\Status;
use App\Models\Invoice;
use Livewire\Component;

class Dashboard extends Component
{
    public $startDate;
    public $endDate;
    public $dateRange;
    public $chartData = [];
    public $totalSales = 0;
    public $monthlySales = 0;
    public $todaySales = 0;
    public $totalDue = 0;
    public $recentInvoices;
    public function mount()
    {
        $this->startDate = date('Y-m-01');
        $this->endDate = date('Y-m-t');
        $this->dateRange = date('Y-m-d');
        $this->getChartDataProperty();
        $this->getStats();
        $this->recentInvoices = Invoice::latest()->limit(3)->get();

    }
    public function render()
    {

        return view('livewire.dashboard')->layout('layouts.company');
    }

    public function getChartDataProperty()
    {
        // dd($this->startDate, $this->endDate);

        $chart = Invoice::where('status', '=', Status::COMPLETED->value)
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
    public function getStats(){
        $this->totalSales = Invoice::where('status', '=', Status::COMPLETED->value)->sum('grand_total');
        $this->monthlySales = Invoice::where('status', '=', Status::COMPLETED->value)->whereBetween('updated_at', [$this->startDate, $this->endDate])->sum('grand_total');
        $this->todaySales = Invoice::where('status', '=', Status::COMPLETED->value)->whereBetween('updated_at', [now()->startOfDay(), now()->endOfDay()])->sum('grand_total');
        $this->totalDue = Invoice::where('status', '=', Status::COMPLETED->value)->where('due_amount', '>', 0)->sum('due_amount');
    }
}
