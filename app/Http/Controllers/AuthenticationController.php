<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class AuthenticationController extends Controller
{
    function login(){

        return view('authentication.login');
    }

    public function changePassword($token) {
        $user = User::where('password_token', '=', $token)->first();
        if (isset($user)) {
            return view('auth.change-password', compact('token'));
        }
        return redirect('/login');
    }

    public function updatePassword() {
        $token = request('password-token');
        $email = request('email');
        $password = request('password');
        $user = User::where('email', 'like', $email)->first();
        $hashed = bcrypt($password);

        if (isset($user->password_token) && $user->password_token == $token) {
            $random = str_random(100);
            $user->update(['password'=>$hashed, 'password_token'=>$random]);
            Auth::attempt(['email' => $email, 'password' => $password]);
            return redirect('/employee/home');
        }

        return back()
        ->withErrors([
            'email' => 'Wrong Email',
        ]);
    }
}
