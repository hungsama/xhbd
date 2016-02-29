<div class="col-md-3">Place</div>
<div class="col-md-6">
    <select class="form-control" name="rank">
        <option value="first">First</option>
        @if (count($data['clubs']) > 0)
        @foreach( $data['clubs'] as $k=> $cb)
        <option value="{!! $k+1 !!}" @if($data['rank'] == $cb->rank) selected @endif >{!! ($k+1).'-'.$cb->name !!}</option>
        @endforeach
        <option value="last">Last</option>
        @endif
    </select>
</div>