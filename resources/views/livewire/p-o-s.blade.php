


    <div class="mx-auto max-w-7xl p-4 sm:p-6 lg:p-8">
        {{-- Header --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">POS</h1>
                <p class="text-sm text-slate-500">Customers • Items • Payment Method</p>
            </div>

            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 text-sm shadow-sm ring-1 ring-slate-200">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    Cashier: <span class="font-medium">John</span>
                </span>
                <button type="button"
                        class="rounded-xl bg-white px-3 py-2 text-sm font-medium shadow-sm ring-1 ring-slate-200 hover:bg-slate-50">
                    New Sale
                </button>
            </div>
        </div>

        {{-- Main grid --}}
        <div class="mt-6 grid gap-6 lg:grid-cols-12">
            {{-- Left: Customers + Items --}}
            <div class="lg:col-span-7 space-y-6">
                {{-- Customer Card --}}
                <section class="rounded-2xl bg-white p-4 sm:p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold">Customer</h2>
                            <p class="text-sm text-slate-500">Choose an existing customer or enter details.</p>
                        </div>
                        <button type="button"
                                class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-medium text-white hover:bg-slate-800">
                            Add Customer
                        </button>
                    </div>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div class="space-y-1">
                            <label class="text-sm font-medium text-slate-700">Customer Name</label>
                            <input type="text" placeholder="e.g. Ahmed Ali"
                                   class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                        </div>
                        
                            
                        </div>

                        <div class="space-y-1">
                            <label class="text-sm font-medium text-slate-700">Phone</label>
                            <input type="tel" placeholder="e.g. 010xxxxxxxx"
                                   class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                        </div>

                        <div class="space-y-1 sm:col-span-2">
                            <label class="text-sm font-medium text-slate-700">Customer Lookup</label>
                            <div class="flex gap-2">
                                <input type="search" placeholder="Search customers..."
                                       class="flex-1 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                                <button type="button"
                                        class="rounded-xl bg-white px-3 py-2 text-sm font-medium shadow-sm ring-1 ring-slate-200 hover:bg-slate-50">
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Items Card --}}
                <section class="rounded-2xl bg-white p-4 sm:p-5 shadow-sm ring-1 ring-slate-200">
                    {{-- resources/views/livewire/pos.blade.php --}}
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold">Items</h2>
                            <p class="text-sm text-slate-500">{{$searchItem}}</p>
                        </div>

                        <div class="flex w-full gap-2 sm:w-auto">
                            <input type="search" placeholder="Search items or scan barcode..." wire:model.live="searchItem"
                                   class="flex-1 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-200 sm:w-72">
                            <button type="button"
                                    class="rounded-xl bg-slate-900 px-3 py-2 text-sm font-medium text-white hover:bg-slate-800">
                                Add
                            </button>
                            
                        </div>
                    </div>
                    
                    {{-- Item grid (cards) --}}
                    <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        @php
                            
                        @endphp
                        
                        @foreach ($items as $it)
                        @php $qty = $it -> inventory -> quantity ?? 0; @endphp
                        
                        <div type="button"
                        class="group flex flex-col rounded-2xl border border-slate-200 bg-white p-3 text-left shadow-sm hover:border-slate-300 hover:bg-slate-50">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                        
                                        <p class="font-medium leading-5">{{ $it-> name }}</p>
                                        <p class="mt-1 text-xs text-slate-500">{{ $it['sku'] }}</p>
                                    </div>
                                    <span class="rounded-full bg-slate-900 px-2 py-1 text-xs font-semibold text-white">
                                        {{ $it['price'] }}
                                    </span>
                                </div>

                                <div class="mt-3 flex items-center justify-between">
                                    <span class="text-xs text-slate-500">Stock</span>
                                    @if ($qty > 0)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-emerald-100">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            {{ $qty }} available
                                        </span>
                                        @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-2 py-1 text-xs font-medium text-rose-700 ring-1 ring-rose-100">
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                            Out of stock
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-3">
                                    <button wire:click="addToCart({{ $it->id }})" class="inline-flex w-full items-center justify-center rounded-xl bg-white px-3 py-2 text-sm font-medium ring-1 ring-slate-200 group-hover:bg-slate-100">
                                        {{ isset($cart[$it->id]) ? 'Added ✓' : 'Add to cart' }}
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </section>
            </div>

            {{-- Right: Cart + Payment --}}
            <div class="lg:col-span-5 space-y-6">
                {{-- Cart --}}
                <section class="rounded-2xl bg-white p-4 sm:p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-semibold">Cart</h2>
                            <p class="text-sm text-slate-500">Review items before payment.</p>
                        </div>
                        <button type="button" wire:click ='clearCart'
                                class="rounded-xl bg-white px-3 py-2 text-sm font-medium shadow-sm ring-1 ring-slate-200 hover:bg-slate-50">
                            Clear
                        </button>
                    </div>

                    <div class="mt-4 overflow-hidden rounded-2xl ring-1 ring-slate-200">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Item</th>
                                    <th class="px-3 py-2 text-center text-xs font-semibold uppercase tracking-wide text-slate-600">Qty</th>
                                    <th class="px-3 py-2 text-right text-xs font-semibold uppercase tracking-wide text-slate-600">Price</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                
                                @foreach ($cart as $c)
                                    <tr>
                                        <td class="px-3 py-3">
                                            <div class="text-sm font-medium">{{ $c['name'] }}</div>
                                            <div class="text-xs text-slate-500">Tap to edit</div>
                                        </td>
                                        <td class="px-3 py-3">
                                            <div class="flex items-center justify-center gap-2">
                                                <button wire:click="decrementQty({{$c['id']}})" type="button" class="h-8 w-8 rounded-xl bg-white ring-1 ring-slate-200 hover:bg-slate-50">−</button>
                                                <input type="text" value="{{ $c['qty'] }}"
                                                       class="w-12 rounded-xl border border-slate-200 px-2 py-1 text-center text-sm outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                                                <button wire:click ="incrementQty({{$c['id']}})" type="button" class="h-8 w-8 rounded-xl bg-white ring-1 ring-slate-200 hover:bg-slate-50">+</button>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3 text-right text-sm font-semibold">
                                            {{ number_format($c['price'] * $c['qty'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    

                    <div class="mt-4 space-y-2">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600">Subtotal</span>
                            <span class="font-medium">{{ $this->cartTotal }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600">Discount</span>
                            <span class="font-medium">0.00</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600">Tax</span>
                            <span class="font-medium">0.00</span>
                        </div>

                        <div class="mt-2 flex items-center justify-between rounded-2xl bg-slate-900 px-4 py-3 text-white">
                            <span class="text-sm font-medium">Total</span>
                            <span class="text-lg font-semibold">{{ $this->cartTotal }}</span>
                        </div>
                    </div>
                </section>

                {{-- Payment --}}
                <section class="rounded-2xl bg-white p-4 sm:p-5 shadow-sm ring-1 ring-slate-200">
                    <div>
                        <h2 class="text-lg font-semibold">Payment</h2>
                        <p class="text-sm text-slate-500">Select a payment method and finish the sale.</p>
                    </div>

                    <div class="mt-4 space-y-4">
                        <div class="space-y-1">
                            <label class="text-sm font-medium text-slate-700">Payment Method</label>
                            <select wire:model.live="paymentMethod"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="split">Split</option>
                            </select>
                           
                        </div>
                        
                         
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-slate-700"> paid amount</label>
                                <input type="number" wire:model.live="paid_amount" step="0.01" placeholder="0.00"
                                       class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                            </div>
                            @php $change = $this->getChange(); @endphp
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-slate-700">Change</label>
                                <input type="text" value="{{ number_format($change, 2) }}"  readonly
                                       class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">
                                       
                            </div>
                        </div>

                        <button type="button" wire:click='completeSale()'
                                class="w-full rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500">
                            Complete Sale
                        </button>

                        <button type="button"
                                class="w-full rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-slate-200 hover:bg-slate-50">
                            Print Receipt
                        </button>

                        <p class="text-xs text-slate-500">
                            Tip: Wire up these fields to Livewire later (customer_id, cart items, payment_method).
                        </p>
                    </div>
                </section>
            </div>
        </div>

        {{-- Footer --}}
        <div class="mt-8 text-center text-xs text-slate-400">
            POS UI • Tailwind only
        </div>
    </div>
