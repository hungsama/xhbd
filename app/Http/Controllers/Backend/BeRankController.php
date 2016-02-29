<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BeRankValidationRequest;
use App\Http\Controllers\Controller;
use App\Models\BeRankModel;
use App\Models\BeCategoryModel;
use App\Models\BeClubModel;
use App\Models\BeCommonModel;
use Route;
use Input;
use App\Libraries\SimpleClass;
use DB;
use Session;
use Validator;

class BeRankController extends Controller
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
        $data['records'] = BeRankModel::getRanks();
        return view('backend.ranks.be_ranks_view', compact('data'));
    }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function createRank()
    {
        $data = array();
        $conds = array(
            'status' => 1,
            'parent' => '0',
            'order_by' => 'asc'
        );
        $data['nations'] = BeCategoryModel::getCategories(array(),$conds, array('all'=>true));

        $conds = array(
            'status' => 1,
            'parent_diff' => '0',
            'is_league' => '1',
            'order_by' => 'asc'
        );
        $data['leagues'] = BeCategoryModel::getCategories(array(),$conds, array('all'=>true));
        $conds = array(
            'cate_id' => $data['nations'][0]->id
        );
        $data['clubs'] = BeClubModel::getClubs(array(),$conds, array('all'=>true));

        return view('backend.ranks.be_create_rank_view', compact('data'));
    }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function saveRank(BeRankValidationRequest $request)
    {
        $data = array();
        $inserts = array(
          'league_id' => $request->get('league_id'),
          'club_id' => $request->get('club_id'),
          'status' => 1,
          'created_by' => 'Hungsama',
          'updated_by' => '',
          'created_at' => time(),
          'updated_at' => 0
        );
        $conds = array(
            'id' => $inserts['league_id']
        );
        $infoLeague = BeCategoryModel::find($inserts['league_id']);
        $inserts['league_name'] = $infoLeague->name;
        $inserts['league_alias'] = $infoLeague->name_alias;
        $inserts['league_logo'] = $infoLeague->image;
        $infoClub = BeClubModel::find($inserts['club_id']);
        $inserts['club_name'] = $infoClub->name;
        $inserts['club_alias'] = $infoClub->name_alias;
        $inserts['club_logo'] = $infoClub->club_logo;

        $new_rank_id = BeRankModel::insertGetId($inserts);

        Session::flash('success', SimpleClass::success_notice('Create new a rank is successfully'));
        return redirect()->route('be-ranks.show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detailRank($id)
    {
        $data = array();
        $data['record'] = BeRankModel::find($id);
        return view('backend.ranks.be_detail_rank_view', compact('data'));
    }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function updateRank($id, BeRankValidationRequest $request)
    {
        $record = BeRankModel::find($id);
        $updates = array(
            'wins' => $request->get('wins'),
            'dashs' => $request->get('dashs'),
            'loses' => $request->get('loses'),
            'goals_win' => $request->get('goals_win'),
            'goals_lose' => $request->get('goals_lose'),
            'updated_by' => 'Hungsama',
            'updated_at' => time()
        );
        $updates['matchs'] = $updates['wins'] + $updates['dashs'] + $inserts['loses'];
        $updates['coefficient'] = $updates['goals_win'] - $updates['goals_lose'];
        $updates['scores'] = $updates['wins']*3 + $updates['dashs'];
        
        BeRankModel::find($id)->update($updates);
        Session::flash('success', SimpleClass::success_notice('Update a rank is successfully'));
        return redirect()->route('be-detail-rank.show', $id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteRank($id)
    {
        $infoRank = BeRankModel::find($id);
        BeRankModel::find($id)->delete();
        Session::flash('success', SimpleClass::success_notice('Delete a rank is successfully'));
        return redirect()->route('be-rank.show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxSearchRank(Request $request) {
        $conds = array(
            'name' => $request->get('name'),
            'status' => $request->get('status'),
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date')
        );
        $records = BeRankModel::getCategories(array(), $conds);
        $response_view = view('backend.ranks.be_ajax_ranks_view', compact('records'))->render();
        $current_search_view = view('backend.ranks.be_current_search_view', compact('conds'))->render();
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
        
        $ranks = BeRankModel::getRanks(array(),$conds, array('all'=>true));
        $data['ranks'] = $ranks;
        $data['rank'] = $request->get('rank');
        
        $response_view = view('backend.ranks.be_ajax_place_view', compact('data'))->render();
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
            BeCommonModel::updateStatus('ranks', array('id' => $id), array('status' => $status));
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
        $nation_id = $request->get('nation_id');
        $club_type = $request->get('club_type');
        $conds = array(
            'cate_id' => $nation_id,
            'order_by' => array('rank', 'asc')
        );
        $data['clubs'] = BeClubModel::getClubs(array(), $conds, array('all' => true));
        $data['club_type'] = $club_type;
        $response_view = view('backend.ranks.be_ajax_change_nation_view', compact('data'))->render();
        return array(
            'response_view' => $response_view
        );
    }
}
