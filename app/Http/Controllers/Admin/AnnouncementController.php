<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Barangay;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('barangay')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->get();

        $barangays = Barangay::orderBy('name')->get();

        return view('admin.announcements.index', compact(
            'announcements',
            'barangays'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'audience' => ['required', 'in:all,barangay,zone'],
            'brgy_id' => ['nullable', 'exists:barangays,id'],
            'zone' => ['nullable', 'string', 'max:100'],
        ]);

        if ($validated['audience'] === 'all') {
            $validated['brgy_id'] = null;
            $validated['zone'] = null;
        }

        if ($validated['audience'] === 'barangay') {
            $validated['zone'] = null;

            if (!$validated['brgy_id']) {
                return back()
                    ->withErrors([
                        'brgy_id' => 'Please select a barangay.'
                    ])
                    ->withInput();
            }
        }

        if ($validated['audience'] === 'zone') {
            if (!$validated['brgy_id']) {
                return back()
                    ->withErrors([
                        'brgy_id' => 'Please select a barangay.'
                    ])
                    ->withInput();
            }

            if (!$validated['zone']) {
                return back()
                    ->withErrors([
                        'zone' => 'Please enter a zone.'
                    ])
                    ->withInput();
            }
        }

        Announcement::create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'audience' => $validated['audience'],
            'brgy_id' => $validated['brgy_id'],
            'zone' => $validated['zone'],
            'published_at' => now(),
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement published successfully.');
    }

    public function show(Announcement $announcement)
    {
        $announcement->load('barangay');

        return view('admin.announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        $barangays = Barangay::orderBy('name')->get();

        return view('admin.announcements.edit', compact(
            'announcement',
            'barangays'
        ));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'audience' => ['required', 'in:all,barangay,zone'],
            'brgy_id' => ['nullable', 'exists:barangays,id'],
            'zone' => ['nullable', 'string', 'max:100'],
        ]);

        if ($validated['audience'] === 'all') {
            $validated['brgy_id'] = null;
            $validated['zone'] = null;
        }

        if ($validated['audience'] === 'barangay') {
            $validated['zone'] = null;

            if (!$validated['brgy_id']) {
                return back()
                    ->withErrors([
                        'brgy_id' => 'Please select a barangay.'
                    ])
                    ->withInput();
            }
        }

        if ($validated['audience'] === 'zone') {
            if (!$validated['brgy_id']) {
                return back()
                    ->withErrors([
                        'brgy_id' => 'Please select a barangay.'
                    ])
                    ->withInput();
            }

            if (!$validated['zone']) {
                return back()
                    ->withErrors([
                        'zone' => 'Please enter a zone.'
                    ])
                    ->withInput();
            }
        }

        $announcement->update([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'audience' => $validated['audience'],
            'brgy_id' => $validated['brgy_id'],
            'zone' => $validated['zone'],
        ]);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }
}