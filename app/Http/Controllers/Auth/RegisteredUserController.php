<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class,
            ],

            'mobile_number' => [
                'required',
                'string',
                'max:20',
            ],

            'brgy_id' => [
                'required',
                'exists:barangays,id',
            ],

            'zone' => [
                'required',
                'string',
                'max:100',
            ],

            'address' => [
                'required',
                'string',
                'max:255',
            ],

            // National ID / Government ID
            'verification_document' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            // Proof of Residency
            'residency_document' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        // Store uploaded documents privately
        $verificationDocument = $request
            ->file('verification_document')
            ->store('verification-documents');

        $residencyDocument = $request
            ->file('residency_document')
            ->store('residency-documents');

        // Create resident account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,

            'brgy_id' => $request->brgy_id,
            'zone' => $request->zone,
            'address' => $request->address,

            'verification_document' => $verificationDocument,
            'residency_document' => $residencyDocument,

            // Resident account
            'role' => 'resident',
            'status' => 'pending',

            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()
            ->route('login')
            ->with(
                'status',
                'Registration successful. Your account is pending LGU verification.'
            );
    }
}