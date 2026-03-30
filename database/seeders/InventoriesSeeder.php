<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inventory;
use App\Models\Item;
class InventoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::all()->each(function ($item) {
            Inventory::create([
                'item_id' => $item->id,
                'quantity' => rand(10, 200),
            ]);
        });
    }
}
