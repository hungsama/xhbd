@section ('fb-url')
    {!! route('ft-live-detail.show', array($data['record']->league_alias, $data['record']->home_alias.'-vs-'.$data['record']->guest_alias)) !!}
@stop
@section ('fb-type')
    Trực tiếp bóng đá
@stop
@section ('fb-title')
    {!! $data['record']->league_name !!}: {!! $data['record']->home_name !!} - {!! $data['record']->guest_name !!}
@stop
@section ('fb-desc')
    {!! $data['record']->league_name !!}: {!! $data['record']->home_name !!} - {!! $data['record']->guest_name !!}
@stop
@section ('fb-img')
    {!! $data['record']->home_logo !!}
@stop
<div class="kode-blog-list kode-fullwidth-blog">
    <ul class="row">
        <li class="col-md-12">
            <div class="kode-time-zoon">
                <time datetime="{!! date('d-m-y i:s') !!}">{!! date('d', $r->created_at) !!}<span>{!! date('M', $r->created_at) !!}</span></time>
                <h5><a href="#">{!! $data['record']->league_name !!}: {!! $data['record']->home_name !!} - {!! $data['record']->guest_name !!}</a></h5>
            </div>
            <div class="kode-blog-info">
                <ul class="kode-blog-options">
                    <li class="fb-like" data-href="{!! route('ft-live-detail.show', array($data['record']->league_alias, $data['record']->home_alias.'-vs-'.$data['record']->guest_alias)) !!}" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></li>
                </ul>
            </div>
        </li>

    </ul>
</div>
<div class="kode-editor">
    <p>{!! $data['record']->description !!}</p>
</div>