<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use DB;
use Config;

class BeAuthenticateModel extends Model
{
    public static function getAdmins($selects=array(), $conds=array(), $opts=array()) {
        $admins = DB::table('admins')
            ->where(function ($q) use ($conds) {
                if (isset($conds['admin_id']) && $conds['admin_id'] != '') 
                    $q->where('admin_id', $conds['admin_id']);

                if (isset($conds['admin_name']) && $conds['admin_name'] != '') 
                    $q->where('admin_name', 'like',"%{$conds['admin_name']}%");

                if (isset($conds['admin_name_where']) && $conds['admin_name_where'] != '') 
                    $q->where('admin_name', $conds['admin_name_where']);

                if (isset($conds['email_where']) && $conds['email_where'] != '') 
                    $q->where('email', $conds['email_where']);

                if (isset($conds['status']) && $conds['status'] != '') 
                    $q->where('status', $conds['status']);

                if (isset($conds['in_roles']) && count($conds['in_roles']) > 0) 
                    $q->whereIn('role', $conds['in_roles']);

                if (isset($conds['start_date']) && is_numeric($conds['start_date'])) 
                    $q->where('create_at', '>=', $conds['start_date']);

                if (isset($conds['start_date']) && is_numeric($conds['start_date'])) 
                    $q->where('create_at', '<=', $conds['end_date']);
                });

        if (isset($conds['order_by']) && is_array($conds['order_by']))
            $admins = $admins->orderBy($conds['order_by'][0], $conds['order_by'][1]);
        else 
            $admins = $admins->orderBy('admin_id', 'desc');
        if (isset($opts['count'])) 
            $admins = $admins->count();
        elseif (isset($opts['all']))
            $admins = $admins->get();
        else
            $admins = $admins->paginate(Config::get('keycaches.LIMIT_PAGE'));
        return $admins;
    }

    public static function createAdmin($adds) {
        try {
            DB::table('admins')->insert($adds);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public static function updateAdmin($id, $updates) {
        if (!is_numeric($id)) return false;
        try {
            
        } catch (Exception $e) {
            
        }
        DB::table('admins')->where('admin_id', $id)
                ->update($updates);
    }

    public static function deleteAdmin($id) {
        if (!is_numeric($id)) return false;
        DB::table('admins')->where('admin_id', $id)
                ->delete();
        return true;
    }

    public static function getGroups($selects=array(), $conds=array(), $count=false) {
        $groups = DB::table('admin_groups')
            ->where(function ($q) use ($conds) {
                if (isset($conds['group_id']) && $conds['group_id'] != '') 
                    $q->where('group_id', $conds['group_id']);

                if (isset($conds['group_name']) && $conds['group_name'] != '') 
                    $q->where('group_name', 'like',"%{$conds['group_name']}%");

                if (isset($conds['group_alias']) && $conds['group_alias'] != '') 
                    $q->where('group_alias', $conds['group_alias']);
                    
                if (isset($conds['status']) && $conds['status'] != '') 
                    $q->where('status', $conds['status']);

                if (isset($conds['start_date']) && is_numeric($conds['start_date'])) 
                    $q->where('create_at', '>=', $conds['start_date']);

                if (isset($conds['start_date']) && is_numeric($conds['start_date'])) 
                    $q->where('create_at', '<=', $conds['end_date']);
                })
            ->orderBy('group_id', 'desc')
            ->paginate(2);
        return $groups;
    }

    public static function getPermissionsGroup($select=array(), $conds=array()) {
        $groups = DB::table('admin_groups')
            ->select('admin_groups.group_id', 'admin_groups.group_alias', 'admin_groups.description', 'admin_groups.status', 'admin_groups.group_name','group_permission.action_name', 'group_permission.method')
            ->join('group_permission', 'admin_groups.group_id', '=', 'group_permission.group_id')
            ->where(function ($q) use ($conds) {
                if (isset($conds['group_id']) && $conds['group_id'] != '') 
                    $q->where('admin_groups.group_id', $conds['group_id']);

                if (isset($conds['group_name']) && $conds['group_name'] != '') 
                    $q->where('admin_groups.group_name', 'like',"%{$conds['name']}%");
                    
                if (isset($conds['status']) && $conds['status'] != '') 
                    $q->where('admin_groups.status', $conds['status']);

                if (isset($conds['start_date']) && is_numeric($conds['start_date'])) 
                    $q->where('admin_groups.create_at', '>=', $conds['start_date']);

                if (isset($conds['start_date']) && is_numeric($conds['start_date'])) 
                    $q->where('admin_groups.create_at', '<=', $conds['end_date']);
                })
            ->orderBy('admin_groups.group_id', 'desc')
            ->get();
        return $groups;
    }

    public static function createGroup($adds) {
        return DB::table('admin_groups')->insertGetId($adds);
    }

    public static function addPermission($sql) {
        return DB::insert($sql);
    }

    public static function updateGroup($id, $updates) {
        if (!is_numeric($id)) return false;
        DB::table('admin_groups')->where('group_id', $id)
                ->update($updates);
        return true;
    }

    public static function deleteGroup($id) {
        if (!is_numeric($id)) return false;
        DB::table('admin_groups')->where('group_id', $id)
                ->delete();
        return true;
    }

    public static function deletePermission($group_id) {
        DB::table('group_permission')
            ->where('group_id',$group_id)
            ->delete();
    }

    public static function updateAdminVsGroupID($group_id, $updates) {
        DB::table('admins')
            ->where('group_id', $group_id)
            ->update($updates);
    }
}
