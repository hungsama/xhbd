@if ($records->items())
    @foreach($records->items() as $k => $v)
        <a rel="group" href="#" onclick="selectFile('#image_{!! $v->id !!}');"><img class="lib-image" id="image_{!! $v->id !!}" src="{!! $v->url !!}" style="margin:4px;" width="150px" height="115px"></a>
    @endforeach
@endif