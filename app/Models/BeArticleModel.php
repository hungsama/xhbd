<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class BeArticleModel extends Model
{
    protected $table = 'articles';
    protected $fillable = ['title', 'title_alias','content', 'url_video', 'slide_img', 'type', 'special', 'author', 'publish', 'created_by', 'updated_by', 'created_at', 'updated_at'];
    protected $dateFormat = 'U';

    public static function getArticles($select = array(), $conds = array(), $count= false) {
        $articles = DB::table('articles')
            ->where(function ($q) use ($conds) {
                if (isset($conds['title']) && $conds['title'] != '') 
                    $q->where('title', 'like',"%{$conds['title']}%");
                
                if (isset($conds['status']) && $conds['status'] != '') 
                    $q->where('status', $conds['status']);

                if (isset($conds['start_date']) && is_numeric($conds['start_date'])) 
                    $q->where('create_at', '>=', $conds['start_date']);

                if (isset($conds['start_date']) && is_numeric($conds['start_date'])) 
                    $q->where('create_at', '<=', $conds['end_date']);
            })
            ->orderBy('id', 'desc')
            ->paginate(2);
        return $articles;
    }
}
