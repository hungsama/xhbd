<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;
use Cache;

class FtArticleModel extends Model
{
    public static function getArticlesInSlide()
    {
        $keyCache = Config::get("keycaches.SLIDE_HOME");
        $dataCache = Cache::get($keyCache);
        if ($dataCache) return $dataCache;
        $records = DB::table('articles')
            ->select('title', 'title_alias', 'content', 'slide_img')
            ->where('status',1)
            ->where('special', 'like', '%slide%')
            ->get();
        if (empty($records)) return false;
        Cache::put($keyCache, $records, Config::get('constants.TIME_CACHE'));
        return $records;
    }

    public static function getArticlesNew($page=1, $conds=array(), $opts=array()) {
        $keyCache = Config::get("keycaches.CONTENT_NEW")."_{$page}";
        $dataCache = Cache::get($keyCache);
        $dataCache = false;
        if ($dataCache) return $dataCache;
        $records = self::getArticles($page, $conds, $opts);
        Cache::put($keyCache, $records, Config::get('constants.TIME_CACHE'));
        return $records;
    }

    public static function getArticlesSearch($page=1, $conds=array(), $opts=array()) {
        $keyCache = Config::get("keycaches.CONTENT_SEARCH")."_{$page}";
        $dataCache = Cache::get($keyCache);
        $dataCache = false;
        if ($dataCache) return $dataCache;
        $records = self::getArticles($page, $conds, $opts);
        Cache::put($keyCache, $records, Config::get('constants.TIME_CACHE'));
        return $records;
    }

    public static function getArticlesHot($page=1, $conds=array(), $opts=array()) {
        $keyCache = Config::get("keycaches.CONTENT_HOT")."_{$page}";
        $dataCache = Cache::get($keyCache);
        $dataCache = false;
        if ($dataCache) return $dataCache;
        $records = self::getArticles($page, $conds, $opts);

        Cache::put($keyCache, $records, Config::get('constants.TIME_CACHE'));
        return $records;
    }

    public static function getArticlesRelated($page=1, $conds=array(), $opts=array()) {
        $keyCache = Config::get("keycaches.CONTENT_RELATE")."_{$page}";
        $dataCache = Cache::get($keyCache);
        $dataCache = false;
        if ($dataCache) return $dataCache;
        $records = self::getArticles($page, $conds, $opts);

        Cache::put($keyCache, $records, Config::get('constants.TIME_CACHE'));
        return $records;
    }

    public static function getVideos($page=1, $conds=array(), $opts=array()) {
        $keyCache = Config::get("keycaches.CONTENT_VIDEO")."_{$page}";
        $dataCache = Cache::get($keyCache);
        $dataCache = false;
        if ($dataCache) return $dataCache;
        $records = self::getArticles($page, $conds, $opts);

        Cache::put($keyCache, $records, Config::get('constants.TIME_CACHE'));
        return $records;
    }

    public static function getArticlesInCategory($page=1, $conds=array(), $opts=array()) {
        $keyCache = Config::get("keycaches.CONTENT_CATEGORY_")."_{$conds['category_alias']}_{$page}";
        $dataCache = Cache::get($keyCache);
        $dataCache = false;
        if ($dataCache) return $dataCache;
        $records = self::getArticles($page, $conds, $opts);

        Cache::put($keyCache, $records, Config::get('constants.TIME_CACHE'));
        return $records;
    }

    public static function getDetailArticle($id) {
        $keyCache = Config::get("keycaches.ARTICLE_DETAIL");
        $dataCache = Cache::get($keyCache);
        $dataCache = false;
        if ($dataCache) return $dataCache;
        $record = DB::table('articles')
            ->where('id', $article_id)
            ->find();
        if(count($record) == 0) return false;
        Cache::put($keyCache, $record, Config::get('keycaches.ARTICLE_DETAIL_TIME_CACHE')); 
        return $record;
    }

    public static function getArticles($page=1, $filters=array(), $opts=array()) {
        $records = DB::table('articles as a')
            ->select('a.id','a.title', 'a.title_alias', 'a.content', 'a.slide_img', 'a.created_at', 'a.author', 'a.url_video', 'a.special', 'c_a.category_id', 'c_a.category_name', 'c_a.category_alias')
            ->join('category_and_article as c_a', 'a.id','=','c_a.article_id')
            ->join('categories as c', 'c.id', '=', 'c_a.category_id')
            ->where('a.status',1)
            ->where('c.status',1);

        if (isset($filters['article_id']) && is_numeric($filters['article_id']))
            $records = $records->where('a.id', '=', $filters['article_id']);

        if (isset($filters['article_name']) && $filters['article_name'] !="")
            $records = $records->where('a.id', 'like', "%{$filters['article_name']}%");

        if (isset($filters['article_id_diff']) && is_numeric($filters['article_id_diff']))
            $records = $records->where('a.id', '!=', $filters['article_id_diff']);

        if (isset($filters['special']))
            $records = $records->where('a.special', 'like', "%{$filters['special']}%");

        if (isset($filters['category_alias']) && $filters['category_alias'] !="")
            $records = $records->where('c.name_alias', '=', $filters['category_alias']);

        if (isset($filters['is_video']) && is_numeric($filters['is_video'])){
            $records = $records->where('a.special', 'like', '%video%');
        }

        $records = $records->orderBy('a.id', 'desc')
            ->groupBy('a.id');

        $limit = Config::get('keycaches.LIMIT_PAGE');
        if (isset($filters['limit']) && is_numeric($filters['limit']))
            $limit = $filters['limit'];

        $skip = 0;
        $take = Config::get('keycaches.LIMIT_PAGE');
        if (isset($conds['limitRecord'])) {
            $skip = $conds['limitRecord'][0];
            $take = $conds['limitRecord'][1];
        } 

        if (isset($opts['count'])) 
            return $records->skip($skip)->take($take)->count();
        elseif (isset($opts['all'])) {
            $records = $records->skip($skip)->take($take)->get();
        }
        else {
            $records = $records->paginate($limit);
            if (count($records->items()) == 0) return false;
        }
        return $records;
    }
}
