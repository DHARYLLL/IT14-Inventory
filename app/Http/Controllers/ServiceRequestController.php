<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Http\Controllers\Controller;
use App\Models\Chapel;
use App\Models\ChapEquipment;
use App\Models\ChapStock;
use App\Models\embalming;
use App\Models\Employee;
use App\Models\Equipment;
use App\Models\jobOrder;
use App\Models\Log;
use App\Models\Package;
use App\Models\PkgEquipment;
use App\Models\PkgStock;
use App\Models\Receipt;
use App\Models\Stock;
use App\Models\SvsEquipment;
use App\Models\SvsStock;
use App\Models\vehicle;
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
        $vehData = vehicle::all();
        $embalmData = embalming::all();

        return view('functions/servicesRequestAdd', ['vehData' => $vehData, 'embalmData' => $embalmData]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([ 
            'clientName' => 'required',
            'clientConNum' => 'required',
            'vehicle' => 'required',
            'svcDate' => [
                'required',
                Rule::date()->afterOrEqual(today())
            ],
            'payment' => 'required|integer|min:1|max:999999',
            'total' => 'required|integer|min:1|max:999999',
            'timeStart' => 'required',
            'timeEnd' => 'required'
            
        ], [
            'clientName.required' => 'This field is required.',
            'clientConNum.required' => 'This field is required.',
            'svcDate.required' => 'This field is required.',
            'svcDate.after_or_equal' => 'The start date must be today or after.',
            'vehicle.required' => 'This field is required.',

            'payment.required' => 'This field is required.',
            'payment.integer' => 'Number only.',
            'payment.min' => 'Payment must be 1 or more',
            'payment.max' => '6 digits is the max.',

            'total.required' => 'This field is required.',
            'total.integer' => 'Number only.',
            'total.min' => 'Total must be 1 or more',
            'total.max' => '6 digits is the max.',

            'timeStart.required' => 'This field is required.',
            'timeEnd.required' => 'This field is required.',
            
        ]);

        //dd('hello');

        // validate time
        $start = Carbon::parse($request->jo_start_time);
        $end   = Carbon::parse($request->jo_end_time);

        if ($end->lt($start)) { // lt = less than
            return back()->with('promt-f', 'End time must be after start time.')->withInput();
        }

        dd('hello');

        ServiceRequest::create([
            'svc_name' => 'test',
            'svc_amount' => $request->total,
            'veh_id' => $request->setVehId,
            'prep_id' => $request->setEmbalmId
        ]);

        $svcId = ServiceRequest::orderBy('id', 'desc')->take(1)->value('id');

        jobOrder::create([
            'client_name' => $request->clientName,
            'client_contact_number' => $request->clientConNum,
            'jo_dp' => $request->payment,
            'jo_total' => $request->total,
            'jo_status' => $request->payment >= $request->total ? 'Paid' : 'Pending',
            'jo_start_date' => $request->svcDate,
            'jo_start_time' => $request->timeStart,
            'jo_end_time' => $request->timeEnd,
            'emp_id' => session('loginId'),
            'svc_id' => $svcId
        ]);

        $joId = jobOrder::orderBy('id', 'desc')->take(1)->value('id');

        /*
        $startTime = Carbon::parse($request->timeStart)->format('g:i A');
        $endTime   = Carbon::parse($request->timeEnd)->format('g:i A');

        to convert military time to standard time
        {{ \Carbon\Carbon::parse($job->jo_start_time)->format('g:i A') }}
        {{ \Carbon\Carbon::parse($job->jo_end_time)->format('g:i A') }}
        */
        //dd($startTime, $endTime);

        
        Log::create([
            'transaction' => 'Create',
            'tx_desc' => 'Created Service Request | ID: ' . $joId,
            'emp_id' => session('loginId')
        ]);


        return redirect(route('Service-Request.show', $joId));
        
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $joData = jobOrder::findOrFail($id);
        return view('shows/serviceRequestShow', ['joData' => $joData]);
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
