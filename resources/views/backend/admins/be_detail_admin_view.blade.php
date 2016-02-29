@extends ('backend.masters.be_master_view')

@section ('head.title')
Backend - Detail new a member
@stop

@section ('body.content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>                    
            <li class="active"><a href="{!! route('be-admin.show')!!}">Admins</a></li>                                        
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-sm-offset-2">

        <div class="block">
            @include('backend.notices.errors_view')
            @if (Session::has('success'))
               {!! Session::get('success') !!}
            @endif
            @if (Session::has('list_errors'))
                   {!! Session::get('list_errors') !!}
            @endif
            <div class="header">
                <h2>Form detail a member</h2>
            </div>
            <div class="content controls">
                <form class="cmxform form-horizontal" id="signupForm" method="post" action="{!! route('be-update-admin.show', $data['record']->admin_id) !!}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <input name="_method" type="hidden" value="PUT">
                    <div class="form-row">
                        <div class="col-md-3">Admin name</div>
                        <div class="col-md-9">
                            <p class="text-static">{!! $data['record']->admin_name !!}</p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Email</div>
                        <div class="col-md-9">
                            <p class="text-static">{!! $data['record']->email !!}</p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Password</div>
                        <div class="col-md-9">
                            <input type="password" name="password" class="form-control" value=""/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Notes</div>
                        <div class="col-md-9">
                            <input type="text" name="description" class="form-control" value="{!! $data['record']->description !!}"/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Role</div>
                        <div class="col-md-6">
                            <select class="form-control" name="role" onchange="change_role(this.value)">
                                @foreach ($data['roles'] as $r)
                                    <option value="{!! $r !!}" @if($data['record']->role == $r) selected @endif>{!! strtoupper($r) !!}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>
                    <div class="form-row" id="belog_group" style="@if($data['record']->role!='limited') display:none @endif">
                        <div class="col-md-3">Belog to Group</div>
                        <div class="col-md-6">
                            @if($data['groups'])
                                <select class="form-control" name="group_id" onchange="change_group(this.value);">
                                    @foreach($data['groups'] as $gr)
                                    <option value="{!! $gr->group_id !!}" @if($data['record']->group_id == $gr->group_id) selected @endif >{!! $gr->group_name !!}</option>
                                    @endforeach
                                </select>
                            @else
                                <p>No group, please create group is first</p>
                            @endif
                        </div>
                        @if($data['groups'])
                        <div class="col-md-3">
                            <a href="#per-group" id="view_group" onclick="getPermissions({!! $data['record']->group_id !!}, 0);" data-toggle="modal" class="btn icon-eye-open tip" title data-original-title="View permissions"></a>
                        </div>
                        @endif
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 col-sm-offset-5">
                            <button type="reset" class="btn btn-default">Cancel</button>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>                                     
    </div>
</div>
<script src="/backend/my-js/be_admin.js"></script>
<div class="modal" id="per-group" tabindex="-1" role="dialog" aria-hidden="true">
</div>
@stop
