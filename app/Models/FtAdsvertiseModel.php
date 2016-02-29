<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Config;
use Cache;

class FtAdsvertiseModel extends Model
{
    public static function getAdsHeader($position=1, $places=array()) {
        $keyCache = Config::get('keycaches.ADS').'_header_'.$position;
        $dataCache = Cache::get($keyCache);
        if ($dataCache) return $dataCache;
        $ads = self::getAds($places);
        Cache::put($keyCache, $ads, Config::get('keycaches.ADS_TIME_CACHE'));
        return $ads;
    }

    public static function getAdsFooter($position=1, $places=array()) {
        $keyCache = Config::get('keycaches.ADS').'_footer_'.$position;
        $dataCache = Cache::get($keyCache);
        if ($dataCache) return $dataCache;
        $ads = self::getAds($places);
        Cache::put($keyCache, $ads, Config::get('keycaches.ADS_TIME_CACHE'));
        return $ads;
    }

    public static function getAdsLeft($position=1, $places=array()) {
        $keyCache = Config::get('keycaches.ADS').'_left_'.$position;
        $dataCache = Cache::get($keyCache);
        if ($dataCache) return $dataCache;
        $ads = self::getAds($places);
        Cache::put($keyCache, $ads, Config::get('keycaches.ADS_TIME_CACHE'));
        return $ads;
    }

    public static function getAdsRight($position=1, $places=array()) {
        $keyCache = Config::get('keycaches.ADS').'_right_'.$postion;
        $dataCache = Cache::get($keyCache);
        if ($dataCache) return $dataCache;
        $ads = self::getAds($places);
        Cache::put($keyCache, $ads, Config::get('keycaches.ADS_TIME_CACHE'));
        return $ads;
    }

    public static function getAds($places=array()) {
        $ads = DB::table('positions as p')
            ->select('p.type', 'p.place', 'p.image_default', 'p_a.position_id', 'p_a.advertisement_id', 'p_a.position_name', 'p_a.position_alias', 'a.name', 'a.name_alias', 'a.note', 'a.url_image', 'a.url_redirect', 'a.advertiser_id', 'a.mode')
            ->join('position_and_advertisement as p_a', 'p.id', '=', 'p_a.position_id')
            ->join('advertisements as a', 'a.id', '=', 'p_a.advertisement_id')
            ->whereIn('p.place', $places)
            ->where('p.status', 1)
            ->where('a.status', 1)
            ->get();
        if (!$ads) return false;
        $types = array('normal', 'popup');
        foreach ($ads as $ad) {
            foreach($types as $plc) {
                foreach ($ads as $a) {
                    if ($ad->type == $a && $ad->place == $plc)
                        $ads[$a][$plc][] = $ad;
                }
            }
        }
        return $ads; 
    }
}
