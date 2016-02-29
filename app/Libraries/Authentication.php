<?php
namespace App\Libraries;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Models\BeAuthenticateModel;
use App\Libraries\SimpleClass;
use Config;
use Route;
use HTML;

class Authentication {
    protected  $permissions= false;
    public function __construct() {
        
    }   

    public static function setCachePermissions($admin_id, $group_id, $data) {
        $permissions = array();
        $stores = (object) array(
            'status' => $data->status,
            'role' => $data->role,
            'acc_id' => $admin_id
        );
        $keyCache = Config::get('keycaches.PERMISSION_NAME_ADMIN').$admin_id;
        if ($data->role == 'limited') {
            $getPermissions = BeAuthenticateModel::getPermissionsGroup(array(), array('group_id' => $group_id));
            if(count($getPermissions) > 0) {
                foreach($getPermissions as $per)
                    $permissions[] = $per->method.'@#'.$per->action_name;
            }
        }
        $stores->permissions = $permissions;
        Cache::put($keyCache, $stores, Config::get('keycaches.TIME_PERMISSION_ADMIN'));
        return $stores;
    }

    public static function authPermissions($rq) {
        $method = $_SERVER['REQUEST_METHOD'];
        $request_uri = preg_replace('/\?.*/', '',$rq);
        $request_array = explode('/',$request_uri);
        $controller = '';
        foreach ($request_array as $r) {
            if (!preg_match('/{/', $r)) $controller .= $r.'/';
        }
        $action = trim($method.'@#'.$controller, '/');
        $adminInfo = Session::get('adminInfo');
        if (!$adminInfo) {
            $errors= array('Account not exist or session expired.');
            Session::flash('list_errors', SimpleClass::error_notice($errors));
            return (object) array(
                'status' => false,
                'redirect' => 'backend/auth/login'
            );
        }
        $auth = new Authentication();
        $auth->setPermissions($adminInfo);
        $permissions = $auth->getPermissions();
        
        if (!$permissions || $permissions->status != 1) {
            Session::forget('adminInfo');
            $errors= array('Account not exist or session expired.');
            Session::flash('list_errors', SimpleClass::error_notice($errors));
            return (object) array(
                'status' => false,
                'redirect' => 'backend/auth/login'
            );
        } 
        if ($permissions->role == 'limited' && !in_array($action, $permissions->permissions)) {
            return (object) array(
                'status' => false,
                'redirect' => 'backend/error/403'
            );
        }
        return (object) array(
            'status' => true
        );
    }

    public function setPermissions($info) {
        $keyCache = Config::get('keycaches.PERMISSION_NAME_ADMIN').$info->admin_id;
        $dataCache = Cache::get($keyCache);
        if ($dataCache)
            $this->permissions = $dataCache;
        else {
            $admin = BeAuthenticateModel::getAdmins(array(), array('admin_id'=>$info->admin_id, 'status' => 1))->items();
            if (count($admin) == 0) return $this->permissions = false;
            $this->permissions = self::setCachePermissions($admin[0]->admin_id, $admin[0]->group_id, $admin[0]);
        }
    }

    public function getPermissions() {
        return $this->permissions;
    }
}
