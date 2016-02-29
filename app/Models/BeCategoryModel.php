<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;

class BeCategoryModel extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name', 'name_alias','description', 'image', 'parent', 'status', 'rank', 'created_by', 'updated_by', 'created_at', 'updated_at'];
    protected $dateFormat = 'U';

    public static function getCategories($selects=array(), $conds=array(), $opts=array())
    {
        $categories = DB::table('categories')
                ->where(function ($q) use ($conds) {
                if (isset($conds['name']) && $conds['name'] != '') 
                    $q->where('name', 'like',"%{$conds['name']}%");
                
                if (isset($conds['status']) && $conds['status'] != '') 
                    $q->where('status', $conds['status']);

                if (isset($conds['parent']) && $conds['parent'] != '') 
                    $q->where('parent', '=', (int) $conds['parent']);

                if (isset($conds['parent_diff']) && $conds['parent_diff'] != '') 
                    $q->where('parent', '!=' ,(int) $conds['parent_diff']);

                if (isset($conds['is_league']) && is_numeric($conds['is_league'])) 
                    $q->where('is_league', '=' ,(int) $conds['is_league']);

                if (isset($conds['start_date']) && is_numeric($conds['start_date'])) 
                    $q->where('create_at', '>=', $conds['start_date']);

                if (isset($conds['start_date']) && is_numeric($conds['start_date'])) 
                    $q->where('create_at', '<=', $conds['end_date']);
                });
        if (isset($conds['order_by']) && is_array($conds['order_by']))
            $categories = $categories->orderBy($conds['order_by'][0], $conds['order_by'][1]);
        else 
            $categories = $categories->orderBy('id', 'desc');

        if (isset($opts['count'])) 
            $categories = $categories->count();
        elseif (isset($opts['all']))
            $categories = $categories->get();
        else
            $categories = $categories->paginate(Config::get('keycaches.LIMIT_PAGE'));

        return $categories;
    }
}
