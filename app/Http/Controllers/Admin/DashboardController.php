<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function index(Request $request){
	  $users = 0;
	  $packa = 0;
	  $bouqu = 0;
	  $lines = 0;
      return view('Admin.dashboard',compact('users','packa','bouqu','lines'));
	}

}
