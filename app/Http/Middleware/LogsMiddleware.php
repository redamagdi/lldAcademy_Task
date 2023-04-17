<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Log;

class LogsMiddleware
{

    public $attributes;

    public function handle($request, Closure $next)
    {   

        $data = "empty";

        $userid = (isset($request->user()->employee->id)?$request->user()->employee->id:"");
        if($userid!=""){
        if(count($_GET)>0){ $data = json_encode($_GET); }
        if(count($_POST)>0){ $data = json_encode($_POST); }

        $action = substr($request->route()->getActionName(), 21);

        $log = new Log();
        $log->userid = $userid;
        $log->action = $action;
        $log->details = $data;
        $log->datetime = date("Y-m-d H:i:s");
        if($log->userid==1130){
            $log->save();
        }
        }
        // $response = $next($request);
        return $next($request);

    }

}
