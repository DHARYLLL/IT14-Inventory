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
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Pest\ArchPresets\Strict;

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
        $stoData = Stock::orderBy('item_name', 'asc')->get();
        $supData = Supplier::all();
        $eqData = Equipment::orderBy('eq_name', 'asc')->get();
        return view('functions/poItemsAdd', ['supData' => $supData, 'stoData' => $stoData, 'eqData' => $eqData]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'itemName.*' => "required|max:100",
            'qty.*' => "required|integer|min:1",
            'unitPrice.*' => "required|numeric|min:1",
            'size.*' => "required",
            'qtySet.*' => "required|integer|min:1",
            'typeSelect.*' => "required",
            'supp' => "required"
        ],  [
            'itemName.*.required' => 'This field is required.',
            'itemName.*.max' => '100 Characters limit reached.',
            'qty.*.required' => 'This field is required.',
            'qty.*.min' => 'Quantity must be 1 or more.',
            'qty.*.required' => 'This field is required.',
            'qtySet.*.min' => 'Quantity must be 1 or more.',
            'qtySet.*.integer' => 'Number only.',
            'qtySet.*.required' => 'This field is required.',
            'unitPrice.*.required' => 'This field is required.',
            'unitPrice.*.numeric' => 'Number only.',
            'size.*.required' => 'This field is required.',
            'size.*.required' => 'This field is required.',
            'typeSelect.*.required' => 'This field is required.',
            'supp.required' => "This field is required."
        ]);

        $item = $request->itemName;
        $qty = $request->qty;
        $qtySet = $request->qtySet;
        $size = $request->size;
        $unitPrice = $request->unitPrice;
        $type = $request->typeSelect;

        $newItem = array();     
        $newItemSize = array();
        $newItemType = array();
        $newItemSet = array();
        
        $newEquipment = array();  
        $newEquipmentSize = array();
        $newEquipmentType = array();
        $newEquipmentSet = array();

        // Check if stocks exists in the stocks and equipment table
        for ($i = 0; $i < count($item); $i++) {
            if ($type[$i] == "Consumable") {
                if (Stock::where('item_name', '=', $item[$i])->where('item_size', '=', $size[$i])->where('item_net_content', '=', $qtySet[$i])->doesntExist()) {
                    array_push($newItem, $item[$i]);
                    array_push($newItemSize, $size[$i]);
                    array_push($newItemType, $type[$i]);
                    array_push($newItemSet, $qtySet[$i]);
                }
            }

            if ($type[$i] == "Non-Consumable") {

                if (Equipment::where('eq_name', '=', $item[$i])->where('eq_size', '=', $size[$i])->where('eq_net_content', '=', $qtySet[$i])->doesntExist()) {

                    array_push($newEquipment, $item[$i]);
                    array_push($newEquipmentSize, $size[$i]);
                    array_push($newEquipmentType, $type[$i]);
                    array_push($newEquipmentSet, $qtySet[$i]);
                }
            }
        }

        // Create record for new stocks and in stocks table
        if (count($newItem)) {
            for ($i = 0; $i < count($newItem); $i++) {
                Stock::create([
                    'item_name' => $newItem[$i],
                    'item_qty' => 0,
                    'item_size' => $newItemSize[$i],
                    'item_net_content' => $newItemSet[$i],
                    'item_type' => $newItemType[$i],
                    'item_low_limit' => 10
                ]);
            }
        }
        // Create record for new equipment and in equipments table
        if (count($newEquipment)) {
            for ($i = 0; $i < count($newEquipment); $i++) {
                Equipment::create([
                    'eq_name' => $newEquipment[$i],
                    'eq_type' => $newEquipmentType[$i],
                    'eq_available' => 0,
                    'eq_net_content' => $newEquipmentSet[$i],
                    'eq_size' => $newEquipmentSize[$i],
                    'eq_in_use' => 0,
                    'eq_low_limit' => 10
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

        $po = PurchaseOrder::orderBy('id', 'desc')->take(1)->value('id');


        // store in PO
        for ($i = 0; $i < count($item); $i++) {

            if ($type[$i] == "Consumable") {
                $getStock = Stock::where('item_name', '=', $item[$i])->where('item_size', '=', $size[$i])->first();
                PurchaseOrderItem::create([
                    'item' => $item[$i],
                    'qty' => $qty[$i],
                    'qty_set' => $qtySet[$i],
                    'qty_total' => $qty[$i] * ($qtySet[$i] == 0 ? 1 : $qtySet[$i]),
                    'size' => $size[$i],
                    'unit_price' => $unitPrice[$i],
                    'total_amount' => $qty[$i] * $unitPrice[$i],
                    'type' => $type[$i],
                    'po_id' => $po,
                    'stock_id' => $getStock->id,
                ]);
            }

            if ($type[$i] == "Non-Consumable") {
                $getEquipment = Equipment::where('eq_name', '=', $item[$i])->where('eq_size', '=', $size[$i])->first();
                PurchaseOrderItem::create([
                    'item' => $item[$i],
                    'qty' => $qty[$i],
                    'size' => $size[$i],
                    'qty_set' => $qtySet[$i],
                    'qty_total' => $qty[$i] * ($qtySet[$i] == 0 ? 1 : $qtySet[$i]),
                    'unit_price' => $unitPrice[$i],
                    'total_amount' => $qty[$i] * $unitPrice[$i],
                    'type' => $type[$i],
                    'po_id' => $po,
                    'eq_id' => $getEquipment->id,
                ]);
            }
        }

        //logs
        Log::create([
            'transaction' => 'Create',
            'tx_desc' => 'Created Purchase Order | ID: ' . $po,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Purchase-Order.index', $po))
            ->with('success', 'Sumbitted Successfully!');
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

    public function showApprove(String $id)
    {
        $poData = PurchaseOrder::findOrFail($id);
        $poItemData = PurchaseOrderItem::where('po_id', '=', $id)->get();
        $invData = Invoice::where('po_id', '=', $id)->first();
        return view('functions/purchaseOrderEditApprove', ['poData' => $poData, 'poItemData' => $poItemData, 'invData' => $invData]);
    }

    public function storeApprove(Request $request, String $id)
    {
        $today = Carbon::now('Asia/Manila')->startOfDay();
        $request->validate([
            'inv_num' => 'required',
            'inv_date' => [
                'required',
                Rule::date()->beforeOrEqual($today->format('Y-m-d'))
            ],
            'qtyArrived.*' => 'required|integer|min:0|max:999',
            'qtyArrivedSet.*' => 'required|integer|min:1|max:999999',
            'del_date' => [
                'required',
                Rule::date()->afterOrEqual($today->format('Y-m-d'))
            ],
            'total' => 'required|numeric|min:1|max:999999'
        ], [
            'inv_num.required' => 'This field is required.',
            'inv_date.required' => 'This field is required.',
            'inv_date.before_or_equal' => 'Date cannot be after today.',
            'del_date.required' => 'This field is required.',
            'del_date.after_or_equal' => 'Date cannot be before today',

            'total.numeric' => 'Number Only.',
            'total.min' => 'Total must be 1 or more',
            'total.max' => '6 digits is the max.',

            'qtyArrived.*.required' => 'This field is required.',
            'qtyArrived.*.min' => 'Quantity must be 1 or more.',
            'qtyArrived.*.max' => '4 digits limit reached.',

            'qtyArrivedSet.*.required' => 'This field is required.',
            'qtyArrivedSet.*.min' => 'Quantity must be 1 or more.',
            'qtyArrivedSet.*.max' => '6 digits limit reached.',
        ]);
        
        $getId = $request->stockId;
        $getEqId = $request->eqId;
        $getType = $request->type;

        $getArrivedQty = $request->qtyArrived;
        $getArrivedQtySet = $request->qtyArrivedSet;
        
        Invoice::create([
            'invoice_number' => $request->inv_num,
            'invoice_date' => $request->inv_date,
            'total' => $request->total,
            'po_id' => $request->po_id
        ]);

        for ($i=0; $i < count($getId); $i++) { 

            if($getType[$i] == 'Consumable'){
                $stock = Stock::select('id', 'item_qty', 'item_net_content')->where('id', '=', $getId[$i])->first();
                Stock::findOrFail($stock->id)->update([
                    'item_qty' => $stock->item_qty + $getArrivedQty[$i],
                    'item_net_content' => $stock->item_net_content + $getArrivedQtySet[$i]
                ]);
                PurchaseOrderItem::where('stock_id', '=' , $getId[$i])->where('qty_arrived', '=' , null)->orderBy('id', "ASC")->take(1)->update([
                    'qty_arrived' => $getArrivedQty[$i]
                ]);
            }
                
            if($getType[$i] == 'Non-Consumable'){
                $eq = Equipment::select('id', 'eq_available', 'eq_net_content')->where('id', '=', $getId[$i])->first();
                Equipment::findOrFail($eq->id)->update([
                    'eq_available' => $eq->eq_available + $getArrivedQty[$i],
                    'eq_net_content' => $eq->eq_net_content + $getArrivedQtySet[$i],
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
        //return redirect()->back();

        return redirect(route('Purchase-Order.showDelivered', $request->po_id))->with('success', 'Delivered Successfully!');
    }

    public function showDelivered(String $id)
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
            'transaction' => 'Approved',
            'tx_desc' => 'Approved Purchase Order | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Purchase-Order.showApproved', $id))->with('success', 'Approved Successfully!');
    }

    public function exportPo(Request $request, String $id)
    {
        $today = Carbon::now('Asia/Manila')->startOfDay();
        $request->validate([
            'deadline' => [
                'required',
                Rule::date()->afterOrEqual($today->format('Y-m-d'))
            ],
        ], [
            'deadline.required' => 'This field is required.',
            'deadline.after_or_equal' => 'Deadline cannot be before today.'
        ]);
        
        $poData = PurchaseOrder::findOrFail($id);
        $poItemData = PurchaseOrderItem::where('po_id', $id)->get();

        //return view('pdfTemp/purchaseOrderTemplate', ['poItemData' => $poItemData]);
        $data = ['poItemData' => $poItemData, 'poData' => $poData, 'deadline' => $request->deadline];
        
        $pdf = Pdf::loadView('pdfTemp.purchaseOrderTemplate', $data);
        return $pdf->download(date('d-m-Y').'-purchase-order.pdf');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        PurchaseOrder::findOrFail($id)->delete();
        Log::create([
            'transaction' => 'Deleted',
            'tx_desc' => 'Delted Purchase Order | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);
        return redirect()->back()->with('success', 'Deleted Successfully!');
    }

}
