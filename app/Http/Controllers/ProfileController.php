<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function show()
    {
        return view('auth.profile');
    }

    public function update(ProfileUpdateRequest $request)
    {
        $validated = $request->validated();

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        }

        auth()->user()->update($validated);

        return redirect()->back()->with('success', 'Profile updated.');
    }
}
