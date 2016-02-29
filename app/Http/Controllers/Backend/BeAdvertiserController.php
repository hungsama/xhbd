<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BeAdvertiserValidationRequest;
use App\Http\Controllers\Controller;
use App\Models\BeAdvertiserModel;
use Route;
use Input;
use App\Libraries\SimpleClass;
use DB;
use Session;
use Validator;

class BeAdvertiserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = array();
    $data['records'] = BeAdvertiserModel::getAdvertisers();
    $data['actives'] = array('xhbd-ads', 'list-advertiser');
    $data['action_controller'] = 'list_advertiser';
    return view('backend.advertisers.be_advertisers_view', compact('data'));
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function createAdvertiser()
  {
    $data = array();
    $data['actives'] = array('xhbd-contents');
    $data['action_controller'] = 'create_advertiser';
    $data['actives'] = array('xhbd-ads', 'list-advertiser');
    return view('backend.advertisers.be_create_advertiser_view', compact('data'));
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function saveAdvertiser(BeAdvertiserValidationRequest $request)
  {
    $data = array();
    $inserts = array(
      'name' => $request->get('name'),
      'description' => $request->get('description'),
      'mobile' => $request->get('mobile'),
      'email' => $request->get('email'),
      'address' => $request->get('address'),
      'status' => 1,
      'created_by' => 'Hungsama',
      'updated_by' => '',
      'created_at' => time(),
      'updated_at' => 0
    );
    BeAdvertiserModel::insertGetId($inserts);
    Session::flash('success', SimpleClass::success_notice('Create new an advertiser is successfully'));
    return redirect()->route('be-advertiser.show');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function detailAdvertiser($id)
  {
    $data = array();
    $data['record'] = BeAdvertiserModel::find($id);
    $data['actives'] = array('xhbd-ads');
    $data['action_controller'] = 'update_advertiser';
    return view('backend.advertisers.be_detail_advertiser_view', compact('data'));
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function updateAdvertiser($id, BeAdvertiserValidationRequest $request)
  {
    $record = BeAdvertiserModel::find($id);
    $updates = array(
      'name' => $request->get('name'),
      'description' => $request->get('description'),
      'mobile' => $request->get('mobile'),
      'email' => $request->get('email'),
      'address' => $request->get('address'),
      'status' => $request->get('status'),
      'updated_by' => 'Hungsama',
      'updated_at' => time()
    );

    BeAdvertiserModel::find($id)->update($updates);
    Session::flash('success', SimpleClass::success_notice('Update an advertiser is successfully'));
    return redirect()->route('be-detail-advertiser.show', $id);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function deleteAdvertiser($id)
  {
    BeAdvertiserModel::find($id)->delete();
    Session::flash('success', SimpleClass::success_notice('Delete an advertiser is successfully'));
    return redirect()->route('be-advertiser.show');
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
            BeCommonModel::updateStatus('advertisers', array('id' => $id), array('status' => $status));
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
