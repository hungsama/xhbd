<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BeLiveValidationRequest;
use App\Http\Controllers\Controller;
use App\Models\BeLiveModel;
use App\Models\BeCategoryModel;
use App\Models\BeClubModel;
use App\Models\BeCommonModel;
use Route;
use Input;
use App\Libraries\SimpleClass;
use DB;
use Session;
use Validator;

class BeLiveController extends Controller
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
        $data['records'] = BeLiveModel::getLives();
        return view('backend.lives.be_lives_view', compact('data'));
    }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function createLive()
    {
        $data = array();
        $conds = array(
            'parent' => '0',
            'order_by' => array('rank', 'asc')
        );
        $data['nations'] = BeCategoryModel::getCategories(array(),$conds, array('all'=>true));
        $conds = array(
            'cate_id' => $data['nations'][0]->id
        );
        $data['clubs'] = BeClubModel::getClubs(array(),$conds, array('all'=>true));
        $conds = array(
            'league_id' => $data['nations'][0]->id,
            'order_by' => array('rank', 'asc')
        );
        $data['lives'] = BeLiveModel::getLives(array(), $conds, array('all' => true));
        $conds = array(
            'parent_diff' => '0',
            'order_by' => array('rank', 'asc')
        );
        $data['leagues'] = BeCategoryModel::getCategories(array(), $conds, array('all' => true));
        return view('backend.lives.be_create_live_view', compact('data'));
    }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function saveLive(BeLiveValidationRequest $request)
    {
        $data = array();
        $inserts = array(
          'home_id' => $request->get('home_id'),
          'guest_id' => $request->get('guest_id'),
          'league_id' => $request->get('league_id'),
          'description' => $request->get('description'),
          'live_time' => $request->get('live_time'),
          'status' => 1,
          'created_by' => 'Hungsama',
          'updated_by' => '',
          'created_at' => time(),
          'updated_at' => 0
        );
        $home_club = BeClubModel::find($inserts['home_id']);
        $inserts['home_name'] = $home_club->name;
        $inserts['home_alias'] = $home_club->name_alias;
        $inserts['home_logo'] = $home_club->logo;

        $guest_club = BeClubModel::find($inserts['guest_id']);
        $inserts['guest_name'] = $guest_club->name;
        $inserts['guest_alias'] = $guest_club->name_alias;
        $inserts['guest_logo'] = $guest_club->logo;

        $league = BeCategoryModel::find($inserts['league_id']);
        $inserts['league_name'] = $league->name;
        $inserts['league_alias'] = $league->name_alias;
        $inserts['league_logo'] = $league->image;

        $new_live_id = BeLiveModel::insertGetId($inserts);
        $upNewRecords = array();
        $rank = $request->get('rank');

        $conds = array(
            'league_id'=> (string) $inserts['league_id'],
            'order_by' => array('rank', 'asc')
        );
        
        $lives = BeLiveModel::getLives(array(), $conds, array('all'=>true));

        if($rank=='first') 
            $rank=1;
        if($rank=='last')
            $rank = count($lives);
        
        if (count($lives) > 1) {
            foreach ($lives as $k => $c) {
                if($k >= $rank) {
                    if ($c->id == $new_live_id) 
                        continue;
                    $updates = array(
                        'rank' => $k+1
                    );
                    BeLiveModel::find($c->id)->update($updates);
                }
            }
        }
        $upNewRecords['rank'] = $rank;
        BeLiveModel::find($new_live_id)->update($upNewRecords);

        Session::flash('success', SimpleClass::success_notice('Create new a live is successfully'));
        return redirect()->route('be-lives.show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detailLive($id)
    {
        $data = array();
        $data['record'] = BeLiveModel::find($id);
        $cate_id = $data['record']->cate_id;
        $data['ranks'] = array();
        $conds = array(
            'cate_id' => (string) $data['record']->cate_id,
            'order_by' => array('rank', 'asc')
        );
        $data['lives'] = BeLiveModel::getLives(array(),$conds, array('all'=>true));
        $conds = array(
            'parent' => '0',
            'order_by' => array('rank', 'asc')
        );
        $data['categories'] = BeCategoryModel::getCategories(array(),$conds, array('all'=>true));
        return view('backend.lives.be_detail_live_view', compact('data'));
    }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function updateLive($id, BeLiveValidationRequest $request)
    {
        $record = BeLiveModel::find($id);
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
            $file->move('uploads/lives', $id.'-live-'.$file->getClientOriginalName());
            $path_old = public_path().'/uploads/lives/'.$id.'-live-'.$file->getClientOriginalName();
            $path_new = public_path().'/uploads/lives/'.$id.'-live-'.SimpleClass::trans_word($file->getClientOriginalName());
            copy($path_old,$path_new);
            $updates['image'] = Url().'/uploads/lives/'.$id.'-live-'.SimpleClass::trans_word($file->getClientOriginalName());
        }
        $conds = array(
            'cate_id'=> (string) $cate_id,
            'order_by' => array('rank', 'asc')
        );
        $lives = BeLiveModel::getLives(array(), $conds, array('all'=>true));

        $rank = $request->get('rank');
        if($rank=='first') 
            $rank=1;
        if($rank=='last') {
            if ($record->cate_id != $cate_id) 
                $rank = count($lives) + 1;
            else 
                $rank = count($lives);
        }

        if (count($lives) > 1) {
            foreach ($lives as $k => $c) {
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
                    BeLiveModel::find($c->id)->update($up);
            }
        }
        $updates['rank'] = $rank;

        BeLiveModel::find($id)->update($updates);
        Session::flash('success', SimpleClass::success_notice('Update a live is successfully'));
        return redirect()->route('be-detail-live.show', $id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteLive($id)
    {
        $infoLive = BeLiveModel::find($id);
        BeLiveModel::find($id)->delete();
        Session::flash('success', SimpleClass::success_notice('Delete a live is successfully'));
        return redirect()->route('be-live.show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxSearchLive(Request $request) {
        $conds = array(
            'name' => $request->get('name'),
            'status' => $request->get('status'),
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date')
        );
        $records = BeLiveModel::getCategories(array(), $conds);
        $response_view = view('backend.lives.be_ajax_lives_view', compact('records'))->render();
        $current_search_view = view('backend.lives.be_current_search_view', compact('conds'))->render();
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

        $lives = BeLiveModel::getLives(array(),$conds, array('all'=>true));
        $data['lives'] = $lives;
        $data['rank'] = $request->get('rank');
        
        $response_view = view('backend.lives.be_ajax_place_view', compact('data'))->render();
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
            BeCommonModel::updateStatus('lives', array('id' => $id), array('status' => $status));
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

    public function changeNation(Request $request) {
        $cate_id = $request->get('nation_id');
        $club_type = $request->get('club_type');
        $conds = array(
            'cate_id' => $cate_id,
            'order_by' => array('rank', 'asc')
        );
        $data['clubs'] = BeClubModel::getClubs(array(), $conds, array('all' => true));
        $data['club_type'] = $club_type;
        $response_view = view('backend.lives.be_ajax_change_nation_view', compact('data'))->render();
        return array(
            'response_view' => $response_view
        );
    }
}
