<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Http\Controllers\Controller;
use App\Models\Chapel;
use App\Models\Employee;
use App\Models\Equipment;
use App\Models\Log;
use App\Models\Package;
use App\Models\Receipt;
use App\Models\Stock;
use App\Models\SvsEquipment;
use App\Models\SvsStock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use function Laravel\Prompts\alert;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $svcReqData = ServiceRequest::all();
        return view('alar/servicesRequest', ['svcReqData' => $svcReqData]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pkgData = Package::all();
        $svcReqData = ServiceRequest::all();
        $chapData = Chapel::all();

        return view('functions/servicesRequestAdd', ['pkgData' => $pkgData, 'svcReqData' => $svcReqData, 'chapData' => $chapData]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'package' => 'required',
            'clientName' => 'required',
            'clientConNum' => 'required',
            'startDate' => [
                'required',
                Rule::date()->afterOrEqual(today())
            ],
            'endDate' => 'required|date|after:startDate',
            'wakeLoc' => 'required',
            'churhcLoc' => 'required',
            'burialLoc' => 'required',
            'decName' => 'required',
            'decBorn' => 'required',
            'decDied' => 'required',
            'decCOD' => 'required',
            'decFName' => 'required',
            'decMName' => 'required',
            'payment' => 'required|integer|min:1|max:999999'
        ], [
            'package.required' => 'This field is required.',
            'clientName.required' => 'This field is required.',
            'clientConNum.required' => 'This field is required.',
            'startDate.required' => 'This field is required.',
            'startDate.after' => 'The start date must be today or after.',
            'endDate.required' => 'This field is required.',
            'endDate.after' => 'The end date must be after start date.',
            'wakeLoc.required' => 'This field is required.',
            'churhcLoc.required' => 'This field is required.',
            'burialLoc.required' => 'This field is required.',
            'decName.required' => 'This field is required.',
            'decBorn.required' => 'This field is required.',
            'decDied.required' => 'This field is required.',
            'decCOD.required' => 'This field is required.',
            'decFName.required' => 'This field is required.',
            'decMName.required' => 'This field is required.',
            'payment.required' => 'This field is required.',
            'payment.number' => 'Number only.',
            'payment.min' => 'Payment must be 1 or more',
            'payment.max' => '6 digits is the max.'
        ]);

        ServiceRequest::create([
            'dec_name' => $request->decName,
            'dec_born_date' => $request->decBorn,
            'dec_died_date' => $request->decDied,
            'dec_cause_of_death' => $request->decCOD,
            'dec_mom_name' => $request->decMName,
            'dec_fr_name' => $request->decFName,
            'svc_startDate' => $request->startDate,
            'svc_endDate' => $request->endDate,
            'svc_wakeLoc' => $request->wakeLoc,
            'svc_churchLoc' => $request->churhcLoc,
            'svc_burialLoc' => $request->burialLoc,
            'svc_equipment_status' => 'Pending',
            'pkg_id' => $request->package,
            'chap_id' => $request->chapel
        ]);

        $getId = ServiceRequest::orderBy('id', 'desc')->take(1)->value('id');

        Receipt::create([
            'client_name' => $request->clientName,
            'client_contact_number' => $request->clientConNum,
            'rcpt_status' => 'Pending',
            'payment_amount' => $request->payment,
            'emp_id' => session('loginId'),
            'svc_id' => $getId
        ]);

        Log::create([
            'transaction' => 'Create',
            'tx_desc' => 'Created Service Request | ID: ' . $getId,
            'emp_id' => session('loginId')
        ]);

        Log::create([
            'transaction' => 'Create',
            'tx_desc' => 'Created Service Request | ID: ' . $getId,
            'emp_id' => session('loginId')
        ]);


        return redirect(route('Service-Request.show', $getId));
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $svcReqData = ServiceRequest::findOrFail($id);
        $svcStoData = SvsStock::where('service_id', '=', $id)->get();
        $svcEqData = SvsEquipment::where('service_id', '=', $id)->get();
        return view('shows/serviceRequestShow', ['svcReqData' => $svcReqData, 'svcStoData' => $svcStoData, 'svcEqData' => $svcEqData]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceRequest $serviceRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        $svcEqs = SvsEquipment::where('service_id', '=', $id)->get();
        $svcStos = SvsStock::where('service_id', '=', $id)->get();

        //
        if ($request->status == 'Deployed') {

            ServiceRequest::findOrFail($id)->update([
                'svc_equipment_status' => 'Returned',
                'svc_return_date' => Carbon::now()->format('Y-m-d')
            ]);

            foreach ($svcEqs as $svcEq) {
                $getEq = Equipment::where('id', '=', $svcEq->equipment_id)->first();
                Equipment::findOrFail($getEq->id)->update([
                    'eq_available' => $getEq->eq_available + $svcEq->eq_used,
                    'eq_in_use' => $getEq->eq_in_use - $svcEq->eq_used
                ]);
            }

            //$empId = Employee::orderBy('id','desc')->take(1)->value('id');
            Log::create([
                'action' => 'Returned',
                'from' => 'Returned Equipment from Service Request | ID: ' . $id,
                'action_date' => Carbon::now()->format('Y-m-d'),
                'emp_id' => session('loginId')
            ]);

            return redirect(route('Service-Request.index'));
        }

        if ($request->status == 'Pending') {
            $get = ServiceRequest::find($id);
            $checkDate = ServiceRequest::where('id', $id)
                        ->whereDate('svc_startDate', '<=', Carbon::now()->format('Y-m-d'))
                        ->whereDate('svc_endDate', '>=', Carbon::now()->format('Y-m-d'))
                        ->first();
            if(!$checkDate){
                return redirect()->back()->with('promt', 'Cannot deploy before ('. $get->svc_startDate .') and after (' . $get->svc_endDate .').')
                    ->withInput();
            }

            ServiceRequest::findOrFail($id)->update([
                'svc_equipment_status' => 'Deployed',
                'svc_deploy_date' => Carbon::now()->format('Y-m-d')
            ]);

            /*
            $test = array();
            $testId = array();
            foreach ($svcEqs as $data) {
                $eqData = Equipment::where('id', '=', $data->equipment_id)->first();
                array_push($test, $data->eq_used);
                array_push($testId, $data->equipment_id);
            }

            dd($test, $testId);
            */

            foreach ($svcEqs as $data) {
                $eqData = Equipment::where('id', '=', $data->equipment_id)->first();
                Equipment::findOrFail($eqData->id)->update([
                    'eq_available' => $eqData->eq_available - $data->eq_used,
                    'eq_in_use' => $eqData->eq_in_use + $data->eq_used
                ]);
            }

            foreach ($svcStos as $data) {
                $stoData = Stock::where('id', '=', $data->stock_id)->first();
                Stock::findOrFail($stoData->id)->update([
                    'item_qty' => $stoData->item_qty - $data->stock_used
                ]);
            }

            Log::create([
                'action' => 'Deployed',
                'from' => 'Deployed Stock from Service Request | ID: ' . $id,
                'action_date' => Carbon::now()->format('Y-m-d'),
                'emp_id' => session('loginId')
            ]);

            Log::create([
                'action' => 'Deployed',
                'from' => 'Deployed Equipment from Service Request | ID: ' . $id,
                'action_date' => Carbon::now()->format('Y-m-d'),
                'emp_id' => session('loginId')
            ]);

            return redirect()->back();
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        ServiceRequest::findOrFail($id)->delete();
        Log::create([
            'action' => 'Deleted',
            'from' => 'Delted Service Request | ID: ' . $id,
            'action_date' => Carbon::now()->format('Y-m-d'),
            'emp_id' => session('loginId')
        ]);
        return redirect()->back()->with('success', 'Deleted Succesfully');
    }
}
