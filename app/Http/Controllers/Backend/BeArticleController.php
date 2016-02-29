<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BeArticleValidationRequest;
use App\Http\Controllers\Controller;
use App\Models\BeArticleModel;
use App\Models\BeCategoryModel;
use App\Models\BeTagModel;
use App\Models\BeCommonModel;
use Route;
use Input;
use App\Libraries\SimpleClass;
use DB;
use Session;
use Validator;
use Response;
use App\Libraries\Authentication;

class BeArticleController extends Controller
{
    public function __construct()
    {
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $data = array();
        $records = BeArticleModel::getArticles();
        $data['records'] = $records;
        $data['actives'] = array('xhbd-contents', 'list-article');
        $data['action_controller'] = 'list_article';
        return view('backend.articles.be_articles_view', compact('data'));
    }

    /**
    * Display a listing of the resource.
    *
     * @return \Illuminate\Http\Response
   */
    public function createArticle()
    {
        $data = array();
        $data['categories'] = BeCategoryModel::select('id', 'name', 'name_alias')->get();
        $data['tags'] = BeTagModel::select('id','name', 'name_alias')->get();
        $data['actives'] = array('xhbd-contents', 'list-article');
        $data['action_controller'] = 'create_article';
        return view('backend.articles.be_create_article_view', compact('data'));
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function saveArticle(BeArticleValidationRequest $request)
    {
        $data = array();
        $inserts = array(
            'title' => $request->get('title'),
            'title_alias' => SimpleClass::trans_word($request->get('title')),
            'content' => $request->get('content'),
            'url_video' => $request->get('url_video'),
            'slide_img' => url().'/frontend/images/fb-df.jpg',
            'type' => '',
            'author' => $request->get('author'),
            'status' => 1,
            'created_by' => 'Hungsama',
            'updated_by' => '',
            'created_at' => time(),
            'updated_at' => 0
        );
        $article_id = BeArticleModel::insertGetId($inserts);

        if (Input::hasFile('slide_img')) {
            $file = Input::file('slide_img');
            $file->move('uploads/article', $article_id.'-'.$file->getClientOriginalName());
            $path_old = public_path().'/uploads/categories/'.$article_id.'-'.$file->getClientOriginalName();
            $path_new = public_path().'/uploads/categories/'.$article_id.'-'.SimpleClass::trans_word($file->getClientOriginalName());
            copy($path_old,$path_new);
            $updates = array('slide_img' => Url().'/uploads/categories/'.$article_id.'-'.SimpleClass::trans_word($file->getClientOriginalName()));
            BeArticleModel::find($article_id)->update($updates);
        }

        $categories = $request->get('categories');
        if (count($categories) > 0) {
            foreach ($categories as $k => $cate_id) {
                $categories_db = BeCategoryModel::select('id', 'name', 'name_alias')->where('id', $cate_id)->get();
                $inserts= array(
                    'article_id' => $article_id,
                    'category_id' => $cate_id,
                    'category_name' => $categories_db[0]->name,
                    'category_alias' => $categories_db[0]->name_alias
                );
                if(!BeCommonModel::exist_category_and_article($inserts)) {
                  DB::table('category_and_article')->insert($inserts);
                }
            }
        }

        $tags = $request->get('tags');
        if (count($tags) > 0) {
            foreach ($tags as $k => $tag_id) {
                $tags_db = BeTagModel::select('id','name', 'name_alias')->where('id', $tag_id)->get();
                $inserts= array(
                    'article_id' => $article_id,
                    'tag_id' => $tag_id,
                    'tag_name' => $tags_db[0]->name,
                    'tag_alias' => $tags_db[0]->name_alias
                );
                if(!BeCommonModel::exist_category_and_article($inserts)) {
                    DB::table('tag_and_article')->insert($inserts);
                }
            }
        }

        $data['action_controller'] = 'create_article';
        Session::flash('success', SimpleClass::success_notice('Create new an article is successfully'));
        return redirect()->route('be-article.show');
    }

    public function detailArticle($id) 
    {
        $data = array();
        $data['record'] = BeArticleModel::find($id);
        $categories_checked = DB::table('category_and_article')->where('article_id', $id)->get();
        if ($categories_checked) {
            foreach($categories_checked as $cate) $data['categories_checked'][] = $cate->category_id;
        } else $data['categories_checked'] = array();
        $data['categories'] = BeCategoryModel::select('id', 'name', 'name_alias')->get();

        $tags_checked = DB::table('tag_and_article')->where('article_id', $id)->get();
        if ($tags_checked) {
            foreach($tags_checked as $tag) $data['tags_checked'][] = $tag->tag_id;
        } else $data['tags_checked'] = array();
        $data['tags'] = BeTagModel::select('id','name', 'name_alias')->get();

        $data['actives'] = array('xhbd-contents');
        $data['action_controller'] = 'update_article';
        return view('backend.articles.be_detail_article_view', compact('data'));
    }

    public function updateArticle($id, BeArticleValidationRequest $request)
    {
        $record = BeArticleModel::find($id);
        $updates = array(
          'title' => $request->get('title'),
          'title_alias' => SimpleClass::trans_word($request->get('title')),
          'content' => $request->get('content'),
          'url_video' => $request->get('url_video'),
          'author' => $request->get('author'),
          'status' => $request->get('status'),
          'updated_by' => 'Hungsama',
          'updated_at' => time()
          );

        if (Input::hasFile('slide_img')) {
            $file = Input::file('slide_img');
            $file->move('uploads/categories', $id.'-'.$file->getClientOriginalName());
            $path_old = public_path().'/uploads/categories/'.$id.'-'.$file->getClientOriginalName();
            $path_new = public_path().'/uploads/categories/'.$id.'-'.SimpleClass::trans_word($file->getClientOriginalName());
            copy($path_old,$path_new);
            $updates['slide_img'] = Url().'/uploads/categories/'.$id.'-'.SimpleClass::trans_word($file->getClientOriginalName());
        }

        BeArticleModel::find($id)->update($updates);
        Session::flash('success', SimpleClass::success_notice('Update an article is successfully'));
        return redirect()->route('be-detail-article.show', $id);
    }

    public function deleteArticle($id)
    {
        BeArticleModel::find($id)->delete();
        DB::table('category_and_article')->where('article_id', $id)->delete();
        DB::table('tag_and_article')->where('tag_id', $id)->delete();
        Session::flash('success', SimpleClass::success_notice('Delete an article is successfully'));
        return redirect()->route('be-article.show');
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function ajaxSearchArticle(Request $request) {
        $conds = array(
            'title' => $request->get('title'),
            'status' => $request->get('status'),
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date')
        );
        $records = BeArticleModel::getArticles(array(), $conds);
        $response_view = view('backend.articles.be_ajax_articles_view', compact('records'))->render();
        $current_search_view = view('backend.articles.be_current_search_view', compact('conds'))->render();
        return array(
            'response_view' => $response_view,
            'current_search_view' => $current_search_view
        );
    }

    public function changeStatus(Request $request) {
        $id = (int) $request->get('id');
        $status = (int) $request->get('status');
        $url = $request->get('url');
        if ($status == 1) {
            $textStatus = 'ON';
            $statusReset = '0';
            $statusClass = 'success';
        }
        else {
            $textStatus = 'OFF';
            $statusReset = '1';
            $statusClass = 'danger';
        }

        try {
            BeCommonModel::updateStatus('articles', array('id' => $id), array('status' => $status));
        } catch (Exception $e) {
            return array(
                'error' => 1,
                'msg' => $e->getMessage()
            );
        }

        $data = "<button type='button' class='btn btn-"."$statusClass btn-small'".'onclick="changeStatus('."'".$url."','".$id."','".$statusReset."');".'">'.$textStatus."</button>";

        return array(
            'error' => 0,
            'msg' => 'success',
            'data' => $data
        );
    } 
}
