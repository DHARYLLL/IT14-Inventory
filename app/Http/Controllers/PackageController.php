<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Equipment;
use App\Models\Log;
use App\Models\packageInclusion;
use App\Models\PkgEquipment;
use App\Models\PkgStock;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PhpParser\Node\Expr\Cast\String_;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacData = Package::paginate(8);
        return view('alar/package', ['pacData' => $pacData]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $eqData = Equipment::all();
        $stoData = Stock::all();
        return view('functions/packageAdd', ['eqData' => $eqData, 'stoData' => $stoData]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pkg_name' => 'required|unique:packages,pkg_name',
            'pkgPrice' => 'required|numeric|min:1|max:999999.99',

            'itemName.*' => 'required',
            'stockQty.*' => 'required|integer|min:1|max:999',
            'stockQtySet.*' => 'required|integer|min:1|max:999',
            'eqName.*' => 'required',
            'eqQty.*' => 'required|integer|min:1|max:999',
            'eqQtySet.*' => 'required|integer|min:1|max:999'  
        ], [
            'pkg_name.required' => 'This field is required',
            'pkg_inclusion.*.required' => 'This field is required',

            'stockQty.*.required' => 'This field is required.',
            'stockQty.*.min' => 'Item quantity must be 1 or more.',
            'stockQty.*.max' => '3 digits limit reached.',

            'stockQtySet.*.required' => 'This field is required.',
            'stockQtySet.*.min' => 'Item quantity must be 1 or more.',
            'stockQtySet.*.max' => '3 digits limit reached.',

            'eqQty.*.required' => 'This field is required.',
            'eqQty.*.min' => 'Equipment quantity must be 1 or more.',
            'eqQty.*.max' => '3 digits limit reached.',

            'eqQtySet.*.required' => 'This field is required.',
            'eqQtySet.*.min' => 'Equipment quantity must be 1 or more.',
            'eqQtySet.*.max' => '3 digits limit reached.'
        ]);


        //Get equpment and stock requests
        $eq = $request->equipment;
        $eqQty = $request->eqQty;
        $eqQtySet = $request->eqQtySet;

        $sto = $request->stock;
        $stoQty = $request->stockQty;
        $stoQtySet = $request->stockQtySet;

        if ($eq == null && $sto == null) {
            return redirect()->back()->with('emptyEq', 'Must have atleast 1 equipment or item.')->withInput();
        }

        //get all equipment in request
        $allErrors = [];

        if ($sto != null) {
            for ($i = 0; $i < count($sto); $i++) {
                $stockId = $sto[$i];
                $requestedQty = (int) $stoQty[$i] * max(1, $stoQtySet[$i]);
                // Get stock from DB
                $stock = Stock::find($stockId); // replace with your actual Stock model

                if (!$stock) {
                    $allErrors["stock.$i"] = "Stock item not found.";
                    continue;
                }

                if ($requestedQty > $stock->item_qty) {
                    $allErrors["stockQty.$i"] = "Requested quantity ({$requestedQty}) exceeds available stock ({$stock->item_qty}).";
                }
            }
        }

        if ($eq !== null) {
            for ($i = 0; $i < count($eq); $i++) {
                $equipmentId = $eq[$i];
                $requestedQty = (int) $eqQty[$i] * max(1, $eqQtySet[$i]);

                $equipment = Equipment::find($equipmentId);

                if (!$equipment) {
                    $allErrors["equipment.$i"] = "Equipment item not found.";
                    continue;
                }

                if ($requestedQty > $equipment->eq_available) {
                    $allErrors["eqQty.$i"] = "Requested quantity ($requestedQty) exceeds available equipment ({$equipment->eq_available}).";
                }
            }
        }
        if (!empty($allErrors)) {
            return back()->withErrors($allErrors)->withInput();
        }

        Package::create([
            'pkg_name' => $request->pkg_name,
            'pkg_price' => $request->pkgPrice
        ]);

        // Get the package ID
        $getPkg = Package::orderBy('id', 'desc')->take(1)->value('id');

        if ($eq != null) {
            for ($i = 0; $i < count($eq); $i++) {
                PkgEquipment::create([
                    'pkg_id' => $getPkg,
                    'eq_id' => $eq[$i],
                    'eq_used' => $eqQty[$i],
                    'eq_used_set' => $eqQtySet[$i]
                ]);
            }
        }

        if ($sto != null) {
            for ($i = 0; $i < count($sto); $i++) {
                PkgStock::create([
                    'pkg_id' => $getPkg,
                    'stock_id' => $sto[$i],    
                    'stock_used' => $stoQty[$i],
                    'stock_used_set' => $stoQtySet[$i]
                ]);
            }
        }
        

        Log::create([
            'transaction' => 'Added',
            'tx_desc' => 'Added Package | ID: ' . $getPkg,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Package.index'))->with('success', 'Created Sucessfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $pkgData = Package::where('id', '=', $id)->first();
        $pkgEqData = PkgEquipment::where('pkg_id', '=', $pkgData->id)->get();
        $pkgStoData = PkgStock::where('pkg_id', '=', $pkgData->id)->get();

        return view('shows/packageInclusionShow', ['pkgData' => $pkgData, 'pkgEqData' => $pkgEqData, 'pkgStoData' => $pkgStoData]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $pkgData = Package::findOrFail($id);
        $pkgEqData = PkgEquipment::where('pkg_id', '=', $id)->get();
        $pkgStoData = PkgStock::where('pkg_id', '=', $id)->get();
        $eqData = Equipment::all();
        $stoData = Stock::all();
        return view('functions/packageEdit', ['pkgData' => $pkgData, 'pkgEqData' => $pkgEqData, 'pkgStoData' => $pkgStoData, 'eqData' => $eqData, 'stoData' => $stoData]);
    }

    public function addRemoveItem(String $id)
    {
        $pkgId = Package::where('id', $id)->take(1)->value('id');
        $eqData = Equipment::all();
        $stoData = Stock::all();

        $leEqData = PkgEquipment::where('pkg_id', $pkgId)->get();
        $leStoData = PkgStock::where('pkg_id', $pkgId)->get();

        $pluckedEqData = PkgEquipment::where('pkg_id', $pkgId)->pluck('eq_id');
        $pluckedStoData = PkgStock::where('pkg_id', $pkgId)->pluck('stock_id');

        $eqData = Equipment::whereNotIn('id', $pluckedEqData)->get();
        $stoData = Stock::whereNotIn('id', $pluckedStoData)->get();
        return view('functions/packageAddRemoveItem', ['pkgId' => $pkgId, 'leEqData' => $leEqData, 'leStoData' => $leStoData, 'eqData' => $eqData, 'stoData' => $stoData]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $request->validate([
            'pkgName' => [
                'required',
                'max:50',
                Rule::unique('packages', 'pkg_name')
                ->where('pkg_price', $request->pkgPrice)
                ->ignore($id)
            ],
            'pkgPrice' => 'required|numeric|min:1|max:999999.99',

            'qty.*' => 'required|integer|min:1|max:999',
            'qtySet.*' => 'required|integer|min:1|max:999',
            'eqQty.*' => 'required|integer|min:1|max:999',
            'eqQtySet.*' => 'required|integer|min:1|max:999',  
        ], [
            'pkgName.required' => 'This field is required.',
            'pkgName.unique' => 'Package name is already added.',
            'pkgName.max' => 'Max 50 character reached.',

            'pkgPrice.required' => 'This field is required.',
            'pkgPrice.numeric' => 'Number only.',
            'pkgPrice.min' => 'Price must be 1 or more.',
            'pkgPrice.max' => '6 digit price reached.',

            'qty.*.required' => 'This field is required.',
            'qty.*.min' => 'Quantity must be 1 or more.',
            'qty.*.max' => '3 digits limit reached.',

            'qtySet.*.required' => 'This field is required.',
            'qtySet.*.min' => 'Quantity must be 1 or more.',
            'qtySet.*.max' => '3 digits limit reached.',

            'eqQty.*.required' => 'This field is required.',
            'eqQty.*.min' => 'Quantity must be 1 or more.',
            'eqQty.*.max' => '3 digits limit reached.',

            'eqQtySet.*.required' => 'This field is required.',
            'eqQtySet.*.min' => 'Quantity must be 1 or more.',
            'eqQtySet.*.max' => '3 digits limit reached.'
        ]);

        //dd('hello');
        $getEqId = $request->eqId;
        $getStoId = $request->stoId;
        
        $getEqQty = $request->eqQty;
        $getEqQtySet = $request->eqQtySet;
        $getStoQty = $request->qty;
        $getStoQtySet = $request->qtySet;

        Package::findOrFail($id)->update([
            'pkg_name' => $request->pkgName,
            'pkg_price' => $request->pkgPrice
        ]);

        if ($getEqQty != null) {
            for ($i=0; $i < count($getEqId); $i++) { 
                PkgEquipment::findOrFail($getEqId[$i])->update([
                    'eq_used' => $getEqQty[$i],
                    'eq_used_set' => $getEqQtySet[$i],
                ]);
            }
        }

        if ($getStoQty != null) {
            for ($i=0; $i < count($getStoId); $i++) { 
                PkgStock::findOrFail($getStoId[$i])->update([
                    'stock_used' => $getStoQty[$i],
                    'stock_used_set' => $getStoQtySet[$i]
                ]);
            }
        }

        Log::create([
            'transaction' => 'Update',
            'tx_desc' => 'Updated Package name | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('success', 'Updated Sucessfuly!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        Package::findOrFail($id)->delete();
        Log::create([
            'transaction' => 'Deleted',
            'tx_desc' => 'Delted Package | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);
        
        return redirect()->back()->with('success', 'Deleted Successfully!');
    }
}
