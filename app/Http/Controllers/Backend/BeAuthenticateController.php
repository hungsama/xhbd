<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BeAuthenticateValidationRequest;
use App\Models\BeAuthenticateModel;
use App\Http\Controllers\Controller;
use App\Libraries\RouteActions;
use App\Libraries\SimpleClass;
use Session;
use Route;
use Input;
use Validator;
use Response;
use Cache;
use Config;
use App\Libraries\Authentication;


class BeAuthenticateController extends Controller
{
    protected $permissions;
    public function __construct()
    {
        parent::__construct();
        $adminInfo = Session::get('adminInfo');
        if ($adminInfo) {
            $keyCache = Config::get('keycaches.PERMISSION_NAME_ADMIN').$adminInfo->admin_id;
            $dataCache = Cache::get($keyCache);
            if (!$dataCache) {
                $dataCache = Authentication::setCachePermissions($adminInfo->admin_id, $adminInfo->group_id, $adminInfo);
            }
            if(!in_array($dataCache->role, array('root', 'admin')) || $dataCache->status != 1)
                return redirect('backend/error/403')->send();
            
            $this->permissions = $dataCache;
        }
        else {
            Session::forget('adminInfo');
            $errors= array('Account not exist or session expired.');
            Session::flash('list_errors', SimpleClass::error_notice($errors));
            return redirect()->route('be-login-admin.show')->send();
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $conds = array('roles' => array('root', 'admin', 'limited'));
        if ($this->permissions->role == 'admin') 
            $conds['in_roles'] = array('admin', 'limited');
        $data['roles'] = $conds['roles'];
        $data['records'] = BeAuthenticateModel::getAdmins(array(), $conds);
        $data['actives'] = array('xhbd-ads', 'list-admins');
        $data['action_controller'] = 'list_admins';
        return view('backend.admins.be_admins_view', compact('data'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxSearchAdmin(Request $request) {
        $conds = array(
            'admin_name' => $request->get('admin_name'),
            'status' => $request->get('status'),
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date')
        );
        if ($this->permissions->role == 'admin') 
            $conds['in_roles'] = array('admin', 'limited');
        $records = BeAuthenticateModel::getAdmins(array(), $conds);
        $response_view = view('backend.admins.be_ajax_admin_view', compact('records'))->render();
        $current_search_view = view('backend.admins.be_current_search_admin_view', compact('conds'))->render();
        return array(
            'response_view' => $response_view,
            'current_search_view' => $current_search_view
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createAdmin()
    {
        $data = array();
        $data['actives'] = array('xhbd-contents');
        $groups = BeAuthenticateModel::getGroups()->items();
        if (isset($groups)) 
            $data['groups'] = $groups;
        else 
            $data['groups'] = false;
        if ($this->permissions->role == 'root') 
            $data['roles'] = array('root', 'admin', 'limited');
        else 
            $data['roles'] = array('limited');

        $data['action_controller'] = 'create_admin';
        return view('backend.admins.be_create_admin_view', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveAdmin(BeAuthenticateValidationRequest $request)
    {
        $data = array();
        $inserts = array(
          'admin_name' => $request->get('admin_name'),
          'admin_alias' => SimpleClass::trans_word($request->get('admin_name')),
          'password' => $request->get('password'),
          'email' => $request->get('email'),
          'description' => $request->get('description'),
          'role' => $request->get('role'),
          'hash' => SimpleClass::generateRandomString(),
          'status' => 1,
          'created_by' => 'Hungsama',
          'updated_by' => '',
          'created_at' => time(),
          'updated_at' => 0
        );

        $errors = array();
        if (in_array($inserts['role'], array('root', 'admin')) && $this->permissions->role == 'admin') {
            $errors[] = 'This account is admin, don\'t create account root or account admin.';
            Session::flash('list_errors', SimpleClass::error_notice($errors));
            return redirect()->route('be-create-admin.show')->withInput();
        }

        $admin = BeAuthenticateModel::getAdmins(array(), array('admin_name_where' => $inserts['admin_name']));
        if (count($admin->items()) > 0) 
            $errors[] = 'Admin name has been used';
        
        $email = BeAuthenticateModel::getAdmins(array(), array('email_where' => $inserts['email']));
        if ($email->items())
            $errors[] = 'Email has been used';
        Session::flash('errors_notice', SimpleClass::error_notice($errors));

        if ($inserts['role'] == 'limited') {
            $group_id = $request->get('group_id');
            if(!$group_id) {
                $errors[] = 'User have not belong group, please select a group';
                Session::flash('list_errors', SimpleClass::error_notice($errors));
                return redirect()->route('be-create-admin.show')->withInput();
            }
            $inserts['group_id'] = $request->get('group_id');
        }
        else 
            $insert['group_id'] = 0;
        $optPass = array(
            'const' => 12,
            'hash' => $inserts['hash']
        );
        $inserts['password'] = password_hash($inserts['password'], PASSWORD_BCRYPT, $optPass);

        if (count($errors) > 0) {
            Session::flash('list_errors', SimpleClass::error_notice($errors));
            return redirect()->route('be-create-admin.show')->withInput();
        }

        BeAuthenticateModel::createAdmin($inserts);
        Session::flash('success', SimpleClass::success_notice('Create new an admin is successfully'));
        return redirect()->route('be-admin.show');
    }

    public function detailAdmin($admin_id) {
        $data = array();
        $record = BeAuthenticateModel::getAdmins(array(), array('admin_id' => $admin_id))->items();
        if (count($record) > 0)
            $data['record'] = $record[0];
        $groups = BeAuthenticateModel::getGroups()->items();
        if (count($groups) > 0) 
            $data['groups'] = $groups;
        else 
            $data['groups'] = false;

        $data['roles'] = array('root', 'admin', 'limited');
        if ($this->permissions->role == 'admin') 
            $data['roles'] = array('admin', 'limited');

        $data['actives'] = array('xhbd-ads');
        $data['action_controller'] = 'update_advertiser';
        return view('backend.admins.be_detail_admin_view', compact('data'));
    }

    public function updateAdmin($admin_id) {
        $updates = array();
        if ($description = Input::get('description'))
            $updates['description'] = $description;
        if ($group_id = Input::get('group_id'))
            $updates['group_id'] = $group_id;
        if ($role = Input::get('role'))
            $updates['role'] = $role;
        if (strlen(trim(Input::get('password'))) >= 6) {
            $password = Input::get('password');
            $updates['hash'] = SimpleClass::generateRandomString();
            $optPass = array(
                'const' => 12,
                'hash' => $updates['hash']
            );
            $updates['password'] = password_hash($password, PASSWORD_BCRYPT, $optPass);
        }
        $errors = array();
        if (($updates['role'] == 'root' || $admin_id != $this->permissions->acc_id) && $this->permissions->role == 'admin') {
            $errors[] = 'You are admin, don\'t update another user with role root, or account admin other';
            Session::flash('list_errors', SimpleClass::error_notice($errors));
            return redirect()->route('be-detail-admin.show', $admin_id)->withInput();
        }
        BeAuthenticateModel::updateAdmin($admin_id, $updates);
        Session::flash('success', SimpleClass::success_notice('Update a admin is successfully'));
        return redirect()->route('be-detail-admin.show', $admin_id);
    }

    public function deleteAdmin($admin_id, $ajax=false) {
        $adminInfo = BeAuthenticateModel::getAdmins(array(), array('admin_id' => $admin_id), array('all'));
        if (count($adminInfo) > 0) {
            if (in_array($adminInfo[0]->role, array('root', 'admin')) && $this->permissions->role=='admin') {
                Session::flash('success', SimpleClass::success_notice('You are admin, because only delete account grant limited.',1));
                return redirect()->route('be-admin.show');
            }
        }
        BeAuthenticateModel::deleteAdmin($admin_id);
        Session::flash('success', SimpleClass::success_notice('Delete a admin is successfully'));
        return redirect()->route('be-admin.show');
    }

    public function getPermissions($group_id=0, $admin_selected=0) {
        $admin = BeAuthenticateModel::getAdmins(array(), array('admin_id'=>$admin_selected))->items();
        if ($group_id==0 && count($admin)>0) {
            $data = array(
                'role' => $admin[0]->role
            );
            $response_view = view('backend.admins.be_ajax_permissions_view', compact('data'))->render();
            return array(
                'response_view' => $response_view
            );
        }
        $pers_selected = [];
        $conds = ['group_id'=>$group_id];
        $all_groups = BeAuthenticateModel::getGroups()->items();
        if (count($all_groups) > 0) 
            $all_groups = $all_groups;
        else 
            $all_groups = array();

        $group_permisions = BeAuthenticateModel::getPermissionsGroup(array(), $conds);
        if (count($group_permisions) > 0) {
            foreach ($group_permisions as $per) {
                $pers_selected[] = $per->method.'@'.$per->action_name;
            }
        } else {
            $group_permisions = BeAuthenticateModel::getGroups(array(), array('group_id'=>$group_id));
        }

        $permissions = RouteActions::actions();

        $data = array(
            'admin_selected' => $admin_selected,
            'group_id' => $group_id,
            'group_name' => $group_permisions[0]->group_name,
            'group_desc' => $group_permisions[0]->description,
            'group_status' => $group_permisions[0]->status,
            'permissions' => $permissions,
            'pers_selected' => $pers_selected,
            'all_groups' => $all_groups,
            'role' => (count($admin) > 0)?$admin[0]->role:'limited'
        );
        $response_view = view('backend.admins.be_ajax_permissions_view', compact('data'))->render();
        return array(
            'response_view' => $response_view
        );
    }

    public function getGroups() {
        $data = array();
        $data['records'] = BeAuthenticateModel::getGroups();
        $data['actives'] = array('xhbd-ads', 'list-admins');
        $data['action_controller'] = 'list_admins';
        return view('backend.admins.be_group_admins_view', compact('data'));
    }

    public function createGroup() {
        $permissions = RouteActions::actions();
        $data = array(
            'permissions' => $permissions
        );
        $response_view = view('backend.admins.be_ajax_create_group_view', compact('data'))->render();
        return array(
            'error' => 0,
            'response_view' => $response_view
        );
    }

    public function saveGroup() {
        $group = array(
            'group_name' => Input::get('group_name'),
            'description' => Input::get('description'),
            'group_alias' => SimpleClass::trans_word(Input::get('group_name')),
            'status' => 1,
            'created_by' => 'hungsama',
            'created_at' => time()
        );
        $groups = BeAuthenticateModel::getGroups(array(), array('group_alias' => $group['group_alias']))->items();
        if (count($groups) > 0) 
            return array(
                'error' => 1,
                'msg' => 'Group name is exists'
            );

        $group_id = BeAuthenticateModel::createGroup($group);

        $permissions = Input::get('permissions');
        if (count($permissions) > 0) {
            $actions = array();
            $sql = "INSERT INTO `group_permission` (`group_id`, `action_desc`, `action_name`, `method`) VALUES ";
            
            foreach ($permissions as $per) {
                $perx = explode('@#', $per);
                if (strpos($perx[0], '@@') === false)
                    $methods = array($perx[0]);
                else
                    $methods = explode("@@", $perx[0]);
                foreach ($methods as $mt) {
                    $obj = (object) array(
                        'action_desc' => $perx[1],
                        'action_name' => $perx[2],
                        'method' => $mt
                    );
                    $sql.="({$group_id}, '{$obj->action_desc}', '{$obj->action_name}', '{$obj->method}'),";
                }
            }
            $sql = rtrim($sql, ',');
            BeAuthenticateModel::addPermission($sql);
        }
        return array(
            'error' => 0,
            'msg' => 'Create group is successfully'
        );
    }

    public function updatePermissionGroup($group_id) {
        $info_update = array(
            'group_name' => Input::get('group_name'),
            'description' => Input::get('description'),
            'group_alias' => SimpleClass::trans_word(Input::get('group_name')),
            'status' => Input::get('status'),
            'created_by' => 'hungsama',
            'created_at' => time()
        );
        BeAuthenticateModel::updateGroup($group_id, $info_update);
        $admin_id = Input::get('admin_id');
        if (is_numeric($admin_id) && $admin_id !=0) 
            BeAuthenticateModel::updateAdmin($admin_id, array('group_id' => $group_id));
        BeAuthenticateModel::deletePermission($group_id);

        $sql = "INSERT INTO `group_permission` (`group_id`, `action_desc`, `action_name`, `method`) VALUES ";
        $permissions = Input::get('permissions');
        if (count($permissions) > 0) {
            $actions = array();
            foreach ($permissions as $per) {
                $perx = explode('@#', $per);
                if (strpos($perx[0], '@@') === false)
                    $methods = array($perx[0]);
                else
                    $methods = explode("@@", $perx[0]);
                foreach ($methods as $mt) 
                    $sql.="({$group_id}, '{$perx[1]}', '{$perx[2]}', '{$mt}'),";
            }
            $sql = rtrim($sql, ',');
            BeAuthenticateModel::addPermission($sql);
        }
        return array(
            'error' => 0,
            'msg' => 'Group has been updated'
        );
    }

    public function deleteGroup($group_id, $ajax=false) {
        BeAuthenticateModel::deleteGroup($group_id);
        $updates= array(
            'role' => 'no-permission' 
        );
        BeAuthenticateModel::updateAdminVsGroupID($group_id, $updates);
        Session::flash('success', SimpleClass::success_notice('Delete a admin is successfully'));
        return redirect()->route('be-admin-group.show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxSearchGroupAdmin(Request $request) {
        $conds = array(
            'group_name' => $request->get('group_name'),
            'status' => $request->get('status'),
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date')
        );
        $records = BeAuthenticateModel::getGroups(array(), $conds);
        $response_view = view('backend.admins.be_ajax_group_admin_view', compact('records'))->render();
        $current_search_view = view('backend.admins.be_current_search_group_admin_view', compact('conds'))->render();
        return array(
            'response_view' => $response_view,
            'current_search_view' => $current_search_view
        );
    }
}
