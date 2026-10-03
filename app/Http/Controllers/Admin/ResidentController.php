<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResidentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'resident');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $residents = $query
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.residents.index', compact('residents'));
    }

    public function create()
    {
        return view('admin.residents.create');
    }

    public function show(User $resident)
    {
        abort_unless($resident->role === 'resident', 404);

        return view('admin.residents.show', compact('resident'));
    }

    public function document(User $resident, string $type)
    {
        abort_unless($resident->role === 'resident', 404);

        $path = match ($type) {
            'verification' => $resident->verification_document,
            'residency' => $resident->residency_document,
            default => null,
        };

        abort_unless($path && Storage::exists($path), 404);

        return Storage::response($path);
    }

    public function edit(User $resident)
    {
        abort_unless($resident->role === 'resident', 404);

        return view('admin.residents.edit', compact('resident'));
    }

    public function update(Request $request, User $resident)
    {
        abort_unless($resident->role === 'resident', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $resident->id,
            ],
            'mobile_number' => ['required', 'string', 'max:20'],
            'brgy_id' => ['required', 'exists:barangays,id'],
            'zone' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        $resident->update($validated);

        return redirect()
            ->route('admin.residents.show', $resident)
            ->with('success', 'Resident information updated successfully.');
    }
}
