@if($data['videosPlace'] == 'main')
<div class="kode-blog-list kode-grid-blog">
    @if ($data['videos'])
    <ul class="row">
        @foreach($data['videos'] as $k => $r)
        <!-- {!! var_dump($r) !!} -->
        <li class="col-md-6">
            <div class="kode-time-zoon">
                <time datetime="{!! date('d-m-y i:s') !!}">{!! date('d', $r->created_at) !!}<span>{!! date('M', $r->created_at) !!}</span></time>
                <h5><a href="{!! route('ft-detail.show', array('cate' => $r->category_alias, 'article' => $r->id.'-'.$r->title_alias))!!}">{!! $r->title !!}</a></h5>
            </div>
            <figure>
                <a href="#">
                    <!-- <img src="{!! $r->slide_img !!}" alt="{!! $r->slide_img !!}" style="width:357x; height:177px; "> -->
                    @if($r->url_video != '')
                    <iframe width="560" height="315" style="height:100px !importaint" src="{!! $r->url_video !!}" frameborder="0" allowfullscreen></iframe>
                    @else
                    <?php
                    $regex = '/https?\:\/\/www.youtube.com\/[^\" ]+/i';
                    preg_match($regex, $r->content, $matches);
                    if(isset($matches[0])) $url_video = $matches[0];
                    ?>
                    @if(isset($url_video))
                    <iframe width="560" height="315" style="height:100px !importaint" src="{!! $url_video !!}" frameborder="0" allowfullscreen></iframe>
                    @else
                    <a href="{!! route('ft-detail.show', array('cate' => $r->category_alias, 'article' => $r->id.'-'.$r->title_alias))!!}"><img src="{!! $r->slide_img !!}" style="height:245px !important"/></a>
                    @endif
                    @endif
                </a>
            </figure>
            <div class="kode-blog-info">
                <ul class="kode-blog-options">
                    <!-- <li><a href="#"><i class="fa fa-user"></i> Jozaf</a>
                    </li>
                    <li><a href="#"><i class="fa fa-comment"></i> 3 Comments</a>
                    </li>
                    <li><a href="#"><i class="fa fa-share-alt"></i> 12 Share</a>
                    </li> -->
                    <li class="fb-like" data-href="{!! route('ft-detail.show', array('cate' => $r->category_alias, 'article' => $r->id.'-'.$r->title_alias))!!}" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></li>
                </ul>
                <p>{!! substr($r->content, 0, 120) !!} ...</p>
                <a href="{!! route('ft-detail.show', array('cate' => $r->category_alias, 'article' => $r->id.'-'.$r->title_alias))!!}" class="kode-modrenbtn thbg-colorhover">Read More</a>
                <div class="clearfix"></div>
                <ul class="kode-team-network">
                    <li>
                        <a class="fa fa-facebook" href="#"></a>
                    </li>
                    <li>
                        <a class="fa fa-twitter" href="#"></a>
                    </li>
                    <li>
                        <a class="fa fa-linkedin" href="#"></a>
                    </li>
                </ul>
            </div>
        </li>
        @if($k%2==1) <li class="clearfix"></li> @endif
        @endforeach
    </ul>

    <!--// Pagination //-->
    <div class="pagination">
        {!! $data['videos']->render() !!}
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
        @if($data['videos'])
            @foreach ($data['videos'] as $r)
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