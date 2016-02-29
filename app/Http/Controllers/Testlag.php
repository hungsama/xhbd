<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Session;
use App;

class Testlag extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index($id)
  {
    Session::set('locate', $id);
    App::setLocale($id);
    $lang = $id;
    return view('testlag_view', compact('lang'));
  }
}
