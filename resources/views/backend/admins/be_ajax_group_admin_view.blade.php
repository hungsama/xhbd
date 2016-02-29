@include('backend.masters.be_reload_js_view')
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th><input type="checkbox" class="checkall"/></th>
            <th width="5%">ID</th>
            <th width="35%">Name</th>
            <th width="25%">Name alias</th>
            <th width="20%" class="text-center">Permissions</th>
            <th width="5%" class="text-center">Status</th>
            <th width="10%" class="text-center">Actions</th>                       
        </tr>
    </thead>
    <tbody id="content">
        @if ($records->items())
        @foreach ($records->items() as $k => $r)
        <tr>
            <td><input type="checkbox" name="checkbox"/></td>
            <td>{!! $r->group_id !!}</td>
            <td>{!! $r->group_name !!}</td>
            <td>{!! $r->group_alias !!}</td>
            <td class="text-center"><a href="#per-group" onclick="getPermissions({!! $r->group_id !!}, 0);" data-toggle="modal" class="btn icon-eye-open tip" title data-original-title="View permissions this group"></a></td>
            <td class="text-center">@if($r->status == 1) <button type="button" class="btn btn-success btn-small">ON</button> @else <button type="button" class="btn btn-danger btn-small">OFF</button>@endif</td>
            <td  class="text-center">
                <form class="cmxform form-horizontal" id="deleteGroup_{!! $r->group_id !!}" method="POST" action="{!! route('be-delete-admin-group.show', $r->group_id) !!}" style="display:inline" >
                    <input name="_method" type="hidden" value="DELETE">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <a class="btn icon-trash tip" title data-original-title="Remove" type="button" onclick="deleteRecord('#deleteGroup_{!! $r->group_id !!}','Are you sure delete this group?');"></a>
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
    @if ($records)
    {!! $records->render() !!}
    @endif
</div>