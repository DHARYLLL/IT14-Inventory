<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use function Ramsey\Uuid\v1;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehData = vehicle::all();
        return view('alar/vehicle', ['vehData' => $vehData]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('functions/vehicleAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'driverName' => ['required',
                            'max:50',
                            Rule::unique('vehicles', 'driver_name')
                            ->where('veh_plate_no', $request->plateNo)],
            'contactNumber' => 'required|digits:11',
            'price' => 'required|numeric|min:1|max:999999.99'
        ], [
            'driverName.required' => 'This field is required.',
            'driverName.max' => '50 characters limit reached.',
            'driverName.unique' => 'Similar Driver & Plate No. is already added.',

            'contactNumber.required' => 'This field is required.',
            'contactNumber.digits' => 'Not a valid number.',

            'price.required' => 'This field is required.',
            'price.numeric' => 'Number only.',
            'price.min' => 'Amount must be 1 or more.',
            'price.max' => '6 digits limit reached.',
        ]);

        vehicle::create([
            'driver_name' => $request->driverName,
            'driver_contact_number' => $request->contactNumber,
            'veh_price' => $request->price
        ]);

        $vehId = vehicle::orderBy('id', 'desc')->take(1)->value('id');

        Log::create([
            'transaction' => 'Added',
            'tx_desc' => 'Added New Vehicle | ID: ' . $vehId,
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
        $vehData = vehicle::findOrFail($id);
        return view('functions/vehicleEdit', ['vehData' => $vehData]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'driverName' => [
                'required',
                'max:50',
                Rule::unique('vehicles', 'driver_name')
                ->ignore($id)
            ],
            'contactNumber' => [
                'required',
                'digits:11',
                Rule::unique('vehicles', 'driver_contact_number')
                ->ignore($id)
            ],
            'price' => 'required|numeric|min:1|max:999999.99'
        ], [
            'driverName.required' => 'This field is required.',
            'driverName.max' => '50 characters limit reached.',
            'driverName.unique' => 'Similar Driver & Plate No. is already added.',

            'contactNumber.required' => 'This field is required.',
            'contactNumber.digits' => 'Not a valid number.',

            'price.required' => 'This field is required.',
            'price.numeric' => 'Number only.',
            'price.min' => 'Amount must be 1 or more.',
            'price.max' => '6 digits limit reached.',
        ]);

        vehicle::findOrFail($id)->update([
            'driver_name' => $request->driverName,
            'driver_contact_number' => $request->contactNumber,
            'veh_price' => $request->price
        ]);

        Log::create([
            'transaction' => 'Edited',
            'tx_desc' => 'Edited Vehicle | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Vehicle.index'))->with('success', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   
        vehicle::findOrFail($id)->delete();
        Log::create([
            'transaction' => 'Delete',
            'tx_desc' => 'Deleted Vehicle | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Vehicle.index'))->with('success', 'Deleted Successfully!');
    }
}
