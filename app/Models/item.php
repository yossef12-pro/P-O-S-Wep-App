<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory;


    protected $fillable = [
        'name',
        'sku',
        'price',
        'status'
    ];
    public function inventory(){
        return $this-> hasOne(inventory::class);
    }
    public function saleItem(){
        return $this-> hasMany(SaleItem::class);
    }
}
