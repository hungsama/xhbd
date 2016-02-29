<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BeLoginValidationRequest;
use App\Models\BeAuthenticateModel;
use App\Http\Controllers\Controller;
use App\Libraries\RouteActions;
use App\Libraries\SimpleClass;
use App\Libraries\Authentication;
use Session;
use Route;
use Input;
use Validator;
use Response;
use Config;
use Cache;
use Intervention\Image\ImageManager;

class BeLoginController extends Controller
{
    public function __construct() {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adminInfo = Session::get('adminInfo');
        if ($adminInfo) {
            $keyCache = Config::get('keycaches.PERMISSION_NAME_ADMIN').$adminInfo->admin_id;
            $dataCache = Cache::get($keyCache);
            if (!$dataCache) {
                $store = Authentication::setCachePermissions($adminInfo->admin_id, $adminInfo->group_id, $adminInfo);
            }
            return redirect('backend/dashboard');
        }

        $data = array();
        Session::forget('adminInfo');
        return view('backend.admins.be_login_view', compact('data'));
    }

    public function actionLogin(BeLoginValidationRequest $request) {
        $admin_name = $request->get('username');
        $password = $request->get('password');
        $admin = BeAuthenticateModel::getAdmins(array(), array('admin_name_where' => $admin_name))->items();

        if (count($admin) == 0) {
            Session::flash('list_errors', SimpleClass::error_notice(array('Username is invalid')));
            return redirect()->route('be-login-admin.show')->withInput();
        }

        $optPass = array(
            'const' => 12,
            'hash' => $admin[0]->hash
        );

        if(!password_verify($password, $admin[0]->password)) {
            Session::flash('list_errors', SimpleClass::error_notice(array('Password is invalid')));
            return redirect()->route('be-login-admin.show')->withInput();
        } 

        if ($admin[0]->status != 1) {
            Session::flash('list_errors', SimpleClass::error_notice(array('Account has been blocked')));
            return redirect()->route('be-login-admin.show')->withInput();
        }

        // set info into session 
        $data = (object) array(
            'admin_id' => $admin[0]->admin_id,
            'admin_name' => $admin[0]->admin_name,
            'email' => $admin[0]->email,
            'role' => $admin[0]->role,
            'status' => $admin[0]->status,
            'group_id' => $admin[0]->group_id
        );
        $request->session()->put('adminInfo', $data);

        // set permissions in to cache
        Authentication::setCachePermissions($admin[0]->admin_id, $admin[0]->group_id, $data);        
        return redirect('backend/dashboard');
    }

    public function logout() {
        $adminInfo = Session::get('adminInfo');
        if ($adminInfo) {
            Session::forget('adminInfo');
            Cache::forget(Config::get('keycaches.PERMISSION_NAME_ADMIN').$adminInfo->admin_id);
        }
        return redirect()->route('be-login-admin.show');
    }
}
