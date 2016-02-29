<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BeTagValidationRequest;
use App\Http\Controllers\Controller;
use App\Models\BeTagModel;
use Route;
use Input;
use App\Libraries\SimpleClass;
use DB;
use Session;
use Validator;

class BeTagController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = array();
    $data['records'] = BeTagModel::getTags();
    $data['actives'] = array('xhbd-contents', 'list-tag');
    $data['action_controller'] = 'list_tag';
    return view('backend.tags.be_tags_view', compact('data'));
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function createTag()
  {
    $data = array();
    $data['actives'] = array('xhbd-contents');
    $data['action_controller'] = 'create_tag';
    return view('backend.tags.be_create_tag_view', compact('data'));
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function saveTag(BeTagValidationRequest $request)
  {
    $data = array();
    $inserts = array(
      'name' => $request->get('name'),
      'name_alias' => SimpleClass::trans_word($request->get('name')),
      'status' => 1,
      'created_by' => 'Hungsama',
      'updated_by' => '',
      'created_at' => time(),
      'updated_at' => 0
    );
    BeTagModel::insertGetId($inserts);
    $data['actives'] = array('xhbd-contents');
    $data['action_controller'] = 'save_tag';
    Session::flash('success', SimpleClass::success_notice('Create new a tag is successfully'));
    return redirect()->route('be-tag.show');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function detailTag($id)
  {
    $data = array();
    $data['actives'] = array('xhbd-contents');
    $data['record'] = BeTagModel::find($id);
    $data['action_controller'] = 'update_tag';
    return view('backend.tags.be_detail_tag_view', compact('data'));
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function updateTag($id, BeTagValidationRequest $request)
  {
    $updates = array(
      'name' => $request->get('name'),
      'name_alias' => SimpleClass::trans_word($request->get('name')),
      'status' => $request->get('name'),
      'created_by' => 'Hungsama',
      'updated_by' => '',
      'created_at' => time(),
      'updated_at' => 0
    );
    $data['action_controller'] = 'update_tag';
    BeTagModel::find($id)->update($updates);
    Session::flash('success', SimpleClass::success_notice('Update a tag is successfully'));
    return redirect()->route('be-detail-tag.show', $id);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function deleteTag($id)
  {
    BeTagModel::find($id)->delete();
    DB::table('tag_and_article')->where('tag_id', $id)->delete();
    Session::flash('success', SimpleClass::success_notice('Delete a tag is successfully'));
    return redirect()->route('be-tag.show');
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
            BeCommonModel::updateStatus('tags', array('id' => $id), array('status' => $status));
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
