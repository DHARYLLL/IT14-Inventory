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
            'startDate' => 'required',
            'endDate' => 'required',
            'wakeLoc' => 'required',
            'churhcLoc' => 'required',
            'burialLoc' => 'required'
        ]);

        ServiceRequest::create([
            'svc_startDate' => $request->startDate,
            'svc_endDate' => $request->endDate,
            'svc_wakeLoc' => $request->wakeLoc,
            'svc_churchLoc' => $request->churhcLoc,
            'svc_burialLoc' => $request->burialLoc,
            'svc_status' => 'Pending',
            'package_id' => $request->package
        ]);

        //get all equipment in request
        $eq = $request->equipment;
        $eqQty = $request->eqQty;

        $getId = ServiceRequest::orderBy('id','desc')->take(1)->value('id');
        
        for ($i=0; $i < count($eq); $i++) { 
            SvsEquipment::create([
                'service_id' => $getId,
                'equipment_id' => $eq[$i],
                'eq_used' => $eqQty[$i]
            ]);

            $eqData = Equipment::where('id', '=', $eq[$i])->first();
            Equipment::findOrFail($eqData->id)->update([
                'eq_available' => $eqData->eq_available - $eqQty[$i],
                'eq_in_use' => $eqData->eq_in_use + $eqQty[$i]
            ]);
        }


        //get all stock in request
        $sto = $request->stock;
        $stoQty = $request->stockQty;
        
        for ($i=0; $i < count($sto); $i++) { 
            SvsStock::create([
                'stock_id' => $sto[$i],
                'service_id'=> $getId,
                'stock_used' => $stoQty[$i]
            ]);

            $stoData = Stock::where('id', '=', $sto[$i])->first();
            Stock::findOrFail($stoData->id)->update([
                'item_qty' => $stoData->item_qty - $stoQty[$i]
            ]);
        }

        $empId = Employee::orderBy('id','desc')->take(1)->value('id');

        Log::create([
            'action' => 'Create',
            'from' => 'Created Service Request | ID: ' . $getId,
            'action_date' => Carbon::now()->format('Y-m-d'),
            'emp_id' => $empId
        ]);
        

        return redirect()->back();
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
    public function update(Request $request, ServiceRequest $serviceRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceRequest $serviceRequest)
    {
        //
    }
}
