<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Equipment;
use App\Models\Log;
use App\Models\Package;
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
        $eqData = Equipment::all();
        $pkgData = Package::all();
        $svcReqData = ServiceRequest::all();
        $stoData = Stock::all();
        return view('functions/servicesRequestAdd', ['pkgData' => $pkgData, 'svcReqData' => $svcReqData, 'eqData' => $eqData, 'stoData' => $stoData]);
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
            'itemName.*' => 'required',
            'stockQty.*' => 'required|min:1|max:6',
            'eqName.*' => 'required',
            'eqQty.*' => 'required|min:1|max:6',
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
            'stockQty.*.required' => 'This field is required.',
            'stockQty.*.min' => 'Item quantity must be 1 or more.',
            'stockQty.*.max' => '6 digit item quantity reached.',
            'eqQty.*.required' => 'This field is required.',
            'eqQty.*.min' => 'Equipment quantity must be 1 or more.',
            'eqQty.*.max' => '6 digit equipment quantity reached.'
        ]);

        $eq = $request->equipment;
        $eqQty = $request->eqQty;
        $sto = $request->stock;
        $stoQty = $request->stockQty;
        
        if ($eq == null && $sto == null) {
            return redirect()->back()->with('emptyEq', 'Must have atleast 1 equipment or item.')->withInput();
        }

        ServiceRequest::create([
            'client_name' => $request->clientName,
            'client_contact_number' => $request->clientConNum,
            'svc_startDate' => $request->startDate,
            'svc_endDate' => $request->endDate,
            'svc_wakeLoc' => $request->wakeLoc,
            'svc_churchLoc' => $request->churhcLoc,
            'svc_burialLoc' => $request->burialLoc,
            'svc_equipment_status' => 'Pending',
            'svc_return_date' => Carbon::now()->format('Y-m-d'),
            'package_id' => $request->package,
            'emp_id' => session('loginId')
        ]);

        //get all equipment in request

        $getId = ServiceRequest::orderBy('id','desc')->take(1)->value('id');
        
        for ($i=0; $i < count($eq); $i++) { 
            SvsEquipment::create([
                'service_id' => $getId,
                'equipment_id' => $eq[$i],
                'eq_used' => $eqQty[$i]
            ]);
        }

        //get all stock in request
        
        
        for ($i=0; $i < count($sto); $i++) { 
            SvsStock::create([
                'stock_id' => $sto[$i],
                'service_id'=> $getId,
                'stock_used' => $stoQty[$i]
            ]);
        }

        Log::create([
            'action' => 'Create',
            'from' => 'Created Service Request | ID: ' . $getId,
            'action_date' => Carbon::now()->format('Y-m-d'),
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
                'svc_equipment_status' => 'Returned'
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
            
            ServiceRequest::findOrFail($id)->update([
                'svc_equipment_status' => 'Deployed'
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
    public function destroy(ServiceRequest $serviceRequest)
    {
        //
    }
}
