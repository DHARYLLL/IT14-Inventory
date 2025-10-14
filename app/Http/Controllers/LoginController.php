<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function set(){
        return view('auth.signin');
    }

    public function loginPage(){
        return view('auth.signin');
    }

    public function registerPage(){
        return view('interface.reg');
    }

    public function login(Request $request){
       $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        //Hash::check($request->pass,$user->e_password);
        $user = Employee::where('emp_email', '=', $request->email)->first();

        if($user){
            if(Hash::check($request->password,$user->emp_password)){
                $request->session()->put('loginId', $user->id);
                $request->session()->regenerate();
                return redirect(route('dashboard.index'));
            }else{
                return back()->with('fail', 'Invalid credentials. Please try again')->withInput();
            }
        }else{
            return back()->with('fail', 'Invalid credentials. Please try again')->withInput();
        }
        return $user;
    }

    public function logout(Request $request){
        $request->session()->invalidate();
        $request->session()->flush();
        return redirect(route('showLogin'));
    }
}
