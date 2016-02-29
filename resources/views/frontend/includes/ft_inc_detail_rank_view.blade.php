@if(count($data['rankClubs']) > 0)
<table class="kode-table kode-table-v2">
    <thead>
        <tr>
            <th>TT</th>
            <th style="text-align: left; padding-left:5px">Team</th>
            <th>Matchs</th>
            <th>Wins</th>
            <th>Dashs</th>
            <th>Loses</th>
            <th>+/-</th>
            <th>Scores</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data['rankClubs'] as $k => $r)
        <tr>
            <td>{!! $k+1 !!}</td>
            <td style="text-align: left; padding-left:5px"><img src="{!! $r->club_logo !!}" alt="{!! $r->club_name !!}" width="24px" height="24px"> {!! $r->club_name !!}</td>
            <td>{!! $r->matchs !!}</td>
            <td>{!! $r->wins !!}</td>
            <td>{!! $r->dashs !!}</td>
            <td>{!! $r->loses !!}</td>
            <td>{!! $r->coefficient !!}</td>
            <td>{!! $r->scores !!}</td>
        </tr>
        @endforeach
       
    </tbody>
</table>
@endif