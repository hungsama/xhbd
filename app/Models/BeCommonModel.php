<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class BeCommonModel extends Model
{
    public static function exist_category_and_article($conds, $test=false)
    { 
        if(!array_key_exists('category_id', $conds) || !array_key_exists('article_id', $conds)) return false;
        $records = DB::table('category_and_article')
                ->where('category_id', $conds['category_id'])
                ->where('article_id', $conds['article_id'])
                ->skip(0)
                ->take(1)
                ->get();
        if (empty($records)) return false;
        else return $records;
    }

    public static function exist_tag_and_article($conds, $test=false)
    { 
        if(!array_key_exists('tag_id', $conds) || !array_key_exists('article_id', $conds)) return false;
        $records = DB::table('tag_and_article')
                ->where('tag_id', $conds['tag_id'])
                ->where('tag_id', $conds['article_id'])
                ->skip(0)
                ->take(1)
                ->get();
        if (empty($records)) return false;
        else return $records;
    }

    public static function exist_position_and_advertisement($conds, $test=false)
    { 
        if(!array_key_exists('position_id', $conds) || !array_key_exists('advertisement_id', $conds)) return false;
        $records = DB::table('position_and_advertisement')
                ->where('position_id', $conds['position_id'])
                ->where('advertisement_id', $conds['advertiserment_id'])
                ->skip(0)
                ->take(1)
                ->get();
        if (empty($records)) return false;
        else return $records;
    }

    public static function join_article_and_category($selects, $conds, $test=false) 
    {
        $records = DB::table('articles')
                ->join('category_and_article', 'articles.id', '=', $conds['article_id'])
                ->select($selects)
                ->get();
        if (empty($record)) return false;
        else return $records;
    }

    public static function join_category_and_article($selects, $conds, $test=false) 
    {
        $records = DB::table('categories')
                ->join('category_and_article', 'categories.id', '=', $conds['category_id'])
                ->select($selects)
                ->get();
        if (empty($record)) return false;
        else return $records;
    }

    public static function join_position_and_advertisement($selects, $conds, $test=false) 
    {
        $records = DB::table('positions')
                ->join('position_and_advertisement', 'positions.id', '=', $conds['position_id'])
                ->select($selects)
                ->get();
        if (empty($record)) return false;
        else return $records;
    }

    public static function updateStatus($table='', $wheres=array(), $updates=array()) {
        if (empty($wheres)) return;
        $records = DB::table($table);
        foreach ($wheres as $k => $v) {
            $records = $records->where($k, $v);
        }
        $records->update($updates);
    }

    public static function insertIntoTablePositionAndAdvertiserment($data=array()) {
        DB::table('position_and_advertisement')->insert($data);
    }
}
