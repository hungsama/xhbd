<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;

class BeClubModel extends Model
{
    protected $table = 'clubs';
    protected $fillable = ['name', 'name_alias', 'logo', 'description','status', 'rank', 'cate_id', 'created_at', 'updated_at', 'created_by', 'updated_by'];
    protected $dateFormat = 'U';

    public static function getClubs($selects=array(), $conds=array(), $opts=array())
    {
        $clubs = DB::table('clubs')
                ->where(function ($q) use ($conds) {
                if (isset($conds['name']) && $conds['name'] != '') 
                    $q->where('name', 'like',"%{$conds['name']}%");

                if (isset($conds['cate_id']) && $conds['cate_id'] != '') 
                    $q->where('cate_id', '=', $conds['cate_id']);
                
                if (isset($conds['status']) && $conds['status'] != '') 
                    $q->where('status', $conds['status']);

                if (isset($conds['start_date']) && is_numeric($conds['start_date'])) 
                    $q->where('create_at', '>=', $conds['start_date']);

                if (isset($conds['start_date']) && is_numeric($conds['start_date'])) 
                    $q->where('create_at', '<=', $conds['end_date']);
                });
        if (isset($conds['order_by']) && is_array($conds['order_by']))
            $clubs = $clubs->orderBy($conds['order_by'][0], $conds['order_by'][1]);
        else 
            $clubs = $clubs->orderBy('id', 'desc');

        if (isset($opts['count'])) 
            $clubs = $clubs->count();
        elseif (isset($opts['all']))
            $clubs = $clubs->get();
        else
            $clubs = $clubs->paginate(Config::get('keycaches.LIMIT_PAGE'));

        return $clubs;
    }
}
