@if($data['articlesIncCatePlace'] == 'main')
<div class="kode-blog-list kode-grid-blog">
    @if ($data['articlesIncCate'])
    <ul class="row">
        @foreach($data['articlesIncCate'] as $k => $r)
        <!-- {!! var_dump($r) !!} -->
        <li class="col-md-6">
            <div class="kode-time-zoon">
                <time datetime="{!! date('d-m-y i:s') !!}">{!! date('d', $r->created_at) !!}<span>{!! date('M', $r->created_at) !!}</span></time>
                <h5><a href="{!! route('ft-detail.show', array('cate' => $r->category_alias, 'article' => $r->id.'-'.$r->title_alias))!!}">{!! $r->title !!}</a></h5>
            </div>
            <figure>
                <a href="#">
                    <img src="{!! $r->slide_img !!}" alt="{!! $r->slide_img !!}" style="width:357x; height:177px; ">
                </a>
            </figure>
            <div class="kode-blog-info">
                <ul class="kode-team-network">
                    <li class="fb-like" data-href="{!! route('ft-detail.show', array('cate' => $r->category_alias, 'article' => $r->id.'-'.$r->title_alias))!!}" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></li>
                </ul>
            </div>
        </li>
        @if($k%2==1) <li class="clearfix"></li> @endif
        @endforeach
    </ul>

    <!--// Pagination //-->
    <div class="pagination">
        {!! $data['articlesIncCate']->render() !!}
    </div>
    <!--// Pagination //-->
    @endif
</div>
@else
<div class="widget kode-recent-blog">
    <div class="kode-widget-title">
    <h2>Tin mới nhất</h2> 
    </div>
    <ul>
        @if($data['articlesIncCate'])
            @foreach ($data['articlesIncCatePlace'] as $r)
        <li>
            <figure>
                <a class="kode-recent-thumb" href="#">
                    <img src="{!! $r->slide_img !!}" alt="{!! $r->title !!}" style="width:75x; height:57px;">
                </a>
                <figcaption>
                    <h6><a href="{!! route('ft-detail.show', array('cate' => $r->category_alias, 'article' => $r->id.'-'.$r->title_alias))!!}">{!! $r->title !!}</a></h6>
                    <ul>
                        <li>{!! date('d/m/y', $r->created_at) !!}</li>
                        <li>by <a href="#">John</a>
                        </li>
                    </ul>
                </figcaption>
            </figure>
        </li>
        @endforeach
        @endif
    </ul>
</div>
@endif