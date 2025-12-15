<?php

namespace App\Http\Controllers;

use App\Models\AddWake;
use App\Models\BurialAssistance;
use App\Models\BurialAsst;
use App\Models\jobOrder;
use App\Models\jobOrderDetails;
use App\Models\Log;
use App\Models\ServiceRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AddWakeController extends Controller
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
            'addDays' => 'required|integer|min:1|max:30',
            'addFeeDays' => 'required|numeric|min:1|max:999999.99'
        ],[
            'addDays.require' => 'This field is required.',
            'addDays.min' => 'Days must be 1 or more',
            'addDays.max' => '30 days limit reached',

            'addFeeDays.require' => 'This field is required.',
            'addFeeDays.numeric' => 'Number only.',
            'addFeeDays.min' => 'Amount must be 1 or more',
            'addFeeDays.max' => '6 digits limit reached'
        ]);

        $checkAvail = Carbon::parse($request->burDate)
            ->addDays((int)$request->addDays)
            ->toDateString();

        $driverUnavailable = JobOrder::where('jo_burial_date', $checkAvail)
            ->whereRelation('joToSvcReq', 'veh_id', $request->vehId)
            ->whereRelation('joToSvcReq', 'svc_status', '<>', 'Completed')
            ->exists();

        if ($driverUnavailable) {
            //dd('driver not available', $checkAvail);
            return back()->with('promt-f-add', 'Driver not available at the date of burial.')->withInput();
        }

        AddWake::create([
            'day' => $request->addDays,
            'fee' => $request->addFeeDays,
            'jod_id' => $request->jodId
        ]);

        $id = AddWake::orderBy('id', 'desc')->take(1)->value('id');

        $addWakeTotal = $request->addDays * $request->addFeeDays;
        $addWakeData = AddWake::select('id', 'jod_id')->where('id', $id)->first();

        $getDp = jobOrder::select('id', 'svc_id', 'jo_dp', 'jo_total', 'jo_burial_date', 'ba_id')->where('jod_id', $addWakeData->jod_id)->first();

        $burAsstTotal = 0;
        if ($request->burrAsstId) {
            $getBurrAsst = BurialAsst::select('id', 'amount')->where('id', $getDp->ba_id)->first();
            $burAsstTotal = $getBurrAsst->amount;
        }



        if (($getDp->jo_total + $addWakeTotal) <= ($getDp->jo_dp + $burAsstTotal)) {
            jobOrder::findOrFail($getDp->id)->update([
                'jo_status' => 'Paid',
                'jo_burial_date' => Carbon::parse($getDp->jo_burial_date)->addDays((int)$request->addDays)->toDateString(),
            ]);
        } else {
            jobOrder::findOrFail($getDp->id)->update([
                'jo_status' => 'Pending',
                'jo_burial_date' => Carbon::parse($getDp->jo_burial_date)->addDays((int)$request->addDays)->toDateString(),
            ]);
        }

        Log::create([
            'transaction' => 'Added',
            'tx_desc' => 'Added add. wake days | ID: ' . $request->jodId,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('success', 'Additional days added!');

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
            'days' => 'required|integer|min:1|max:30',
            'feeDays' => 'required|numeric|min:1|max:999999.99'
        ],[
            'days.require' => 'This field is required.',
            'days.min' => 'Days must be 1 or more',
            'days.max' => '30 days limit reached',

            'feeDays.require' => 'This field is required.',
            'feeDays.numeric' => 'Number only.',
            'feeDays.min' => 'Amount must be 1 or more',
            'feeDays.max' => '6 digits limit reached'
        ]);

        $addWakeTotal = $request->days * $request->feeDays;
        $addWakeData = AddWake::select('id', 'jod_id')->where('id', $id)->first();

        $getDp = jobOrder::select('id', 'svc_id', 'jo_dp', 'jo_total', 'jo_start_date', 'jod_id', 'ba_id')->where('jod_id', $addWakeData->jod_id)->first();
        $jodData = jobOrderDetails::select('id', 'jod_days_of_wake')->where('id', $getDp->jod_id)->first();

        $checkAvail = Carbon::parse($getDp->jo_start_date)
            ->addDays((int)$jodData->jod_days_of_wake + $request->days)
            ->toDateString();

        $driverUnavailable = JobOrder::where('jo_burial_date', $checkAvail)
            ->whereRelation('joToSvcReq', 'veh_id', $request->vehId)
            ->whereRelation('joToSvcReq', 'svc_status', '<>', 'Completed')
            ->exists();

        if ($driverUnavailable) {
            //dd('driver not available', $checkAvail);
            return back()->with('promt-f-edit', 'Driver not available at the date of burial.')->withInput();
        }

        $burAsstTotal = 0;
        if ($request->burrAsstId) {
            $getBurrAsst = BurialAsst::select('id', 'amount')->where('id', $getDp->ba_id)->first();
            $burAsstTotal = $getBurrAsst->amount;
        }

        if (($getDp->jo_total + $addWakeTotal) <= ($getDp->jo_dp + $burAsstTotal)) {
            jobOrder::findOrFail($getDp->id)->update([
                'jo_status' => 'Paid',
                'jo_burial_date' => Carbon::parse($getDp->jo_start_date)->addDays((int)$request->days + $jodData->jod_days_of_wake)->toDateString(),
            ]);
        } else {
            jobOrder::findOrFail($getDp->id)->update([
                'jo_status' => 'Pending',
                'jo_burial_date' => Carbon::parse($getDp->jo_start_date)->addDays((int)$request->days + $jodData->jod_days_of_wake)->toDateString(),
            ]);
        }

        AddWake::findOrFail($id)->update([
            'day' => $request->days,
            'fee' => $request->feeDays,
        ]);

        Log::create([
            'transaction' => 'Update',
            'tx_desc' => 'Updated add. wake days and fee | ID: ' . $request->jodId,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('success', 'Updated Successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $addWakeData = AddWake::where('id', $id)->first();
        $joData = jobOrder::select('id', 'jo_dp', 'jo_total' , 'jo_start_date', 'jo_burial_date', 'svc_id', 'ba_id')->where('jod_id', $addWakeData->jod_id)->first();
        $jodData = jobOrderDetails::select('id', 'jod_days_of_wake')->where('id', $addWakeData->jod_id)->first();
        $svcReqData = ServiceRequest::where('id', $joData->svc_id)->first();

        $checkAvail = Carbon::parse($joData->jo_start_date)
            ->addDays((int)$jodData->jod_days_of_wake)
            ->toDateString();

        $driverUnavailable = JobOrder::where('jo_burial_date', $checkAvail)
            ->whereRelation('joToSvcReq', 'veh_id', $svcReqData->veh_id)
            ->whereRelation('joToSvcReq', 'svc_status', '<>', 'Completed')
            ->exists();

        if ($driverUnavailable) {
            //dd('driver not available', $checkAvail);
            return back()->with('promt-f-delete', 'Driver not available at the date of burial.')->withInput();
        }

        $addWakeTotal = $addWakeData->day * $addWakeData->fee;

        $burAsstTotal = 0;
        if ($joData->ba_id) {
            $getBurrAsst = BurialAsst::select('id', 'amount')->where('id', $joData->ba_id)->first();
            $burAsstTotal = $getBurrAsst->amount;
        }

        if (($joData->jo_total - $addWakeTotal) <= ($joData->jo_dp + $burAsstTotal)) {
            jobOrder::where('jod_id', $addWakeData->jod_id)->update([
                'jo_status' => 'Paid',
                'jo_burial_date' => Carbon::parse($joData->jo_start_date)->addDays((int)$jodData->jod_days_of_wake)->toDateString(),
            ]);
        } else {
            jobOrder::where('jod_id', $addWakeData->jod_id)->update([
                'jo_status' => 'Pending',
                'jo_burial_date' => Carbon::parse($joData->jo_start_date)->addDays((int)$jodData->jod_days_of_wake)->toDateString(),
            ]);
        }

        AddWake::findOrFail($id)->delete();

        Log::create([
            'transaction' => 'Delete',
            'tx_desc' => 'Deletd add. wake | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('success', 'Deleted Successfully!');
    }
}
