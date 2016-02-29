<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;

class FtRankModel extends Model
{
    public static function getRankClubs($page=1, $filters=array(), $opts=array())
    {
        $ranks = DB::table('ranks as r')
            ->where('status', '=', '1');
        if (isset($filters['id']) && $filters['id'] !="")
            $ranks = $ranks->where('id', '=', $filters['id']);

        if (isset($filters['league_alias']) && $filters['league_alias'] !="")
            $ranks = $ranks->where('league_alias', '=', strtolower($filters['league_alias']));

        if (isset($filters['order_by']) && is_array($filters['order_by']))
            $ranks = $ranks->orderBy($filters['order_by'][0], $filters['order_by'][1]);
        else {
            $ranks = $ranks->orderBy('scores', 'desc')
                ->orderBy('coefficient', 'desc')
                ->orderBy('matchs', 'asc');
        }

        $limit = Config::get('keycaches.LIMIT_PAGE');
        if (isset($filters['limit']) && is_numeric($filters['limit']))
            $limit = $filters['limit'];

        $skip = 0;
        $take = Config::get('keycaches.LIMIT_PAGE');
        if (isset($filters['limitRecord'])) {
            $skip = $filters['limitRecord'][0];
            $take = $filters['limitRecord'][1];
        } 

        if (isset($opts['count'])) 
            return $ranks->skip($skip)->take($take)->count();
        elseif (isset($opts['all'])) {
            $ranks = $ranks->skip($skip)->take($take)->get();
        }
        else {
            $ranks = $ranks->paginate($limit);
            if (count($ranks->items()) == 0) return false;
        }
        return $ranks;
    }
}
