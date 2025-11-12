<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\PkgEquipment;
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
            'eqUtilQty' => 'required|integer|min:1|max:999999'
        ],[
            'eqAdd.required' => 'This field is required.',
            'eqUtilQty.required' => 'This field is required.',
            'eqUtilQty.min' => 'Must be 1 or more.',
            'eqUtilQty.max' => '6 digit max reached.',
        ]);

        PkgEquipment::create([
            'pkg_id' => $request->pkgId,
            'eq_id' => $request->eqAdd,
            'eq_used' => $request->eqUtilQty
        ]);

        Log::create([
            'transaction' => 'Added',
            'tx_desc' => 'Added New Equipment (ID: '. $request->eqAdd .') to Package (ID: ' . $request->pkgId . ')',
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('promt-eq', 'Added Successfully.');
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
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('promt-eq', 'Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pkgId = PkgEquipment::where('id', $id)->take(1)->value('pkg_id');
        PkgEquipment::findOrFail($id)->delete();

        Log::create([
            'transaction' => 'Deleted',
            'tx_desc' => 'Deleted Equipment (ID: '. $id .') from Package | ID: ' . $pkgId,
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('promt-eq', 'Deleted Successfully.');
    }
}
