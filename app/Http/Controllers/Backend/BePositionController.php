<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BePositionValidationRequest;
use App\Http\Controllers\Controller;
use App\Models\BePositionModel;
use Route;
use Input;
use App\Libraries\SimpleClass;
use DB;
use Session;
use Validator;

class BePositionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = array();
    $data['records'] = BePositionModel::getPositions();
    $data['actives'] = array('xhbd-ads', 'list-position');
    $data['action_controller'] = 'list_position';
    return view('backend.positions.be_positions_view', compact('data'));
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function createPosition()
  {
    $data = array();
    $data['actives'] = array('xhbd-ads', 'list-position');
    $data['action_controller'] = 'create_position';
    return view('backend.positions.be_create_position_view', compact('data'));
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function savePosition(BePositionValidationRequest $request)
  {
    $data = array();
    $inserts = array(
      'name' => $request->get('name'),
      'name_alias' => SimpleClass::trans_word($request->get('name')),
      'type' => $request->get('type'),
      'notes' => $request->get('notes'),
      'image_default' => '',
      'place' => $request->get('place').'_'.$request->get('place_sub'),
      'limit_ads' => $request->get('limit_ads'),
      'status' => 1,
      'created_by' => 'Hungsama',
      'updated_by' => '',
      'created_at' => time(),
      'updated_at' => 0
    );
    $postion_id = BePositionModel::insertGetId($inserts);

    if (Input::hasFile('image_default')) {
      $file = Input::file('image_default');
      $file->move('uploads/positions', $postion_id.'-'.$file->getClientOriginalName());
      $path_old = public_path().'/uploads/positions/'.$postion_id.'-'.$file->getClientOriginalName();
      $path_new = public_path().'/uploads/positions/'.$postion_id.'-'.SimpleClass::trans_word($file->getClientOriginalName());
      copy($path_old,$path_new);
      $updates = array('image_default' => Url().'/uploads/positions/'.$postion_id.'-'.SimpleClass::trans_word($file->getClientOriginalName()));
    } else 
      $updates = array('image_default' => url().'/frontend/images/quang-cao.jpg');
    
    BePositionModel::find($postion_id)->update($updates);
    $data['actives'] = array('xhbd-contents');
    $data['action_controller'] = 'save_position';
    Session::flash('success', SimpleClass::success_notice('Create new a position is successfully'));
    return redirect()->route('be-position.show');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function detailPosition($id)
  {
    $data = array();
    $data['record'] = BePositionModel::find($id);
    $data['actives'] = array('xhbd-contents');
    $data['action_controller'] = 'update_position';
    return view('backend.positions.be_detail_position_view', compact('data'));
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function updatePosition($id, BePositionValidationRequest $request)
  {
    $updates = array(
      'name' => $request->get('name'),
      'name_alias' => SimpleClass::trans_word($request->get('name')),
      'type' => $request->get('type'),
      'notes' => $request->get('notes'),
      'place' => $request->get('place').'_'.$request->get('place_sub'),
      'limit_ads' => $request->get('limit_ads'),
      'status' => $request->get('status'),
      'updated_by' => 'Hungsama',
      'updated_at' => time()
    );

    if (Input::hasFile('image_default')) {
      $file = Input::file('image_default');
      $file->move('uploads/positions', $postion_id.'-'.$file->getClientOriginalName());
      $path_old = public_path().'/uploads/positions/'.$postion_id.'-'.$file->getClientOriginalName();
      $path_new = public_path().'/uploads/positions/'.$postion_id.'-'.SimpleClass::trans_word($file->getClientOriginalName());
      copy($path_old,$path_new);
      $updates['image_default'] = Url().'/uploads/positions/'.$postion_id.'-'.SimpleClass::trans_word($file->getClientOriginalName());
      BePositionModel::find($postion_id)->update($updates);
    }
    BePositionModel::find($id)->update($updates);
    Session::flash('success', SimpleClass::success_notice('Update a position is successfully'));
    return redirect()->route('be-detail-position.show', $id);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function deletePosition($id)
  {
    BePositionModel::find($id)->delete();
    DB::table('position_and_advertisement')->where('position_id', $id)->delete();
    Session::flash('success', SimpleClass::success_notice('Delete a position is successfully'));
    return redirect()->route('be-position.show');
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
            BeCommonModel::updateStatus('positions', array('id' => $id), array('status' => $status));
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
