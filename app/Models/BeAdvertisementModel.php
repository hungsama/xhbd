<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;

class BeAdvertisementModel extends Model
{
    protected $table = 'advertisements';
    protected $fillable = ['url_image'];
    protected $dateFormat = 'U';

    public static function getAdvertisements($selects=array(), $conds=array(), $count=false)
    {
        $advertisements = DB::table('advertisements')
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
        return $advertisements;
    }
}
