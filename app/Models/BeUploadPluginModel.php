<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class BeUploadPluginModel extends Model
{
    protected $table = 'filesstore';
    protected $fillable = ['url','ext'];
    protected $dateFormat = 'U';

    public static function getFiles($select=array(), $conds=array()) {
        $files = DB::table('filesstore')
            ->where(function ($q) use ($conds) {
                if (isset($conds['file_name']) && $conds['file_name'] != '') 
                    $q->where('file_name', 'like',"%{$conds['file_name']}%");
                
                if (isset($conds['status']) && $conds['status'] != '') 
                    $q->where('status', $conds['status']);
                })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        return $files;
    }

    public static function insertImage($data) {
        DB::table('filesstore')
            ->insert($data);
    }
}
