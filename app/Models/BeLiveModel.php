<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;

class BeLiveModel extends Model
{
    protected $table = 'lives';
    protected $fillable = ['league_id', 'live_name', 'league_name','wins', 'dashs', 'loses', 'goals_win','goals_lose', 'status', 'created_at', 'updated_at' ,'created_by', 'updated_by'];
    protected $dateFormat = 'U';

    public static function getLives($selects=array(), $conds=array(), $opts=array())
    {
        $lives = DB::table('lives')
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
            $lives = $lives->orderBy($conds['order_by'][0], $conds['order_by'][1]);
        else 
            $lives = $lives->orderBy('id', 'desc');

        if (isset($opts['count'])) 
            $lives = $lives->count();
        elseif (isset($opts['all']))
            $lives = $lives->get();
        else
            $lives = $lives->paginate(Config::get('keycaches.LIMIT_PAGE'));

        return $lives;
    }
}
