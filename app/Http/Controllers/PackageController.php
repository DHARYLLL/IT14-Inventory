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
            'eqName.*' => 'required',
            'eqQty.*' => 'required|integer|min:1|max:999'     
        ], [
            'pkg_name.required' => 'This field is required',
            'pkg_inclusion.*.required' => 'This field is required',
            'stockQty.*.required' => 'This field is required.',
            'stockQty.*.min' => 'Item quantity must be 1 or more.',
            'stockQty.*.max' => '6 digit item quantity reached.',
            'eqQty.*.required' => 'This field is required.',
            'eqQty.*.min' => 'Equipment quantity must be 1 or more.',
            'eqQty.*.max' => '6 digit equipment quantity reached.',
            'pkgPrice.required' => 'This field is required.',
            'pkgPrice.numeric' => 'Number only.',
            'pkgPrice.min' => 'Price must be 1 or more.',
            'pkgPrice.max' => '6 digit price reached.'
        ]);


        //Get equpment and stock requests
        $eq = $request->equipment;
        $eqQty = $request->eqQty;
        $sto = $request->stock;
        $stoQty = $request->stockQty;

        if ($eq == null && $sto == null) {
            return redirect()->back()->with('emptyEq', 'Must have atleast 1 equipment or item.')->withInput();
        }

        //get all equipment in request
        $equipmentErrors = [];

        if ($eq !== null) {
            for ($i = 0; $i < count($eq); $i++) {
                $equipmentId = $eq[$i];
                $requestedQty = (int) $eqQty[$i];

                $equipment = Equipment::find($equipmentId);

                if (!$equipment) {
                    $equipmentErrors["equipment.$i"] = "Equipment item not found.";
                    continue;
                }

                if ($requestedQty > $equipment->eq_available) {
                    $equipmentErrors["eqQty.$i"] = "Requested quantity ($requestedQty) exceeds available equipment ({$equipment->eq_available}).";
                }
            }

            if (!empty($equipmentErrors)) {
                return back()->withErrors($equipmentErrors)->withInput();
            }
        }


        $StoErrors = [];

        if ($sto != null) {
            for ($i = 0; $i < count($sto); $i++) {
                $stockId = $sto[$i];
                $requestedQty = (int) $stoQty[$i];

                // Get stock from DB
                $stock = Stock::find($stockId); // replace with your actual Stock model

                if (!$stock) {
                    $StoErrors["stock.$i"] = "Stock item not found.";
                    continue;
                }

                if ($requestedQty > $stock->item_qty) {
                    $StoErrors["stockQty.$i"] = "Requested quantity ({$requestedQty}) exceeds available stock ({$stock->item_qty}).";
                }
            }

            if (!empty($StoErrors)) {
                return back()->withErrors($StoErrors)->withInput();
            }

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
                    'eq_used' => $eqQty[$i]
                ]);
            }
        }

        if ($sto != null) {
            for ($i = 0; $i < count($sto); $i++) {
                PkgStock::create([
                    'pkg_id' => $getPkg,
                    'stock_id' => $sto[$i],    
                    'stock_used' => $stoQty[$i]
                ]);
            }
        }

        Log::create([
            'transaction' => 'Added',
            'tx_desc' => 'Added Package | ID: ' . $getPkg,
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Package.index'))->with('promt', 'Created Sucessfully');
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $request->validate([
            'pkgName' => 'required|max:50|unique:packages,pkg_name'
        ], [
            'pkgName.required' => 'This field is required.',
            'pkgName.unique' => 'Package name is already added.',
            'pkgName.max' => 'Max 50 character reached.'
        ]);
        Package::findOrFail($id)->update([
            'pkg_name' => $request->pkgName
        ]);

        Log::create([
            'transaction' => 'Update',
            'tx_desc' => 'Updated Package name | ID: ' . $id,
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('promt', 'Updated Sucessfuly');
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
            'emp_id' => session('loginId')
        ]);
        
        return redirect()->back()->with('promt', 'Deleted Successfully');
    }
}
