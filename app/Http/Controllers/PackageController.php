<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacData = Package::all();
        return view('alar/package', ['pacData' => $pacData]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('functions/packageAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pkg_name' => 'required|unique:packages,pkg_name',
            'pkg_inclusion' => 'required'
        ]);

        Package::create([
            'pkg_name' => $request->pkg_name,
            'pkg_inclusion' =>$request->pkg_inclusion
        ]);

        $getPkg = Package::orderBy('id','desc')->take(1)->value('id');
        $empId = Employee::orderBy('id','desc')->take(1)->value('id');

        Log::create([
            'action' => 'Added',
            'from' => 'Added Equipment | ID: ' . $getPkg,
            'action_date' => Carbon::now()->format('Y-m-d'),
            'emp_id' => $empId
        ]);

        return redirect(route('Package.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        //
    }
}
