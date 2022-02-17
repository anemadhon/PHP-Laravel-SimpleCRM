<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        (new LogService())->store([
            'method' => 'App\Http\Controllers\Auth\AuthenticatedSessionController@store',
            'action' => 'Login',
            'detail' => 'User Login into System',
            'status' => 'success@200',
            'data' => json_encode([
                'userlogin' => $request->userlogin,
                'password' => Hash::make($request->password)
            ]),
            'session_id' => $request->session()->getId(),
            'from_ip' => $request->ip(),
            'user_id' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $user = auth()->user();
        $sessionId = $request->session()->getId();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        (new LogService())->store([
            'method' => 'App\Http\Controllers\Auth\AuthenticatedSessionController@destroy',
            'action' => 'Logout',
            'detail' => 'User Logout from System',
            'status' => 'success@200',
            'data' => json_encode([
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'role' => $user->role->name
            ]),
            'session_id' => $sessionId,
            'from_ip' => $request->ip(),
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect('/');
    }
}
