<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\Models\User;
use App\Models\Previliges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

	public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
		$user = User::where("email", $request->email)->first();
        if(empty($user)){
            return redirect()->route("login")->with('error', __('auth.userNotFound'));
        }else{
            if($user->password==md5($request->password)){
                if($user->status=="1"){
                    Auth::login($user);
                    if(session()->has('url.intended')){
                        return redirect()->intended();
                    }else{
                        if($user->type=="A"){
                            return redirect()->route('dashboard')->with('success', 'Loggin in successfuly.');
                        }else{
                            return redirect()->route('userProducts')->with('success', 'Loggin in successfuly.');
                        }
                    }
                }else{
                    return redirect()->route("login")->with('error', __('auth.userNotActive'));
                }
            }else{
                return redirect()->route("login")->with('error', __('auth.password'));
            }
        }

		return $user;
	}

	public function logout(Request $request){
        Auth::logout();
        return redirect()->route("login");
	}
}
