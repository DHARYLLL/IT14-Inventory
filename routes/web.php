<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseOrderItemController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Middleware\AuthCheck;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\PurchaseOrderItem;
use Illuminate\Support\Facades\Auth;

// ====================
// Guest Routes (Login & Register)
// ====================
/*
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });

    // Login
    Route::get('/signin', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/signin', [LoginController::class, 'login'])->name('login.post');

    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

// ====================
// Authenticated Routes
// ====================
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // After login, redirect to Purchase Order
    Route::get('/PurchaseOrder', [PurchaseOrderController::class, 'index'])->name('purchaseOrder.index');

    // Other pages
    Route::get('/Dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/Equipment', [EquipmentController::class, 'index'])->name('equipment.index');
    Route::get('/Stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('/Supplier', [SupplierController::class, 'index'])->name('supplier.index');

    // Data routes
    Route::post('/PurchaseOrderItems', [PurchaseOrderItemController::class, 'store'])->name('POItems.store');
    Route::post('/Supplier', [SupplierController::class, 'store'])->name('supplier.store');
    Route::delete('/supplier/{supplier}/delete', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    Route::put('/Supplier/{supplier}/update', [SupplierController::class, 'update'])->name('supplier.update');
});
*/

/*
Route::get('/', function () {
    return view('alar/dashboard');
});
*/

Route::get('/', [LoginController::class, 'set'])->name('setLogin');
Route::get('/login', [LoginController::class, 'loginPage'])->name('showLogin');
Route::post('/', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(AuthCheck::class)->group(function () {
    //Resource
    Route::resource('Purchase-Order', PurchaseOrderController::class);
    Route::resource('Purchase-Order-Item', PurchaseOrderItem::class);
    Route::resource('Invoice', InvoiceController::class);
    Route::resource('Equipment', EquipmentController::class);
    Route::resource('Service-Request', ServiceRequestController::class);
    Route::resource('Package', PackageController::class);
    Route::resource('Stock', StockController::class);
    Route::resource('Log', LogController::class);


    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // After login, redirect to Purchase Order
    //Route::get('/PurchaseOrder', [PurchaseOrderController::class, 'index'])->name('purchaseOrder.index');

    // Other pages
    Route::get('/Dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    //Route::get('/Equipment', [EquipmentController::class, 'index'])->name('equipment.index');
    //Route::get('/Stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('/Supplier', [SupplierController::class, 'index'])->name('supplier.index');

    // Data routes
    //Route::post('/PurchaseOrderItems', [PurchaseOrderItemController::class, 'store'])->name('POItems.store');
    Route::post('/Supplier', [SupplierController::class, 'store'])->name('supplier.store');
    Route::delete('/supplier/{supplier}/delete', [SupplierController::class, 'destroy'])->name('supplier.destroy');
    Route::put('/Supplier/{supplier}/update', [SupplierController::class, 'update'])->name('supplier.update');
});


/*

Route::resource('Purchase-Order', PurchaseOrderController::class);
Route::resource('Purchase-Order-Item', PurchaseOrderItem::class);
Route::resource('Invoice', InvoiceController::class);
Route::resource('Equipment', EquipmentController::class);
Route::resource('Service-Request', ServiceRequestController::class);
Route::resource('Package', PackageController::class);
Route::resource('Stock', StockController::class);
Route::resource('Log', LogController::class);


// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// After login, redirect to Purchase Order
//Route::get('/PurchaseOrder', [PurchaseOrderController::class, 'index'])->name('purchaseOrder.index');

// Other pages
Route::get('/Dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
//Route::get('/Equipment', [EquipmentController::class, 'index'])->name('equipment.index');
//Route::get('/Stock', [StockController::class, 'index'])->name('stock.index');
Route::get('/Supplier', [SupplierController::class, 'index'])->name('supplier.index');

// Data routes
//Route::post('/PurchaseOrderItems', [PurchaseOrderItemController::class, 'store'])->name('POItems.store');
Route::post('/Supplier', [SupplierController::class, 'store'])->name('supplier.store');
Route::delete('/supplier/{supplier}/delete', [SupplierController::class, 'destroy'])->name('supplier.destroy');
Route::put('/Supplier/{supplier}/update', [SupplierController::class, 'update'])->name('supplier.update');
*/