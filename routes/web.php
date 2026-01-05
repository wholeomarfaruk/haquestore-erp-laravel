<?php

use App\Http\Controllers\Invoice as ControllersInvoice;
use App\Livewire\BlankPage;
use App\Livewire\Customer;
use App\Livewire\Dashboard;
use App\Livewire\Invoice;
use App\Livewire\POS;
use App\Livewire\Product;
use App\Livewire\RoleCreate;
use App\Livewire\RoleEdit;
use App\Livewire\RoleList;
use App\Livewire\SalesPoint;
use App\Livewire\StockList;
use App\Livewire\UserList;
use App\Livewire\UserProfile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('company.pos');
});

Route::get('/blank', BlankPage::class)->name('pages.blank');

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });


Route::middleware(['auth', 'verified'])->prefix('company')->name('company.')->group(function () {
        //Dashboard Start===============================
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        //Dashboard End===============================

        Route::get('/roles', RoleList::class)->name('roles.list');
        Route::get('/roles/create', RoleCreate::class)->name('roles.create');
        Route::get('/roles/edit/{id}', RoleEdit::class)->name('roles.edit');

        //Users
        Route::get('/users',UserList::class)->name('user.list');

        //customers
        Route::get('/customers', Customer::class)->name('customer.list');

        //products
        Route::get('/products', Product::class)->name('product.list');

        //stocklist
        Route::get('/stocks', StockList::class)->name('stocklist');

        //Invoices
        Route::get('/invoices', Invoice::class)->name('invoice.list');

        //Transections
        Route::get('/transections', BlankPage::class)->name('transection.list');

        //pos
        Route::get('/pos', SalesPoint::class)->name('pos');
        Route::get('/sales', SalesPoint::class)->name('sales');

        //invoice
        Route::get('/invoice/download/{id}', [ControllersInvoice::class, 'download'])->name('invoice.download');
        Route::get('/invoice/view/{id}', [ControllersInvoice::class, 'view'])->name('invoice.view');

        Route::get('/user/profile', UserProfile::class)->name('company.user.profile');
});
