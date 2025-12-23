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
use Illuminate\Validation\Rule;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $stoData = Stock::when($search, function ($q) use ($search) {
                $q->where('item_name', 'like', "%{$search}%")
                ->orWhere('item_size', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
            })
            ->orderByRaw("CASE WHEN item_qty <= item_low_limit THEN 0 ELSE 1 END")
            ->orderBy('item_qty', 'asc')
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'table' => view('alar.partials.stockTable', compact('stoData'))->render(),
                'pagination' => view('alar.partials.stockPagination', compact('stoData'))->render(),
            ]);
        }

        return view('alar.stock', compact('stoData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('functions/stockAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'itemName' => ['required',
                            'max:100',
                            Rule::unique('stocks', 'item_name')
                            ->where('item_size', $request->size)
                            ->where('item_net_content', $request->itemQtySet)
            ],
            'itemQty' => 'required|integer|min:0|max:999999',
            'itemQtySet' => 'required|integer|min:1|max:999999',
            'size' => 'required|max:20',
            'itemLimit' => 'required|integer|min:1|max:999999'
        ], [
            'itemName.required' => 'This field is required.',
            'itemName.max' => '100 Characters limit reached.',
            'itemName.unique' => 'Item already added.',

            'itemQty.required' => 'This field is required.',
            'itemQty.integer' => 'Number only.',
            'itemQty.min' => 'Not a valid Quantity.',
            'itemQty.max' => '6 digits limit reached.', 

            'itemQtySet.required' => 'This field is required.',
            'itemQtySet.integer' => 'Number only.',
            'itemQtySet.min' => 'Must be 1 or more.',
            'itemQtySet.max' => '6 digits limit reached.',

            'size.required' => 'This field is required.',
            'size.max' => '20 characters limit reached.',

            'itemLimit.required' => 'This field is required.',
            'itemLimit.integer' => 'Number only.',
            'itemLimit.min' => 'Must be 1 or more.',
            'itemLimit.max' => '6 digits limit reached.',
        ]);

        Stock::create([
            'item_name' => $request->itemName,
            'item_qty' => $request->itemQty,
            'item_net_content' => $request->itemQtySet,
            'item_size' => $request->size,
            'item_type' => 'Consumable',
            'item_low_limit' => $request->itemLimit
        ]);
        
        $getId = Stock::orderBy('id', 'desc')->take(1)->value('id');

        Log::create([
            'transaction' => 'Added',
            'tx_desc' => 'Added new stock |'. $getId,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Stock.index'))->with('success', 'Added Sucessfuly!');
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
            'itemName' => ['required',
                            'max:100',
                            Rule::unique('stocks', 'item_name')
                            ->where('item_size', $request->size)
                            ->where('item_net_content)', $request->itemQtySet)
                            ->ignore($id)
            ],
            'itemQty' => 'required|integer|min:0|max:999999',
            'itemQtySet' => 'required|integer|min:1|max:999999',
            'size' => "required|max:20",
            'itemLimit' => 'required|integer|min:1|max:999999.99'
        ],  [
            'itemName.required' => 'This field is required.',
            'itemName.unique' => 'Item already added.',
            'itemName.max' => '100 Characters limit reached.',

            'itemQty.required' => 'This field is required.',
            'itemQty.integer' => 'Number only.',
            'itemQty.min' => 'Not a valid Quantity.',
            'itemQty.max' => '6 digits limit reached.',

            'itemQtySet.required' => 'This field is required.',
            'itemQtySet.integer' => 'Number only.',
            'itemQtySet.min' => 'Quantity must be 1 or more.',
            'itemQtySet.max' => '6 digits limit reached.',

            'size.required' => 'This field is required.',
            'size.max' => '20 Characters limit reached.',

            'itemLimit.required' => 'This field is required.',
            'itemLimit.min' => 'Limit must be 1 or more.',
            'itemLimit.max' => '6 digits limit reached.',
        ]);

        Stock::findOrFail($id)->update([
            'item_name' => $request->itemName,
            'item_size' => $request->size,
            'item_low_limit' => $request->itemLimit
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
