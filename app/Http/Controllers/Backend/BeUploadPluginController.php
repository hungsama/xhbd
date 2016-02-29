<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BeUploadPluginValidationRequest;
use App\Http\Controllers\Controller;
use App\Models\BeUploadPluginModel;
use App\Libraries\SimpleClass;
use Route;
use Input;
use Session;
use Image;

class BeUploadPluginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data['records'] = BeUploadPluginModel::getFiles();
        $response_view = view('backend.uploads.be_listfiles_view', compact('data'))->render();
        return array(
            'error' => 0,
            'msg' => 'success',
            'response_view' => $response_view
        );
    }

    public function uploadFile(BeUploadPluginValidationRequest $request) {
        $file_name = Input::get('file_name');
        $width = Input::get('width');
        $height = Input::get('height');

        if (Input::hasFile('url')) {
            $file = Input::file('url');
            $ran = mt_rand(0, 100);
            $ran_new = mt_rand(0, 100);
            $file->move('uploads/filesstore', $ran.'-'.$file->getClientOriginalName());
            $path_old = public_path().'/uploads/filesstore/'.$ran.'-'.$file->getClientOriginalName();
            $path_new = public_path().'/uploads/filesstore/'.$ran_new.'-'.SimpleClass::trans_word($file->getClientOriginalName());
            copy($path_old,$path_new);
            unset($path_old);
            if (is_numeric($width) && $width>=80 && is_numeric($height) && $height>=80) {
                $img = Image::make($path_new)->resize($width, $height);
                $img->save($path_new);
            }
            $url = Url().'/uploads/filesstore/'.$ran_new.'-'.SimpleClass::trans_word($file->getClientOriginalName());
        }

        $path = $_FILES['url']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $inserts = array(
            'file_name' => $file_name,
            'url' => $url,
            'ext' => $ext,
            'status' => 1,
            'created_by' => 'hungsama',
            'created_at' => time()
        );
        BeUploadPluginModel::insertImage($inserts);
        return array(
            'error' => 0,
            'msg' => 'success',
            'url' => $url
        );
    }

    public function ajaxSearchFile(Request $request) {
        $conds = array();
        $records = BeUploadPluginModel::getFiles(array(), $conds);
        $response_view = view('backend.uploads.be_more_image_view', compact('records'))->render();
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
            BeCommonModel::updateStatus('filesstore', array('id' => $id), array('status' => $status));
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
