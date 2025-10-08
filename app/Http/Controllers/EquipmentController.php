<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eqData = Equipment::all();
        return view('alar.equipment', ['eqData' => $eqData]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('functions/equipmentAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $request->validate([
            'eq_name' => 'required|unique:equipments,eq_name',
            'eq_add' => 'required|integer'
        ]);
        Equipment::create([
            'eq_name' => $request->eq_name,
            'eq_available' => $request->eq_add,
            'eq_in_use' => 0
        ]);

        $getEq = Equipment::orderBy('id','desc')->take(1)->value('id');
        $empId = Employee::orderBy('id','desc')->take(1)->value('id');

        Log::create([
            'action' => 'Added',
            'from' => 'Added Equipment | ID: ' . $getEq,
            'action_date' => Carbon::now()->format('Y-m-d'),
            'emp_id' => $empId
        ]);

        return redirect(route('Equipment.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $eqData = Equipment::findOrFail($id);
        return view('shows/equipmentShow', ['eqData' => $eqData]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipment $equipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        //
    }
}
