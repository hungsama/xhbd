@section ('fb-url')
    {!! route('ft-detail.show', array('cate' => $data['record']->category_alias, 'article' => $data['record']->id.'-'.$data['record']->title_alias))!!}
@stop
@section ('fb-type')
    website
@stop
@section ('fb-title')
    {!! $data['record']->title !!}
@stop
@section ('fb-desc')
    {!! $data['record']->title !!}
@stop
@section ('fb-img')
    {!! $data['record']->slide_img !!}
@stop

<div class="kode-blog-list kode-fullwidth-blog">
    <ul class="row">
        <li class="col-md-12">
            <div class="kode-time-zoon">
                <time datetime="{!! date('d-m-y i:s') !!}">{!! date('d', $r->created_at) !!}<span>{!! date('M', $r->created_at) !!}</span></time>
                <h5><a href="#">{!! $data['record']->title !!}</a></h5>
            </div>
            <!-- <figure>
                <a href="#">
                    <img src="{!! $data['record']->slide_img !!}" alt="{!! $data['record']->title !!}" style="width:870px; height:259px">
                </a>
            </figure> -->
            <div class="kode-blog-info">
                <ul class="kode-blog-options">
                    <li class="fb-like" data-href="{!! route('ft-detail.show', array('cate' => $data['record']->category_alias, 'article' => $data['record']->id.'-'.$data['record']->title_alias))!!}" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></li>
                </ul>
            </div>
        </li>

    </ul>
</div>
<div class="kode-editor">
    <p>{!! $data['record']->content !!}</p>
    <p class="clearfix"><strong>Tác giả</strong> : {!! $data['record']->author !!}</p> 
</div>