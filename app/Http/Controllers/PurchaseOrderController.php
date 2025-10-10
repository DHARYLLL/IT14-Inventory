<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Log;
use App\Models\PurchaseOrderItem;
use App\Models\Stock;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $poData = PurchaseOrder::all();
        $supData = Supplier::all();
        return view('alar.purchaseOrder', ['poData' => $poData, 'supData' => $supData]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stoData = Stock::all();
        $supData = Supplier::all();
        return view('functions/poItemsAdd', ['supData' => $supData, 'stoData' => $stoData]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'itemName.*' => "required|min:5|max:100",
            'qty.*' => "required|numeric|min:1",
            'unitPrice.*' => "required|numeric|min:1",
            'sizeWeigth.*' => "required",
            'supp' => "required"
        ],  [
            'itemName.*.required' => 'This field is required.',
            'itemName.*.min' => '5 - 100 Characters only.',
            'itemName.*.max' => '5 - 100 Characters only.',
            'qty.*.required' => 'This field is required.',
            'qty.*.numeric' => 'Number only.',
            'unitPrice.*.required' => 'This field is required.',
            'unitPrice.*.numeric' => 'Number only.',
            'sizeWeigth.*.required' => 'This field is required.',
            'supp.required' => "This field is required."
        ]);


        $qty = $request -> qty;
        $unitPrice = $request -> unitPrice;
        $item = $request -> itemName;
        $sizeWeight = $request -> sizeWeigth;

        $newItems = array();
        $newUnitPrice = array();
        $newsizeWeight = array();
        //dd(stockModel::where('item_name', '=', $item[0])->get());

        //dd($item);
        $empId = Employee::orderBy('id','desc')->take(1)->value('id');

        // Check if stocks exists in the stocks table
        for ($i=0; $i < count($item) ; $i++) {     
            if (!Stock::where('item_name', '=', $item[$i])->where('size_weight', '=', $sizeWeight[$i])->first()){        
                array_push($newItems, $item[$i]);
                array_push($newsizeWeight, $sizeWeight[$i]);
                array_push($newUnitPrice, $unitPrice[$i]);
            }
        }
        
        // Create record for new stocks in stocks table
        if (count($newItems)){
            for ($i=0; $i < count($newItems) ; $i++) {       
                Stock::create([
                    'item_name' => $newItems[$i],
                    'item_qty' => 0,
                    'size_weight' => $newsizeWeight[$i],
                    'item_unit_price' => $newUnitPrice[$i]
                ]);
            }
        }

        // Create PO Items
        PurchaseOrder::create([
            'status' => 'Pending',
            'submitted_date' => Carbon::now()->format('Y-m-d'),
            'supplier_id' => $request->supp,
            'emp_id' => $empId
        ]);

        $po = PurchaseOrder::orderBy('id','desc')->take(1)->value('id');
        
        
        // store in PO
        for ($i=0; $i < count($item) ; $i++) {    
            $getID = Stock::where('item_name', '=', $item[$i])->where('size_weight', '=', $sizeWeight[$i])->first();   
            PurchaseOrderItem::create([
                'item' => $item[$i],
                'qty' => $qty[$i],
                'sizeWeight' => $sizeWeight[$i],
                'unit_price' => $unitPrice[$i],
                'total_amount' => $qty[$i] * $unitPrice[$i],
                'po_id' => $po,
                'stock_id' => $getID->id
            ]);
        }

        //logs
        Log::create([
            'action' => 'Create',
            'from' => 'Created Purchase Order | ID: ' . $po,
            'action_date' => Carbon::now()->format('Y-m-d'),
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Purchase-Order.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $poData = PurchaseOrder::findOrFail($id);
        $poItemData = PurchaseOrderItem::where('po_id', '=', $id)->get();
        $invData = Invoice::where('po_id', '=', $id)->first();
        return view('shows/purchaseOrderShow', ['poData' => $poData, 'poItemData' => $poItemData, 'invData' => $invData]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        PurchaseOrder::findOrFail($id)->update([
            'status' => 'Approved',
            'approved_date' => Carbon::now()->format('Y-m-d'),
            'total_amount' => $request->total
        ]);

        $empId = Employee::orderBy('id','desc')->take(1)->value('id');

        Log::create([
            'action' => 'Approved',
            'from' => 'Approved Purchase Order | ID: ' . $id,
            'action_date' => Carbon::now()->format('Y-m-d'),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }
}
