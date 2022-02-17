<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Services\LogService;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;

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

        (new LogService())->store([
            'method' => 'App\Http\Controllers\ProfileController@update',
            'action' => 'Profile',
            'detail' => 'User Update Profile Data',
            'status' => 'success@200',
            'data' => json_encode($validated + $request->safe()->only('skill_id')),
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Profile updated.');
    }
}
