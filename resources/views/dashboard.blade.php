<div class="min-h-screen bg-gray-50 dark:bg-neutral-950">
    <style>
        .stat-card { transition: box-shadow 0.2s, transform 0.2s; }
        .stat-card:hover { box-shadow: 0 8px 32px 0 rgba(0,0,0,0.10); transform: translateY(-2px); }
        .bar-col { transition: opacity 0.2s; }
        .bar-col:hover { opacity: 0.75; }
        .action-btn { transition: background 0.15s, opacity 0.15s; }
        .row-hover { transition: background 0.15s; }
        .row-hover:hover { background: rgba(0,0,0,0.04); }
    </style>

    {{-- Header --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Dashboard</h1>
            <p class="text-xs text-gray-400 mt-0.5">{{ now()->format('l, F j, Y') }}</p>
        </div>
        <div class="h-9 w-9 rounded-full bg-indigo-600 flex items-center justify-center text-white text-sm font-bold shadow">
            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 pb-10 space-y-6">

        {{-- ── Stat Cards ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="stat-card bg-indigo-600 text-white p-5 rounded-2xl shadow">
                <div class="flex items-start justify-between">
                    <div class="space-y-1">
                        <p class="text-sm font-medium opacity-80">Today's Sales</p>
                        <p class="text-2xl font-bold tracking-tight">{{ $todayTotal }} $</p>
                        <p class="text-xl font-medium opacity-80 {{ $yesterDayTotal < $todayTotal ? 'text-green-500' : 'text-red-500' }}">{{ $todayTotal - $yesterDayTotal }} $ vs yesterday</p>
                    </div>
                    <div class="p-2.5 rounded-xl bg-white/20">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-white dark:bg-neutral-900 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-800">
                <div class="flex items-start justify-between">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-gray-500">Transactions</p>
                        <p class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $todaySales }}</p>
                        <p class="text-xs text-gray-400">Today</p>
                    </div>
                    <div class="p-2.5 rounded-xl bg-gray-100 dark:bg-neutral-800">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-white dark:bg-neutral-900 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-800">
                <div class="flex items-start justify-between">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-gray-500">Monthly Revenue</p>
                        <p class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $yearMonthSales }} $</p>
                        <p class="text-xs text-gray-400">{{ now()->format('F Y') }}</p>
                    </div>
                    <div class="p-2.5 rounded-xl bg-gray-100 dark:bg-neutral-800">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-white dark:bg-neutral-900 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-800">
                <div class="flex items-start justify-between">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-gray-500">Avg. Sale Value</p>
                        <p class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ number_format($avgTodaySales, 0) }}</p>
                        <p class="text-xs text-gray-400">Today</p>
                    </div>
                    <div class="p-2.5 rounded-xl bg-gray-100 dark:bg-neutral-800">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── Chart + Quick Actions + Payment ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            <div class="lg:col-span-2 bg-white dark:bg-neutral-900 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-800 p-5">
    <h3 class="font-semibold text-base text-gray-900 dark:text-white">Sales This Week</h3>
    <p class="text-xs text-gray-400 mt-0.5 mb-4">Daily revenue breakdown</p>
    <div id="weeklyChart"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            chart: {
                type: 'area',
                height: 200,
                toolbar: { show: false },
                background: 'transparent',
            },
            series: [{
                name: 'Revenue',
                data: @json($weeklySales->pluck('total'))
            }],
            xaxis: {
                categories: @json($weeklySales->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('D')))
            },
            colors: ['#4f46e5'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.0,
                }
            },
            stroke: { curve: 'smooth', width: 2 },
            dataLabels: { enabled: false },
            grid: { borderColor: '#f1f1f1' },
            theme: { mode: 'light' }
        };

        var chart = new ApexCharts(document.querySelector("#weeklyChart"), options);
        chart.render();
    });
