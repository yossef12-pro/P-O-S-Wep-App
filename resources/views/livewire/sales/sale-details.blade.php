<div class="p-2 space-y-4 z-300">

    {{-- Sale Info --}}
    <div class="grid grid-cols-2 gap-3 text-sm">
        <div class="rounded-xl bg-slate-50 px-4 py-3">
            <p class="text-slate-500">Date</p>
            <p class="font-medium mt-0.5">23/03/2026 08:00 AM</p>
        </div>
        <div class="rounded-xl bg-slate-50 px-4 py-3">
            <p class="text-slate-500">Payment Method</p>
            <p class="font-medium mt-0.5">{{$sale->payment_method}}</p>
        </div>
        <div class="rounded-xl bg-slate-50 px-4 py-3">
            <p class="text-slate-500">Customer</p>
            <p class="font-medium mt-0.5">Walk-in</p>
        </div>
        <div class="rounded-xl bg-slate-50 px-4 py-3">
            <p class="text-slate-500">Discount</p>
            <p class="font-medium mt-0.5">{{$sale->discount}}</p>
        </div>
    </div>

    {{-- Items Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-200">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 py-2.5 text-left font-medium text-slate-600">Item</th>
                    <th class="px-4 py-2.5 text-center font-medium text-slate-600">Qty</th>
                    <th class="px-4 py-2.5 text-right font-medium text-slate-600">Price</th>
                    <th class="px-4 py-2.5 text-right font-medium text-slate-600">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach ($sale->saleItems as $saleItem)
                <tr>
                    <td class="px-4 py-3">{{$saleItem->item->name}}</td>
                    <td class="px-4 py-3 text-center">{{$saleItem->quantity}}</td>
                    <td class="px-4 py-3 text-right">{{$saleItem->price}}</td>
                    <td class="px-4 py-3 text-right font-medium">{{$saleItem->quantity * $saleItem->price }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    {{-- Totals --}}
    <div class="rounded-xl border border-slate-200 divide-y divide-slate-200 text-sm">
        <div class="flex justify-between px-4 py-3">
            <span class="text-slate-500">Total</span>
            <span class="font-semibold">{{$sale->total}}</span>
        </div>
        <div class="flex justify-between px-4 py-3">
            <span class="text-slate-500">Paid</span>
            <span class="font-semibold">{{$sale->paid_amount}}</span>
        </div>
        <div class="flex justify-between px-4 py-3 bg-slate-50 rounded-b-xl">
            <span class="text-slate-500">Change</span>
            <span class="font-semibold text-emerald-600">{{$sale->change}}</span>
        </div>
    </div>

</div>