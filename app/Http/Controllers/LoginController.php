<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login',[
        ] );
     }


     public function auth(Request $request)
     {
         $credentials = $request->validate([
             'username' => ['required'],
             'password' => ['required'],
         ]);
         
         if (Auth::attempt($credentials)) {
             $request->session()->regenerate();
  
             return redirect('/dashboard');
         }
  
         return back()->with('failed', 'Login failed!');
     }
 

     public function logout(Request $request)
 {
     Auth::logout();
  
     $request->session()->invalidate();
  
     $request->session()->regenerateToken();
  
     return redirect('/login');
 }

}
