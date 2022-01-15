<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Skill;

class ProfileController extends Controller
{
    public function show()
    {
        return view('auth.profile', [
            'skills' => Skill::get(['id', 'name']),
            'user_skills' => auth()->user()->skills->pluck('id')->toArray()
        ]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $validated = $request->validated();

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        auth()->user()->update($validated);
        auth()->user()->skills()->sync($request->safe()->only('skill_id')['skill_id']);

        return redirect()->back()->with('success', 'Profile updated.');
    }
}
