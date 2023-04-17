<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Previliges;

class PreviligesMiddleware
{

    public $attributes;

    public function handle($request, Closure $next , $page)
    {   
        $user = $request->user();
        $previliges = Previliges::where([["job", $user->job], ["page", $page]])->first();

        if($user && $page && $previliges && $previliges->v=="1") {
            view()->share('roles', $previliges);
            return $next($request);
        }

        return redirect()->route('notauthorized');

    }

}