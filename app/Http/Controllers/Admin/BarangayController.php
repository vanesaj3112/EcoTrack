<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barangay;
use App\Services\AuditLogger;
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
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:barangays,name',
            ],
        ]);

        $barangay = Barangay::create([
            'name' => $validated['name'],
        ]);

        AuditLogger::log(
            'BARANGAY_CREATED',
            'Created barangay: '
            . $barangay->name
            . '.'
        );

        return redirect()
            ->route('admin.barangays.index')
            ->with('success', 'Barangay added successfully.');
    }

    public function update(Request $request, Barangay $barangay)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:barangays,name,' . $barangay->id,
            ],
        ]);

        $oldName = $barangay->name;
        $newName = $validated['name'];

        $barangay->update([
            'name' => $newName,
        ]);

        if ($oldName !== $newName) {
            AuditLogger::log(
                'BARANGAY_UPDATED',
                'Updated barangay name: '
                . $oldName
                . ' → '
                . $newName
                . '.'
            );
        }

        return redirect()
            ->route('admin.barangays.index')
            ->with('success', 'Barangay updated successfully.');
    }

    public function destroy(Barangay $barangay)
    {
        $barangayName = $barangay->name;

        $barangay->delete();

        AuditLogger::log(
            'BARANGAY_DELETED',
            'Deleted barangay: '
            . $barangayName
            . '.'
        );

        return redirect()
            ->route('admin.barangays.index')
            ->with('success', 'Barangay deleted successfully.');
    }
}