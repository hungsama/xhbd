@include('backend.masters.be_reload_js_view')
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th><input type="checkbox" class="checkall"/></th>
            <th width="5%">ID</th>
            <th width="35%">Title</th>
            <th width="5%" class="text-center">Status</th>
            <th width="25%">Create time</th>
            <th width="20%">Author</th>                                    
            <th width="10%" class="text-center">Actions</th>                                    
        </tr>
    </thead>
    <tbody id="content">
        @if ($records->items())
        @foreach ($records->items() as $k => $r)
        <tr>
            <td><input type="checkbox" name="checkbox"/></td>
            <td>{!! $r->id !!}</td>
            <td>{!! $r->title !!}</td>
            <td class="text-center">{!! $r->status !!}</td>
            <td>{!! date('d/m/Y', $r->created_at) !!}</td>
            <td>{!! $r->author !!}</td>
            <td class="text-center">
                <a href="{!! route('be-detail-article.show', $r->id) !!}" class="btn icon-eye-open tip" title data-original-title="View detail"></a>
                <form class="cmxform form-horizontal" method="POST" action="{!! route('be-delete-article.show', $r->id) !!}" style="display:inline">
                    <input name="_method" type="hidden" value="DELETE">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <button class="btn icon-trash tip" title data-original-title="Remove" type="submit"></button>
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