<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\FtArticleModel;
use App\Models\FtCategoryModel;
use App\Models\FtLiveModel;
use App\Models\FtRankModel;
use App\Models\FtAdsvertiseModel;
use Input;

class HomeController extends Controller
{
    protected $commons = array();

    public function __construct()
    {
        $this->commons['recordsMenu'] = FtCategoryModel::getCatesMenu();
        $this->commons['recordsSlide'] = FtArticleModel::getArticlesInSlide();
        $this->commons['ranksMenu'] = FtCategoryModel::getRanksMenu();
        $this->commons['videosMenu'] = FtCategoryModel::getRanksMenu();
        $this->commons['dateInWeek'] = array('Monday');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array('commons' => $this->commons);
        $page = 1;
        if ($ip_put = Input::get('page')) 
            $page = (int) $ip_put;
        $data['articlesNew'] = FtArticleModel::getArticlesNew($page);
        $data['articlesNewPlace'] = 'main';
        $conds = array(
            'special' => 'ordinary',
            'limitRecord' => array(0,10)
        );
        $data['articlesHot'] = FtArticleModel::getArticles($page, $conds, array('all'=>true, 'test'=>true));
        $data['articlesHotPlace'] = 'sidebar';

        $data['articlesLive'] = FtLiveModel::getLives(1, array());
        $data['articlesLivePlace'] = 'main';

        $data['AdsRight1'] = FtAdsvertiseModel::getAdsLeft(1,array('right_1'));

        $data['head_activated'] = 'home';
        return view('frontend.contents.ft_home_view', compact('data'));
    }

    public function detailArticle($cate_alias="", $title_alias="") {
        $data = array('commons' => $this->commons);
        $page = 1;
        if ($ip_put = Input::get('page')) 
            $page = (int) $ip_put;
        $article_id = explode('-', $title_alias)[0];
        $conds = array(
            'special' => 'ordinary',
            'article_id' => (int) $article_id,
            'limitRecord' => array(0,1)
        );
        $data['record'] = FtArticleModel::getArticles(1, $conds, array('all'=>true, 'test'=>true))[0];

        $conds = array(
            'special' => 'ordinary',
            'article_id_diff' => (int) $article_id,
            'category_alias' => $cate_alias,
            'limitRecord' => array(0,10)
        );
        $data['articlesRelated'] = FtArticleModel::getArticlesRelated($page, $conds);
        $data['articlesRelatedPlace'] = 'main';

        $conds = array(
            'special' => 'ordinary',
            'limitRecord' => array(0,10)
        );
        $data['articlesHot'] = FtArticleModel::getArticles($page, $conds, array('all'=>true, 'test'=>true));
        $data['articlesHotPlace'] = 'sidebar';

        $data['AdsRight1'] = FtAdsvertiseModel::getAdsLeft(1,array('right_1'));

        $data['head_activated'] = 'detail';

        return view('frontend.contents.ft_detail_article_view', compact('data'));
    }

    public function articlesInCategory($cate_alias="") {
        $page = 1;
        if ($ip_put = Input::get('page')) 
            $page = (int) $ip_put;
        $data = array('commons' => $this->commons);

        $conds = array(
            'category_alias' => $cate_alias,
            'limit' => array(0,1)
        );
        $data['infoCate'] = FtCategoryModel::getCategories($page, $conds, array('all'=>true))[0];
        $data['infoCate']->activated = $data['infoCate']->name_alias;

        if ($data['infoCate']->parent != 0) {
            $conds = array(
                'id' => $data['infoCate']->parent,
                'limit' => array(0,1)
            );
            $data['infoCate']->activated = FtCategoryModel::getCategories($page, $conds, array('all'=>true))[0]->name_alias;
        }

        $conds = array(
            'category_alias' => $cate_alias,
            'limitRecord' => array(0,10)
        );
        $data['articlesIncCate'] = FtArticleModel::getArticlesInCategory($page, $conds);
        $data['articlesIncCatePlace'] = 'main';

        $conds = array(
            'special' => 'ordinary',
            'limitRecord' => array(0,10)
        );
        $data['articlesHot'] = FtArticleModel::getArticles($page, $conds, array('all'=>true, 'test'=>true));
        $data['articlesHotPlace'] = 'sidebar';

        $data['articlesLive'] = FtLiveModel::getLives(1, array());
        $data['articlesLivePlace'] = 'sidebar';

        $data['AdsRight1'] = FtAdsvertiseModel::getAdsLeft(1,array('right_1'));

        $data['head_activated'] = $data['infoCate']->activated;
        return view('frontend.contents.ft_articles_in_category_view', compact('data'));
    }

