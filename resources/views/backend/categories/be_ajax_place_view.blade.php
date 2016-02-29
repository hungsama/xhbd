<div class="col-md-3">Place</div>
<div class="col-md-6">
    <select class="form-control" name="rank">
        <option value="first">First</option>
        @if (count($data['categories']) > 0)
        @foreach( $data['categories'] as $k=> $cate)
        <option value="{!! $k+1 !!}" @if($data['rank'] == $cate->rank) selected @endif >{!! ($k+1).'-'.$cate->name !!}</option>
        @endforeach
        <option value="last">Last</option>
        @endif
    </select>
</div>