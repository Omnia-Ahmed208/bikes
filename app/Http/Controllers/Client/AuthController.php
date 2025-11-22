<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('client.dashboard');
        }

        return view('client.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $client = User::where('email', $request->email)->first();

        if ($client && Hash::check($request->password, $client->password)) {
            Auth::login($client);
            return redirect()->route('client.dashboard');
        }

        return back()->withErrors([
            'email_or_password' => __('trans.alert.error.invalid_email_or_password'),
        ])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('client.login');
    }
}
