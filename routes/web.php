<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseOrderItemController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('alar.purchaseOrder');
});


Route::post('/PurchaseOrderItems', [PurchaseOrderItemController::class, 'store'])->name('POItems.store');

Route::post('/Supplier', [SupplierController::class, 'store'])->name('supplier.store');
Route::delete('/supplier/{supplier}/delete', [SupplierController::class, 'destroy'])->name('supplier.destroy');
Route::put('/Supplier/{supplier}/update', [SupplierController::class, 'update'])->name('supplier.update');

// Views
Route::get('/Dahsboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/Equipment', [EquipmentController::class, 'index'])->name('equipment.index');
Route::get('/Stock', [StockController::class, 'index'])->name('stock.index');
Route::get('/Purchase Order', [PurchaseOrderController::class, 'index'])->name('purchaseOrder.index');
Route::get('/Supplier', [SupplierController::class, 'index'])->name('supplier.index');
