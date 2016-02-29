<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BeCategoryValidationRequest;
use App\Http\Controllers\Controller;
use App\Models\BeCategoryModel;
use App\Models\BeCommonModel;
use Route;
use Input;
use App\Libraries\SimpleClass;
use DB;
use Session;
use Validator;

class BeCategoryController extends Controller
{
    public function __construct()
    {
        // dd($actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]".$_SERVER['REQUEST_METHOD']);
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $data = array();
        $data['records'] = BeCategoryModel::getCategories();
        $data['actives'] = array('xhbd-contents', 'list-category');
        $data['action_controller'] = 'list_category';
        return view('backend.categories.be_categories_view', compact('data'));
    }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function createCategory()
    {
        $data = array();
        $data['actives'] = array('xhbd-contents');
        $conds = array(
            'parent' => '0',
            'order_by' => array('rank', 'asc')
        );
        $data['categories_parent'] = BeCategoryModel::getCategories(array(),$conds, array('all'=>true));
        $data['action_controller'] = 'create_category';
        return view('backend.categories.be_create_category_view', compact('data'));
    }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function saveCategory(BeCategoryValidationRequest $request)
    {
        $data = array();
        $inserts = array(
          'name' => $request->get('name'),
          'name_alias' => SimpleClass::trans_word($request->get('name')),
          'description' => $request->get('description'),
          'image' => '',
          'status' => 1,
          'created_by' => 'Hungsama',
          'updated_by' => '',
          'created_at' => time(),
          'updated_at' => 0
        );
        if ($request->get('is_parent') != 1) {
            $inserts['parent'] = $request->get('parent');
            if (!$cate_parent = BeCategoryModel::find($inserts['parent']))
            {
                $errors[] = 'Parent Category is not exist';
                Session::flash('list_errors', SimpleClass::error_notice($errors));
                return redirect()->route('be-category.show')->withInput();
            }
            $inserts['parent_name'] = $cate_parent->name;
        }
        else $inserts['parent'] = 0;

        $new_cate_id = BeCategoryModel::insertGetId($inserts);
        $upNewRecords = array();
        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $file->move('uploads/categories', $new_cate_id.'-cate-'.$file->getClientOriginalName());
            $path_old = public_path().'/uploads/categories/'.$new_cate_id.'-cate-'.$file->getClientOriginalName();
            $path_new = public_path().'/uploads/categories/'.$new_cate_id.'-cate-'.SimpleClass::trans_word($file->getClientOriginalName());
            copy($path_old,$path_new);
            $upNewRecords['image'] = Url().'/uploads/categories/'.$new_cate_id.'-cate-'.SimpleClass::trans_word($file->getClientOriginalName());
        }
        $rank = $request->get('rank');

        $conds = array(
            'parent'=> (string) $inserts['parent'],
            'order_by' => array('rank', 'asc')
        );
        $cates = BeCategoryModel::getCategories(array(), $conds, array('all'=>true));
        if($rank=='first') 
            $rank=1;
        if($rank=='last')
            $rank = count($cates);
        
        if (count($cates) > 1) {
            foreach ($cates as $k => $c) {
                if($k >= $rank) {
                    if ($c->id == $new_cate_id) 
                        continue;
                    $updates = array(
                        'rank' => $k+1
                    );
                    BeCategoryModel::find($c->id)->update($updates);
                }
            }
        }
        $upNewRecords['rank'] = $rank;
        BeCategoryModel::find($new_cate_id)->update($upNewRecords);

