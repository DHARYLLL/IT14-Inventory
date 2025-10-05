<?php

use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseOrderItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('purchaseOrder');
});


Route::post('/PurchaseOrderItems', [PurchaseOrderItemController::class, 'store'])->name('POItems.store');