    public function detailRank($league_alias="") {
        $data = array('commons' => $this->commons);
        $page = 1;
        if ($ip_put = Input::get('page')) 
            $page = (int) $ip_put;

        $conds = array(
            'league_alias' => $league_alias,
            'limit' => array(0,36)
        );
        $data['rankClubs'] = FtRankModel::getRankClubs(1, $conds, array('all' => true));
        $conds = array(
            'special' => 'ordinary',
            'limitRecord' => array(0,10)
        );
        $data['articlesHot'] = FtArticleModel::getArticles($page, $conds, array('all'=>true, 'test'=>true));
        $data['articlesHotPlace'] = 'sidebar';

        $data['head_activated'] = 'ranks';
        return view('frontend.contents.ft_ranks_view', compact('data'));
    }

    public function videos($type="") {
        $data = array('commons' => $this->commons);
        $page = 1;
        if ($ip_put = Input::get('page')) 
            $page = (int) $ip_put;
        $conds = array(
            'is_video' => 1
        );
        $data['videos'] = FtArticleModel::getVideos(1, $conds, array());
        $data['videosPlace'] = 'main';

        $data['articlesHot'] = FtArticleModel::getArticles($page, $conds, array('all'=>true, 'test'=>true));
        $data['articlesHotPlace'] = 'sidebar';

        $data['articlesLive'] = FtLiveModel::getLives(1, array());
        $data['articlesLivePlace'] = 'sidebar'; 

        $data['AdsRight1'] = FtAdsvertiseModel::getAdsLeft(1,array('right_1'));
        $data['head_activated'] = 'videos';
        return view('frontend.contents.ft_videos_view', compact('data'));
    }

    public function lives($league="") {
        $data = array('commons' => $this->commons);
        $page = 1;
        if ($ip_put = Input::get('page')) 
            $page = (int) $ip_put;

        $conds = array();
        if ($league=="tong-hop") $conds['league_alias'] = $league;
        $data['articlesLive'] = FtLiveModel::getLives($page, array());

        $conds = array(
            'special' => 'ordinary',
            'limitRecord' => array(0,10)
        );
        $data['articlesHot'] = FtArticleModel::getArticles(1, $conds, array('all'=>1));
        $data['articlesHotPlace'] = 'sidebar';

        $data['AdsRight1'] = FtAdsvertiseModel::getAdsLeft(1,array('right_1'));

        $data['head_activated'] = 'truc-tiep';
        return view('frontend.contents.ft_lives_view', compact('data'));
    }

    public function liveDetail($league="", $match="") {
        $data = array('commons' => $this->commons);
        $clubs = explode('-vs-', $match);
        $conds = array(
            'home_alias' => $clubs[0],
            'guest_alias' => $clubs[1],
            'league_alias' => $league,
            'limit' => array(0,1)
        );
        $data['record'] = FtLiveModel::getLives(1, $conds, array('all'=> 1))[0];

        $conds = array(
            'special' => 'ordinary',
            'limitRecord' => array(0,10)
        );
        $data['articlesHot'] = FtArticleModel::getArticles(1, $conds, array('all'=>true, 'test'=>true));
        $data['articlesHotPlace'] = 'sidebar';

        $data['AdsRight1'] = FtAdsvertiseModel::getAdsLeft(1,array('right_1'));

        $data['head_activated'] = 'live';
        return view('frontend.contents.ft_detail_match_view', compact('data'));
    }

    public function search($keywords="") {
        $data = array('commons' => $this->commons);
        $page = 1;
        if ($ip_put = Input::get('page')) 
            $page = (int) $ip_put;

        if($keywords == "") {
            $keywords = Input::get('keysearch');
        }
        $conds = array(
            'article_name' => $keywords,
            'limitRecord' => array(0,10)
        );
        $data['recordsSearch'] = FtArticleModel::getArticlesSearch($page, $conds);

        $conds = array(
            'special' => 'ordinary',
            'limitRecord' => array(0,10)
        );
        $data['articlesHot'] = FtArticleModel::getArticles($page, $conds, array('all'=>true, 'test'=>true));

        $data['articlesLive'] = FtLiveModel::getLives(1, array());

        $data['AdsRight1'] = FtAdsvertiseModel::getAdsLeft(1,array('right_1'));

        $data['head_activated'] = 'search';
        return view('frontend.contents.ft_search_view', compact('data'));
    }
}
