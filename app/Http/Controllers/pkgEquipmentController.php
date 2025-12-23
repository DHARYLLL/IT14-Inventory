<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Log;
use App\Models\PkgEquipment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class pkgEquipmentController extends Controller
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
            'eqAdd' => 'required',
            'eqQty' => 'required|integer|min:1|max:999',
        ],[
            'eqAdd.required' => 'This field is required.',
            'eqQty.required' => 'This field is required.',
            'eqQty.min' => 'Must be 1 or more.',
            'eqQty.max' => '3 digit limit reached.',
        ]);

        $getEqQty = Equipment::select('id', 'eq_available')->where('id', $request->eqAdd)->first();
        if ($getEqQty->eq_available < $request->eqQty) {
            return back()->with('promt-f-eq', 'Requested quantity ('. $request->eqQty .') exceeds available stock ('. $getEqQty->eq_available .').')->withInput();
        }

        PkgEquipment::create([
            'pkg_id' => $request->pkgId,
            'eq_id' => $request->eqAdd,
            'eq_used' => $request->eqQty
        ]);

        Log::create([
            'transaction' => 'Added',
            'tx_desc' => 'Added New Equipment (ID: '. $request->eqAdd .') to Package (ID: ' . $request->pkgId . ')',
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
            'eqUtil' => 'required|integer|min:1|max:999999'
        ],[
            'eqUtil.required' => 'This field is required.',
            'eqUtil.min' => 'Must be 1 or more.',
            'eqUtil.max' => '6 digit max reached.',
        ]);

        $pkgId = PkgEquipment::where('id', $id)->take(1)->value('pkg_id');
        
        PkgEquipment::findOrFail($id)->update([
            'eq_used' => $request->eqUtil
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
        $pkgId = PkgEquipment::where('id', $id)->take(1)->value('pkg_id');
        PkgEquipment::findOrFail($id)->delete();

        Log::create([
            'transaction' => 'Removed',
            'tx_desc' => 'Removed Equipment (ID: '. $id .') from Package | ID: ' . $pkgId,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('success', 'Removed Successfully!');
    }
}
