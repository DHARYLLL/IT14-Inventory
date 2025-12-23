<?php

namespace App\Http\Controllers;

use App\Models\addEquipment;
use App\Models\addStock;
use App\Models\AddWake;
use App\Models\BurialAssistance;
use App\Models\BurialAsst;
use App\Models\Chapel;
use App\Models\embalming;
use App\Models\Equipment;
use App\Models\jobOrder;
use App\Models\jobOrderDetails;
use App\Models\Log;
use App\Models\Package;
use App\Models\PkgEquipment;
use App\Models\PkgStock;
use App\Models\ServiceRequest;
use App\Models\Soa;
use App\Models\Stock;
use App\Models\TempEquipment;
use App\Models\vehicle;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Faker\Provider\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = JobOrder::leftJoin(
                'services_requests',
                'services_requests.id',
                '=',
                'job_orders.svc_id'
            )
            ->select('job_orders.*')
            ->orderByRaw("
                CASE
                    WHEN services_requests.svc_status = 'Completed'
                    AND job_orders.jo_status = 'Paid'
                    THEN 1 ELSE 0
                END
            ")
            ->orderBy('client_fname', 'asc');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('client_fname', 'like', "%{$search}%")
                ->orWhere('client_mname', 'like', "%{$search}%")
                ->orWhere('client_lname', 'like', "%{$search}%")
                ->orWhere('client_address', 'like', "%{$search}%")
                ->orWhere('client_contact_number', 'like', "%{$search}%");
            });
        }

        // Filter
        if ($request->filled('filter') && $request->filter !== 'all') {
            if ($request->filter === 'paid') {
                $query->where('jo_status', 'Paid');
            } elseif ($request->filter === 'pending') {
                $query->where('jo_status', '!=', 'Paid');
            } elseif ($request->filter === 'package') {
                $query->whereNotNull('jod_id');
            } elseif ($request->filter === 'service') {
                $query->whereNull('jod_id');
            }
        }

        $jOData = $query->paginate(10)->withQueryString();

        // AJAX response
        if ($request->ajax()) {
            return response()->json([
                'table' => view('alar.partials.jobOrderTable', compact('jOData'))->render(),
                'pagination' => view('alar.partials.jobOrderPagination', compact('jOData'))->render(),
            ]);
        }

        return view('alar.jobOrder', compact('jOData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $jodIds = jobOrder::where('jo_burial_date', '>=', today())
            ->where('jo_start_date', '<=', today())
            ->whereNotNull('jod_id') 
            ->pluck('jod_id');
        //dd($jodIds);

        $usedChapelIds = jobOrderDetails::whereIn('id', $jodIds)
            ->where('jod_eq_stat', '<>', 'Returned')
            ->whereNotNull('chap_id')
            ->pluck('chap_id');

        $pkgData = Package::all();
        $chapData = Chapel::whereNotIn('id', $usedChapelIds)->get();
        $vehData = vehicle::all();
        $embalmData = embalming::all();

        $eqData = Equipment::all();
        $stoData = Stock::all();

        return view('functions/jobOrdDetailAdd', ['pkgData' => $pkgData, 'chapData' => $chapData, 'vehData' => $vehData, 'eqData' => $eqData, 'stoData' => $stoData, 'embalmData' => $embalmData]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $today = Carbon::now('Asia/Manila')->startOfDay();
        //dd(Carbon::parse($request->svcDate)->addDays((int)$request->wakeDay));
        $request->validate([
            'package' => 'required',
            'vehicle' => 'required',
            'embalm' => 'required',
            'cliFname' => 'required|regex:/^[A-Za-z0-9\s\.\'-]+$/|min:1|max:50',
            'cliMname' => 'required|regex:/^[A-Za-z0-9\s\.\'-]+$/|min:1|max:20',
            'cliLname' => 'required|regex:/^[A-Za-z0-9\s\.\'-]+$/|min:1|max:20',
            'address' => 'required|max:150',
            'clientConNum' => 'required|regex:/^[0-9]{11}$/',
            'svcDate' => [
                'required',
                Rule::date()->afterOrEqual($today->format('Y-m-d'))
            ],
            'decFname' => ['required',
                            'max:50',
                            Rule::unique('job_ord_details', 'dec_fname')
                            ->where('dec_mname', $request->decMname)
                            ->where('dec_lname', $request->decLname)
            ],
            'decMname' => 'required|max:20',
            'decLname' => 'required|max:20',
            'decBorn' => [
                'required',
                Rule::date()->beforeOrEqual($today->format('Y-m-d'))
            ],
            'decDied' => [
                'required',
                Rule::date()->afterOrEqual('decBorn')
                ->beforeOrEqual($today->format('Y-m-d'))
            ],
            'payment' => 'required|integer|min:1000|max:999999',
            'total' => 'required|integer|min:1|max:999999',

            'wakeDay' => 'required|integer|min:1|max:999'
        ], [
            'package.required' => 'This field is required.',
            'vehicle.required' => 'This field is required.',
            'embalm.required' => 'This field is required.',

            'cliFname.required' => 'This field is required.',
            'cliFname.regex' => 'Not a valid name.',
            'cliFname.min' => 'At least 1 or more characters.',
            'cliFname.max' => '50 charaters limit reached.',
            
            'cliMname.required' => 'This field is required.',
            'cliMname.regex' => 'Not a valid name.',
            'cliMname.min' => 'At least 1 or more characters.',
            'cliMname.max' => '20 charaters limit reached.',

            'cliLname.required' => 'This field is required.',
            'cliLname.regex' => 'Not a valid name.',
            'cliLname.min' => 'At least 1 or more characters.',
            'cliLname.max' => '20 charaters limit reached.',
            
            'address.required' => 'This field is required.',
            'address.max' => '150 charaters limit reached.',

            'clientConNum.required' => 'This field is required.',
            'clientConNum.regex' => 'Not a valid number.',

            'svcDate.required' => 'This field is required.',
            'svcDate.after_or_equal' => 'The start date must be today or after.',

            'decFname.required' => 'This field is required.',
            'decFname.unique' => 'Deceased name has been taken.',
            'decFname.max' => '50 characters limit reached.',

            'decMname.required' => 'This field is required.',
            'decMname.max' => '20 characters limit reached.',

            'decLname.required' => 'This field is required.',
            'decLname.max' => '20 characters limit reached.',

            'decBorn.required' => 'This field is required.',
            'decBorn.before_or_equal' => 'The date must be before or today.',

            'decDied.required' => 'This field is required.',
            'decDied.after_or_equal' => 'The date must be after of equal the date of born.',
            'decDied.before_or_equal' => 'The date must be before of today.',

            'payment.required' => 'This field is required.',
            'payment.number' => 'Number only.',
            'payment.min' => 'Minimum downpayment PHP 1,000.',
            'payment.max' => '6 digit limit reached.',

            'wakeDay.required' => 'This field is required.',
            'wakeDay.min' => 'Day must be 1 or more.',
            'wakeDay.max' => '3 digits limit reached.',

            'pkgPrice.required' => 'This field is required.',
            'pkgPrice.numeric' => 'Number only.',
            'pkgPrice.min' => 'Amount must be 1 or more.',
            'pkgPrice.max' => '6 digits limit reached.'
        ]);

        $checkAvail = Carbon::parse($request->svcDate)
            ->addDays((int)$request->wakeDay)
            ->toDateString();

        $driverUnavailable = jobOrder::where('jo_burial_date', $checkAvail)
            ->whereRelation('joToSvcReq', 'veh_id', $request->vehicle)
            ->whereRelation('joToSvcReq', 'svc_status', '<>', 'Completed')
            ->exists();

        if ($driverUnavailable) {
            //dd('driver not available', $checkAvail);
            return back()->with('promt-f', 'Driver not available at the date of burial.')->withInput();
        }

        //dd('driver available', $checkAvail);

        
        ServiceRequest::create([
            'veh_id' => $request->vehicle,
            'prep_id' => $request->embalm,
            'svc_status' =>  Carbon::parse($request->svcDate)->addDays((int)$request->wakeDay)->isSameDay(Carbon::today()) ? 'Ongoing' : 'Pending'
        ]);

        $svcId = ServiceRequest::orderBy('id', 'desc')->take(1)->value('id');

        //dd($request->payment >= $request->total ? 'paid' : 'not paid');
        jobOrderDetails::create([
            'dec_fname' => $request->decFname,
            'dec_mname' => $request->decMname,
            'dec_lname' => $request->decLname,
            'dec_born_date' => $request->decBorn, 
            'dec_died_date' => $request->decDied,
            'jod_days_of_wake' => $request->wakeDay,
            'jod_burialLoc' => $request->burialLoc,
            'jod_eq_stat' => 'Pending',
            'pkg_id' => $request->pkgId,
            'chap_id' => $request->chapId
        ]);

        $jodId = jobOrderDetails::orderBy('id', 'desc')->take(1)->value('id');

        jobOrder::create([
            'client_fname' => $request->cliFname,
            'client_mname' => $request->cliMname,
            'client_lname' => $request->cliLname,
            'client_contact_number' => $request->clientConNum,
            'client_address' => $request->address,
            'jo_total' => $request->total,
            'jo_status' => $request->payment >= $request->total ? 'Paid' : 'Pending',
            'jo_start_date' => $request->svcDate,
            'jo_embalm_time' => $request->embalmTime,
            'jo_burial_date' => Carbon::parse($request->svcDate)->addDays((int)$request->wakeDay)->toDateString(),
            'jo_burial_time' => $request->burialTime,
            'jod_id' => $jodId,
            'svc_id' => $svcId
        ]);

        $joId = jobOrder::orderBy('id', 'desc')->take(1)->value('id');

        Soa::Create([
            'payment' => $request->payment,
            'payment_date' => Carbon::today(),
            'jo_id' => $joId,
            'emp_id' => session('loginId')
        ]);
      
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

        $pkgEqData = PkgEquipment::where('pkg_id', $jodData->pkg_id)->get();
        $pkgStoData = PkgStock::where('pkg_id', $jodData->pkg_id)->get();

        $tempEqData = TempEquipment::where('jod_id', $joData->jod_id)->get();
        $payHistoryData = Soa::select('payment', 'payment_date', 'emp_id')->where('jo_id', $id)->orderBy('id', 'desc')->get();

        return view('shows/jobOrdShow', ['joData' => $joData, 'jodData' => $jodData, 'pkgEqData' => $pkgEqData, 'pkgStoData' => $pkgStoData, 'tempEqData' => $tempEqData, 'payHistoryData' => $payHistoryData]);
    }

    public function showDeployItems(string $id)
    {
        $joData = jobOrder::findOrFail($id);
        $jodData = jobOrderDetails::findOrFail($joData->jod_id);

        $pkgEqData = PkgEquipment::where('pkg_id', $jodData->pkg_id)->get();
        $pkgStoData = PkgStock::where('pkg_id', $jodData->pkg_id)->get();
        $payHistoryData = Soa::select('payment', 'payment_date', 'emp_id')->where('jo_id', $id)->orderBy('id', 'desc')->get();
        $vehData = vehicle::all();
        $embalmData = embalming::all();
        return view('shows/jobOrdDeplShow', ['joData' => $joData, 'jodData' => $jodData, 'pkgEqData' => $pkgEqData, 
                                            'pkgStoData' => $pkgStoData , 'payHistoryData' => $payHistoryData,
                                            'vehData' => $vehData, 'embalmData' => $embalmData]);
    }

    public function deployItems(Request $request, string $id)
    {
        $request->validate([
            'eqId.*' => 'required',
            'stoId.*' => 'required',

            'eqDepl.*' => 'required|integer|min:0|max:999',

            'stoDepl.*' => 'required|integer|min:0|max:999',

        ], [
            'stoDepl.*.required' => 'This field is required.',
            'stoDepl.*.min' => 'Quantity must atleast 0 or more.',
            'stoDepl.*.max' => '3 digit item quantity reached.',

            'eqDepl.*.required' => 'This field is required.',
            'eqDepl.*.min' => 'Quantity must be 0 or more.',
            'eqDepl.*.max' => '3 digit equipment quantity reached.'
        ]);

        // Store equipment and stock IDs and quantity used
        $stoId = $request->stoId;
        $eqId = $request->eqId;

        $stoDepl = $request->stoDepl;
        $eqDepl = $request->eqDepl;

        //dd($addStoId, $addStoDepl, $addEqId, $addEqDepl);
        //dd($stoId, $stoDepl, $eqId, $eqDepl);


        // Check date
        $jo = jobOrder::select('id', 'jo_start_date', 'jo_burial_time')->where('jod_id', $id)->first();
        if ($jo->jo_burial_time == null) {
            return redirect()->back()
                ->with('promt-f', 'Please schedule burial time.')
                ->withInput();
        }
        $today = Carbon::now('Asia/Manila')->startOfDay();
        $joDate = Carbon::parse($jo->jo_start_date);
        if ($joDate->gt($today->format('Y-m-d'))) {
            return redirect()->back()
                ->with('promt-f', 'Cannot deploy before (' . $jo->jo_start_date . ')')
                ->withInput();
        }

        // for the inital item and equipment from th package
        $stocks = Stock::select('id', 'item_qty')->whereIn('id', $stoId)->get();
        $eq = Equipment::select('id', 'eq_available', 'eq_in_use')->whereIn('id', $eqId)->get();
        $pkgEq = PkgEquipment::select('id', 'eq_used')->whereIn('eq_id', $eqId)->get();

        foreach ($stocks as $index => $data) {
            $data->update([
                'item_qty' => $data->item_qty - $stoDepl[$index]
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

        return redirect(route('Job-Order.index'))->with('success', 'Deployed Successfuly!');
    }

    public function showReturnItems(string $id)
    {
        $joData = jobOrder::findOrFail($id);
        $jodData = jobOrderDetails::findOrFail($joData->jod_id);

        $pkgEqData = PkgEquipment::where('pkg_id', $jodData->pkg_id)->get();
        $pkgStoData = PkgStock::where('pkg_id', $jodData->pkg_id)->get();

        $tempEqData = TempEquipment::where('jod_id', $joData->jod_id)->get();

        $payHistoryData = Soa::select('payment', 'payment_date', 'emp_id')->where('jo_id', $id)->orderBy('id', 'desc')->get();
        $vehData = vehicle::all();
        $embalmData = embalming::all();

        return view('functions/jobOrdReturn', ['joData' => $joData, 'jodData' => $jodData, 'pkgEqData' => $pkgEqData, 
                                                'pkgStoData' => $pkgStoData, 'tempEqData' => $tempEqData, 'payHistoryData' => $payHistoryData,
                                                'vehData' => $vehData, 'embalmData' => $embalmData]);
    }

    public function returnItems(Request $request, string $id)
    {
        $request->validate([
            'addEqId.*' => 'required',
            'addEqDepl.*' => 'required|integer|min:1|max:999',

            'eqId.*' => 'required',
            'eqDepl.*' => 'required|integer|min:0|max:999'

        ]);
        // Store equipment and stock IDs and quantity used
        $eqId = $request->eqId;

        $eqDepl = $request->eqDepl;

        // Check date for deployment
        $jo = jobOrder::select('id', 'jo_start_date', 'svc_id')->where('jod_id', $id)->first();

        // for the inital item and equipment from the package
        $eq = Equipment::select('id', 'eq_available', 'eq_in_use')->whereIn('id', $eqId)->get();
        $pkgEq = PkgEquipment::select('id', 'eq_used')->whereIn('eq_id', $eqId)->get();

        foreach ($eq as $index => $data) {
            $data->update([
                'eq_available' => $data->eq_available + $eqDepl[$index],
                'eq_in_use' => $data->eq_in_use - $eqDepl[$index],
            ]);
        }

        jobOrderDetails::findOrFail($id)->update([
            'jod_eq_stat' => 'Returned',
            'jod_return_date' => Carbon::now()->format('Y-m-d')
        ]);

        ServiceRequest::findOrFail($jo->svc_id)->update([
            'svc_status' => 'Completed'
        ]);

        Log::create([
            'transaction' => 'Return',
            'tx_desc' => 'Returned Equipment from Job Order | ID: ' . $jo->id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);
        return redirect(route('Job-Order.show', $jo->id))->with('success', 'Returned Successfuly!');
    }

    public function applyBurAsst(string $id)
    {
        $joData = jobOrder::findOrFail($id);
        return view('functions/burialAssistanceAdd', ['joData' => $joData]);
    }

     public function applySched(Request $request, string $id)
    {
        $request->validate([
            'burialTime' => 'required'
        ],[
            'burialTime.required' => 'This field is required.'
        ]);

        jobOrder::findOrFail($id)->update([
            'jo_embalm_time' => $request->embalmTime,
            'jo_burial_time' => $request->burialTime
        ]);

        Log::create([
            'transaction' => 'Added',
            'tx_desc' => 'Added time schedule | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

       return redirect()->back()->with('success', 'Updated Schedule!');
    }

    public function updateRA(Request $request, string $id)
    {
        $row = JobOrder::findOrFail($id);
        $row->ra = $request->boolean('status'); 
        $row->save();

        return redirect()->back();
    }

    public function payAmount(Request $request, string $id)
    {
        $request->validate([
            'payAmount' => 'required|numeric|min:100|max:999999' 
        ], [
            'payAmount.required' => 'This field is required.',
            'payAmount.numeric' => 'Number only.',
            'payAmount.min' => 'Minimum payment is PHP 100.',
            'payAmount.max' => '6 digit limit reached.'
        ]);
        $getDp = jobOrder::select('id', 'svc_id', 'jo_total', 'ba_id')->where('id', $id)->first();
        $totalPayment = Soa::where('jo_id', $id)->sum('payment');

        $addWakeTotal = 0;
        if ($request->addWakeId != null) {
            $getWake = AddWake::where('id', $request->addWakeId)->first();
            $addWakeTotal = $getWake->day * $getWake->fee;
        }

        $burAsstTotal = 0;
        if ($getDp->ba_id) {
            $getBurrAsst = BurialAsst::select('id', 'amount')->where('id', $getDp->ba_id)->first();
            $burAsstTotal = $getBurrAsst->amount;
        }

        if ((($getDp->jo_total + $addWakeTotal) - ($totalPayment + $burAsstTotal)) <= $request->payAmount)
        {
            Soa::Create([
                'payment' => $request->payAmount,
                'payment_date' => Carbon::today(),  
                'jo_id' => $id,
                'emp_id' => session('loginId')
            ]);
            jobOrder::findOrFail($getDp->id)->update([
                'jo_status' => 'Paid'
            ]);
        } else {
            Soa::Create([
                'payment' => $request->payAmount,
                'payment_date' => Carbon::today(),
                'jo_id' => $id,
                'emp_id' => session('loginId')
            ]);     
        }    
        
        Log::create([
            'transaction' => 'Pay',
            'tx_desc' => 'Payed for Job Order| ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId') 
        ]);


        return redirect()->back()->with('success', 'Paid Successfully!');
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
