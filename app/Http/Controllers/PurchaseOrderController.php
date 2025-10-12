<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Equipment;
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
        $eqData = Equipment::all();
        return view('functions/poItemsAdd', ['supData' => $supData, 'stoData' => $stoData, 'eqData' => $eqData]);
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
            'typeSelect.*' => "required",
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
            'typeSelect.*.required' => 'This field is required.',
            'supp.required' => "This field is required."
        ]);


        $qty = $request -> qty;
        $unitPrice = $request -> unitPrice;
        $item = $request -> itemName;
        $sizeWeight = $request -> sizeWeigth;
        $type = $request -> typeSelect;

        $newItems = array();
        $newItemUnitPrice = array();
        $newItemSizeWeight = array();
        $newItemType = array();

        $newEquipment = array();
        $newEquipmentUnitPrice = array();
        $newEquipmentSizeWeight = array();
        $newEquipmentType = array();
        //dd(stockModel::where('item_name', '=', $item[0])->get());


        // Check if stocks exists in the stocks and equipment table
        for ($i=0; $i < count($item) ; $i++) {  
            if ($type[$i] == "Consumable") {
                if (Stock::where('item_name', '=', $item[$i])->where('size_weight', '=', $sizeWeight[$i])->doesntExist()){        
                    array_push($newItems, $item[$i]);
                    array_push($newItemSizeWeight, $sizeWeight[$i]);
                    array_push($newItemUnitPrice, $unitPrice[$i]);
                    array_push($newItemType, $type[$i]);
                    
                }
            } 
            
            if ($type[$i] == "Non-Consumable") {
                
                if(Equipment::where('eq_name', '=', $item[$i])->where('eq_size_weight', '=', $sizeWeight[$i])->doesntExist()){
                    
                    array_push($newEquipment, $item[$i]);
                    array_push($newEquipmentSizeWeight, $sizeWeight[$i]);
                    array_push($newEquipmentUnitPrice, $unitPrice[$i]);
                    array_push($newEquipmentType, $type[$i]);
                }
            }   
            
        }

        // Create record for new stocks and in stocks table
        if (count($newItems)){
            for ($i=0; $i < count($newItems) ; $i++) {       
                Stock::create([
                    'item_name' => $newItems[$i],
                    'item_qty' => 0,
                    'size_weight' => $newItemSizeWeight[$i],
                    'item_unit_price' => $newItemUnitPrice[$i],
                    'item_type' => $newItemType[$i]
                ]);
            }
        }
        // Create record for new equipment and in equipments table
        if (count($newEquipment)){
            for ($i=0; $i < count($newEquipment) ; $i++) {       
                Equipment::create([
                    'eq_name' => $newEquipment[$i],
                    'eq_type' => $newEquipmentType[$i],
                    'eq_available' => 0,
                    'eq_size_weight' => $newEquipmentSizeWeight[$i],
                    'eq_unit_price' => $newEquipmentUnitPrice[$i],
                    'eq_in_use' => 0
                ]);
            }
        }

        // Create PO Items
        PurchaseOrder::create([
            'status' => 'Pending',
            'submitted_date' => Carbon::now()->format('Y-m-d'),
            'supplier_id' => $request->supp,
            'emp_id' => session('loginId')
        ]);

        $po = PurchaseOrder::orderBy('id','desc')->take(1)->value('id');
        
        
        // store in PO
        for ($i=0; $i < count($item) ; $i++) {    

            if ($type[$i] == "Consumable") {
                $getStock = Stock::where('item_name', '=', $item[$i])->where('size_weight', '=', $sizeWeight[$i])->first();   
                PurchaseOrderItem::create([
                    'item' => $item[$i],
                    'qty' => $qty[$i],
                    'sizeWeight' => $sizeWeight[$i],
                    'unit_price' => $unitPrice[$i],
                    'total_amount' => $qty[$i] * $unitPrice[$i],
                    'type' => $type[$i],
                    'po_id' => $po,
                    'stock_id' => $getStock->id
                ]);
            } 
            
            if ($type[$i] == "Non-Consumable") {
                $getEquipment = Equipment::where('eq_name', '=', $item[$i])->where('eq_size_weight', '=', $sizeWeight[$i])->first();   
                PurchaseOrderItem::create([
                    'item' => $item[$i],
                    'qty' => $qty[$i],
                    'sizeWeight' => $sizeWeight[$i],
                    'unit_price' => $unitPrice[$i],
                    'total_amount' => $qty[$i] * $unitPrice[$i],
                    'type' => $type[$i],
                    'po_id' => $po,
                    'eq_id' => $getEquipment->id
                ]);
            } 


            
        }

        //logs
        Log::create([
            'action' => 'Create',
            'from' => 'Created Purchase Order | ID: ' . $po,
            'action_date' => Carbon::now()->format('Y-m-d'),
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Purchase-Order.show', $po));
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
