<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class employeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empData = Employee::all();
        return view('functions/manageEmp', ['empData' => $empData]);
    }

    public function editEmp(string $id)
    {
        $empData = Employee::findOrFail($id);
        return view('functions/manageEmp', ['empData' => $empData]);
    }

    public function resetPassword(Request $request, string $id)
    {
        $request->validate([
            'newPass' => 'required'
        ],[
            'newPass.required' => 'This field is required.'
        ]);

        Employee::findOrFail($id)->update([
            'emp_password' => Hash::make($request->newPass)
        ]);

        Log::create([
            'transaction' => 'Update',
            'tx_desc' => 'Change Password | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return back()->with('promt-s', 'Updated Successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('functions/employeeAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'empFname' => ['required',
                            'max:30',
                            Rule::unique('employees', 'emp_fname')
                            ->where('emp_lname', $request->input('empLname'))
                            ->where('emp_mname', $request->input('empMname'))],
            'empMname' => 'required|max:15',
            'empLname' => 'required|max:15',
            'empConNum' => ['required',
                            'digits:11',
                            Rule::unique('employees', 'emp_contact_number')],
            'empAddress' => 'required|max:150',
            'email' => 'required|unique:employees,emp_email',
            'role' => 'required',
            'newPass' => 'required',
            'confPass' => 'required'
        ],[
            'empFname.required' => 'This field is required.',
            'empFname.unique' => 'Name is already already added.',
            'empFname.max' => '30 characters limit reached.',

            'empMname.required' => 'This field is required.',
            'empMname.max' => '15 characters limit reached.',

            'empLname.required' => 'This field is required.',  
            'empLname.max' => '15 characters limit reached.',

            'empConNum.required' => 'This field is required.',
            'empConNum.digits' => 'Invalid contact number.',
            'empConNum.unique' => 'Contact number is already in use.',
            
            'empAddress.required' => 'This field is required.',
            'empAddress.max' => '150 characters limit reached.',
            
            'email.required' => 'This field is required.',
            'email.unique' => 'Email is already already in use.',
            'role.required' => 'This field is required.',
            'newPass.required' => 'This field is required.',
            'confPass.required' => 'This field is required.',
        ]);

         if ($request->newPass == $request->confPass) {
            
            Employee::create([
                'emp_fname' => $request->empFname,
                'emp_mname' => $request->empMname,
                'emp_lname' => $request->empLname,
                'emp_contact_number' => $request->empConNum,
                'emp_address' => $request->empAddress,
                'emp_email' => $request->email,
                'emp_password' => Hash::make($request->newPass),
                'emp_role' => $request->role
            ]);

            Log::create([
                'transaction' => 'Created',
                'tx_desc' => 'Created new account',
                'emp_id' => session('loginId')
            ]);

            return back()->with('promt-s', 'Updated Successfully.');
        } else {
            return back()->with('promt-a', 'Password did not match.')->withInput();
        }


       

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
                            ->where('emp_contact_number', $request->input('empConNum'))
                            ->ignore($id)],
            'empMname' => 'required|max:15',
            'empLname' => 'max:15',
            'empConNum' => ['required',
                            'digits:11',
                            Rule::unique('employees', 'emp_fname')
                            ->where('emp_lname', $request->input('empLname'))
                            ->where('emp_mname', $request->input('empMname'))
                            ->where('emp_contact_number', $request->input('empConNum'))
                            ->ignore($id)],
            'empAddress' => 'required|max:150',
        ], [
            'empFname.required' => 'This field is required.',
            'empFname.unique' => 'Name is already already added.',
            'empFname.max' => '30 characters limit reached.',

            'empMname.max' => '15 characters limit reached.',

            'empLname.required' => 'This field is required.',  
            'empLname.max' => '15 characters limit reached.',

            'empConNum.required' => 'This field is required.',
            'empConNum.digits' => 'Invalid contact number.',
            'empConNum.unique' => 'Contact number is already added.',
            
            'empAddress.required' => 'This field is required.',
            'empAddress.max' => '150 characters limit reached.'
        ]);

        if (session("empRole") == 'sadmin') {

            $request->validate([
                'email' => ['required',
                            Rule::unique('employees','emp_email')
                            ->ignore($id)],
                'role' => 'required'
            ],[
                'email.required' => 'This field is required.',
                'email.unique' => 'Email is already already in use.',
                'role.required' => 'This field is required.',
            ]);
            
            Employee::findOrFail($id)->update([
                'emp_fname' => $request->empFname,
                'emp_mname' => $request->empMname,
                'emp_lname' => $request->empLname,
                'emp_contact_number' => $request->empConNum,
                'emp_address' => $request->empAddress,
                'emp_email' => $request->email,
                'emp_role' => $request->role
            ]);
        } else {
            
            Employee::findOrFail($id)->update([
                'emp_fname' => $request->empFname,
                'emp_mname' => $request->empMname,
                'emp_lname' => $request->empLname,
                'emp_contact_number' => $request->empConNum,
                'emp_address' => $request->empAddress
            ]);
        }
        
        Log::create([
            'transaction' => 'Update',
            'tx_desc' => 'Updated Profile | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('success', 'Updated Successfuly!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
