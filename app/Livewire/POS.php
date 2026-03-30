<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Sales;
use App\Models\SaleItem;
use Illuminate\Support\Str;
use App\Models\Item;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
class POS extends Component
{
    public $customer;
    public $paymentMethod = 'cash';
    public $searchItem = '';
    public $cart = [];
    public $receipt =[];
    public $items =[];
    public $success;

    public $customer_id = null;
    public $payment_method_id ;
    public $paid_amount;
    public $discount_amount = 0;

    public function mount()
    {
        $this->items = Item::with('inventory')
        ->where('status', 'active')
        ->whereHas('inventory', fn($q) => $q->where('quantity', '>', 0))
        ->get();
    }

    public function render()
    {
        $items = Item::with('inventory')
            ->whereHas('inventory', function (EloquentBuilder $builder) {
                $builder->where('quantity', '>', 0);
            })
            ->where('Status', 'active')
            ->when($this->searchItem, function ($q) {
                $q->where(function ($qq) {
                    $qq->where('name', 'like', "%{$this->searchItem}%")
                       ->orWhere('sku', 'like', "%{$this->searchItem}%");
                });
            })
            ->get();

        return view('livewire.p-o-s', compact('items'));
    }

    // ─── CART METHODS ────────────────────────────────────────────

    public function addToCart($itemId)
    {
        $itemId = (int) $itemId;
        $item = collect($this->items)->firstWhere('id', $itemId);
        $maxQty = $item->inventory->quantity ?? 0;
        // search cart by value — find the index of this item if it exists
        $key = collect($this->cart)->search(fn($c) => $c['id'] === $itemId);

        if ($key !== false) {
            // item already in cart — increase qty if not at max
            if ($this->cart[$key]['qty'] < $this->cart[$key]['max_qty']) {
                $this->cart[$key]['qty']++;
            }
        } else {
            // item not in cart yet — push it in
            $this->cart[] = [
                'id'      => $itemId,
                'name'    => $item->name,
                'price'   => $item->price,
                'qty'     => 1,
                'max_qty' => $maxQty,
            ];
        }
    }

    public function incrementQty($itemId)
    {
        $itemId = (int) $itemId;

        // find which index in cart has this item id
        $key = collect($this->cart)->search(fn($c) => $c['id'] === $itemId);

        if ($key !== false && $this->cart[$key]['qty'] < $this->cart[$key]['max_qty']) {
            $this->cart[$key]['qty']++;
        }
    }

    public function decrementQty($itemId)
    {
        $itemId = (int) $itemId;

        $key = collect($this->cart)->search(fn($c) => $c['id'] === $itemId);

        if ($key !== false) {
            if ($this->cart[$key]['qty'] > 1) {
                $this->cart[$key]['qty']--;
            } else {
                // qty reached 0 — remove from cart entirely
                $this->removeFromCart($itemId);
            }
        }
    }

    public function removeFromCart($itemId)
    {
        $itemId = (int) $itemId;

        $key = collect($this->cart)->search(fn($c) => $c['id'] === $itemId);

        if ($key !== false) {
            unset($this->cart[$key]);
            // re-index so array stays clean (0, 1, 2...)
            $this->cart = array_values($this->cart);
        }
    }
    #[Computed]
    public function CartTotal()
    {
        return collect($this->cart) ->sum(fn($c)=>$c['price']*$c['qty']);
    }
    
    public function getChange()
    {
       return(float) $this-> paid_amount- $this -> cartTotal();
    }
    // COMPLETE SALE

    public function completeSale()
{
    //Check if cart is not empty
    if (empty($this->cart)) {
    Notification::make()->title('Cart is empty')->danger()->send();
    return; // stops the function here
}
//Check if paid_amount greater than total
    if ($this->paid_amount < $this->cartTotal) {
    Notification::make()->title('wrong payment paid amount less than total')->danger()->send();
    return; // stops the function here
}
DB::beginTransaction();try{
    // 1. build receipt first while cart still has data
    $this->remainingStock();
    // 2. save sale to database
    $sale = Sales::create([
        'invoice_number'    => "INV-" . Str::random(5),
        'customer_id'       => null,
        'payment_method' => $this->paymentMethod,
        'total'             => $this->cartTotal(),
        'paid_amount'       => $this->paid_amount,
        'change'       => $this->getChange(),
        'discount'          => 0,
    ]);

    // 3. save each cart item to sale_items table
    foreach ($this->cart as $cartItem) {
        SaleItem::create([
            'sale_id'  => $sale->id,
            'item_id'  => $cartItem['id'],
            'quantity' => $cartItem['qty'],
            'price'    => $cartItem['price'],
        ]);
    }
       DB::commit();
       $success = true;
    }
    catch(\Exception $e){
     Notification::make()->title('Something went wrong!')->danger()->send();
    DB::rollback();
    }

if ($success) {
    $this->getReceipt($sale);
    $this->reset(['cart', 'paid_amount', 'paymentMethod']);
    Notification::make()->title('Sale Completed!')->success()->send();
}
}
    public function remainingStock()
    {
       foreach($this -> cart as $cartItem){
        $inventory = Inventory::where('item_id',$cartItem['id']) ->first();
        if($inventory){
        $inventory->quantity -= $cartItem['qty'];
        $inventory->save();
        }
       }

    }
    public function getReceipt($sale)
{
    $this->receipt = [];

    // section 1 — one entry per item
    foreach ($this->cart as $cartItem) {
        $this->receipt[] = [
            'name'          => $cartItem['name'],
            'price'         => $cartItem['price'],
            'qty'           => $cartItem['qty'],
            'subtotal'      => $cartItem['price'] * $cartItem['qty'],
            'remaining_qty' => Item::find($cartItem['id'])->inventory->quantity ?? 0,
        ];
    }

    // section 2 — summary (once, not per item)
    $this->receipt['summary'] = [
        'total'          => $this->cartTotal,
        'paid_amount'    => $this->paid_amount,
        'change'         => $this->getChange(),
        'payment_method' => $this->paymentMethod,
        'created_at'     => $sale->created_at->format('d/m/Y h:i A'),
    ];
}
    public function clearCart()
    {
       return $this -> cart = [];
    }
    

}
