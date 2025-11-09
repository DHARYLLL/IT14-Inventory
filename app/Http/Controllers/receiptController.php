<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class receiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rcptData = Receipt::all();
        return view('alar/receipt', ['rcptData' => $rcptData]);
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
        $rcptData = Receipt::findOrFail($id);
        return view('shows/receiptShow', ['rcptData' => $rcptData]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rcptData = Receipt::findOrFail($id);     
        return view('functions/receiptEdit', ['rcptData' => $rcptData]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $getRcpt = Receipt::findOrFail($id);
        if ($request->check == 'edit') {
            $request->validate([
                'clientName' => 'required|unique:receipts,client_name',
                'clientConNum' => 'required'
            ], [
                'clientName.required' => 'This field is required.',
                'clientName.unique' => 'Name already added.',
                'clientConNum.required' => 'This field is required.'
            ]);

            Receipt::findOrFail($id)->update([
                'client_name' => $request->clientName,
                'client_contact_number' => $request->clientConNum
            ]);

            return redirect()->back()->with('promt', 'Updated Successfuly.');
        }
        
        if ($request->check == 'payment') {
            /*
            $request->validate([
                'paid' => 'required|numeric|min:1|max:999999.99'
            ], [
                'paid.required' => 'This field is required.',
                'paid.numeric' => 'Number only.',
                'paid.min' => 'Amount must be 1 or more.',
                'paid.max' => 'Max 6 digits reached.'
            ]);
            */
            Receipt::findOrFail($id)->update([
                'rcpt_status' => 'Paid',
                'paid_amount' => $getRcpt->total_payment
            ]);
            return redirect(route('Receipt.show', $id))->with('promt', 'Paid Successfuly.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
