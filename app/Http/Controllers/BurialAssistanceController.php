<?php

namespace App\Http\Controllers;

use App\Models\BurialAssistance;
use App\Models\jobOrder;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BurialAssistanceController extends Controller
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
        return view('functions/burialAssistanceAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'civilStatus' => 'required|max:20',
            'religion' => 'required|max:50',
            'birthDate' => [
                'required',
                Rule::date()->beforeOrEqual(today())
            ],
            'address' => 'required|max:150',
            'gender' => 'required',
            'rotd' => 'required|max:50',
            'amount' => 'required|numeric|min:1|max:999999'
        ], [
            'civilStatus.required' => 'This field is required.',
            'civilStatus.max' => '20 character limit reached.',

            'religion.required' => 'This field is required.',
            'religion.max' => '50 character limit reached.',

            'birthDate.required' => 'This field is required.',
            'birthDate.before_or_equal' => 'Date cannot be after today.',

            'address.required' => 'This field is required.',
            'address.max' => '150 character limit reached.',

            'gender.required' => 'This field is required.',

            'rotd.required' => 'This field is required.',
            'rotd.max' => '50 character limit reached.',

            'amount.required' => 'This field is required.',
            'amount.numeric' => 'Number only.',
            'amount.min' => 'Amount must be 1 or more',
            'amount.max' => '6 digit limit reached.',

        ]);

        $getTotal = jobOrder::select('jo_dp', 'jo_total')->where('id', $request->joId)->first();
        if (($getTotal->jo_dp - $getTotal->jo_total) <= $request->amount)
        {
            jobOrder::findOrFail($request->joId)->update([
                'jo_status' => 'Paid'
            ]);
        }
        
        BurialAssistance::create([
            'civil_status' => $request->civilStatus,
            'religion' => $request->religion,
            'address' => $request->address,
            'birthdate' => $request->birthDate,
            'gender' => $request->gender,
            'rel_to_the_dec' => $request->rotd,
            'amount' => $request->amount,
            'jo_id' => $request->joId,
        ]);

        Log::create([
            'transaction' => 'Apply',
            'tx_desc' => 'Apllied for Burial Assistance at Job Order | ID: ' . $request->joId,
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Job-Order.showDeploy', $request->joId))->with('promt', 'Applied Successfuly');
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
            'payAmount' => 'required|numeric|min:1|max:999999' 
        ], [
            'payAmount.required' => 'This field is required.',
            'payAmount.numeric' => 'Number only.',
            'payAmount.min' => 'Amount must be 1 or more.',
            'payAmount.max' => '6 digit limit reached.'
        ]);

        $getDp = jobOrder::select('id', 'jo_dp')->where('id', $id)->first();
        jobOrder::findOrFail($id)->update([
            'jo_dp' => $getDp->jo_dp + $request->payAmount,
            'jo_status' => 'Paid'
        ]);

        Log::create([
            'transaction' => 'Pay',
            'tx_desc' => 'Payed for Job Order| ID: ' . $id,
            'emp_id' => session('loginId') 
        ]);

        return redirect(route('Job-Order.show', $id))->with('promt-s', 'Balance has been Paid Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
