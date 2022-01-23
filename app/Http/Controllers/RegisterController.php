<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function save(Request $request){
        if (Auth::check()) {
            return redirect(route('private'));
        }
        $validateFields = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (User::where('email', $validateFields['email'])->exists()) {
            return redirect(route('registration'))->withErrors([
                'email' => 'Already exist'
            ]);
        }
        $user = User::create($validateFields);

        if($user) {
            Auth::login($user);
            return redirect(route('private'));
        }
        return redirect(route('login'))->withErrors([
            'formError' => 'Error saving'
        ]);

    }
}
