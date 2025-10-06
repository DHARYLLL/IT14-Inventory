<?php

use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseOrderItemController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('alar.purchaseOrder');
});


Route::post('/PurchaseOrderItems', [PurchaseOrderItemController::class, 'store'])->name('POItems.store');


// Views
Route::get('/Stock', [StockController::class, 'index'])->name('stock.index');
Route::get('/Purchase Order', [PurchaseOrderController::class, 'index'])->name('purchaseOrder.index');
Route::get('/Supplier', [SupplierController::class, 'index'])->name('supplier.index');