</script>

            {{-- Quick Actions + Payment --}}
            <div class="space-y-4">

                {{-- Quick Actions --}}
                <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-800 p-5">
                    <h3 class="font-semibold text-base text-gray-900 dark:text-white mb-3">Quick Actions</h3>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('pos') }}" class="action-btn flex items-center gap-2.5 h-11 px-4 rounded-xl bg-indigo-600 text-white font-medium text-sm hover:opacity-90">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Open POS
                        </a>
                        <a href="{{ route('Item.create') }}" class="action-btn flex items-center gap-2.5 h-11 px-4 rounded-xl border border-gray-200 dark:border-neutral-700 text-sm font-medium hover:bg-gray-50 dark:hover:bg-neutral-800">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Add Item
                        </a>
                        <a href="{{ route('sales.index') }}" class="action-btn flex items-center gap-2.5 h-11 px-4 rounded-xl border border-gray-200 dark:border-neutral-700 text-sm font-medium hover:bg-gray-50 dark:hover:bg-neutral-800">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            View All Sales
                        </a>
                    </div>
                </div>

                {{-- Payment Breakdown --}}
                <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-800 p-5">
                    <h3 class="font-semibold text-base text-gray-900 dark:text-white">Payment Methods</h3>
                    <p class="text-xs text-gray-400 mt-0.5 mb-3">Today's breakdown</p>
                    @forelse($topPaymentMethod as $topMethod)
                        <div class="mb-3 last:mb-0 space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="h-8 w-8 rounded-lg bg-gray-100 dark:bg-neutral-800 flex items-center justify-center">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white capitalize">{{ $topMethod->payment_method }}</p>
                                        <p class="text-xs text-gray-400">{{ $topMethod->total }}$</p>
                                    </div>
                                </div>
                            </div>
                            <div class="h-2 bg-gray-100 dark:bg-neutral-800 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-600 rounded-full"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-4">No payments today</p>
                    @endforelse
                </div>

            </div>
        </div>

        {{-- ── Recent Sales + Top Selling + Inventory ── --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- Recent Sales --}}
            <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-800 p-5">
                <h3 class="font-semibold text-base text-gray-900 dark:text-white">Recent Sales</h3>
                <p class="text-xs text-gray-400 mt-0.5 mb-3">Latest transactions today</p>
                <div class="space-y-1">
                    @forelse ($recentSales as $recent)
                        <div class="row-hover flex items-center justify-between py-2.5 px-3 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-xl bg-gray-100 dark:bg-neutral-800 flex items-center justify-center">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $recent->invoice_number }}</p>
                                    <p class="text-xs text-gray-400">{{ $recent->customer?->name ?? 'Walk-in' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $recent->total }}$</p>
                                <p class="text-xs text-gray-400">{{ $recent->created_at->format('h:i A') }}</p>
                            </div>
                            <button wire:click="viewReceipt({{ $recent->id }})"
                                    class="text-xs px-3 py-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 font-medium hover:bg-indigo-100">
                                View
                            </button>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-6">No sales today yet</p>
                    @endforelse
                </div>
            </div>

            {{-- Top Selling --}}
            <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-800 p-5">
                <h3 class="font-semibold text-base text-gray-900 dark:text-white">Top Selling Today</h3>
                <p class="text-xs text-gray-400 mt-0.5 mb-3">Best performers</p>
                <div class="space-y-3">
                    @forelse($topSelling as $topSell)
                        <div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-gray-400 w-4">{{ $loop->iteration }}</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $topSell->name }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-xs text-gray-400">
                                    <span>{{ $topSell->total_qty }}pcs</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $topSell->total_rev }}$</span>
                                </div>
                            </div>
                            <div class="h-1 bg-gray-100 dark:bg-neutral-800 rounded-full overflow-hidden mt-1">
                                <div class="h-full bg-indigo-600 rounded-full"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-6">No sales today yet</p>
                    @endforelse
                </div>
            </div>

            {{-- Inventory Alerts --}}
            <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-sm border border-gray-100 dark:border-neutral-800 p-5">
                <h3 class="font-semibold text-base text-gray-900 dark:text-white">Inventory Alerts</h3>
                <p class="text-xs text-gray-400 mt-0.5 mb-3">Low stock items need attention</p>
                <div class="space-y-4">

                    {{-- Out of Stock --}}
                    <div class="space-y-2">
                        <div class="flex items-center gap-1.5 text-xs font-semibold text-red-500 uppercase tracking-wider">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                            Out of Stock
                        </div>
                        @forelse($outOfStock as $outStock)
                            <div class="flex items-center justify-between py-2 px-3 rounded-xl bg-red-50 dark:bg-red-900/10">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $outStock->name }}</span>
                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-red-500 text-white">OUT</span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 text-center py-2">None ✅</p>
                        @endforelse
                    </div>

                    {{-- Low Stock --}}
                    <div class="space-y-2">
                        <div class="flex items-center gap-1.5 text-xs font-semibold text-amber-500 uppercase tracking-wider">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            Low Stock
                        </div>
                        @forelse($lowStock as $lowStockItem)
                            <div class="flex items-center justify-between py-2 px-3 rounded-xl bg-amber-50 dark:bg-amber-900/10">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $lowStockItem->name }}</span>
                                <span class="text-xs text-gray-400">
                                    <span class="font-bold text-amber-500">{{ $lowStockItem->inventory->quantity }}</span> left
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 text-center py-2">None ✅</p>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>

        {{-- Receipt Modal --}}
        @if ($showReceiptModal && $selectedSaleId)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-xl w-full max-w-lg mx-4 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                        Invoice: {{ $selectedSale->invoice_number }}
                    </h2>
                    <button wire:click="closeReceipt" class="text-gray-400 hover:text-gray-600 text-xl">✕</button>
                </div>
                @include('livewire.sales.sale-details', ['sale' => $selectedSale])
            </div>
        </div>
        @endif

    </div>
</div>