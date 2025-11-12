<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Package;
use App\Models\PkgStock;
use App\Models\Stock;
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
            'utilQty' => 'required|integer|min:1|max:999999'
        ],[
            'stoAdd.required' => 'This field is required.',
            'utilQty.required' => 'This field is required.',
            'utilQty.min' => 'Must be 1 or more.',
            'utilQty.max' => '6 digit max reached.',
        ]);

        PkgStock::create([
            'pkg_id' => $request->pkgId,
            'stock_id' => $request->stoAdd,
            'stock_used' => $request->utilQty
        ]);

        Log::create([
            'transaction' => 'Added',
            'tx_desc' => 'Added New Item (ID: '. $request->stoAdd .') to Package (ID: ' . $request->pkgId . ')',
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('promt-sto', 'Added Successfully.');
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
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('promt-sto', 'Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pkgId = PkgStock::where('id', $id)->take(1)->value('pkg_id');

        PkgStock::findOrFail($id)->delete();

        Log::create([
            'transaction' => 'Deleted',
            'tx_desc' => 'Deleted Item (ID: '. $id .') from Package | ID: ' . $pkgId,
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('promt-sto', 'Deleted Successfully.');
    }
}
