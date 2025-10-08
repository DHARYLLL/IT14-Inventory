<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Log;
use App\Models\PurchaseOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        Invoice::create([
            'invoice_number' => $request->inv_num,
            'invoice_date' => $request->inv_date,
            'total' => $request->total,
            'po_id' => $request->po_id
        ]);

        PurchaseOrder::findOrFail($request->po_id)->update([
            'status' => 'Delivered',
            'delivered_date' => Carbon::now()->format('Y-m-d')
        ]);

        $empId = Employee::orderBy('id','desc')->take(1)->value('id');
        $invId = Invoice::orderBy('id','desc')->take(1)->value('id');

        Log::create([
            'action' => 'Create',
            'from' => 'Created Invoice | ID: ' . $invId,
            'action_date' => Carbon::now()->format('Y-m-d'),
            'emp_id' => $empId
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
