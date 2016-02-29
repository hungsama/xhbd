@extends ('backend.masters.be_master_view')

@section ('head.title')
Backend - Create new a member
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
            @if (Session::has('list_errors'))
                   {!! Session::get('list_errors') !!}
            @endif
            @include('backend.notices.errors_view')
            <div class="header">
                <h2>Form create a member</h2>
            </div>
            <div class="content controls">
                <form class="cmxform form-horizontal" id="signupForm" method="post" action="{!! route('be-save-admin.show') !!}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="form-row">
                        <div class="col-md-3">Admin name</div>
                        <div class="col-md-9">
                            <input type="text" name="admin_name" class="form-control" value="{!! Input::old('admin_name') !!}" required/>
                        </div>
                    </div>
                     <div class="form-row">
                        <div class="col-md-3">Password</div>
                        <div class="col-md-9">
                            <input type="password" name="password" class="form-control" value="{!! Input::old('admin_name') !!}" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Email</div>
                        <div class="col-md-9">
                            <input type="email" name="email" class="form-control" value="{!! Input::old('email') !!}" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Notes</div>
                        <div class="col-md-9">
                            <input type="text" name="description" class="form-control" value="{!! Input::old('description') !!}" required/>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-3">Role</div>
                        <div class="col-md-6">
                            <select class="form-control" name="role" onchange="change_role(this.value)">
                                @foreach ($data['roles'] as $r)
                                    <option value="{!! $r !!}">{!! strtoupper($r) !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row" id="belog_group">
                        <div class="col-md-3">Belog to Group</div>
                        <div class="col-md-6">
                            @if($data['groups'])
                                <select class="form-control" name="group_id" onchange="change_group(this.value);">
                                    @foreach($data['groups'] as $gr)
                                    <option value="{!! $gr->group_id !!}">{!! $gr->group_name !!}</option>
                                    @endforeach
                                </select>
                            @else
                                <p class="text-danger">No group, please create group is first.</p>
                            @endif
                        </div>
                        @if($data['groups'])
                        <div class="col-md-3">
                            <a href="#per-group" id="view_group" onclick="getPermissions({!! $data['groups'][0]->group_id !!}, 0);" data-toggle="modal" class="btn icon-eye-open tip" title data-original-title="View permissions"></a>
                        </div>
                        @endif
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">File</div>
                        <div class="col-md-6">
                            <a href="#form-upload" id="view_group" onclick="getFiles('#image_url');" data-toggle="modal" class="btn btn-warning tip" title data-original-title="Upload image">Select File</a>
                        </div>
                    </div>
                    <div class="form-row" id="file-append">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <input type="hidden" name="image_url" id="image_url" value="" class="form-control">
                            <div class="gallery-item">
                                <div class="gallery-image">
                                    <a rel="group" href="#"><img id="image_url_show" src="" width="150" height="115"></a>
                                </div>
                            </div>                        
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 col-sm-offset-5">
                            <button type="reset" class="btn btn-default">Cancel</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>                                     
    </div>
</div>
<script src="/backend/my-js/be_admin.js"></script>
<script src="{!! url() !!}/backend/my-js/be_upload_plugin.js"></script>
<div class="modal" id="per-group" tabindex="-1" role="dialog" aria-hidden="true">
</div>
<div class="modal" id="form-upload" tabindex="-1" role="dialog" aria-hidden="true">
</div>
@stop
