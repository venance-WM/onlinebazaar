<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordUpdateController extends Controller
{
    public function update(Request $request)
    {
        $user = $request->user();

        // Validate the request
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:1|confirmed',
        ]);

        // Handle validation failures
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            } else {
                if ($user->role === 3) {
                    return redirect()->route('profile.show', 'account')->withErrors($validator);
                } else {
                    return redirect()->back()->withErrors($validator);
                }
            }
        }

        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            $errorMessage = ['current_password' => 'The current password is incorrect.'];

            if ($request->ajax()) {
                return response()->json(['errors' => $errorMessage], 422);
            } else {
                if ($user->role === 3) {
                    return redirect()->route('profile.show', 'account')->withErrors($errorMessage);
                } else {
                    return redirect()->back()->withErrors($errorMessage);
                }
            }
        }

        // Update the user's password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Handle successful password update
        $successMessage = 'Password updated successfully.';

        if ($request->ajax()) {
            return response()->json(['message' => $successMessage]);
        } else {
            if ($user->role === 3) {
                return redirect()->route('profile.show', 'account')->with('status', $successMessage);
            } else {
                return redirect()->back()->with('success', $successMessage);
            }
        }
    }
}
