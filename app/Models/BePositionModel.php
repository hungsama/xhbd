<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class BePositionModel extends Model
{
    protected $table = 'positions';
    protected $fillable = ['image_default', 'updated_by', 'updated_at', 'status', 'name', 'name_alias', 'type', 'notes', 'place', 'limit_ads'];
    protected $dateFormat = 'U';

    public static function getPositions($selects=array(), $conds=array(), $count=false)
    {
        $postions = DB::table('positions')
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
        return $postions;
    }
}
