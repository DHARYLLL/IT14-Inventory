<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $logData = Log::all();
        // return view('alar/logs', ['logData' => $logData]);
        $search = $request->query('search');

        $logData = Log::with('logToEmp')
            ->when($search, function ($query, $search) {
                $query->where('transaction', 'like', "%{$search}%")
                    ->orWhere('tx_desc', 'like', "%{$search}%")
                    ->orWhereHas('logToEmp', function ($q) use ($search) {
                        $q->where('emp_fname', 'like', "%{$search}%")
                        ->orWhere('emp_lname', 'like', "%{$search}%");
                    });
            })
            ->orderBy('tx_date', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            return view('alar.partials.logs-table', compact('logData'))->render();
        }

        return view('alar.logs', compact('logData'));
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
