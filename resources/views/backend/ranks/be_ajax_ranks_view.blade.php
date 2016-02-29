@include('backend.masters.be_reload_js_view')
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th><input type="checkbox" class="checkall"/></th>
            <th width="2%">ID</th>
            <th width="2%">Club ID</th>
            <th width="15%">Club Name</th>
            <th width="15%">League Name</th>
            <th width="5%" class="text-center">Total Matchs</th>
            <th width="5%" class="text-center">Coefficient</th>
            <th width="5%" class="text-center">Wins</th>
            <th width="5%" class="text-center">Dashs</th>
            <th width="5%" class="text-center">Loses</th>
            <th width="5%" class="text-center">Score</th>
            <th width="10%" class="text-center">Status</th>                                    
            <th width="20%" class="text-center">Actions</th>                                    
        </tr>
    </thead>
    <tbody id="content">
        @if ($data['records']->items())
        @foreach ($data['records']->items() as $k => $r)
        <tr>
            <td><input type="checkbox" name="checkbox"/></td>
            <td>{!! $r->id !!}</td>
            <td>{!! $r->club_id !!}</td>
            <td>{!! $r->club_name !!}</td>
            <td>{!! $r->league_name !!}</td>
            <td class="text-center">{!! $r->wins + $r->dashs + $r->loses !!}</td>
            <td class="text-center">{!! $r->goals_win - $r->goals_lose !!}</td>
            <td class="text-center">{!! $r->wins !!}</td>
            <td class="text-center">{!! $r->dashs !!}</td>
            <td class="text-center">{!! $r->loses !!}</td>
            <td class="text-center">{!! $r->wins*3 + $r->dashs*1 !!}</td>
            <td class="text-center change-status-{!! $r->id !!}">@if($r->status == 1) <button type="button" class="btn btn-success btn-small" onclick="changeStatus('{!! route('be-change-status-rank.show') !!}', '{!! $r->id !!}', '0');">ON</button> @else <button type="button" class="btn btn-danger btn-small" onclick="changeStatus('{!! route('be-change-status-rank.show') !!}', '{!! $r->id !!}', '1');">OFF</button>@endif</td>
            <td  class="text-center">
                <a href="{!! route('be-detail-rank.show', $r->id) !!}" class="btn icon-eye-open tip" title data-original-title="View detail"></a>
                <form class="cmxform form-horizontal" method="POST" action="{!! route('be-delete-rank.show', $r->id) !!}" style="display:inline">
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