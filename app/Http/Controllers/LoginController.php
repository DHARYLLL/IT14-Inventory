<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Log;
use Carbon\Carbon;
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
                $request->session()->put('empRole', $user->emp_role);
                $request->session()->regenerate();
                Log::create([
                    'transaction' => 'Login',
                    'tx_desc' => 'Login User',
                    'tx_date' => Carbon::now(),
                    'emp_id' => session('loginId')
                ]);
                return redirect(route('dashboard.index'));
            }else{
                return back()->with('fail', 'Invalid credentials. Please try again')->withInput();
            }
        }else{
            return back()->with('fail', 'Invalid credentials. Please try again')->withInput();
        }
        return back()->with('fail', 'Invalid credentials. Please try again')->withInput();
    }

    public function changePassword(Request $request, String $id){
        $request->validate([
            'curPass' => 'required|max:30',
            'newPass' => 'required|max:30',
            'confPass' => 'required|max:30'
        ], [
            'curPass.required' => 'This field is required.',
            'curPass' => '30 character limit reached.',

            'newPass.required' => 'This field is required.',
            'newPass' => '30 character limit reached.',

            'confPass.required' => 'This field is required.',
            'confPass' => '30 character limit reached.'
        ]);
        $user = Employee::where('id', $id)->first();

        if (Hash::check($request->curPass,$user->emp_password)) {
            
            if ($request->newPass == $request->confPass) {
                
                Employee::findOrFail($id)->update([
                    'emp_password' => Hash::make($request->newPass)
                ]);

                Log::create([
                    'transaction' => 'Update',
                    'tx_desc' => 'Change Password | ID: ' . $id,
                    'emp_id' => session('loginId')
                ]);

                return back()->with('promt-s', 'Updated Successfully.');
            } else {
                return back()->with('promt-a', 'Password did not match.')->withInput();
            }

        }else{
            return back()->with('promt', 'Incorrect Password.')->withInput();
        }
        return back()->with('promt', 'Employee not found.')->withInput();
    }

    public function logout(Request $request){
        $request->session()->invalidate();
        $request->session()->flush();
        return redirect(route('showLogin'));
    }
}
