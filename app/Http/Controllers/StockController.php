<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Log;
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
        $request->validate([
            'inv_num' => 'required',
            'inv_date' => 'required',
            'total' => 'required|numeric|min:1'
        ], [
            'inv_num.required' => 'This field is required.',
            'inv_date.required' => 'This field is required.',
            'total.numeric' => 'Number Only.',
            'total.min' => 'Cannot be 0'            
        ]);
        
        $items = PurchaseOrderItem::where('po_id', '=', $request->po_id)->get();
        //$stock = stockModel::where()->first;

        $getStock = array();
        $getStockID = array();
        $total = array();

        Invoice::create([
            'invoice_number' => $request->inv_num,
            'invoice_date' => $request->inv_date,
            'total' => $request->total,
            'po_id' => $request->po_id
        ]);

        foreach($items as $item){
            //array_push($getStock, $item->qty);
            //array_push($getStockID, $item->stock_id);
            $stock = Stock::where('id', '=', $item->stock_id)->first();
            Stock::findOrFail($stock->id)->update([
                'item_qty' => $stock->item_qty + $item->qty
            ]);
        }

        $empId = Employee::orderBy('id','desc')->take(1)->value('id');
        $invId = Invoice::orderBy('id','desc')->take(1)->value('id');

        Log::create([
            'action' => 'Create',
            'from' => 'Created Invoice | ID: ' . $invId,
            'action_date' => Carbon::now()->format('Y-m-d'),
            'emp_id' => $empId
        ]);

        return redirect(route('Stock.index'));
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
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
