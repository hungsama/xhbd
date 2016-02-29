<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BeClubValidationRequest;
use App\Http\Controllers\Controller;
use App\Models\BeClubModel;
use App\Models\BeCategoryModel;
use App\Models\BeCommonModel;
use Route;
use Input;
use App\Libraries\SimpleClass;
use DB;
use Session;
use Validator;

class BeClubController extends Controller
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
        $data['records'] = BeClubModel::getClubs();
        return view('backend.clubs.be_clubs_view', compact('data'));
    }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function createClub()
    {
        $data = array();
        $conds = array(
            'parent' => '0',
            'order_by' => array('rank', 'asc')
        );
        $data['categories'] = BeCategoryModel::getCategories(array(),$conds, array('all'=>true));
        $conds = array(
            'cate_id' => $data['categories'][0]->id
        );
        $data['clubs'] = BeClubModel::getClubs(array(),$conds, array('all'=>true));
        return view('backend.clubs.be_create_club_view', compact('data'));
    }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function saveClub(BeClubValidationRequest $request)
    {
        $data = array();
        $inserts = array(
          'name' => $request->get('name'),
          'name_alias' => SimpleClass::trans_word($request->get('name')),
          'description' => $request->get('description'),
          'logo' => url().'/frontend/images/fb-df.jpg',
          'cate_id' => $request->get('cate_id'),
          'status' => 1,
          'created_by' => 'Hungsama',
          'updated_by' => '',
          'created_at' => time(),
          'updated_at' => 0
        );
        $inserts['belong_league'] = BeCategoryModel::find($inserts['cate_id'])->name;

        $new_club_id = BeClubModel::insertGetId($inserts);
        $upNewRecords = array();
        if (Input::hasFile('logo')) {
            $file = Input::file('logo');
            $file->move('uploads/clubs', $new_club_id.'-club-'.$file->getClientOriginalName());
            $path_old = public_path().'/uploads/clubs/'.$new_club_id.'-club-'.$file->getClientOriginalName();
            $path_new = public_path().'/uploads/clubs/'.$new_club_id.'-club-'.SimpleClass::trans_word($file->getClientOriginalName());
            copy($path_old,$path_new);
            $upNewRecords['logo'] = Url().'/uploads/clubs/'.$new_club_id.'-club-'.SimpleClass::trans_word($file->getClientOriginalName());
        }
        $rank = $request->get('rank');

        $conds = array(
            'cate_id'=> (string) $inserts['cate_id'],
            'order_by' => array('rank', 'asc')
        );
        $clubs = BeClubModel::getClubs(array(), $conds, array('all'=>true));

        if($rank=='first') 
            $rank=1;
        if($rank=='last')
            $rank = count($clubs);
        
        if (count($clubs) > 1) {
            foreach ($clubs as $k => $c) {
                if($k >= $rank) {
                    if ($c->id == $new_club_id) 
                        continue;
                    $updates = array(
                        'rank' => $k+1
                    );
                    BeClubModel::find($c->id)->update($updates);
                }
            }
        }
        $upNewRecords['rank'] = $rank;
        BeClubModel::find($new_club_id)->update($upNewRecords);

        Session::flash('success', SimpleClass::success_notice('Create new a club is successfully'));
        return redirect()->route('be-clubs.show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detailClub($id)
    {
        $data = array();
        $data['record'] = BeClubModel::find($id);
        $cate_id = $data['record']->cate_id;
        $data['ranks'] = array();
        $conds = array(
            'cate_id' => (string) $data['record']->cate_id,
            'order_by' => array('rank', 'asc')
        );
        $data['clubs'] = BeClubModel::getClubs(array(),$conds, array('all'=>true));
        $conds = array(
            'parent' => '0',
            'order_by' => array('rank', 'asc')
        );
        $data['categories'] = BeCategoryModel::getCategories(array(),$conds, array('all'=>true));
        return view('backend.clubs.be_detail_club_view', compact('data'));
    }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function updateClub($id, BeClubValidationRequest $request)
    {
        $record = BeClubModel::find($id);
        $updates = array(
            'name' => $request->get('name'),
            'name_alias' => SimpleClass::trans_word($request->get('name')),
            'description' => $request->get('description'),
            'status' => $request->get('status'),
            'updated_by' => 'Hungsama',
            'updated_at' => time()
        );
        $cate_id = $request->get('cate_id');

        if (Input::hasFile('logo')) {
            $file = Input::file('logo');
            $file->move('uploads/clubs', $id.'-club-'.$file->getClientOriginalName());
            $path_old = public_path().'/uploads/clubs/'.$id.'-club-'.$file->getClientOriginalName();
            $path_new = public_path().'/uploads/clubs/'.$id.'-club-'.SimpleClass::trans_word($file->getClientOriginalName());
            copy($path_old,$path_new);
            $updates['image'] = Url().'/uploads/clubs/'.$id.'-club-'.SimpleClass::trans_word($file->getClientOriginalName());
        }
        $conds = array(
            'cate_id'=> (string) $cate_id,
            'order_by' => array('rank', 'asc')
        );
        $clubs = BeClubModel::getClubs(array(), $conds, array('all'=>true));

        $rank = $request->get('rank');
        if($rank=='first') 
            $rank=1;
        if($rank=='last') {
            if ($record->cate_id != $cate_id) 
                $rank = count($clubs) + 1;
            else 
                $rank = count($clubs);
        }

        if (count($clubs) > 1) {
            foreach ($clubs as $k => $c) {
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
                    BeClubModel::find($c->id)->update($up);
            }
        }
        $updates['rank'] = $rank;

        BeClubModel::find($id)->update($updates);
        Session::flash('success', SimpleClass::success_notice('Update a club is successfully'));
        return redirect()->route('be-detail-club.show', $id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteClub($id)
    {
        $infoClub = BeClubModel::find($id);
        BeClubModel::find($id)->delete();
        Session::flash('success', SimpleClass::success_notice('Delete a club is successfully'));
        return redirect()->route('be-club.show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxSearchClub(Request $request) {
        $conds = array(
            'name' => $request->get('name'),
            'status' => $request->get('status'),
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date')
        );
        $records = BeClubModel::getCategories(array(), $conds);
        $response_view = view('backend.clubs.be_ajax_clubs_view', compact('records'))->render();
        $current_search_view = view('backend.clubs.be_current_search_view', compact('conds'))->render();
        return array(
            'response_view' => $response_view,
            'current_search_view' => $current_search_view
        );
    }

    public function listRank(Request $request) {
        $data = array();
        $conds=array(
            'cate_id' => $request->get('cate_id'),
            'order_by' => array('rank', 'asc')
        );

        $clubs = BeClubModel::getClubs(array(),$conds, array('all'=>true));
        $data['clubs'] = $clubs;
        $data['rank'] = $request->get('rank');
        
        $response_view = view('backend.clubs.be_ajax_place_view', compact('data'))->render();
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
            BeCommonModel::updateStatus('clubs', array('id' => $id), array('status' => $status));
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
