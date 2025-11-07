<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Package;
use App\Models\packageInclusion;
use App\Models\PkgEquipment;
use App\Models\PkgStock;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class setStoEqToPkgController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pkgData = Package::orderBy('id','desc')->first();
        $pkgIncData = packageInclusion::where('package_id', '=', $pkgData->id)->get();
        $eqData = Equipment::all();
        $stoData = Stock::all();
        return view('functions/addStoEqToPkg', ['pkgData' => $pkgData, 'pkgIncData' => $pkgIncData, 'eqData' => $eqData, 'stoData' => $stoData]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'itemName.*' => 'required',
            'stockQty.*' => 'required|integer|min:1|max:999',
            'eqName.*' => 'required',
            'eqQty.*' => 'required|integer|min:1|max:999',
        ], [
            'stockQty.*.required' => 'This field is required.',
            'stockQty.*.min' => 'Item quantity must be 1 or more.',
            'stockQty.*.max' => '6 digit item quantity reached.',
            'eqQty.*.required' => 'This field is required.',
            'eqQty.*.min' => 'Equipment quantity must be 1 or more.',
            'eqQty.*.max' => '6 digit equipment quantity reached.'
        ]);

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

        if ($eq != null) {
            for ($i = 0; $i < count($eq); $i++) {
                PkgEquipment::create([
                    'pkg_id' => $request->pkgId,
                    'eq_id' => $eq[$i],
                    'eq_used' => $eqQty[$i]
                ]);
            }
        }

        if ($sto != null) {
            for ($i = 0; $i < count($sto); $i++) {
                PkgStock::create([
                    'pkg_id' => $request->pkgId,
                    'stock_id' => $sto[$i],    
                    'stock_used' => $stoQty[$i]
                ]);
            }
        }

        return redirect(route('Package.index'))->with('promt', 'Created Sucessfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
