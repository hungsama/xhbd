@include('backend.masters.be_reload_js_view')
<div class="modal-dialog" stype="width: 1231px; height: 300px; padding-top: 15px; padding-bottom: 15px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Create new group</h4>
        </div>
        <div class="content controls">
            <div class="form-row">
                <div class="col-md-2 col-sm-offset-1">
                    Group name
                </div>
                <div class="col-md-6 col-sm-offset-1">
                    <input type="text" name="group_name" id="group_name" class="form-control">
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-2 col-sm-offset-1">
                    Description
                </div>
                <div class="col-md-6 col-sm-offset-1">
                    <input type="text" name="description" id="description" class="form-control">
                </div>
            </div>
            <div class="form-row">
            </div>
        </div>
        
        <div class="modal-body clearfix npr">
            <div class="scroll">
                @if(isset($data['permissions']))
                @foreach($data['permissions'] as $key => $per)
                <div class="col-md-12">
                    <div class="block block-drop-shadow">
                        <div class="header">
                        <h2 style="margin-left:24px;"> <input type="checkbox" class="checkall"/> <span class="text text-warning">{!! $per->group_alias !!}</span></h2></h2>
                        </div>                    
                        <div class="content list-group list-group-icons">
                            @if (count($per->actions) > 0)
                                @foreach($per->actions as $k => $v) 
                                    <span class="list-group-item"><input type="checkbox" name="permission" value="{!! implode('@@',$v->methods) !!}@#{!! $v->alias !!}@#{!! trim($v->url,'/') !!}") />{!! $v->alias !!}<i class="icon-angle-right pull-right"></i></span>
                                @endforeach
                            @endif
                        </div>      
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>     
        <div class="modal-footer">                
            <button type="button" class="btn btn-default btn-clean" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success btn-clean" onclick="saveGroup();">Create Group</button>
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
