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
use App\Models\Soa;
use App\Models\Stock;
use App\Models\SvsEquipment;
use App\Models\SvsStock;
use App\Models\vehicle;
use Carbon\Carbon;
use Faker\Provider\Payment;
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
            'clientName' => 'required|regex:/^[A-Za-z0-9\s\.\'-]+$/|min:1|max:100',
            'clientConNum' => 'required|regex:/^[0-9]{11}$/',
            'address' => 'required|max:150',
            'vehicle' => 'required_without:embalm',
            'embalm'  => 'required_without:vehicle',
            'burialTime'  => 'required',
            'svcDate' => [
                Rule::date()->afterOrEqual(today())
            ],
            'payment' => 'required|integer|min:1000|max:999999',
            'total' => 'required|integer|min:1|max:999999',

            'burrDate' => [
                'required',
                Rule::date()->afterOrEqual('svcDate')
            ]
        ], [
            'clientName.required' => 'This field is required.',
            'clientName.regex' => 'Not a valid name.',
            'clientName.min' => 'At least 1 or more characters.',
            'clientName.max' => '100 charaters limit reached.',

            'clientConNum.required' => 'This field is required.',
            'clientConNum.regex' => 'Not a valid number.',

            'svcDate.required' => 'This field is required.',
            'svcDate.after_or_equal' => 'Date must be today or after.',

            'burrDate.required' => 'This field is required.',
            'burrDate.after_or_equal' => 'Date must be today or after service date.',

            'burialTime.required' => 'This field is required.',

            'vehicle.required_without' => 'Select at least one: vehicle or embalm.',
            'embalm.required_without'  => 'Select at least one: vehicle or embalm.',

            'address.required' => 'This field is required.',
            'address.max' => '150 charaters limit reached.',

            'payment.required' => 'This field is required.',
            'payment.integer' => 'Number only.',
            'payment.min' => 'Minimum downpayment PHP 1,000.',
            'payment.max' => '6 digits is the max.',

            'total.required' => 'This field is required.',
            'total.integer' => 'Number only.',
            'total.min' => 'Total must be 1 or more',
            'total.max' => '6 digits is the max.'
        ]);


        $driverUnavailable = jobOrder::Where('jo_burial_date', $request->burrDate)
            ->whereRelation('joToSvcReq', 'veh_id', $request->setVehId)
            ->whereRelation('joToSvcReq', 'svc_status', '<>', 'Completed')
            ->exists();

        if ($driverUnavailable) {
            //dd('driver not available', $checkAvail);
            return back()->with('promt', 'Driver not available')->withInput();
        }

        ServiceRequest::create([
            'veh_id' => $request->setVehId,
            'prep_id' => $request->setEmbalmId,
            'svc_status' => Carbon::parse($request->svcDate)->isSameDay(Carbon::today()) ? 'Ongoing' : 'Pending'
        ]);

        $svcId = ServiceRequest::orderBy('id', 'desc')->take(1)->value('id');

        jobOrder::create([
            'client_name' => $request->clientName,
            'client_contact_number' => $request->clientConNum,
            'client_address' => $request->address,
            'jo_total' => $request->total,
            'jo_status' => $request->payment >= $request->total ? 'Paid' : 'Pending',
            'jo_start_date' => $request->svcDate,
            'jo_embalm_time' => $request->embalmTime,
            'jo_burial_date' => $request->burrDate,
            'jo_burial_time' => $request->burialTime,
            'svc_id' => $svcId,
        ]);

        $joId = jobOrder::orderBy('id', 'desc')->take(1)->value('id');

        Soa::create([
            'payment' => $request->payment,
            'payment_date' => Carbon::today(),
            'jo_id' => $joId,
            'emp_id' => session('loginId')
        ]);
        
        Log::create([
            'transaction' => 'Create',
            'tx_desc' => 'Created Service Request | ID: ' . $joId,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);


        return redirect(route('Job-Order.index'))->with('success', 'Requested Successfully!');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $joData = jobOrder::findOrFail($id);
        $payHistoryData = Soa::where('jo_id', $joData->id)->orderBy('id', 'desc')->get();
        return view('shows/serviceRequestShow', ['joData' => $joData, 'payHistoryData' => $payHistoryData]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceRequest $serviceRequest)
    {
        //
    }

    public function payBalance(Request $request, String $id)
    {
        $request->validate([
            'payment' => 'required|numeric|min:100|max:999999.99'
        ], [
            'payment.required' => 'This field is required.',
            'payment.numeric' => 'Number only.',
            'payment.min' => 'Minimun payment PHP 100.',
            'payment.max' => '6 digits limit reached.'
        ]);
       
        $getDp = jobOrder::select('id', 'jo_total')->where('svc_id', $id)->first();
        $totalPayment = Soa::where('jo_id', $getDp->id)->sum('payment');
        jobOrder::findOrFail($id)->update([
            'jo_status' => ($request->payment >= ($getDp->jo_total - $totalPayment )) ? 'Paid' : 'Pending'
        ]);
        Soa::create([
            'payment' => $request->payment,
            'payment_date' => Carbon::today(),
            'jo_id' => $getDp->id,
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('success', 'Payment Successfull!');
    }

    public function updateSchedule(Request $request, String $id)
    {
        $request->validate([
            'burrDate' => [
                'required',
                'date',
                Rule::date()->afterOrEqual('svcDate')
            ]
        ],[
            'burrDate.required' => 'This field is required.',
            'burrDate.after_or_equal' => 'Date must on or after Service date.'
        ]);

        jobOrder::findOrFail($id)->update([
            'jo_start_date' => $request->burrDate,
            'jo_embalm_time' => $request->embalmTime,
            'jo_burial_time' => $request->burialTime
        ]);

        Log::create([
            'transaction' => 'Update',
            'tx_desc' => 'Updated service request schedule | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

       return redirect()->back()->with('success', 'Updated Schedule!');
    }

    public function completeService(String $id) {
        $getStat = jobOrder::select('id', 'jo_status', 'jo_burial_time')->where('svc_id', $id)->first();
        if ($getStat->jo_status != 'Paid') {
            return redirect()->back()->with('promt-f', 'Client have pending balance');
        }

        if ($getStat->jo_burial_time == null) {
            return redirect()->back()->with('promt-f', 'Please schedule burial time.');
        }

        ServiceRequest::findOrFail($id)->update([
            'svc_status' => 'Completed'
        ]);

        return redirect(route('Job-Order.index'))->with('success', 'Completed Serivce Request!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        // $pkgId = ServiceRequest::where('id', $id)->take(1)->value('pkg_id');
        // $pkgEqs = PkgEquipment::where('pkg_id', '=', $pkgId)->get();
        // $pkgStos = PkgStock::where('pkg_id', '=', $pkgId)->get();

        // // returning equipment
        // if ($request->status == 'Deployed') {

        //     // return equipment from package
        //     foreach ($pkgEqs as $pkgEq) {
        //         $getEq = Equipment::where('id', '=', $pkgEq->eq_id)->first();
        //         Equipment::findOrFail($getEq->id)->update([
        //             'eq_available' => $getEq->eq_available + $pkgEq->eq_used,
        //             'eq_in_use' => $getEq->eq_in_use - $pkgEq->eq_used
        //         ]);
        //     }


        //     Log::create([
        //         'transaction' => 'Returned',
        //         'tx_desc' => 'Returned Equipment from Service Request | ID: ' . $id,
        //         'tx_date' => Carbon::now(),
        //         'emp_id' => session('loginId')
        //     ]);

        //     return redirect(route('Job-Order.index'));
        // }

        // // Deploying stock and equipment
        // if ($request->status == 'Pending') {
        //     $get = ServiceRequest::find($id);
        //     $checkDate = ServiceRequest::where('id', $id)
        //                 ->whereDate('svc_startDate', '<=', Carbon::now()->format('Y-m-d'))
        //                 ->whereDate('svc_endDate', '>=', Carbon::now()->format('Y-m-d'))
        //                 ->first();
        //     if(!$checkDate){
        //         return redirect()->back()->with('promt', 'Cannot deploy before ('. $get->svc_startDate .') and after (' . $get->svc_endDate .').')
        //             ->withInput();
        //     }

        //     // update deployed equipment from package
        //     foreach ($pkgEqs as $data) {
        //         $eqData = Equipment::where('id', '=', $data->eq_id)->first();
        //         Equipment::findOrFail($eqData->id)->update([
        //             'eq_available' => $eqData->eq_available - $data->eq_used,
        //             'eq_in_use' => $eqData->eq_in_use + $data->eq_used
        //         ]);
        //     }

        //     // update deployed stocks from package
        //     foreach ($pkgStos as $data) {
        //         $stoData = Stock::where('id', '=', $data->stock_id)->first();
        //         Stock::findOrFail($stoData->id)->update([
        //             'item_qty' => $stoData->item_qty - $data->stock_used
        //         ]);
        //     }

        //     Log::create([
        //         'transaction' => 'Deployed',
        //         'tx_desc' => 'Deployed Stock from Service Request | ID: ' . $id,
        //         'tx_date' => Carbon::now(),
        //         'emp_id' => session('loginId')
        //     ]);

        //     Log::create([
        //         'transaction' => 'Deployed',
        //         'tx_desc' => 'Deployed Equipment from Service Request | ID: ' . $id,
        //         'tx_date' => Carbon::now(),
        //         'emp_id' => session('loginId')
        //     ]);

        //     return redirect()->back();
        // }

        // return redirect()->back();

        $request->validate([
            'embalm' => 'required',
            'vehicle' => 'required'
        ], [
            'embalm.required' => 'This field is required.',
            'vehicle.required' => 'This field is required.',
        ]);

        $driverUnavailable = jobOrder::Where('jo_burial_date', $request->burrDate)
            ->whereRelation('joToSvcReq', 'veh_id', $request->vehicle)
            ->whereRelation('joToSvcReq', 'svc_status', '<>', 'Completed')
            ->exists();

        if ($driverUnavailable) {
            //dd('driver not available', $checkAvail);
            return back()->with('promt-f-svc', 'Driver not available')->withInput();
        }
        
        ServiceRequest::findOrFail($id)->update([
            'veh_id' => $request->vehicle,
            'prep_id' => $request->embalm
        ]);
        return redirect()->back()->with('success', 'Updated Succesfully!');
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
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);
        return redirect()->back()->with('success', 'Deleted Succesfully!');
    }
}
