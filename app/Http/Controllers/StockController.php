<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Equipment;
use App\Models\Invoice;
use App\Models\Log;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stoData = Stock::all();
        return view('alar.stock', ['stoData' => $stoData]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->qtyArrived , $request->stockId);
        $request->validate([
            'inv_num' => 'required',
            'inv_date' => 'required',
            'qtyArrived.*' => 'required|min:1|max:4',
            'del_date' => 'required',
            'total' => 'required|min:1|max:6'
        ], [
            'inv_num.required' => 'This field is required.',
            'inv_date.required' => 'This field is required.',
            'del_date.required' => 'This field is required.',
            'total.numeric' => 'Number Only.',
            'total.min' => 'Total must be 1 or more',
            'total.max' => '6 digits is the max.',
            'qtyArrived.*.required' => 'This field is required.',
            'qtyArrived.*.min' => 'Quantity must be 1 or more.',
            'qtyArrived.*.max' => '4 digits is the max.'            
        ]);
        
        
        $items = PurchaseOrderItem::where('po_id', '=', $request->po_id)->get();
        //$stock = stockModel::where()->first;

        $getId = $request->stockId;
        $getType = $request->type;
        $getArrivedQty = $request->qtyArrived;

        Invoice::create([
            'invoice_number' => $request->inv_num,
            'invoice_date' => $request->inv_date,
            'total' => $request->total,
            'po_id' => $request->po_id
        ]);
        /*
        foreach($items as $item){
            //array_push($getStock, $item->qty);
            //array_push($getStockID, $item->stock_id);
            $stock = Stock::where('id', '=', $item->stock_id)->first();
            Stock::findOrFail($stock->id)->update([
                'item_qty' => $stock->item_qty + $item->qty
            ]);
        }
        */

        for ($i=0; $i < count($getId); $i++) { 

            if($getType[$i] == 'Consumable'){
                $stock = Stock::where('id', '=', $getId[$i])->first();
                Stock::findOrFail($stock->id)->update([
                    'item_qty' => $stock->item_qty + $getArrivedQty[$i]
                ]);
                PurchaseOrderItem::where('stock_id', '=' , $getId[$i])->update([
                    'qty_arrived' => $getArrivedQty[$i]
                ]);
            }

            if($getType[$i] == 'Non-Consumable'){
                $eq = Equipment::where('id', '=', $getId[$i])->first();
                Equipment::findOrFail($eq->id)->update([
                    'eq_available' => $eq->eq_available + $getArrivedQty[$i]
                ]);
                PurchaseOrderItem::where('eq_id', '=' , $getId[$i])->update([
                    'qty_arrived' => $getArrivedQty[$i]
                ]);
            }

        }


        PurchaseOrder::findOrFail($request->po_id)->update([
            'status' => "Delivered",
            'delivered_date' => $request->del_date
        ]);

        $invId = Invoice::orderBy('id','desc')->take(1)->value('id');

        Log::create([
            'action' => 'Create',
            'from' => 'Created Invoice | ID: ' . $invId,
            'action_date' => Carbon::now()->format('Y-m-d'),
            'emp_id' => session('loginId')
        ]);

        Log::create([
            'action' => 'Added',
            'from' => 'Added Stock from Po | ID: ' . $request->po_id,
            'action_date' => Carbon::now()->format('Y-m-d'),
            'emp_id' => session('loginId')
        ]);

        //return redirect(route('Stock.index'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $stockData = Stock::findOrFail($id);
        return view('functions/stockEdit', ['stockData' => $stockData]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $request->validate([
            'itemName' => "required|min:5|max:100",
            'unitPrice' => "required|numeric|min:1",
            'sizeWeight.*' => "required"
        ],  [
            'itemName.*.required' => 'This field is required.',
            'itemName.*.min' => '5 - 100 Characters only.',
            'itemName.*.max' => '5 - 100 Characters only.',
            'unitPrice.*.required' => 'This field is required.',
            'unitPrice.*.numeric' => 'Number only.',
            'sizeWeigth.*.required' => 'This field is required.'
        ]);

        Stock::findOrFail($id)->update([
            'item_name' => $request->itemName,
            'size_weight' => $request->sizeWeight,
            'item_unit_price' => $request->unitPrice
        ]);

        Log::create([
            'action' => 'Updated',
            'from' => 'Update Stock | ID: ' . $id,
            'action_date' => Carbon::now()->format('Y-m-d'),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('promt', 'Updated Sucessfuly');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
