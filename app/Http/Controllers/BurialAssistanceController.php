<?php

namespace App\Http\Controllers;

use App\Models\AddWake;
use App\Models\BAClientInfos;
use App\Models\BAFatherInfos;
use App\Models\BAMotherInfos;
use App\Models\BAOtherInfos;
use App\Models\BurialAssistance;
use App\Models\BurialAsst;
use App\Models\jobOrder;
use App\Models\jobOrderDetails;
use App\Models\Log;
use Carbon\Carbon;
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
            'cliLname' => 'required|max:20',
            'cliFname' => 'required|max:50',
            'cliMname' => 'required|max:20',
            'civilStatus' => 'required',
            'religion' => 'required|max:50',
            'address' => 'required|max:150',
            'birthDate' => 
                'required|date|before_or_equal:'. Carbon::now()->subYear(18)->format('Y-m-d')
            ,
            'gender' => 'required',
            'rotd' => 'required|max:50',
            'amount' => 'required|numeric|min:1|max:999999'
            
        ], [
            'cliLname.required' => 'This field is required.',
            'cliLname.max' => '20 character limit reached.',

            'cliFname.required' => 'This field is required.',
            'cliFname.max' => '50 character limit reached.',

            'cliMname.required' => 'This field is required.',
            'cliMname.max' => '20 character limit reached.',

            'civilStatus.required' => 'This field is required.',

            'religion.required' => 'This field is required.',
            'religion.max' => '50 character limit reached.',

            'birthDate.required' => 'This field is required.',
            'birthDate.before_or_equal' => 'Must be 18 years or above.',

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
        //dd($request->addWakeId);
        $getTotal = jobOrder::select('id', 'jod_id', 'jo_dp', 'jo_total')->where('id', $request->joId)->first();
        $getStat = jobOrderDetails::select('id', 'jod_eq_stat')->where('id', $getTotal->jod_id)->first();


        // validate for mother info
        if ($request->filled('motherLname') || $request->filled('motherFname') || $request->filled('motherMname') ||
            $request->filled('momCivilStatus') || $request->filled('momReligion')) {
            $request->validate([
                'motherLname' => 'required|max:20',
                'motherFname' => 'required|max:50',
                'motherMname' => 'required|max:20',
                'momCivilStatus' => 'required',
                'momReligion' => 'required|max:50',
            ], [
                'motherLname.required' => 'This field is required.',
                'motherLname.max' => '20 character limit reached.',

                'motherFname.required' => 'This field is required.',
                'motherFname.max' => '50 character limit reached.',

                'motherMname.required' => 'This field is required.',
                'motherMname.max' => '20 character limit reached.',

                'momCivilStatus.required' => 'This field is required.',

                'momReligion.required' => 'This field is required.',
                'momReligion.max' => '50 character limit reached.',
            ]);
        }
        // validate for father info
        if ($request->filled('fatherFname') || $request->filled('fatherMname') || $request->filled('fatherLname') ||
            $request->filled('fatherCivilStatus') || $request->filled('fatherReligion')) {
            $request->validate([
                'fatherLname' => 'required|max:20',
                'fatherFname' => 'required|max:50',
                'fatherMname' => 'required|max:20',
                'fatherCivilStatus' => 'required',
                'fatherReligion' => 'required|max:50',
            ], [
                'fatherLname.required' => 'This field is required.',
                'fatherLname.max' => '20 character limit reached.',

                'fatherFname.required' => 'This field is required.',
                'fatherFname.max' => '50 character limit reached.',

                'fatherMname.required' => 'This field is required.',
                'fatherMname.max' => '20 character limit reached.',

                'fatherCivilStatus.required' => 'This field is required.',

                'fatherReligion.required' => 'This field is required.',
                'fatherReligion.max' => '50 character limit reached.',
            ]);
        }
        //validate other info
        if ($request->filled('otherFname') || $request->filled('otherMname') || $request->filled('otherLname') ||
            $request->filled('otherCivilStatus') || $request->filled('otherReligion') || $request->filled('relationship')) {
            $request->validate([
                'otherLname' => 'required|max:20',
                'otherFname' => 'required|max:50',
                'otherMname' => 'required|max:20',
                'otherCivilStatus' => 'required',
                'otherReligion' => 'required|max:50',
                'relationship' => 'required|max:50',
            ], [
                'otherLname.required' => 'This field is required.',
                'otherLname.max' => '20 character limit reached.',

                'otherFname.required' => 'This field is required.',
                'otherFname.max' => '50 character limit reached.',

                'otherMname.required' => 'This field is required.',
                'otherMname.max' => '20 character limit reached.',

                'otherCivilStatus.required' => 'This field is required.',

                'otherReligion.required' => 'This field is required.',
                'otherReligion.max' => '50 character limit reached.',

                'relationship.required' => 'This field is required.',
                'relationship.max' => '50 character limit reached.',
            ]);
        }

        //dd(($getTotal->jo_total - $getTotal->jo_dp) <= $request->amount);
        //dd($getStat->jod_eq_stat);
        $addWakeTotal = 0;
        if ($request->addWakeId != null) {
            $getWake = AddWake::where('id', $request->addWakeId)->first();
            $addWakeTotal = $getWake->day * $getWake->fee;
        }

        if ((($getTotal->jo_total + $addWakeTotal) - $getTotal->jo_dp) <= $request->amount)
        {
            jobOrder::findOrFail($request->joId)->update([
                'jo_status' => 'Paid',
            ]);
        }
        BurialAsst::create([
            'amount' => $request->amount,
        ]);

        $burAsstId = BurialAsst::orderBy('id', 'desc')->take(1)->value('id');

        jobOrder::findOrFail($request->joId)->update([
            'ba_id' => $burAsstId
        ]);

        BAClientInfos::create([
            'cli_fname' => $request->cliFname,
            'cli_mname' => $request->cliMname,
            'cli_lname' => $request->cliLname,
            'civil_status' => $request->civilStatus,
            'religion' => $request->religion,
            'address' => $request->address,
            'birthdate' => $request->birthDate,
            'gender' => $request->gender,
            'rel_to_the_dec' => $request->rotd,
            'ba_id' => $burAsstId
        ]);
        
        if ($request->filled('motherLname') || $request->filled('motherFname') || $request->filled('motherMname')) {
            BAMotherInfos::create([
                'fname' => $request->motherFname,
                'mname' => $request->motherMname,
                'lname' => $request->motherLname,
                'civil_status' => $request->momCivilStatus,
                'religion' => $request->momReligion,
                'ba_id' => $burAsstId
            ]);
        }

        if ($request->filled('fatherFname') || $request->filled('fatherMname') || $request->filled('fatherLname')) {     
            BAFatherInfos::create([
                'fname' => $request->fatherFname,
                'mname' => $request->fatherMname,
                'lname' => $request->fatherLname,
                'civil_status' => $request->fatherCivilStatus,
                'religion' => $request->fatherReligion,
                'ba_id' => $burAsstId
            ]);
        }

        if ($request->filled('otherFname') || $request->filled('otherMname') || $request->filled('otherLname')) {      
            BAOtherInfos::create([
                'fname' => $request->otherFname,
                'mname' => $request->otherMname,
                'lname' => $request->otherLname,
                'civil_status' => $request->otherCivilStatus,
                'religion' => $request->otherReligion,
                'relationship'=> $request->relationship,
                'ba_id' => $burAsstId
            ]);
        }

        Log::create([
            'transaction' => 'Apply',
            'tx_desc' => 'Applied GL at Job Order | ID: ' . $request->joId,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        if ($getStat->jod_eq_stat == 'Pending') {
            return redirect(route('Job-Order.showDeploy', $request->joId))->with('success', 'Applied Successfuly!');
        }
        if ($getStat->jod_eq_stat == 'Deployed') {
            return redirect(route('Job-Order.showReturn', $request->joId))->with('success', 'Applied Successfuly!');
        }
        if ($getStat->jod_eq_stat == 'Returned') {
            return redirect(route('Job-Order.show', $request->joId))->with('success', 'Applied Successfuly!');
        }
        return redirect(route('dashboard.index'));
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $burrAsstData = BurialAsst::findOrFail($id);
        $cliData = BAClientInfos::where('ba_id', $id)->first();
        $momData = BAMotherInfos::where('ba_id', $id)->first();
        $fatherData = BAFatherInfos::where('ba_id', $id)->first();
        $otherData = BAOtherInfos::where('ba_id', $id)->first();
        return view('shows/burialAssistanceShow', ['burrAsstData' => $burrAsstData, 'cliData' => $cliData, 'momData' => $momData, 'fatherData' => $fatherData, 'otherData' => $otherData]);
    }

    public function burrAsstBack(string $id)
    {
        $joData = jobOrder::select('id', 'jod_id')->where('ba_id', $id)->first();
        $jodData = jobOrderDetails::select('id', 'jod_eq_stat')->where('id', $joData->jod_id)->first();

        if ($jodData->jod_eq_stat == 'Pending') {
            return redirect(route('Job-Order.showDeploy', $joData->id));
        }
        if ($jodData->jod_eq_stat == 'Deployed') {
            return redirect(route('Job-Order.showReturn', $joData->id));
        }
        if ($jodData->jod_eq_stat == 'Returned') {
            return redirect(route('Job-Order.show', $joData->id));
        }
        return redirect(route('dashboard.index'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
