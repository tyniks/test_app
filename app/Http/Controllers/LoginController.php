<?php

namespace App\Http\Controllers;

use App\Events\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function login(Request $request) {
        if(Auth::check()) {
            return redirect(route('private'));
        }

        $formFields = $request->only('email', 'password');
        if(Auth::attempt($formFields)) {

            event(new UserLogin($request->input('email')));
            return redirect(route('private'));
        }

        return redirect(route('login'))->withErrors([
           'email' => 'No such user'
        ]);
    }
}
