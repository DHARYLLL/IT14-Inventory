<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BurialAssistanceController;
use App\Http\Controllers\ChapelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmbalmerController;
use App\Http\Controllers\employeeController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JobOrderController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\packageInclusionController;
use App\Http\Controllers\pkgEquipmentController;
use App\Http\Controllers\pkgStockController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseOrderItemController;
use App\Http\Controllers\receiptController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\setStoEqToPkgController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\VehicleController;
use App\Http\Middleware\AuthCheck;
use App\Models\embalming;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\PurchaseOrderItem;
use App\Models\ServiceRequest;
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

Route::middleware(AuthCheck::class)->group(function(){
    //Resource
    
    Route::resource('Purchase-Order', PurchaseOrderController::class);
    Route::get('Purchase-Order/{id}/Get', [PurchaseOrderController::class, 'showApprove'])->name('Purchase-Order.showApproved');
    Route::put('Purchase-Order/{id}/Store', [PurchaseOrderController::class, 'storeApprove'])->name('Purchase-Order.storeApproved');
    Route::get('Purchase-Order/{id}/Show-Delivered', [PurchaseOrderController::class, 'showDelivered'])->name('Purchase-Order.showDelivered');
    Route::post('Purchase-Order/{id}/Export', [PurchaseOrderController::class, 'exportPo'])->name('Purchase-Order.export');

    Route::resource('Purchase-Order-Item', PurchaseOrderItem::class);
    Route::resource('Invoice', InvoiceController::class);

    Route::resource('Equipment', EquipmentController::class);
    
    Route::resource('Service-Request', ServiceRequestController::class);
    Route::put('Service-Request/{id}/Pay-Balance', [ServiceRequestController::class, 'payBalance'])->name('Service-Request.payBalance');
    //Route::put('Service-Request/{$id}/Deploy-Equipment', [ServiceRequestController::class, 'deploy'])->name('Service-Request.deploy');
    Route::resource('Package', PackageController::class);
    
    Route::get('Package/{id}/Remove-Item', [PackageController::class, 'addRemoveItem'])->name('Package.addRemItem');



    Route::resource('Package-Inclusion', packageInclusionController::class);
    Route::resource('Stock', StockController::class);
    Route::resource('Log', LogController::class);
    Route::resource('Chapel', ChapelController::class);
    //Route::resource('Receipt', receiptController::class);
    Route::resource('Pkg-Stock', pkgStockController::class);
    Route::resource('Pkg-Equipment', pkgEquipmentController::class);
    
    Route::resource('Employee', employeeController::class);
    Route::get('Employyee/{id}/Employee-Edit', [employeeController::class, 'editEmp'])->name('Employee.editEmp');
    Route::post('Employyee/{id}/Employee-Reset-Password', [employeeController::class, 'resetPassword'])->name('Employee.resetPass');
    
    Route::resource('Vehicle', VehicleController::class);
    Route::resource('Embalmer', EmbalmerController::class);
    Route::get('Embalmer/{id}/Remove-Item', [EmbalmerController::class, 'addRemoveStoEq'])->name('Embalmer.addRemItem');
    Route::post('Embalmer/store/Add-Item', [EmbalmerController::class, 'addSto'])->name('Embalmer.addItem');
    Route::post('Embalmer/store/Add-Equipment', [EmbalmerController::class, 'addEq'])->name('Embalmer.addEq');
    Route::delete('Embalmer/{id}}/Remove-Stock', [EmbalmerController::class, 'removeSto'])->name('Embalmer.removeItem');
    Route::delete('Embalmer/{id}/Remove-Equipment', [EmbalmerController::class, 'removeEq'])->name('Embalmer.removeEq');

    
    Route::resource('Job-Order', JobOrderController::class);
    Route::get('Job-Order/{id}/Show-Deploy-Items', [JobOrderController::class, 'showDeployItems'])->name('Job-Order.showDeploy');
    Route::get('Job-Order/{id}/Show-Return-Items', [JobOrderController::class, 'showReturnItems'])->name('Job-Order.showReturn');
    Route::put('Job-Order/{id}/Deploy', [JobOrderController::class, 'deployItems'])->name('Job-Order.deploy');
    Route::put('Job-Order/{id}/Return', [JobOrderController::class, 'returnItems'])->name('Job-Order.return');
    Route::get('Job-Order/{id}/Apply-Burial-Assistance', [JobOrderController::class, 'applyBurAsst'])->name('Job-Order.apply');

    Route::resource('Burial-Assistance', BurialAssistanceController::class);
    Route::get('Burial-Assistance/{id}/Back', [BurialAssistanceController::class, 'burrAsstBack'])->name('Burial-Assistance.back');
    
    Route::resource('Stock-Out', StockOutController::class);
    Route::get('Stock-Out/{id}/Cancel', [StockOutController::class, 'cancelSO'])->name('Stock-Out.cancel');

    //new
    Route::resource('Set-Item-Equipment', setStoEqToPkgController::class);

    // Update password
    Route::put('/Employee/{id}/update', [LoginController::class, 'changePassword'])->name('updatePassword');
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

Route::get('/test-assets', function() {
    return response()->json([
        'css_exists' => file_exists(public_path('css/style.css')),
        'css_path' => public_path('css/style.css'),
        'files_in_css' => scandir(public_path('css')),
        'public_path' => public_path(),
        'base_path' => base_path(),
    ]);
});