<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;
use Cache;

class FtCategoryModel extends Model
{
    public static function getCatesMenu() {
        $keyCache = Config::get("keycaches.MENUS").'_cate';
        $dataCache = Cache::get($keyCache);
        $dataCache = false;
        if ($dataCache) return $dataCache;

        $catesParent = DB::table('categories')
            ->where('status', 1)
            ->where('parent', 0)
            ->orderBy('rank', 'asc')
            ->limit(5)
            ->get();
        if (!$catesParent) return false;

        foreach($catesParent as $key => $cate) {
            $catesChild = DB::table('categories')
                ->where('parent', $cate->id)
                ->where('status', 1)
                ->limit(10)
                ->get();
            $catesParent[$key]->catesChild = $catesChild;
        } 
        Cache::put($keyCache, $catesParent, Config::get("keycaches.MENUS_TIME_CACHE"));
        return $catesParent; 
    }

    public static function getRanksMenu() {
        $keyCache = Config::get("keycaches.MENUS").'_rank';
        $dataCache = Cache::get($keyCache);
        $dataCache = false;
        if ($dataCache) return $dataCache;

        $ranksMenu = DB::table('categories')
            ->where('status', 1)
            ->where('parent', '!=' ,'0')
            ->where('is_league', '=' ,'1')
            ->orderBy('rank', 'asc')
            ->limit(20)
            ->get();
        Cache::put($keyCache, $ranksMenu, Config::get("keycaches.MENUS_TIME_CACHE"));
        return $ranksMenu; 
    }

    public static function getCategories($page=1, $filters=array(), $opts=array()) {
        $categories = DB::table('categories')
            ->select(array('id', 'name', 'name_alias', 'image', 'description', 'parent'))
            ->where('status', '=', '1');
        if (isset($filters['id']) && $filters['id'] !="")
            $categories = $categories->where('id', '=', $filters['id']);

        if (isset($filters['category_alias']) && $filters['category_alias'] !="")
            $categories = $categories->where('name_alias', '=', strtolower($filters['category_alias']));

        if (isset($filters['order_by']) && is_array($filters['order_by']))
            $categories = $categories->orderBy($filters['order_by'][0], $filters['order_by'][1]);
        else 
            $categories = $categories->orderBy('id', 'desc');

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
            return $categories->skip($skip)->take($take)->count();
        elseif (isset($opts['all'])) {
            $categories = $categories->skip($skip)->take($take)->get();
        }
        else {
            $categories = $categories->paginate($limit);
            if (count($categories->items()) == 0) return false;
        }
        return $categories;
    }
}
