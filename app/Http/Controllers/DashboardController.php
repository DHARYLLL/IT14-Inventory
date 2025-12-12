<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Invoice;
use App\Models\jobOrder;
use App\Models\Log;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stockData = Stock::all();
        $lowStockData = Stock::where('item_qty', '<', 11)->get();
        $noStockData = Stock::where('item_qty', '=', 0)->get();

        $eqData = Equipment::all();
        $lowEqData = Equipment::whereRaw('eq_available + eq_in_use < ?', [11])->get();
        $noEqData = Equipment::whereRaw('eq_available + eq_in_use <= ?', [0])->get();

        $jobOrdData = jobOrder::where('jo_start_date', '<=', Carbon::today())->
                                where('jo_burial_date', '>=', Carbon::today())->
                                orderBy('jo_start_date', 'desc')->get();

        $getValue = Invoice::select('total')->whereMonth('invoice_date', date('m'))->get();
        $set = array();
        if (count($getValue) > 0) {

            foreach ($getValue as $data) {
                array_push($set, $data->total);
            }
        }
        
        $getAv = count($getValue) > 0 ? array_sum($set) / count($getValue) : 0;

        return view('alar.dashboard', ['stockData' => $stockData, 'lowStockData' => $lowStockData, 
        'noStockData' => $noStockData, 'getAv' => $getAv, 'jobOrdData' => $jobOrdData,
        'eqData' => $eqData, 'lowEqData' => $lowEqData, 'noEqData' => $noEqData]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
