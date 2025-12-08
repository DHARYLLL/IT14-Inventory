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
    public function index(Request $request)
    {
        //$stoData = Stock::paginate(10);
        $search = $request->input('search');

        $stoData = Stock::when($search, function ($q) use ($search) {
            $q->where('item_name', 'like', "%{$search}%")
            ->orWhere('item_size', 'like', "%{$search}%")
            ->orWhere('id', 'like', "%{$search}%");
        })
        ->paginate(10)
        ->withQueryString(); 
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
        $request->validate([
            'inv_num' => 'required',
            'inv_date' => 'required',
            'qtyArrived.*' => 'required|integer|min:1|max:999',
            'del_date' => 'required',
            'total' => 'required|numeric|min:1|max:999999'
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
        $getEqId = $request->eqId;
        $getType = $request->type;

        $getArrivedQty = $request->qtyArrived;
        
        Invoice::create([
            'invoice_number' => $request->inv_num,
            'invoice_date' => $request->inv_date,
            'total' => $request->total,
            'po_id' => $request->po_id
        ]);
        


        for ($i=0; $i < count($getId); $i++) { 

            if($getType[$i] == 'Consumable'){
                $stock = Stock::where('id', '=', $getId[$i])->first();
                Stock::findOrFail($stock->id)->update([
                    'item_qty' => $stock->item_qty + $getArrivedQty[$i]
                ]);
                PurchaseOrderItem::where('stock_id', '=' , $getId[$i])->where('qty_arrived', '=' , null)->orderBy('id', "ASC")->take(1)->update([
                    'qty_arrived' => $getArrivedQty[$i]
                ]);
            }
                
            if($getType[$i] == 'Non-Consumable'){
                $eq = Equipment::where('id', '=', $getId[$i])->first();
                Equipment::findOrFail($eq->id)->update([
                    'eq_available' => $eq->eq_available + $getArrivedQty[$i]
                ]);
                PurchaseOrderItem::where('eq_id', '=' , $getId[$i])->where('qty_arrived', '=' , null)->orderBy('id', "ASC")->take(1)->update([
                    'qty_arrived' => $getArrivedQty[$i]
                ]);
            }
            
            

        }
        

        PurchaseOrder::findOrFail($request->po_id)->update([
            'status' => "Delivered",
            'delivered_date' => $request->del_date
        ]);

        $invId = Invoice::orderBy('id', 'desc')->take(1)->value('id');

        Log::create([
            'transaction' => 'Create',
            'tx_desc' => 'Created Invoice | ID: ' . $invId,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        Log::create([
            'transaction' => 'Added',
            'tx_desc' => 'Added Stock from Po | ID: ' . $request->po_id,
            'tx_date' => Carbon::now(),
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
            'itemName' => "required|max:100",
            'size' => "required|max:20"
        ],  [
            'itemName.required' => 'This field is required.',
            'itemName.max' => '100 Characters limit reached.',

            'size.required' => 'This field is required.',
            'size.max' => '20 Characters limit reached.',
        ]);

        Stock::findOrFail($id)->update([
            'item_name' => $request->itemName,
            'item_size' => $request->size,
        ]);

        Log::create([
            'transaction' => 'Updated',
            'tx_desc' => 'Update Stock | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('success', 'Updated Sucessfuly!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
