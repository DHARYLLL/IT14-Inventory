<?php

namespace App\Http\Controllers;

use App\Models\embalming;
use App\Models\Equipment;
use App\Models\Log;
use App\Models\PkgEquipment;
use App\Models\PkgStock;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmbalmerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leData = embalming::all();
        return view('alar/embalmer', ['leData' => $leData]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $eqData = Equipment::all();
        $stoData = Stock::all();
        return view('functions/embalmerAdd', ['eqData' => $eqData, 'stoData' => $stoData]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'embalmName' => 'required|unique:embalming,embalmer_name',
            'embalmPrice' => 'required|numeric|min:1|max:999999.99',

            'itemName.*' => 'required',
            'stockQty.*' => 'required|integer|min:1|max:999',
            'stockQtySet.*' => 'required|integer|min:1|max:999',
            'eqName.*' => 'required',
            'eqQty.*' => 'required|integer|min:1|max:999',
            'eqQtySet.*' => 'required|integer|min:1|max:999'  
        ], [
            'embalmName.required' => 'This field is required.',

            'embalmPrice.required' => 'This field is required.',
            'embalmPrice.integer' => 'Number only.',
            'embalmPrice.min' => 'Price must be 1 or more.',
            'embalmPrice.max' => '3 Digits limit reached.',

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

        //dd($request->embalmName);
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

        embalming::create([
            'embalmer_name' => $request->embalmName,
            'prep_price' => $request->embalmPrice
        ]);

        $embId = embalming::orderBy('id', 'desc')->take(1)->value('id');

        if ($eq != null) {
            for ($i = 0; $i < count($eq); $i++) {
                PkgEquipment::create([
                    'prep_id' => $embId,
                    'eq_id' => $eq[$i],
                    'eq_used' => $eqQty[$i], 
                    'eq_used_set' => $eqQtySet[$i]
                ]);
            }
        }

        if ($sto != null) {
            for ($i = 0; $i < count($sto); $i++) {
                PkgStock::create([
                    'prep_id' => $embId,
                    'stock_id' => $sto[$i],    
                    'stock_used' => $stoQty[$i],
                    'stock_used_set' => $stoQtySet[$i]
                ]);
            }
        }

        Log::create([
            'transaction' => 'Added',
            'tx_desc' => 'Added New Embalmer | ID: ' . $embId,
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Embalmer.index'))->with('success', 'Created successfully!');
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
        $leData = embalming::findOrFail($id);

        $leEqData = PkgEquipment::where('prep_id', $leData->id)->get();
        $leStoData = PkgStock::where('prep_id', $leData->id)->get();
        return view('functions/embalmerEdit', ['leData' => $leData, 'leEqData' => $leEqData, 'leStoData' => $leStoData]);
    }

    public function addRemoveStoEq(string $id) 
    {
        $embId = embalming::where('id', $id)->take(1)->value('id');

        $leEqData = PkgEquipment::where('prep_id', $embId)->get();
        $leStoData = PkgStock::where('prep_id', $embId)->get();

        $pluckedEqData = PkgEquipment::where('prep_id', $embId)->pluck('eq_id');
        $pluckedStoData = PkgStock::where('prep_id', $embId)->pluck('stock_id');

        $eqData = Equipment::whereNotIn('id', $pluckedEqData)->get();
        $stoData = Stock::whereNotIn('id', $pluckedStoData)->get();
        return view('functions/embalmerAddRemoveItem', ['embId' => $embId, 'leEqData' => $leEqData, 'leStoData' => $leStoData, 'eqData' => $eqData, 'stoData' => $stoData]);
    }

    public function addSto(Request $request)
    {
        $request->validate([
            'stoAdd' => 'required',
            'qty' => 'required|integer|min:1|max:999',
            'qtySet' => 'required|integer|min:1|max:999'
        ],[
            'stoAdd.required' => 'This field is required.',
            'qty.required' => 'This field is required.',
            'qty.min' => 'Must be 1 or more.',
            'qty.max' => '3 digit limit reached.',
            'qtySet.required' => 'This field is required.',
            'qtySet.min' => 'Must be 1 or more.',
            'qtySet.max' => '3 digit limit reached.',
        ]);
        //dd($request->embId, $request->stoAdd, $request->utilQty);

        PkgStock::create([
            'prep_id' => $request->embId,
            'stock_id' => $request->stoAdd,
            'stock_used' => $request->qty,
            'stock_used_set' => $request->qtySet,
        ]);

        Log::create([
            'transaction' => 'Added',
            'tx_desc' => 'Added New Item To Embalmer | ID: ' . $request->embId,
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('success', 'Added Successfuly!');
    }

    public function addEq(Request $request)
    {
        $request->validate([
            'eqAdd' => 'required',
            'eqQty' => 'required|integer|min:1|max:999',
            'eqQtySet' => 'required|integer|min:1|max:999'
        ],[
            'eqAdd.required' => 'This field is required.',
            'eqQty.required' => 'This field is required.',
            'eqQty.min' => 'Must be 1 or more.',
            'eqQty.max' => '3 digit limit reached.',
            'eqQtySet.required' => 'This field is required.',
            'eqQtySet.min' => 'Must be 1 or more.',
            'eqQtySet.max' => '3 digit limit reached.',
        ]);
        //dd($request->embId, $request->eqAdd, $request->eqUtilQty);
        PkgEquipment::create([
            'prep_id' => $request->embId,
            'eq_id' => $request->eqAdd,
            'eq_used' => $request->eqQty,
            'eq_used_set' => $request->eqQtySet
        ]);

        Log::create([
            'transaction' => 'Added',
            'tx_desc' => 'Added New Equip. To Embalmer | ID: ' . $request->embId,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('success', 'Added Successfuly!');
    }

    public function removeSto(string $id)
    {

        PkgStock::findOrFail($id)->delete();

        Log::create([
            'transaction' => 'Remove',
            'tx_desc' => 'Remove Item To Embalmer | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('success', 'Removed Successfuly!');
    }

    public function removeEq(string $id)
    {

        PkgEquipment::findOrFail($id)->delete();

        Log::create([
            'transaction' => 'Remove',
            'tx_desc' => 'Remove Equipment To Embalmer | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('success', 'Removed Successfuly!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'embalmName' => [
                'required',
                'max:50',
                Rule::unique('embalming', 'embalmer_name')
                ->ignore($id)
            ],
            'embalmPrice' => 'required|numeric|min:1|max:999999.99',
            
            'qty.*' => 'required|integer|min:1|max:999',
            'qtySet.*' => 'required|integer|min:1|max:999',
            'eqQty.*' => 'required|integer|min:1|max:999',
            'eqQtySet.*' => 'required|integer|min:1|max:999',  
        ], [
            'embalmName.required' => 'This field is required.',
            'embalmName.unique' => 'Name is already added.',
            'embalmName.max' => '50 characters limit reached.',

            'embalmPrice.required' => 'This field is required.',
            'embalmPrice.numeric' => 'Number only.',
            'embalmPrice.min' => 'Price must be 1 or more.',
            'embalmPrice.max' => '6 digits limit reached.',

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

        $getEqId = $request->eqId;
        $getStoId = $request->stoId;
        
        $getEqQty = $request->eqQty;
        $getEqQtySet = $request->eqQtySet;
        $getStoQty = $request->qty;
        $getStoQtySet = $request->qtySet;
        //dd($getStoQty);

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

        embalming::findOrFail($id)->update([
            'embalmer_name' => $request->embalmName,
            'prep_price' => $request->embalmPrice
        ]);
        

        Log::create([
            'transaction' => 'Updated',
            'tx_desc' => 'Updated Items Used To Embalmer | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('success', 'Updated Successfuly!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        embalming::findOrFail($id)->delete();

        Log::create([
            'transaction' => 'Delete',
            'tx_desc' => 'Deleted Embalmer | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Embalmer.index'))->with('success', 'Deleted Successfuly!');
    }
}
