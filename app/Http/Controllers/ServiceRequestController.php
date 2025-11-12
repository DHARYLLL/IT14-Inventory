<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Http\Controllers\Controller;
use App\Models\Chapel;
use App\Models\ChapEquipment;
use App\Models\ChapStock;
use App\Models\Employee;
use App\Models\Equipment;
use App\Models\Log;
use App\Models\Package;
use App\Models\PkgEquipment;
use App\Models\PkgStock;
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
            'decDied' => 'required|date|after:decBorn',
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
            'decDied.after' => 'The died date must be after born date.',
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
            'pkg_id' => $request->pkgId,
            'chap_id' => $request->chapId
        ]);

        $getId = ServiceRequest::orderBy('id', 'desc')->take(1)->value('id');

        Receipt::create([
            'client_name' => $request->clientName,
            'client_contact_number' => $request->clientConNum,
            'rcpt_status' => 'Pending',
            'paid_amount' => $request->payment,
            'total_payment' => $request->total,
            'emp_id' => session('loginId'),
            'svc_id' => $getId
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
        $pkgStoData = PkgStock::where('pkg_id', '=', $svcReqData->pkg_id )->get();
        $pkgEqData = PkgEquipment::where('pkg_id', '=', $svcReqData->pkg_id)->get();
        return view('shows/serviceRequestShow', ['svcReqData' => $svcReqData, 'pkgStoData' => $pkgStoData, 'pkgEqData' => $pkgEqData]);
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
        $pkgId = ServiceRequest::where('id', $id)->take(1)->value('pkg_id');
        

        $pkgEqs = PkgEquipment::where('pkg_id', '=', $pkgId)->get();
        $pkgStos = PkgStock::where('pkg_id', '=', $pkgId)->get();

        // returning equipment
        if ($request->status == 'Deployed') {

            // return equipment from package
            foreach ($pkgEqs as $pkgEq) {
                $getEq = Equipment::where('id', '=', $pkgEq->eq_id)->first();
                Equipment::findOrFail($getEq->id)->update([
                    'eq_available' => $getEq->eq_available + $pkgEq->eq_used,
                    'eq_in_use' => $getEq->eq_in_use - $pkgEq->eq_used
                ]);
            }

            ServiceRequest::findOrFail($id)->update([
                'svc_equipment_status' => 'Returned',
                'svc_return_date' => Carbon::now()->format('Y-m-d')
            ]);

            Log::create([
                'transaction' => 'Returned',
                'tx_desc' => 'Returned Equipment from Service Request | ID: ' . $id,
                'emp_id' => session('loginId')
            ]);

            return redirect(route('Service-Request.index'));
        }

        // Deploying stock and equipment
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

            // update deployed equipment from package
            foreach ($pkgEqs as $data) {
                $eqData = Equipment::where('id', '=', $data->eq_id)->first();
                Equipment::findOrFail($eqData->id)->update([
                    'eq_available' => $eqData->eq_available - $data->eq_used,
                    'eq_in_use' => $eqData->eq_in_use + $data->eq_used
                ]);
            }

            // update deployed stocks from package
            foreach ($pkgStos as $data) {
                $stoData = Stock::where('id', '=', $data->stock_id)->first();
                Stock::findOrFail($stoData->id)->update([
                    'item_qty' => $stoData->item_qty - $data->stock_used
                ]);
            }

            ServiceRequest::findOrFail($id)->update([
                'svc_equipment_status' => 'Deployed',
                'svc_deploy_date' => Carbon::now()->format('Y-m-d')
            ]);

            Log::create([
                'transaction' => 'Deployed',
                'tx_desc' => 'Deployed Stock from Service Request | ID: ' . $id,
                'emp_id' => session('loginId')
            ]);

            Log::create([
                'transaction' => 'Deployed',
                'tx_desc' => 'Deployed Equipment from Service Request | ID: ' . $id,
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
            'transaction' => 'Deleted',
            'tx_desc' => 'Deleted Service Request | ID: ' . $id,
            'emp_id' => session('loginId')
        ]);
        return redirect()->back()->with('success', 'Deleted Succesfully');
    }
}
