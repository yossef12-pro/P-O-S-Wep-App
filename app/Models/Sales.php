<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    /** @use HasFactory<\Database\Factories\SalesFactory> */
    use HasFactory;
    protected $fillable = [
    'invoice_number',
    'customer_id',
    'payment_method',
    'total',
    'paid_amount',
    'change',
    'discount',
];
    public function customer(){
        return $this-> belongsTo(Customer::class);
    }
    public function paymentMethod(){
        return $this-> belongsTo(PaymentMethod::class);
    }
    public function saleItems(){
        return $this-> hasMany(SaleItem::class,'sale_id');
    }
}
