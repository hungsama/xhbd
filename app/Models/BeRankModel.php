<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;

class BeRankModel extends Model
{
    protected $table = 'ranks';
    protected $fillable = ['club_id', 'league_id', 'rank_name', 'league_name','wins', 'dashs', 'loses', 'goals_win','goals_lose', 'status', 'created_at', 'updated_at' ,'created_by', 'updated_by'];
    protected $dateFormat = 'U';

    public static function getRanks($selects=array(), $conds=array(), $opts=array())
    {
        $ranks = DB::table('ranks')
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
            $ranks = $ranks->orderBy($conds['order_by'][0], $conds['order_by'][1]);
        else 
            $ranks = $ranks->orderBy('id', 'desc');

        if (isset($opts['count'])) 
            $ranks = $ranks->count();
        elseif (isset($opts['all']))
            $ranks = $ranks->get();
        else
            $ranks = $ranks->paginate(Config::get('keycaches.LIMIT_PAGE'));

        return $ranks;
    }
}
