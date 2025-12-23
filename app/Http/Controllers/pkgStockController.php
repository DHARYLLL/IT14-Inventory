<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Package;
use App\Models\PkgStock;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;

class pkgStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'stoAdd' => 'required',
            'qty' => 'required|integer|min:1|max:999',
        ],[
            'stoAdd.required' => 'This field is required.',
            'qty.required' => 'This field is required.',
            'qty.min' => 'Must be 1 or more.',
            'qty.max' => '3 digit limit reached.'
        ]); 

        $getStockQty = Stock::select('id', 'item_qty')->where('id', $request->stoAdd)->first();
        if ($getStockQty->item_qty < $request->qty) {
            return back()->with('promt-f-sto', 'Requested quantity ('. $request->qty .') exceeds available stock ('. $getStockQty->item_qty .').')->withInput();
        }
        PkgStock::create([
            'pkg_id' => $request->pkgId,
            'stock_id' => $request->stoAdd,
            'stock_used' => $request->qty,
        ]);
        

        Log::create([
            'transaction' => 'Added',
            'tx_desc' => 'Added New Item (ID: '. $request->stoAdd .') to Package (ID: ' . $request->pkgId . ')',
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('success', 'Added Successfully!');
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
        $request->validate([
            'util' => 'required|integer|min:1|max:999999'
        ],[
            'util.required' => 'This field is required.',
            'util.min' => 'Must be 1 or more.',
            'util.max' => '6 digit max reached.',
        ]);

        $pkgId = PkgStock::where('id', $id)->take(1)->value('pkg_id');
        
        PkgStock::findOrFail($id)->update([
            'stock_used' => $request->util
        ]);

        Log::create([
            'transaction' => 'Updated',
            'tx_desc' => 'Updated Utilize Qty. from Package | ID: ' . $pkgId,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('success', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pkgId = PkgStock::where('id', $id)->take(1)->value('pkg_id');

        PkgStock::findOrFail($id)->delete();

        Log::create([
            'transaction' => 'Removed',
            'tx_desc' => 'Removed Item (ID: '. $id .') from Package | ID: ' . $pkgId,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('success', 'Removed Successfully!');
    }
}
