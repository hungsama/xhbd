<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BeAdvertisementValidationRequest;
use App\Http\Controllers\Controller;
use App\Models\BeAdvertisementModel;
use App\Models\BePositionModel;
use App\Models\BeAdvertiserModel;
use App\Models\BeCommonModel;
use Route;
use Input;
use App\Libraries\SimpleClass;
use DB;
use Session;
use Validator;

class BeAdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data['records'] = BeAdvertisementModel::getAdvertisements();
        $data['actives'] = array('xhbd-ads', 'list-advertisement');
        $data['action_controller'] = 'list_advertisement';
        return view('backend.advertisements.be_advertisements_view', compact('data'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createAdvertisement()
    {
        $data = array();
        $data['advertisers'] = DB::table('advertisers')->get();
        $data['positions'] = DB::table('positions')->get();
        $data['actives'] = array('xhbd-contents');
        $data['action_controller'] = 'create_advertisement';
        return view('backend.advertisements.be_create_advertisement_view', compact('data'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveAdvertisement(BeAdvertisementValidationRequest $request)
    {
        $data = array();
        $inserts = array(
            'name' => $request->get('name'),
            'name_alias' => SimpleClass::trans_word($request->get('name')),
            'note' => $request->get('note'),
            'url_image' => '',
            'url_redirect' => $request->get('url_redirect'),
            'advertiser_id' => $request->get('advertiser_id'),
            'position_id' => $request->get('position_id'),
            'mode' => $request->get('mode'),
            'status' => 1,
            'time_start' => $request->get('time_start'),
            'time_end' => $request->get('time_end'),
            'created_by' => 'Hungsama',
            'updated_by' => '',
            'created_at' => time(),
            'updated_at' => 0
            );
        $advertisement_id = BeAdvertisementModel::insertGetId($inserts);
        if (Input::hasFile('url_image')) {
            $file = Input::file('url_image');
            $file->move('uploads/advertisements', $advertisement_id.'-'.$file->getClientOriginalName());
            $path_old = public_path().'/uploads/advertisements/'.$advertisement_id.'-'.$file->getClientOriginalName();
            $path_new = public_path().'/uploads/advertisements/'.$advertisement_id.'-'.SimpleClass::trans_word($file->getClientOriginalName());
            copy($path_old,$path_new);
            $updates = array('url_image' => Url().'/uploads/advertisements/'.$advertisement_id.'-'.SimpleClass::trans_word($file->getClientOriginalName()));
            BeAdvertisementModel::find($advertisement_id)->update($updates);
        }

        $infoPosition = BePositionModel::find($inserts['position_id']);
        $infoAdvertiser = BeAdvertisementModel::find($inserts['advertiser_id']);

        $insert_new = array(
            'position_id' => $inserts['position_id'],
            'advertisement_id' => $advertisement_id,
            'position_name' => $inserts['name'],
            'position_alias' => $inserts['name_alias']
        );

        BeCommonModel::insertIntoTablePositionAndAdvertiserment($insert_new);

        $data['actives'] = array('xhbd-ads');
        $data['action_controller'] = 'save_advertisement';
        Session::flash('success', SimpleClass::success_notice('Create new a advertisement is successfully'));
        return redirect()->route('be-advertisement.show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detailAdvertisement($id)
    {
        $data = array();
        $data['actives'] = array('xhbd-contents');
        $data['advertisers'] = DB::table('advertisers')->get();
        $data['positions'] = DB::table('positions')->get();
        $data['record'] = BeAdvertisementModel::find($id);
        $data['actives'] = array('xhbd-ads');
        $data['action_controller'] = 'update_advertisement';
        return view('backend.advertisements.be_detail_advertisement_view', compact('data'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAdvertisement($id, BeAdvertisementValidationRequest $request)
    {
        $record = BeAdvertisementModel::find($id);
        $updates = array(
            'name' => $request->get('name'),
            'name_alias' => SimpleClass::trans_word($request->get('name')),
            'note' => $request->get('note'),
            'url_image' => '',
            'url_redirect' => $request->get('url_redirect'),
            'advertiser_id' => $request->get('advertiser_id'),
            'position_id' => $request->get('position_id'),
            'mode' => $request->get('mode'),
            'status' => $request->get('status'),
            'time_start' => $request->get('time_start'),
            'time_end' => $request->get('time_end'),
            'updated_by' => 'Hungsama',
            'updated_at' => time()
            );
        if (Input::hasFile('url_image')) {
            $file = Input::file('url_image');
            $file->move('uploads/advertisements', $id.'-'.$file->getClientOriginalName());
            $path_old = public_path().'/uploads/advertisements/'.$id.'-'.$file->getClientOriginalName();
            $path_new = public_path().'/uploads/advertisements/'.$id.'-'.SimpleClass::trans_word($file->getClientOriginalName());
            copy($path_old,$path_new);
            $updates = array('url_image' => Url().'/uploads/advertisements/'.$id.'-'.SimpleClass::trans_word($file->getClientOriginalName()));
            BeAdvertisementModel::find($id)->update($updates);
        }

        BeAdvertisementModel::find($id)->update($updates);
        Session::flash('success', SimpleClass::success_notice('Update a advertisement is successfully'));
        return redirect()->route('be-detail-advertisement.show', $id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAdvertisement($id)
    {
        BeAdvertisementModel::find($id)->delete();
        Session::flash('success', SimpleClass::success_notice('Delete an advertisement is successfully'));
        return redirect()->route('be-advertisement.show');
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
            BeCommonModel::updateStatus('advertisements', array('id' => $id), array('status' => $status));
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
