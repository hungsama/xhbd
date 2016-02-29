<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class BeAdvertiserModel extends Model
{
    protected $table = 'advertisers';
    protected $fillable = ['name', 'description', 'email', 'mobile', 'address', 'status', 'updated_by', 'updated_at'];
    protected $dateFormat = 'U';

    public static function getAdvertisers($selects=array(), $conds=array(), $count=false)
    {
        $advertisers = DB::table('advertisers')
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
        return $advertisers;
    }
}
