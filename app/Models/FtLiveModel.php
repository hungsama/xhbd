<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;
use Cache;

class FtLiveModel extends Model
{
    public static function getLives($page=1, $filters=array(), $opts=array()) {
        $lives = DB::table('lives')
            ->where('status', '=', '1');
        if (isset($filters['id']) && $filters['id'] !="")
            $lives = $lives->where('id', '=', $filters['id']);

        if (isset($filters['home_alias']) && $filters['home_alias'] !="")
            $lives = $lives->where('home_alias', '=', strtolower($filters['home_alias']));

        if (isset($filters['guest_alias']) && $filters['guest_alias'] !="")
            $lives = $lives->where('guest_alias', '=', strtolower($filters['guest_alias']));

        if (isset($filters['league_alias']) && $filters['league_alias'] !="")
            $lives = $lives->where('league_alias', '=', strtolower($filters['league_alias']));

        if (isset($filters['order_by']) && is_array($filters['order_by']))
            $lives = $lives->orderBy($filters['order_by'][0], $filters['order_by'][1]);
        else 
            $lives = $lives->orderBy('id', 'desc');

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
            return $lives->skip($skip)->take($take)->count();
        elseif (isset($opts['all'])) {
            $lives = $lives->skip($skip)->take($take)->get();
        }
        else {
            $lives = $lives->paginate($limit);
            if (count($lives->items()) == 0) return false;
        }
        return $lives;
    }
}
