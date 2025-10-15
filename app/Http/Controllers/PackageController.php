<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Log;
use App\Models\packageInclusion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\String_;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacData = Package::paginate(8);
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
            'pkg_inclusion.*' => 'required'
        ], [
            'pkg_inclusion.*.required' => 'This field is required'
        ]);

        $pkgInclusions = $request->pkg_inclusion;
        Package::create([
            'pkg_name' => $request->pkg_name,
        ]);

        $getPkg = Package::orderBy('id', 'desc')->take(1)->value('id');

        for ($i = 0; $i < count($pkgInclusions); $i++) {
            packageInclusion::create([
                'pkg_inclusion' => $pkgInclusions[$i],
                'package_id' => $getPkg
            ]);
        }

        Log::create([
            'action' => 'Added',
            'from' => 'Added Package | ID: ' . $getPkg,
            'action_date' => Carbon::now()->format('Y-m-d'),
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Package.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $pckIncData = packageInclusion::where('package_id', '=', $id)->get();
        $pkgData = Package::findOrFail($id);
        return view('shows/packageInclusionShow', ['pckIncData' => $pckIncData, 'pkgData' => $pkgData]);
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
    public function update(Request $request, String $id)
    {
        $request->validate([
            'pkgName' => 'required|max:50|unique:packages,pkg_name'
        ], [
            'pkgName.required' => 'This field is required.',
            'pkgName.unique' => 'Package name is already added.',
            'pkgName.max' => 'Max 50 character reached.'
        ]);
        Package::findOrFail($id)->update([
            'pkg_name' => $request->pkgName
        ]);

        Log::create([
            'action' => 'Update',
            'from' => 'Updated Package name | ID: ' . $id,
            'action_date' => Carbon::now()->format('Y-m-d'),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('promt', 'Updated Sucessfuly');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        Package::findOrFail($id)->delete();
        Log::create([
            'action' => 'Deleted',
            'from' => 'Delted Package | ID: ' . $id,
            'action_date' => Carbon::now()->format('Y-m-d'),
            'emp_id' => session('loginId')
        ]);
        return redirect()->back()->with('success', 'Deleted Successfully');
    }
}
