<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class BeTagModel extends Model
{
    protected $table = 'tags';
    protected $fillable = ['name', 'name_alias', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
    protected $dateFormat = 'U';

    public static function getTags($selects=array(), $conds=array(), $count=false)
    {
        $tags = DB::table('tags')
            ->where(function ($q) use ($conds) {
                if (isset($conds['name']) && $conds['name'] != '') 
                    $q->where('name', 'like',"%{$conds['name']}%");
                
                if (isset($conds['status']) && $conds['status'] != '') 
                    $q->where('status', $conds['status']);

                if (isset($conds['start_date']) && is_numeric($conds['start_date'])) 
                    $q->where('create_at', '>=', $conds['start_date']);

                if (isset($conds['start_date']) && is_numeric($conds['start_date'])) 
                    $q->where('create_at', '<=', $conds['end_date']);
                })
            ->orderBy('id', 'desc')
            ->paginate(2);
        return $tags;
    }
}
