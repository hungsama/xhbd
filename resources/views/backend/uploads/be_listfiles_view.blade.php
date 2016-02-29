@include('backend.masters.be_reload_js_view')
<div class="modal-dialog">
    <div class="modal-content">
        @include('backend.notices.errors_view')
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Select File</h4>
        </div>
        <div class="content controls">
            <div class="form-row">
                <div class="col-md-12">
                <div class="block">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="active"><a href="#tab11" data-toggle="tab" onclick="change_tab('1');">Select image in library</a></li>
                        <li><a href="#tab12" data-toggle="tab" onclick="change_tab('2')">Upload file from computer</a></li>                        
                    </ul>
                    <div class="content content-transparent tab-content">
                        <div class="tab-pane active" id="tab11">
                            @if(count($data['records']->items()) > 0)
                                <div class="block block-transparent">
                                    <div class="content gallery" style="margin-left:42px;" id="append-file">
                                        @foreach($data['records']->items() as $k => $v)
                                            <a rel="group" href="#" onclick="selectFile('#image_{!! $v->id !!}');"><img class="lib-image" id="image_{!! $v->id !!}" src="{!! $v->url !!}" style="margin:4px;" width="150px" height="115px"></a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 col-sm-offset-5">
                                        <button type="button" class="btn btn-success btn-clean" onclick="getAjaxFiles();">More...</button>
                                    </div>
                                </div>
                            @else 
                                <p>No image, please first upload.</p>
                            @endif
                        </div>
                        <div class="tab-pane" id="tab12">
                            <form enctype="multipart/form-data" id="form_submit" role="form" method="POST" action="" >
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <div class="form-row">
                                    <div class="col-md-3">File name</div>
                                    <div class="col-md-6">
                                        <input type="text" name="file_name" class="form-control"/>                                
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-3">Select path</div>
                                    <div class="col-md-6">
                                        <div class="input-group file">                                    
                                            <input type="text" class="form-control">
                                            <input type="file" name="url">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button">Browse</button>
                                            </span>
                                        </div>                                
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="col-md-3">Resize</div>
                                    <div class="col-md-2">
                                        <input type="text" name="width" class="img_width" value="" placeholder="width"/>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="height" class="img_height" value="" placeholder="height"/>
                                    </div>
                                </div>
                            </form>
                        </div> 
                    </div>
                </div>                
            </div>
            </div>

            <div class="form-row">
            </div>
        </div>
             
        <div class="modal-footer">                
            <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Close</button>
            <button type="button" id="applyFile" class="btn btn-success btn-clean" onclick="applyFile('');">Apply</button>
        </div>         
    </div>
</div>
<style type="text/css" media="screen">
    .modal{
        overflow-y: initial !important;
        outline: none !important;
    }
    .modal-body{
        height: 400px;
        overflow-y: auto;
    }
</style>




