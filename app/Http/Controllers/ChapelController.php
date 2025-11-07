<?php

namespace App\Http\Controllers;

use App\Models\Chapel;
use App\Models\ChapEquipment;
use App\Models\ChapStock;
use App\Models\Equipment;
use App\Models\Log;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chapData = Chapel::all();
        return view('alar/chapel', ['chapData' => $chapData]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $eqData = Equipment::all();
        $stoData = Stock::all();
        return view('functions/addChapel', ['eqData' => $eqData, 'stoData' => $stoData]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'chapName' => ['required',
                            'max:50',
                            Rule::unique('chapels', 'chap_name')
                            ->where('chap_room', $request->chapRoom)],
            'chapRoom' => 'required|max:10|unique:chapels,chap_room',
            'chapPrice' => 'required|numeric|min:1|max:999999.99',
            'maxCap' => 'required|integer|min:1|max:999',
            'stockQty.*' => 'required|integer|min:1|max:999',
            'eqName.*' => 'required',
            'eqQty.*' => 'required|integer|min:1|max:999',
        ], [
            'chapName.required' => 'This field is required',
            'chapName.unique' => 'Name & Room is already added.',
            'chapRoom.unique' => 'Room is already added.',
            'chapRoom.required' => 'This field is required',
            'maxCap.required' => 'This field is required',
            'maxCap.min' => 'Max capacity must be 1 or more.',
            'maxCap.max' => 'Max 3 digit reached.',
            'chapPrice.required' => 'This field is required.',
            'chapPrice.numeric' => 'Number only.',
            'chapPrice.min' => 'Price must be 1 or more.',
            'chapPrice.max' => '6 digit price reached.',
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

        Chapel::create([
            'chap_name' => $request->chapName,
            'chap_room' => $request->chapRoom,
            'chap_price' => $request->chapPrice,
            'chap_status' => 'Available',
            'max_cap' => $request->maxCap
        ]);


        $getChap = Chapel::orderBy('id', 'desc')->take(1)->value('id');

        if ($eq != null) {
            for ($i = 0; $i < count($eq); $i++) {
                ChapEquipment::create([
                    'chap_id' => $getChap,
                    'eq_id' => $eq[$i],
                    'eq_used' => $eqQty[$i]
                ]);
            }
        }

        if ($sto != null) {
            for ($i = 0; $i < count($sto); $i++) {
                ChapStock::create([
                    'chap_id' => $getChap,
                    'stock_id' => $sto[$i],    
                    'stock_used' => $stoQty[$i]
                ]);
            }
        }

        Log::create([
            'transaction' => 'Added',
            'tx_desc' => 'Added Chapel | ID: ' . $getChap,
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Chapel.index'));
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
