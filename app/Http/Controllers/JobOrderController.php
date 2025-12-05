<?php

namespace App\Http\Controllers;

use App\Models\addEquipment;
use App\Models\addStock;
use App\Models\BurialAssistance;
use App\Models\Chapel;
use App\Models\Equipment;
use App\Models\jobOrder;
use App\Models\jobOrderDetails;
use App\Models\Log;
use App\Models\Package;
use App\Models\PkgEquipment;
use App\Models\PkgStock;
use App\Models\Stock;
use App\Models\TempEquipment;
use App\Models\vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jOData = jobOrder::all();
        return view('alar/jobOrder', ['jOData' => $jOData]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pkgData = Package::all();
        $chapData = Chapel::all();
        $vehData = vehicle::all();

        $eqData = Equipment::all();
        $stoData = Stock::all();

        return view('functions/jobOrdDetailAdd', ['pkgData' => $pkgData, 'chapData' => $chapData, 'vehData' => $vehData, 'eqData' => $eqData, 'stoData' => $stoData]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'package' => 'required',
            'clientName' => 'required|max:100',
            'address' => 'required|max:150',
            'clientConNum' => 'required|integer|digits:11',
            'svcDate' => [
                'required',
                Rule::date()->afterOrEqual(today())
            ],
            'timeStart' => 'required',
            'timeEnd' => 'required',
            'wakeLoc' => 'required',
            'burialLoc' => 'required',
            'decName' => 'required',
            'decBorn' => [
                'required',
                Rule::date()->beforeOrEqual(today())
            ],
            'decDied' => [
                'required',
                Rule::date()->afterOrEqual('decBorn')
            ],
            'decCOD' => 'required',
            'payment' => 'required|integer|min:0|max:999999',
            'vehicle' => 'required',
            'total' => 'required|integer|min:1|max:999999',

            'itemName.*' => 'required',
            'stockQty.*' => 'required|integer|min:1|max:999',
            'stofee.*' => 'required|numeric|min:1|max:999999.99',
            'eqName.*' => 'required',
            'eqQty.*' => 'required|integer|min:1|max:999',
            'eqfee.*' => 'required|numeric|min:1|max:999999.99',
            'wakeDay' => 'required|integer|min:1|max:999'
        ], [
            'package.required' => 'This field is required.',

            'clientName.required' => 'This field is required.',
            'clientName.max' => '100 charaters limit reached.',
            
            'address.required' => 'This field is required.',
            'address.max' => '150 charaters limit reached.',

            'clientConNum.required' => 'This field is required.',
            'clientConNum.integer' => 'Number only.',
            'clientConNum.digits' => 'Not a valid number.',

            'svcDate.required' => 'This field is required.',
            'svcDate.after_or_equal' => 'The start date must be today or after.',

            'timeStart.required' => 'This field is required.',
            'timeEnd.required' => 'This field is required.',

            'wakeLoc.required' => 'This field is required.',
            'burialLoc.required' => 'This field is required.',
            'decName.required' => 'This field is required.',

            'decBorn.required' => 'This field is required.',
            'decBorn.before_or_equal' => 'The date must be before or today.',

            'decDied.required' => 'This field is required.',
            'decDied.after_or_equal' => 'The date must be after of equal the date of born.',

            'decCOD.required' => 'This field is required.',

            'payment.required' => 'This field is required.',
            'payment.number' => 'Number only.',
            'payment.min' => 'Invalid amount',
            'payment.max' => '6 digit limit reached.',

            'vehicle.required' => 'This field is required.',

            'stockQty.*.required' => 'This field is required.',
            'stockQty.*.min' => 'Item quantity must be 1 or more.',
            'stockQty.*.max' => '3 digits limit reached.',

            'stofee.*.required' => 'This field is required.',
            'stofee.*.numeric' => 'Numer only.',
            'stofee.*.min' => 'Amount must be 1 or more.',
            'stofee.*.max' => '6 digits limit reached.',

            'eqQty.*.required' => 'This field is required.',
            'eqQty.*.min' => 'Equipment quantity must be 1 or more.',
            'eqQty.*.max' => '3 digits limit reached.',

            'eqfee.*.required' => 'This field is required.',
            'eqfee.*.numeric' => 'Numer only.',
            'eqfee.*.min' => 'Amount must be 1 or more.',
            'eqfee.*.max' => '6 digits limit reached.',

            'wakeDay.required' => 'This field is required.',
            'wakeDay.min' => 'Day must be 1 or more.',
            'wakeDay.max' => '3 digits limit reached.',

            'pkgPrice.required' => 'This field is required.',
            'pkgPrice.numeric' => 'Number only.',
            'pkgPrice.min' => 'Amount must be 1 or more.',
            'pkgPrice.max' => '6 digits limit reached.'
        ]);

        $start = Carbon::parse($request->jo_svc_date. ' ' .$request->jo_start_time);
        $end   = Carbon::parse($request->jo_svc_date. ' ' .$request->jo_end_time);

        if ($end->lt($start)) { // lt = less than
            return back()->with('promt-f-date', 'End time must be after start time.')->withInput();
        }

        $eq = $request->equipment;
        $eqQty = $request->eqQty;
        $eqFee = $request->eqfee;
        $sto = $request->stock;
        $stoQty = $request->stockQty;
        $stoFee = $request->stofee; 

        $sumEqFee = array();
        $sumStoFee = array();

        

        //get all equipment in request and rpovide error
        $equipmentErrors = [];
        if ($eq !== null) {
            for ($i = 0; $i < count($eq); $i++) {
                $equipmentId = $eq[$i];
                $requestedQty = (int) $eqQty[$i];
                array_push($sumEqFee, (float) $eqFee[$i]);

                $equipment = Equipment::find($equipmentId);

                if (!$equipment) {
                    $equipmentErrors["equipment.$i"] = "Equipment item not found.";
                    continue;
                }
                if ($requestedQty > $equipment->eq_available) {
                    $equipmentErrors["eqQty.$i"] = "Requested quantity ($requestedQty) exceeds available equipment ({$equipment->eq_available}).";
                }
            }

            if (!empty($equipmentErrors)) {
                return back()->withErrors($equipmentErrors)->withInput();
            }
        }

        $StoErrors = [];
        if ($sto != null) {
            for ($i = 0; $i < count($sto); $i++) {
                $stockId = $sto[$i];
                $requestedQty = (int) $stoQty[$i];
                array_push($sumStoFee, (float) $stoFee[$i]);

                // Get stock from DB
                $stock = Stock::find($stockId); // replace with your actual Stock model

                if (!$stock) {
                    $StoErrors["stock.$i"] = "Stock item not found.";
                    continue;
                }
                if ($requestedQty > $stock->item_qty) {
                    $StoErrors["stockQty.$i"] = "Requested quantity ({$requestedQty}) exceeds available stock ({$stock->item_qty}).";
                }
            }

            if (!empty($StoErrors)) {
                return back()->withErrors($StoErrors)->withInput();
            }
        }

        $eqTotal = array_sum($sumEqFee);
        $stoTotal = array_sum($sumStoFee);

        //dd($request->payment >= $request->total ? 'paid' : 'not paid');
        jobOrderDetails::create([
            'dec_name' => $request->decName,
            'dec_born_date' => $request->decBorn, 
            'dec_died_date' => $request->decDied,
            'dec_cause_of_death' => $request->decCOD,
            'jod_days_of_wake' => $request->wakeDay,
            'jod_wakeLoc' => $request->wakeLoc,
            'jod_burialLoc' => $request->burialLoc,
            'jod_eq_stat' => 'Pending',
            'pkg_id' => $request->pkgId,
            'chap_id' => $request->chapId
        ]);

        $jodId = jobOrderDetails::orderBy('id', 'desc')->take(1)->value('id');

        if ($eq != null) {
            for ($i = 0; $i < count($eq); $i++) {
                addEquipment::create([
                    'jod_id' => $jodId,
                    'eq_id' => $eq[$i],
                    'eq_add_fee' => $eqFee[$i],
                    'eq_dpl' => $eqQty[$i]
                ]);
            }
        }

        if ($sto != null) {
            for ($i = 0; $i < count($sto); $i++) {
                addStock::create([
                    'jod_id' => $jodId,
                    'stock_id' => $sto[$i],    
                    'stock_add_fee' => $stoFee[$i],
                    'stock_dpl' => $stoQty[$i]
                ]);
            }
        }

        jobOrder::create([
            'client_name' => $request->clientName,
            'client_contact_number' => $request->clientConNum,
            'client_address' => $request->address,
            'jo_dp' => $request->payment,
            'jo_total' => $request->total + ($eqTotal + $stoTotal),
            'jo_status' => $request->payment >= $request->total ? 'Paid' : 'Pending',
            'jo_start_date' => $request->svcDate,
            'jo_start_time' => $request->timeStart,
            'jo_end_time' => $request->timeEnd,
            'emp_id' => session('loginId'),
            'jod_id'=> $jodId
        ]);

        $joId = jobOrder::orderBy('id', 'desc')->take(1)->value('id');
      
        Log::create([
            'transaction' => 'Create',
            'tx_desc' => 'Created New Job Order | ID: ' . $joId,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        //return redirect(route('Service-Request.show', $jodId));
        return redirect(route('Job-Order.index'))->with('success', 'Created successfully!');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $joData = jobOrder::findOrFail($id);
        $jodData = jobOrderDetails::findOrFail($joData->jod_id);

        $addEqData = addEquipment::where('jod_id', $jodData->id)->get();
        $addStoData = addStock::where('jod_id', $jodData->id)->get();

        $pkgEqData = PkgEquipment::where('pkg_id', $jodData->pkg_id)->get();
        $pkgStoData = PkgStock::where('pkg_id', $jodData->pkg_id)->get();

        $tempEqData = TempEquipment::where('jod_id', $joData->jod_id)->get();
   

        return view('shows/jobOrdShow', ['joData' => $joData, 'jodData' => $jodData, 'addStoData' => $addStoData, 
                                    'addEqData' => $addEqData, 'pkgEqData' => $pkgEqData, 'pkgStoData' => $pkgStoData, 'tempEqData' => $tempEqData]);
    }

    public function showDeployItems(string $id)
    {
        $joData = jobOrder::findOrFail($id);
        $jodData = jobOrderDetails::findOrFail($joData->jod_id);

        $addEqData = addEquipment::where('jod_id', $jodData->id)->get();
        $addStoData = addStock::where('jod_id', $jodData->id)->get();

        $pkgEqData = PkgEquipment::where('pkg_id', $jodData->pkg_id)->get();
        $pkgStoData = PkgStock::where('pkg_id', $jodData->pkg_id)->get();
        return view('shows/jobOrdDeplShow', ['joData' => $joData, 'jodData' => $jodData, 'addStoData' => $addStoData, 
                                        'addEqData' => $addEqData, 'pkgEqData' => $pkgEqData, 'pkgStoData' => $pkgStoData]);
    }

    public function deployItems(Request $request, string $id)
    {
        $request->validate([
            'addEqId.*' => 'required',
            'addStoId.*' => 'required',

            'addEqDepl.*' => 'required|integer|min:1|max:999',
            'addStoDepl.*' => 'required|integer|min:1|max:999',

            'eqId.*' => 'required',
            'stoId.*' => 'required',

            'eqDepl.*' => 'required|integer|min:0|max:999',
            'stoDepl.*' => 'required|integer|min:0|max:999'

        ], [
            'stoDepl.*.required' => 'This field is required.',
            'stoDepl.*.min' => 'Quantity must atleast 0 or more.',
            'stoDepl.*.max' => '3 digit item quantity reached.',
            'eqDepl.*.required' => 'This field is required.',
            'eqDepl.*.min' => 'Quantity must be 0 or more.',
            'eqDepl.*.max' => '3 digit equipment quantity reached.',
        ]);

        // Store additional equipment and stock IDs and quantity used
        $addStoId = $request->addStoId;
        $addEqId = $request->addEqId;

        $addStoDepl = $request->addStoDepl;
        $addEqDepl = $request->addEqDepl;

        // Store equipment and stock IDs and quantity used
        $stoId = $request->stoId;
        $eqId = $request->eqId;

        $stoDepl = $request->stoDepl;
        $eqDepl = $request->eqDepl;

        //dd($addStoId, $addStoDepl, $addEqId, $addEqDepl);
        //dd($stoId, $stoDepl, $eqId, $eqDepl);

        // Check date
        $jo = jobOrder::select('id', 'jo_start_date')->where('jod_id', $id)->first();
        if (Carbon::parse($jo->jo_start_date)->gt(Carbon::today())) {
            return redirect()->back()
                ->with('promt-f', 'Cannot deploy before (' . $jo->jo_start_date . ')')
                ->withInput();
        }

        // for additional item and equipment

        if ($addStoId != null) {
            $addStocks = Stock::select('id', 'item_qty')->whereIn('id', $addStoId)->get();
            foreach ($addStocks as $index => $data) {
                $data->update([
                    'item_qty' => $data->item_qty - $addStoDepl[$index],
                ]);
            }
        }

        if ($addEqId != null) {
            $addEq = Equipment::select('id', 'eq_available', 'eq_in_use')->whereIn('id', $addEqId)->get();
            foreach ($addEq as $index => $data) {
                $data->update([
                    'eq_available' => $data->eq_available - $addEqDepl[$index],
                    'eq_in_use' => $data->eq_in_use + $addEqDepl[$index],
                ]);
            }
        }

        // for the inital item and equipment from th package
        $stocks = Stock::select('id', 'item_qty')->whereIn('id', $stoId)->get();
        $eq = Equipment::select('id', 'eq_available', 'eq_in_use')->whereIn('id', $eqId)->get();
        $pkgEq = PkgEquipment::select('id', 'eq_used')->whereIn('eq_id', $eqId)->get();

        foreach ($stocks as $index => $data) {
            $data->update([
                'item_qty' => $data->item_qty - $stoDepl[$index],
            ]);
        }

        foreach ($eq as $index => $data) {
            TempEquipment::create([
                'jod_id' => $id,
                'pkg_eq_id' => $pkgEq[$index]->id,
                'eq_dpl_qty' => $eqDepl[$index]
            ]);

            $data->update([
                'eq_available' => $data->eq_available - $eqDepl[$index],
                'eq_in_use' => $data->eq_in_use + $eqDepl[$index],
            ]);
        }

        jobOrderDetails::findOrFail($id)->update([
            'jod_eq_stat' => 'Deployed',
            'jod_deploy_date' => Carbon::now()->format('Y-m-d')
        ]);

        Log::create([
            'transaction' => 'Deploy',
            'tx_desc' => 'Deployed Equipment from Job Order | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Job-Order.showReturn', $jo->id))->with('promt-s', 'Deployed Successfuly.');
    }

    public function showReturnItems(string $id)
    {
        $joData = jobOrder::findOrFail($id);
        $jodData = jobOrderDetails::findOrFail($joData->jod_id);

        $addEqData = addEquipment::where('jod_id', $jodData->id)->get();
        $addStoData = addStock::where('jod_id', $jodData->id)->get();

        $pkgEqData = PkgEquipment::where('pkg_id', $jodData->pkg_id)->get();
        $pkgStoData = PkgStock::where('pkg_id', $jodData->pkg_id)->get();

        $tempEqData = TempEquipment::where('jod_id', $joData->jod_id)->get();
   

        return view('functions/jobOrdReturn', ['joData' => $joData, 'jodData' => $jodData, 'addStoData' => $addStoData, 
                                    'addEqData' => $addEqData, 'pkgEqData' => $pkgEqData, 'pkgStoData' => $pkgStoData, 'tempEqData' => $tempEqData]);
    }

    public function returnItems(Request $request, string $id)
    {
        $request->validate([
            'addEqId.*' => 'required',
            'addEqDepl.*' => 'required|integer|min:1|max:999',

            'eqId.*' => 'required',
            'eqDepl.*' => 'required|integer|min:0|max:999'

        ]);

        // Store additional equipment and stock IDs and quantity used
        $addEqId = $request->addEqId;
        $addEqDepl = $request->addEqDepl;

        // Store equipment and stock IDs and quantity used
        $eqId = $request->eqId;
        $eqDepl = $request->eqDepl;

        //dd($addStoId, $addStoDepl, $addEqId, $addEqDepl);
        //dd($stoId, $stoDepl, $eqId, $eqDepl);

        // Check date
        $jo = jobOrder::select('id', 'jo_start_date')->where('jod_id', $id)->first();
        if (Carbon::parse($jo->jo_start_date)->gt(Carbon::today())) {
            return redirect()->back()
                ->with('promt-f', 'Cannot deploy before (' . $jo->jo_start_date . ')')
                ->withInput();
        }

        // for additional item and equipment

        if ($addEqId != null) {
            $addEq = Equipment::select('id', 'eq_available', 'eq_in_use')->whereIn('id', $addEqId)->get();
            foreach ($addEq as $index => $data) {
                $data->update([
                    'eq_available' => $data->eq_available + $addEqDepl[$index],
                    'eq_in_use' => $data->eq_in_use - $addEqDepl[$index],
                ]);
            }
        }

        // for the inital item and equipment from th package
        $eq = Equipment::select('id', 'eq_available', 'eq_in_use')->whereIn('id', $eqId)->get();
        $pkgEq = PkgEquipment::select('id', 'eq_used')->whereIn('eq_id', $eqId)->get();

        foreach ($eq as $index => $data) {
            TempEquipment::create([
                'jod_id' => $id,
                'pkg_eq_id' => $pkgEq[$index]->id,
                'eq_dpl_qty' => $eqDepl[$index]
            ]);

            $data->update([
                'eq_available' => $data->eq_available + $eqDepl[$index],
                'eq_in_use' => $data->eq_in_use - $eqDepl[$index],
            ]);
        }

        jobOrderDetails::findOrFail($id)->update([
            'jod_eq_stat' => 'Returned',
            'jod_return_date' => Carbon::now()->format('Y-m-d')
        ]);

        Log::create([
            'transaction' => 'Return',
            'tx_desc' => 'Returned Equipment from Job Order | ID: ' . $jo->id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);
        return redirect(route('Job-Order.show', $jo->id))->with('promt-s', 'Returned Successfuly.');
    }

    public function applyBurAsst(string $id)
    {
        $joData = jobOrder::findOrFail($id);
        return view('functions/burialAssistanceAdd', ['joData' => $joData]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $joData = jobOrder::findOrFail($id);
        $jodData = jobOrderDetails::findOrFail($joData->jod_id);
        return view('functions/jobOrdEdit', ['joData' => $joData, 'jodData' => $jodData]);
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
