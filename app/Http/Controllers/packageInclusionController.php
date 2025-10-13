<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Package;
use App\Models\packageInclusion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class packageInclusionController extends Controller
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
        //
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
        $pkgIncData = packageInclusion::findOrFail($id);
        $pckIncData = packageInclusion::where('package_id', '=' , $pkgIncData->package_id)->get();
        $pkgData = Package::findOrFail($pkgIncData->package_id);
        return view('functions/packageIncEdit', ['pkgIncData' => $pkgIncData, 'pckIncData' => $pckIncData, 'pkgData' => $pkgData]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'pkgInc' => 'required|max:50|unique:package_inclusions,pkg_inclusion'
        ], [
            'pkgInc.required' => 'This field is required.',
            'pkgInc.max' => 'Max 50 character reached.',
            'pkgInc.unique' => 'Package inclusion is already added.',
        ]);
        packageInclusion::findOrFail($id)->update([
            'pkg_inclusion' => $request->pkgInc
        ]);
        $pkgIncId = packageInclusion::findOrFail($id);

        Log::create([
            'action' => 'Update',
            'from' => 'Updated Package inclusion | ID: ' . $id,
            'action_date' => Carbon::now()->format('Y-m-d'),
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Package.show', $pkgIncId->package_id))->with('promt', 'Updated Sucessfully');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
