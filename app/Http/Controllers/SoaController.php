<?php

namespace App\Http\Controllers;

use App\Models\Soa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $soaData = Soa::orderBy('payment_date', 'desc')->get();
        // return view('alar/paymentHistory', ['soaData' => $soaData]);
        $search = $request->search;
        $filter = $request->filter;

        $query = Soa::orderBy('id', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('soaToJo', function ($q2) use ($search) {
                    $q2->where('client_name', 'like', "%{$search}%");
                })
                ->orWhereHas('soaToEmp', function ($q2) use ($search) {
                    $q2->where('emp_fname', 'like', "%{$search}%")
                       ->orWhere('emp_lname', 'like', "%{$search}%");
                });
            });
        }

        if ($filter === 'today') {
            $query->whereDate('payment_date', Carbon::today());
        }

        if ($filter === 'week') {
            $query->whereBetween('payment_date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        }

        if ($filter === 'month') {
            $query->whereMonth('payment_date', Carbon::now()->month)
                  ->whereYear('payment_date', Carbon::now()->year);
        }

        if ($filter === 'year') {
            $query->whereYear('payment_date', Carbon::now()->year);
        }

        $soaData = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('alar.partials.soa-table', compact('soaData'))->render();
        }

        return view('alar/paymentHistory', compact('soaData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shows/viewReport'); // your Blade page
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
