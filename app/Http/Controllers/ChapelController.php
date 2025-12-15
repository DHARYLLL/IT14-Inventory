<?php

namespace App\Http\Controllers;

use App\Models\Chapel;
use App\Models\ChapEquipment;
use App\Models\ChapStock;
use App\Models\Equipment;
use App\Models\Log;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chapData = Chapel::all();
        return view('alar/chapel', ['chapData' => $chapData]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $eqData = Equipment::all();
        $stoData = Stock::all();
        return view('functions/addChapel', ['eqData' => $eqData, 'stoData' => $stoData]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'chapName' => ['required',
                            'max:50',
                            Rule::unique('chapels', 'chap_name')
                            ->where('chap_room', $request->chapRoom)],
            'chapRoom' => 'required|max:10|unique:chapels,chap_room',
            'chapPrice' => 'required|numeric|min:1|max:999999.99'
        ], [
            'chapName.required' => 'This field is required',
            'chapName.unique' => 'Name already added.',
            'chapRoom.unique' => 'Room is already occupied.',
            'chapRoom.required' => 'This field is required',

            'chapPrice.required' => 'This field is required.',
            'chapPrice.numeric' => 'Number only.',
            'chapPrice.min' => 'Price must be 1 or more.',
            'chapPrice.max' => '6 digit price reached.',
        ]);

        Chapel::create([
            'chap_name' => $request->chapName,
            'chap_room' => $request->chapRoom,
            'chap_price' => $request->chapPrice,
            'max_cap' => $request->maxCap
        ]);

        $getChap = Chapel::orderBy('id', 'desc')->take(1)->value('id');

        Log::create([
            'transaction' => 'Added',
            'tx_desc' => 'Added Chapel | ID: ' . $getChap,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Chapel.index'))->with('success', 'Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $chapData = Chapel::findOrFail($id);
        return view('shows/chapelShow', ['chapData' => $chapData]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $chapData = Chapel::findOrFail($id);
        return view('functions/chapelEdit', ['chapData' => $chapData]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'chapName' =>  ['required',
                            'max:50',
                            Rule::unique('chapels', 'chap_name')
                            ->where('chap_room', $request->chapRoom)
                            ->ignore($id)
            ],
            'chapRoom' => ['required',
                            'max:10',
                            Rule::unique('chapels', 'chap_name')
                            ->where('chap_room', $request->chapRoom)
                            ->ignore($id)
            ],
            'chapPrice' => "required|numeric|min:1|max:999999.99"
        ],  [
            'chapName.required' => 'This field is required.',
            'chapName.max' => '50 characters limit reached.',
            'chapName.unique' => 'Name already added.',

            'chapRoom.required' => 'This field is required.',
            'chapRoom.max' => '10 characters limit reached.',
            'chapRoom.unique' => 'Room already occupied.',

            'chapPrice.required' => 'This field is required.',
            'chapPrice.numeric' => 'Number only.',
            'chapPrice.min' => 'Amount must be 1 or more.',
            'chapPrice.max' => '6 digits limit reached.',
        ]);

        Chapel::findOrFail($id)->update([
            'chap_name' => $request->chapName,
            'chap_room' => $request->chapRoom,
            'chap_price' => $request->chapPrice,
        ]);

        Log::create([
            'transaction' => 'Updated',
            'tx_desc' => 'Update Chapel | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect()->back()->with('success', 'Updated Successfuly!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Chapel::findOrFail($id)->delete();
        Log::create([
            'transaction' => 'Deleted',
            'tx_desc' => 'Deleted Chapel | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);
        return redirect(route('Chapel.index'))->with('success', 'Deleted Successfully!');
    }
}
