<?php

namespace App\Livewire;

use App\Models\item;
use App\Models\Sales;
use Livewire\Component;


class Dashboard extends Component
{
    public $allSales;
    public $todayTotal;
    public $todaySales;
    public $yesterDayTotal;
    public $yesterDaySales;
    public $avgTodaySales;
    public $yearMonthSales;
    public $recentSales;
    public $topPaymentMethod;
    public $selectedSaleId = null;
    public $showReceiptModal = false;
    public $topSelling;
    public $outOfStock;
    public $lowStock;

    public function mount()
    {
        $this->allSales = Sales::count(); // the count of all sales
       $this->todayTotal = Sales::whereDate('created_at',today())->sum('total'); // the total income today
        $this->todaySales = Sales::whereDate('created_at',today())->count(); // the count of sales today
        $this->yesterDayTotal = Sales::whereDate('created_at',now()->subDay())->count(); // the count of sales yesterday
        $this->yesterDaySales = Sales::whereDate('created_at',now()->subDay())->count(); // the count of sales yesterday
        $this->yearMonthSales = Sales::whereMonth('created_at',now()->month)->whereYear('created_at',now()->year) ->sum('total');
        $this->avgTodaySales = Sales::whereDate('created_at',today())->avg('total');


        $this->recentSales = Sales::latest()->take(5)->get();
        $this->topPaymentMethod = Sales::selectRaw('payment_method, sum(total) as total')->groupBy('payment_method')->get();

        $this ->topSelling = item::select('items.id', 'items.name')
    ->selectRaw('SUM(sale_items.quantity) as total_qty, SUM(sale_items.quantity * sale_items.price) as total_rev')
    ->join('sale_items', 'items.id', '=', 'sale_items.item_id')
    ->groupBy('items.id', 'items.name')
    ->orderByDesc('total_qty','total_rev')
    ->take(5)
    ->get();

       $this->outOfStock = item::whereHas('inventory',function($q){
        $q->where('quantity', 0);
       })->get();
       $this->lowStock = item::with('inventory')->whereHas('inventory',function($q){
       $q-> whereBetween('quantity',[1,10]);
       })->get();

    }
    public function viewReceipt($saleId)
{
    $this->selectedSaleId = $saleId;
    $this->showReceiptModal = true;
}

public function closeReceipt()
{
    $this->selectedSaleId = null;
    $this->showReceiptModal = false;
}

    public function render()
    {
        $selectedSale = $this->selectedSaleId
        ? Sales::with('saleItems.item', 'customer')->find($this->selectedSaleId)
        : null;

        $weeklySales = Sales::selectRaw('DATE(created_at) as date, SUM(total) as total')
        ->whereBetween('created_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        return view('dashboard',compact('selectedSale','weeklySales'));
    }
}