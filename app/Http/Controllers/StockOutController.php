<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Log;
use App\Models\Stock;
use App\Models\stockOut;
use Illuminate\Http\Request;

class StockOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stoOutData = stockOut::all();
        return (view('alar/stockOut', ['stoOutData' => $stoOutData]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stoData = Stock::all();
        $eqData = Equipment::all();
        return view('functions/stockOutCreate', ['stoData' => $stoData, 'eqData' => $eqData]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'itemName.*' => 'required',
            'stockQty.*' => 'required|integer|min:1|max:999',
            'stockQtySet.*' => 'required|integer|min:1|max:999',
            'eqName.*' => 'required',
            'eqQty.*' => 'required|integer|min:1|max:999',
            'eqQtySet.*' => 'required|integer|min:1|max:999'
        ], [
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
        $StoErrors = [];

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
            /*
            if (!empty($StoErrors)) {
                return back()->withErrors($StoErrors)->withInput();
            }
            */
        }

        $equipmentErrors = [];

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
            /*
            if (!empty($equipmentErrors)) {
                return back()->withErrors($equipmentErrors)->withInput();
            }
                */
        }
        if (!empty($allErrors)) {
            return back()->withErrors($allErrors)->withInput();
        }

        if ($sto !== null) {
            for ($i = 0; $i < count($sto); $i++) {
                $getStoQty = Stock::select('id', 'item_qty')->where('id', $sto[$i])->first();
                Stock::find($sto[$i])->update([
                    'item_qty' => $getStoQty->item_qty - ($stoQty[$i] * max(1, $stoQtySet[$i]))
                ]); 
            }
        }

        if ($eq !== null) {
            for ($i = 0; $i < count($eq); $i++) {
                $getEqQty = Equipment::select('id', 'eq_available')->where('id', $sto[$i])->first();
                Equipment::find($eq[$i])->update([
                    'eq_available' => $getEqQty->eq_available - ($eqQty[$i] * max(1, $eqQtySet[$i]))
                ]); 
            }
        }

        Log::create([
            'transaction' => 'Stock Out',
            'tx_desc' => 'Stock out | Items:'. count($sto) . ' | Equipment: '. count($eq),
            'emp_id' => session('loginId') 
        ]);

        return redirect()->back()->with('promt', 'Items Stock Out Successfully.');
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
