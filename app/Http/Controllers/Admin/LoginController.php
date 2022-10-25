<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // use AuthenticatesUsers;

    protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware(['guest:admin'])->except('logout');
    }

    public function showFormLogin()
    {
        return view('admin.auth.singin');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::guard('admin')->attempt($credentials, $request->remember)){
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withInput($request->only(['email', 'remember']));
    }

}
