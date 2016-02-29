<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class FtCommonModel extends Model
{
    public static function getArticlesInSlide()
    {
        $records = DB::table('articles')
            ->select('title', 'title_alias', 'content', 'slide_img')
            ->where('status',1)
            ->where('special', 'like', 'slide')
            ->get();
    }
}
