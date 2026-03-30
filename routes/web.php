<?php

use App\Livewire\Customer\CreateCustomer;
use App\Livewire\Customer\EditCustomers;
use App\Livewire\Customer\ListCustomers;
use App\Livewire\Items\CreateInventory;
use App\Livewire\Items\CreateItem;
use App\Livewire\Items\EditInventories;
use App\Livewire\Items\EditItem;
use App\Livewire\Items\ListInventories;
use App\Livewire\Items\ListItems;
use App\Livewire\Mangment\CreatePaymentMethod;
use App\Livewire\Mangment\CreateUsers;
use App\Livewire\Mangment\EditPaymentMethod;
use App\Livewire\Mangment\EditUsers;
use App\Livewire\Mangment\ListPaymentMethods;
use App\Livewire\Mangment\ListUsers;
use App\Livewire\POS;
use App\Livewire\Sales\CreateSale;
use App\Livewire\Sales\EditSales;
use App\Livewire\Sales\ListSales;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;

Route::get('/', function () {
    return view('welcome');
})->name('home');



    Route::middleware(['auth'])->group(function () {
        Route::get('dashboard', Dashboard::class)->name('dashboard');
    //users
    Route::get('/manage-users',ListUsers::class)->name('users.index');
    Route::get('/edit-User/{record}',EditUsers::class)->name('User.edit');
    Route::get('/create-User',CreateUsers::class)->name('User.create');
    //Items
    Route::get('/manage-items',ListItems::class)->name('items.index');
    Route::get('/edit-items/{record}',EditItem::class)->name('items.edit');
    Route::get('/create-item',CreateItem::class)->name('Item.create');
    //Sales
    Route::get('/manage-sales',ListSales::class)->name('sales.index');
    Route::get('/edit-sales/{record}',EditSales::class)->name('Sales.edit');
    Route::get('/create-sales',CreateSale::class)->name('Sales.create');
    //Inventories
    Route::get('/manage-inventories',ListInventories::class)->name('inventories.index');
    Route::get('/edit-inventories/{record}',EditInventories::class)->name('Inventories.edit');
    Route::get('/create-inventories',CreateInventory::class)->name('Inventory.create');
    //Customers
    Route::get('/manage-Customers',ListCustomers::class)->name('customers.index');
    Route::get('/edit-customers/{record}',EditCustomers::class)->name('Customers.edit');
    Route::get('/create-customers',CreateCustomer::class)->name('Customers.create');
    //PaymentMethods
    Route::get('/manage-Payments',ListPaymentMethods::class)->name('payment.methods.index');
    Route::get('/edit-PaymentMethod/{record}',EditPaymentMethod::class)->name('PaymentMethod.edit');
    Route::get('/create-PaymentMethod',CreatePaymentMethod::class)->name('PaymentMethod.create');
    
    Route::get('/pos',POS::class)->name('pos');
    
    });

require __DIR__.'/settings.php';