        $data['actives'] = array('xhbd-contents');
        $data['action_controller'] = 'save_category';
        Session::flash('success', SimpleClass::success_notice('Create new a category is successfully'));
        return redirect()->route('be-category.show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detailCategory($id)
    {
        $data = array();
        $data['record'] = BeCategoryModel::find($id);
        $parent = $data['record']->parent;
        $data['ranks'] = array();
        $conds = array(
            'parent' => (string) $data['record']->parent,
            'order_by' => array('rank', 'asc')
        );
        $data['categories_parent'] = BeCategoryModel::getCategories(array(),$conds, array('all'=>true));
        if ($parent != 0) {
            $conds = array(
                'parent' => (string) $parent,
                'order_by' => array('rank', 'asc')
            );
            $data['ranks'] = BeCategoryModel::getCategories(array(),$conds, array('all'=>true));
        } else {
            $data['ranks'] = $data['categories_parent'];
        }

        $data['categories_parent'] = BeCategoryModel::getCategories(array(),array('parent' => '=0'), array('all'=>true));
        $data['actives'] = array('xhbd-contents');
        $data['action_controller'] = 'update_category';
        return view('backend.categories.be_detail_category_view', compact('data'));
    }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function updateCategory($id, BeCategoryValidationRequest $request)
    {
        $record = BeCategoryModel::find($id);
        $updates = array(
            'name' => $request->get('name'),
            'name_alias' => SimpleClass::trans_word($request->get('name')),
            'description' => $request->get('description'),
            'status' => $request->get('status'),
            'updated_by' => 'Hungsama',
            'updated_at' => time()
        );
        $parent = $request->get('parent');
        if ($parent != 0) {
            if (!$cate_parent = BeCategoryModel::find($parent))
            {
                $errors[] = 'Parent Category is not exist';
                Session::flash('list_errors', SimpleClass::error_notice($errors));
                return redirect()->route('be-update-category.show', $id)->withInput();
            }
            $updates['parent'] = $parent;
        }

        if (Input::hasFile('image')) {
            $file = Input::file('image');
            $file->move('uploads/categories', $id.'-cate-'.$file->getClientOriginalName());
            $path_old = public_path().'/uploads/categories/'.$id.'-cate-'.$file->getClientOriginalName();
            $path_new = public_path().'/uploads/categories/'.$id.'-cate-'.SimpleClass::trans_word($file->getClientOriginalName());
            copy($path_old,$path_new);
            $updates['image'] = Url().'/uploads/categories/'.$id.'-cate-'.SimpleClass::trans_word($file->getClientOriginalName());
        }
        $conds = array(
            'parent'=> (string) $record->parent,
            'order_by' => array('rank', 'asc')
        );
        $cates = BeCategoryModel::getCategories(array(), $conds, array('all'=>true));

        $rank = $request->get('rank');
        if($rank=='first') 
            $rank=1;
        if($rank=='last') {
            if ($record->parent != $parent) 
                $rank = count($cates) + 1;
            else 
                $rank = count($cates);
        }

        if (count($cates) > 1) {
            foreach ($cates as $k => $c) {
                if ($c->id == $id) continue;
                if ($c->rank > 1 && $rank > $c->rank)
                    if ($c->rank > $record->rank)
                        $up = array('rank' => $c->rank-1);
                    else 
                        continue;
                elseif ($c->rank > 1 && $rank < $c->rank) 
                    if ($c->rank < $record->rank)
                        $up = array('rank' => $c->rank+1);
                    else 
                        continue;
                elseif($c->rank > 1 && $rank==$c->rank) 
                    if ($c->rank > $record->rank)
                        $up = array('rank' => $c->rank-1);
                    elseif($c->rank < $record->rank) 
                        $up = array('rank' => $c->rank+1);
                    else
                        continue;
                elseif($rank == 1)
                    if ($c->rank <= $record->rank)
                        $up = array('rank' => $c->rank+1);
                    else
                        continue;
                    
                if (isset($up))
                    BeCategoryModel::find($c->id)->update($up);
            }
        }
        $updates['rank'] = $rank;

        BeCategoryModel::find($id)->update($updates);
        Session::flash('success', SimpleClass::success_notice('Update a category is successfully'));
        return redirect()->route('be-detail-category.show', $id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteCategory($id)
    {
        BeCategoryModel::find($id)->delete();
        DB::table('category_and_article')->where('category_id', $id)->delete();
        Session::flash('success', SimpleClass::success_notice('Delete a category is successfully'));
        return redirect()->route('be-category.show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxSearchCategory(Request $request) {
        $conds = array(
            'name' => $request->get('name'),
            'status' => $request->get('status'),
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date')
        );
        $records = BeCategoryModel::getCategories(array(), $conds);
        $response_view = view('backend.categories.be_ajax_categories_view', compact('records'))->render();
        $current_search_view = view('backend.categories.be_current_search_view', compact('conds'))->render();
        return array(
            'response_view' => $response_view,
            'current_search_view' => $current_search_view
        );
    }

    public function listRank(Request $request) {
        $data = array();
        if ($request->get('is_parent')) {
            $conds = array(
                'parent' => '0',
                'order_by' => array('rank', 'asc')
            );
        } else {
            $cate_parent_id = $request->get('cate_parent_id');
            $conds = array(
                'parent' => (string) $cate_parent_id,
                'order_by' => array('rank', 'asc')
            );
        }
        $categories = BeCategoryModel::getCategories(array(),$conds, array('all'=>true));
        $data['categories'] = $categories;
        $data['rank'] = $request->get('rank');
        
        $response_view = view('backend.categories.be_ajax_place_view', compact('data'))->render();
        return array(
            'response_view' => $response_view
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
            BeCommonModel::updateStatus('categories', array('id' => $id), array('status' => $status));
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
