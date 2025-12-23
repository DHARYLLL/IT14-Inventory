<?php

namespace App\Http\Controllers;

use App\Models\jobOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('shows/viewReport');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shows/viewReport');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dateReport' => 'required'
        ], [
            'dateReport.required' => 'This field is required.'
        ]);

        session(['dateReport' => $request->dateReport]);

        // Redirect back so iframe can load
        return redirect()->route('Report.index')->with('showPreview', true);

        // $query = jobOrder::orderBy('id', 'desc')
        //     ->where('jo_status', 'Paid');

        // if ($request->dateReport === 'today') {

        //     $query->where(function ($q) {
        //         $q->whereDate('jo_start_date', Carbon::today())
        //         ->orWhereDate('jo_burial_date', Carbon::today());
        //     });

        // } elseif ($request->dateReport === 'week') {

        //     $query->where(function ($q) {
        //         $q->whereBetween('jo_start_date', [
        //             Carbon::now()->startOfWeek(),
        //             Carbon::now()->endOfWeek(),
        //         ])
        //         ->orWhereBetween('jo_burial_date', [
        //             Carbon::now()->startOfWeek(),
        //             Carbon::now()->endOfWeek(),
        //         ]);
        //     });

        // } elseif ($request->dateReport === 'month') {

        //     $query->where(function ($q) {
        //         $q->whereMonth('jo_start_date', Carbon::now()->month)
        //         ->whereYear('jo_start_date', Carbon::now()->year)
        //         ->orWhere(function ($sub) {
        //             $sub->whereMonth('jo_burial_date', Carbon::now()->month)
        //                 ->whereYear('jo_burial_date', Carbon::now()->year);
        //         });
        //     });

        // } elseif ($request->dateReport === 'year') {

        //     $query->where(function ($q) {
        //         $q->whereYear('jo_start_date', Carbon::now()->year)
        //         ->orWhereYear('jo_burial_date', Carbon::now()->year);
        //     });

        // } elseif ($request->dateReport === 'all' || empty($request->dateReport)) {

        // }

        // $jobOrders = $query->get();

        // $pdf = Pdf::loadView('pdfTemp/joTemplate', ['jobOrders' => $jobOrders]);
        // return $pdf->stream('job-orders.pdf');
    }

    public function preview()
    {
        $dateReport = session('dateReport');
        

        $query = jobOrder::orderBy('id', 'desc')
            ->where('jo_status', 'Paid');

        if ($dateReport === 'today') {
            $query->where(function ($q) {
                $q->whereDate('jo_start_date', Carbon::today())
                ->orWhereDate('jo_burial_date', Carbon::today());
            });

        } elseif ($dateReport === 'week') {
            $query->where(function ($q) {
                $q->whereBetween('jo_start_date', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek(),
                ])
                ->orWhereBetween('jo_burial_date', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek(),
                ]);
            });

        } elseif ($dateReport === 'month') {
            $query->where(function ($q) {
                $q->whereMonth('jo_start_date', Carbon::now()->month)
                ->whereYear('jo_start_date', Carbon::now()->year)
                ->orWhere(function ($sub) {
                    $sub->whereMonth('jo_burial_date', Carbon::now()->month)
                        ->whereYear('jo_burial_date', Carbon::now()->year);
                });
            });

        } elseif ($dateReport === 'year') {
            $query->where(function ($q) {
                $q->whereYear('jo_start_date', Carbon::now()->year)
                ->orWhereYear('jo_burial_date', Carbon::now()->year);
            });
        }

        $jobOrders = $query->get();

        $pdf = Pdf::loadView('pdfTemp.joTemplate', ['joData' => $jobOrders]);

        // 👇 THIS is what iframe needs
        return $pdf->stream('job-orders.pdf');
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
