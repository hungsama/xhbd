@extends ('backend.masters.be_master_view')

@section ('head.title')
Backend - Quản lý admin
@stop

@section ('body.content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>                    
            <li class="active"><a href="#">Admins</a></li>                                        
        </ol>
    </div>
</div>        

@include('backend.admins.be_form_search_admin_view')

<div class="row">

    <div class="col-md-12">

        <div class="block">
            <div class="header">
                <h2>Result data</h2>  
                <div class="side pull-right">                            
                    <ul class="buttons">                                
                        <li><a href="{!! route('be-create-admin.show')!!}"><span class=" btn btn-success icon-plus tip" title data-original-title="Create a new admin"> Create</span></a></li>
                    </ul>
                </div>                                      
            </div>
            <div class="content" id="content">
                @if (Session::has('success'))
                   {!! Session::get('success') !!}
                @endif
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="checkall"/></th>
                            <th width="5%">ID</th>
                            <th width="35%">Name</th>
                            <th width="25%">Role</th>
                            <th width="20%" class="text-center">Permissions</th>
                            <th width="5%" class="text-center">Status</th>
                            <th width="10%" class="text-center">Actions</th>                                    
                        </tr>
                    </thead>
                    <tbody id="content">
                        @if ($data['records']->items())
                        @foreach ($data['records']->items() as $k => $r)
                        <tr>
                            <td><input type="checkbox" name="checkbox"/></td>
                            <td>{!! $r->admin_id !!}</td>
                            <td>{!! $r->admin_name !!}</td>
                            <td>{!! strtoupper($r->role) !!}</td>
                            <td class="text-center"><a href="#per-group" onclick="getPermissions({!! $r->group_id !!}, {!! $r->admin_id !!})" data-toggle="modal" class="btn icon-eye-open tip" title data-original-title="View permissions this account"></a></td>
                            <td class="text-center">@if($r->status == 1) <button type="button" class="btn btn-success btn-small">ON</button> @else <button type="button" class="btn btn-danger btn-small">OFF</button>@endif</td>
                            <td  class="text-center">
                                <a href="{!! route('be-detail-admin.show', $r->admin_id) !!}" class="btn icon-pencil tip" title data-original-title="View detail & edit account"></a>
                                <form class="cmxform form-horizontal" method="POST" action="{!! route('be-delete-admin.show', $r->admin_id) !!}" style="display:inline" id="deleteAdmin_{!! $r->admin_id !!}">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                    <button class="btn icon-trash tip" title data-original-title="Remove" type="button" onclick="deleteRecord('#deleteAdmin_{!! $r->admin_id !!}','Are you sure delete this admin?');"></button>
                                </form>
                            </td>
                        </tr>  
                        @endforeach
                        @else
                        <tr class="odd"><td valign="top" colspan="7" class="text-center text-danger">No matching records found</td></tr>
                        @endif                           
                    </tbody>
                </table>
                <div class="dataTables_paginate paging_full_numbers" id="DataTables_Table_1_paginate">
                    @if ($data['records'])
                    {!! $data['records']->render() !!}
                    @endif
                </div>
            </div>
        </div>
        
    </div>
    <a href="{!! route('be-ajaxsearch-admin.show') !!}" title="" id="search-paginate"></a>
    <script src="/backend/my-js/be_admin.js"></script>
</div>

<div class="modal" id="per-group" tabindex="-1" role="dialog" aria-hidden="true">
</div>
@stop