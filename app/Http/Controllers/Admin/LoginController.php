<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
        redireciona administrador autenticado
     */
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

        return back()->withErrors(['senha ou email são invaidos!'])->withInput($request->only(['email', 'remember']));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('admin.login');
    }

}
