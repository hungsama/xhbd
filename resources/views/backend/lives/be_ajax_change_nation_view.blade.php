@if (count($data['clubs']) > 0)
    @if($data['club_type'] == 'home-club')
    <select class="form-control" name="home_id" id="parent">
        @foreach( $data['clubs'] as $cate)
        <option value="{!! $cate->id !!}">{!! $cate->name !!}</option>
        @endforeach
    </select>
    @else
    <select class="form-control" name="guest_id" id="parent">
        @foreach( $data['clubs'] as $cate)
        <option value="{!! $cate->id !!}">{!! $cate->name !!}</option>
        @endforeach
    </select>
    @endif
@else
<p class="text text-danger">No parent category, please first create it.</p>
@endif