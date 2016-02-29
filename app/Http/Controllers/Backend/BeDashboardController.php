<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use App\Libraries\SimpleClass;
use Illuminate\Routing\Controller as BaseController;

class BeDashboardController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $data = array();
        if (!Session::get('adminInfo')) {
            Session::forget('adminInfo');
            $errors= array('Account not exist or session expired.');
            Session::flash('list_errors', SimpleClass::error_notice($errors));
            return redirect()->route('be-login-admin.show')->withInput();
        }
        return view('backend.dashboard.be_dashboard_view', compact('data'));
    }
}
