@if (count($data['clubs']) > 0)
    <select class="form-control" name="club_id" id="parent">
        @foreach( $data['clubs'] as $cl)
        <option value="{!! $cl->id !!}">{!! $cl->name !!}</option>
        @endforeach
    </select>
@else
<p class="text text-danger">No club, please first create it.</p>
@endif