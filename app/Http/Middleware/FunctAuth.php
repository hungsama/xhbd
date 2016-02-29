<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Cache;
use Config;
use App\Libraries\Authentication;
use App\Libraries\SimpleClass;
use Route;

class FunctAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $adminInfo = Session::get('adminInfo');
        $rq_uri = $request->route()->uri();
        $obj = Authentication::authPermissions($rq_uri);
        if (!$obj->status) 
            return redirect($obj->redirect);
        return $next($request);
    }
}
