<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Cache;
use Config;
use App\Libraries\Authentication;
use App\Libraries\SimpleClass;

class CoreAuth
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
        if ($adminInfo) {
            $keyCache = Config::get('keycaches.PERMISSION_NAME_ADMIN').$adminInfo->admin_id;
            $dataCache = Cache::get($keyCache);
            if (!$dataCache) {
                $dataCache = Authentication::setCachePermissions($adminInfo->admin_id, $adminInfo->group_id, $adminInfo);
            }
            if(!in_array($dataCache->role, array('root')) || $dataCache->status != 1)
                return redirect('backend/error/403')->send();
        } else {
            Session::forget('adminInfo');
            $errors= array('Account not exist or session expired.');
            Session::flash('list_errors', SimpleClass::error_notice($errors));
            return redirect()->route('be-login-admin.show')->withInput();
        }
        return $next($request);
    }
}
