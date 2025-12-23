<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Log;
use App\Models\Stock;
use App\Models\stockOut;
use App\Models\StoOutEquipment;
use App\Models\StoOutItems;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StockOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stoOutData = stockOut::orderByRaw("CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END")->orderBy('so_date', 'desc')->get();
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
            'reason' => 'required|max:100',

            'itemName.*' => 'required',
            'stockQty.*' => 'required|integer|min:1|max:999',
            'eqName.*' => 'required',
            'eqQty.*' => 'required|integer|min:1|max:999',
        ], [
            'reason.required' => 'This field is required.',
            'reason.max' => '100 digits limit reached.',

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

        $sto = $request->stock;
        $stoQty = $request->stockQty;

        if ($eq == null && $sto == null) {
            return redirect()->back()->with('emptyEq', 'Must have atleast 1 equipment or item.')->withInput();
        }

        //get all equipment in request
        $allErrors = [];

        if ($sto != null) {
            for ($i = 0; $i < count($sto); $i++) {
                $stockId = $sto[$i];
                $requestedQty = (int) $stoQty[$i];
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
                $requestedQty = (int) $eqQty[$i];

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

        stockOut::create([
            'reason' => $request->reason,
            'so_date' => Carbon::today()->toDateString(),
            'emp_id' => session('loginId') 
        ]);

        $soId = stockOut::orderBy('id', 'desc')->take(1)->value('id');

        if ($sto !== null) {
            for ($i = 0; $i < count($sto); $i++) {
                $getStoQty = Stock::select('id', 'item_qty')->where('id', $sto[$i])->first();
                Stock::find($sto[$i])->update([
                    'item_qty' => $getStoQty->item_qty - $stoQty[$i]
                ]); 

                StoOutItems::create([
                    'so_id' => $soId,
                    'stock_id' => $sto[$i],
                    'so_qty' => $stoQty[$i]
                ]);
            }
        }

        if ($eq !== null) {
            for ($i = 0; $i < count($eq); $i++) {
                $getEqQty = Equipment::select('id', 'eq_available')->where('id', $eq[$i])->first();
                Equipment::find($eq[$i])->update([
                    'eq_available' => $getEqQty->eq_available - $eqQty[$i]
                ]); 

                StoOutEquipment::create([
                    'so_id' => $soId,
                    'eq_id' => $eq[$i],
                    'so_qty' => $eqQty[$i]
                ]);
            }
        }
        
        Log::create([
            'transaction' => 'Stock Out',
            'tx_desc' => 'Stock out | Items: '. max(0, count($sto ?? [])) . ' | Equipment: '. max(0, count($eq ?? [])),
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId') 
        ]);

        return redirect(route('Stock-Out.index'))->with('success', 'Stock-out successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $soData = stockOut::findOrFail($id);
        $soStoData = StoOutItems::where('so_id', $id)->get();
        $soEqData = StoOutEquipment::where('so_id', $id)->get();
        return view('shows/stockOutShow', ['soData' => $soData, 'soStoData' => $soStoData, 'soEqData' => $soEqData]);
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

    public function cancelSO(string $id)
    {
        $soData = stockOut::findOrFail($id)->update([
            'status' => 'Cancelled'
        ]);
        $soEqData = StoOutEquipment::where('so_id', $id)->get();
        $soStoData = StoOutItems::where('so_id', $id)->get();

        $eqQty = [];
        $stoQty = [];

        if (!$soEqData->isEmpty()) {
            
            foreach ($soEqData as $row) {
                $eqQty[$row->eq_id] = $row->so_qty;
            }
            $addEq = Equipment::select('id', 'eq_available', 'eq_in_use')->whereIn('id', array_keys($eqQty))->get();
            foreach ($addEq as $equipment) {
                $equipment->update([
                    'eq_available' => $equipment->eq_available + $eqQty[$equipment->id]
                ]);
            }
        }
        if (!$soStoData->isEmpty()) {
            foreach ($soStoData as $row) {
                $stoQty[$row->stock_id] = $row->so_qty;
            }
            $addStocks = Stock::select('id', 'item_qty')->whereIn('id', array_keys($stoQty))->get();
            foreach ($addStocks as $stock) {
                $stock->update([
                    'item_qty' => $stock->item_qty + $stoQty[$stock->id]
                ]);
            }
        }

        return redirect()->back()->with('success', 'Stock-out has been Cancelled!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        stockOut::findOrFail($id)->delete();
        return redirect(route('Stock-Out.index'))->with('success', 'Deleted successfully!');
    }
}
