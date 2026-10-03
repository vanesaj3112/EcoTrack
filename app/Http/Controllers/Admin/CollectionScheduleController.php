<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Models\CollectionSchedule;
use Illuminate\Http\Request;

class CollectionScheduleController extends Controller
{
    public function index()
    {
        $schedules = CollectionSchedule::with('barangay')
            ->orderBy('collection_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        $barangays = Barangay::orderBy('name')->get();

        return view('admin.collection-schedules.index', compact(
            'schedules',
            'barangays'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brgy_id' => ['required', 'exists:barangays,id'],
            'zone' => ['required', 'string', 'max:100'],
            'collection_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'status' => ['required', 'in:scheduled,completed,cancelled'],
        ]);

        CollectionSchedule::create([
            'brgy_id' => $validated['brgy_id'],
            'zone' => $validated['zone'],
            'collection_date' => $validated['collection_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => $validated['status'],
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.collection-schedules.index')
            ->with('success', 'Collection schedule created successfully.');
    }
}