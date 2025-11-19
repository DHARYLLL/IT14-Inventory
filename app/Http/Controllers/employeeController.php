<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class employeeController extends Controller
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
        $empData = Employee::findOrFail($id);
        return view('functions/employeeEdit', ['empData' => $empData]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'empFname' => ['required',
                            'max:30',
                            Rule::unique('employees', 'emp_fname')
                            ->where('emp_lname', $request->input('empLname'))
                            ->where('emp_mname', $request->input('empMname'))
                            ->where('emp_contact_number', $request->input('empConNum'))],
            'empMname' => 'required|max:15',
            'empLname' => 'required|max:15',
            'empConNum' => ['required',
                            'digits:11',
                            Rule::unique('employees', 'emp_fname')
                            ->where('emp_lname', $request->input('empLname'))
                            ->where('emp_mname', $request->input('empMname'))
                            ->where('emp_contact_number', $request->input('empConNum'))],
            'empAddress' => 'required|max:150',
        ], [
            'empFname.required' => 'This field is required.',
            'empFname.unique' => 'Name is already already added.',
            'empFname.max' => '30 characters limit reached.',

            'empMname.required' => 'This field is required.',
            'empMname.max' => '15 characters limit reached.',

            'empLname.required' => 'This field is required.',  
            'empLname.max' => '15 characters limit reached.',

            'empConNum.required' => 'This field is required.',
            'empConNum.digits' => 'Invalid contact number.',
            'empConNum.unique' => 'Contact number is already added.',
            
            'empAddress.required' => 'This field is required.',
            'empAddress.max' => '150 characters limit reached.'
        ]);

        Employee::findOrFail($id)->update([
            'emp_fname' => $request->empFname,
            'emp_mname' => $request->empMname,
            'emp_lname' => $request->empLname,
            'emp_contact_number' => $request->empConNum,
            'emp_address' => $request->empAddress
        ]);

        Log::create([
            'transaction' => 'Update',
            'tx_desc' => 'Updated Profile | ID: ' . $id,
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('promt-b', 'Updated Successfuly');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
