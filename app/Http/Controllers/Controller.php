<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function system(){
        $employee = Auth::user();
        $permissions = $employee->permission("system")->first();
        if(!$permissions){
            $permissions = new \stdClass();
            $permissions->v = 1;
            $permissions->a = 0;
            $permissions->e = 0;
            $permissions->d = 0;
        }
        $permissions->branch = $employee->branch;
        $permissions->userid = $employee->id;
        return $permissions;
    }
}
