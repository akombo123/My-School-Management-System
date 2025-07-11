<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(){
        // dd(Hash::make(123456));
        if(!empty(Auth::check())){

            if(Auth::user()->user_type == 1){
                return redirect('admin/dashboard');
            }
            else if(Auth::user()->user_type == 2){
                return redirect('teacher/dashboard');
            }
            else if(Auth::user()->user_type == 3){
                return redirect('student/dashboard');
            }
            else if(Auth::user()->user_type == 4){
                return redirect('parent/dashboard');
            }

        }
        return view('auth.login');
    }

    public function auth_login(Request $request){
        $remember = !empty($request->remember) ? true : false;

        if(Auth::attempt(['email' => $request->email,'password' => $request->password],$remember)){

            if(Auth::user()->user_type == 1){
                return redirect('admin/dashboard')->with('success', 'Login Successful!');
            }
            else if(Auth::user()->user_type == 2){
                return redirect('teacher/dashboard')->with('success', 'Login Successful!');
            }
            else if(Auth::user()->user_type == 3){
                return redirect('student/dashboard')->with('success', 'Login Successful!');
            }
            else if(Auth::user()->user_type == 4){
                return redirect('parent/dashboard')->with('success', 'Login Successful!');
            }

        }
        return redirect()->back()->with('error','Please Enter Correct Credentials');
    }

    public function forgotpassword(){
        return view('auth.forgot');
    }

    public function postforgotpassword(Request $request){
        dd($request->all());
    }

    public function logout(){
        Auth::logout();
        return redirect(url(''));
    }
}
