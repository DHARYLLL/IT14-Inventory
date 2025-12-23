<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $eqData = Equipment::when($search, function ($q) use ($search) {
                $q->where('eq_name', 'like', "%{$search}%")
                ->orWhere('eq_size', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
            })
            ->orderByRaw("CASE WHEN eq_available <= eq_low_limit THEN 0 ELSE 1 END")
            ->orderBy('eq_available', 'asc')
            ->paginate(10)
            ->withQueryString();


        if ($request->ajax()) {
            return response()->json([
                'table' => view('alar.partials.equipmentTable', compact('eqData'))->render(),
                'pagination' => view('alar.partials.equipmentPagination', compact('eqData'))->render(),
            ]);
        }

        return view('alar.equipment', compact('eqData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('functions/equipmentAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $request->validate([
            'eqName' => ['required',
                        'max:100',
                        Rule::unique('equipments', 'eq_name')
                        ->where('eq_size', $request->size)
                        ->where('eq_net_content', $request->eqAvailSet)
            ],
            'size' => 'required|max:20',
            'eqAvail' => 'required|integer|min:0|max:999',
            'eqAvailSet' => 'required|integer|min:1|max:999999',
            'eqLimit' => 'required|integer|min:1|max:999999'
        ], [
            'eqName.required' => 'This field is required.',
            'eqName.max' => '100 characters limit reached.',
            'eqName.unique' => 'Equipment already added.',

            'size.required' => 'This field is required.',
            'size.max' => '20 characters limit reached.',

            'eqAvail.required' => 'This field is required.',
            'eqAvail.min' => 'Not a valid quantity.',
            'eqAvail.max' => '3 digits limit reached.',

            'eqAvailSet.required' => 'This field is required.',
            'eqAvailSet.min' => 'Not a valid quantity.',
            'eqAvailSet.max' => '6 digits limit reached.',

            'eqLimit.required' => 'This field is required.',
            'eqLimit.integer' => 'Number only.',
            'eqLimit.min' => 'Must be 1 or more.',
            'eqLimit.max' => '6 digits limit reached.',
        ]);

        Equipment::create([
            'eq_name' => $request->eqName,
            'eq_type' => 'Non-Consumable',
            'eq_available' => $request->eqAvail,
            'eq_net_content' => $request->eqAvailSet,
            'eq_size' => $request->size,
            'eq_in_use' => 0,
            'eq_low_limit' => $request->eqLimit
        ]);

        $getEq = Equipment::orderBy('id','desc')->take(1)->value('id');

        Log::create([
            'transaction' => 'Added',
            'tx_desc' => 'Added Equipment | ID: ' . $getEq,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);

        return redirect(route('Equipment.index'))->with('success', 'Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $eqData = Equipment::findOrFail($id);
        return view('shows/equipmentShow', ['eqData' => $eqData]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {   
        $eqData = Equipment::findOrFail($id);
        return view('functions/equipmentEdit', ['eqData' => $eqData]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'eqName' => ['required',
                        'max:100',
                        Rule::unique('equipments', 'eq_name')
                        ->where('eq_size', $request->size)
                        ->where('eq_net_content', $request->eqAvailSet)
                        ->ignore($id)
            ],
            'size' => "required|max:20",
            'eqAvail' => 'required|integer|min:0|max:999',
            'eqAvailSet' => 'required|integer|min:1|max:999999.99',
            'eqLimit' => 'required|integer|min:1|max:999999.99'
        ],  [
            'eqName.required' => 'This field is required.',
            'eqName.unique' => 'Equipment already added.',
            'eqName.max' => '100 Characters limit reached.',

            'size.required' => 'This field is required.',
            'size.max' => '20 Characters limit reached.',

            'eqAvail.required' => 'This field is required.',
            'eqAvail.min' => 'Not a valid number.',
            'eqAvail.max' => '3 digits limit reached.',

            'eqAvailSet.required' => 'This field is required.',
            'eqAvailSet.min' => 'Must be 1 or more.',
            'eqAvailSet.max' => '6 digits limit reached.',

            'eqLimit.required' => 'This field is required.',
            'eqLimit.min' => 'Must be 1 or more.',
            'eqLimit.max' => '6 digits limit reached.',
        ]);

        Equipment::findOrFail($id)->update([
            'eq_name' => $request->eqName,
            'eq_size' => $request->size,
            'eq_available' => $request->eqAvail,
            'eq_net_content' => $request->eqAvailSet,
            'eq_low_limit' => $request->eqLimit
        ]);

        Log::create([
            'transaction' => 'Updated',
            'tx_desc' => 'Update Equipment | ID: ' . $id,
            'tx_date' => Carbon::now(),
            'emp_id' => session('loginId')
        ]);
        return redirect()->back()->with('success', 'Updated Successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        //
    }
}
