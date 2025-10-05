<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class UserSettingsController extends Controller
{
    /**
     * Show the user settings form
     */
    public function edit(): View
    {
        $user = Auth::user();
        return view('user-settings.edit', compact('user'));
    }

    /**
     * Update the user settings
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20|regex:/^\+[1-9]\d{1,14}$/',
            'notification_switch' => 'boolean',
        ], [
            'phone_number.regex' => 'Please enter a valid phone number with country code (e.g., +1234567890).'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'notification_switch' => $request->boolean('notification_switch'),
        ]);

        return redirect()->route('user-settings.edit')
                        ->with('success', 'Settings updated successfully.');
    }

}
