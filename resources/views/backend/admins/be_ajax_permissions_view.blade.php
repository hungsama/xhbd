@include('backend.masters.be_reload_js_view')
@if($data['role']=='limited')
<div class="modal-dialog" stype="width: 1231px; height: 300px; padding-top: 15px; padding-bottom: 15px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Group @if(isset($data['group_name'])) {!! $data['group_name'] !!} @endif</h4>
        </div>
        <div class="content controls">
            <div class="form-row">
                @if($data['admin_selected'] != 0)
                <div class="col-md-2 col-sm-offset-1">
                    Select Group
                </div>
                <div class="col-md-6 col-sm-offset-1">
                    @if(count($data['all_groups']) > 0)
                    <select class="form-control" onchange="getPermissions(this.value, {!! $data['admin_selected'] !!});">
                        @foreach($data['all_groups'] as $k => $gr)
                        <option value='{!! $gr->group_id !!}' @if($data['group_id'] == $gr->group_id) selected @endif >{!! $gr->group_name !!}</option>
                        @endforeach
                    </select>
                    @else
                        No Permissions
                    @endif
                </div>
                @endif
            </div>
            <div class="form-row">
                <div class="col-md-2 col-sm-offset-1">
                    Group name
                </div>
                <div class="col-md-6 col-sm-offset-1">
                    <input type="text" name="group_name" id="group_name" value="{!! $data['group_name'] !!}" class="form-control">
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-2 col-sm-offset-1">
                    Description
                </div>
                <div class="col-md-6 col-sm-offset-1">
                    <input type="text" name="description" value="{!! $data['group_desc'] !!}" id="description" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-2 col-sm-offset-1">Status</div>
                <div class="col-md-6 col-sm-offset-1">
                    <div class="radiobox-inline custom">
                        <label style="margin-right: 35px;">
                            <input type="radio" name="status" value="1" @if($data['group_status']!=0) checked @endif /> ON
                        </label>
                        <label>
                            <input type="radio" name="status" value="0" @if($data['group_status']==0) checked @endif /> OFF
                        </label>
                    </div>
                    
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
                                    @foreach($v->methods as $m) 
                                        @if(in_array($m.'@'.trim($v->url, '/'), $data['pers_selected']))
                                            <?php $checked = true;?>
                                        @endif
                                    @endforeach
                                    <span class="list-group-item"><input type="checkbox" name="permission" value="{!! implode('@@',$v->methods) !!}@#{!! $v->alias !!}@#{!! trim($v->url, '/') !!}") @if(isset($checked)) checked @endif/> {!! $v->alias !!}<i class="icon-angle-right pull-right"></i></span>
                                    <?php if(isset($checked)) unset($checked);?>
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
            <button type="button" class="btn btn-success btn-clean" onclick="updatePermissionGroup({!! $data['group_id'] !!}, {!! $data['admin_selected'] !!});">Update Permissions</button>
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
@else
<div class="modal-dialog">
    <div class="modal-content">                
        <div class="modal-body clearfix">
            You are full permission {!! $data['role'] !!}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning btn-clean" data-dismiss="modal">Ok</button>              
        </div>
    </div>
</div>
@endif


