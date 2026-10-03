<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use Illuminate\Http\Request;

class BarangayController extends Controller
{
    public function index()
    {
        $barangays = Barangay::orderBy('name')->get();

        return view('admin.barangays.index', compact('barangays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:barangays,name'],
        ]);

        Barangay::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.barangays.index')
            ->with('success', 'Barangay added successfully.');
    }

    public function update(Request $request, Barangay $barangay)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:barangays,name,' . $barangay->id,
            ],
        ]);

        $barangay->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.barangays.index')
            ->with('success', 'Barangay updated successfully.');
    }

    public function destroy(Barangay $barangay)
    {
        $barangay->delete();

        return redirect()
            ->route('admin.barangays.index')
            ->with('success', 'Barangay deleted successfully.');
    }
}
