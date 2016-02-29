@if($data['articlesRelatedPlace'] == 'main')
<div class="kode-related-blog">
    <div class="kode-section-title">
        <h2>Tin liên quan</h2> 
    </div>
    @if ($data['articlesRelated'])
    <ul class="row">
        @foreach($data['articlesRelated'] as $k => $r)
        <li class="col-md-4">
            <a href="#" class="related-thumb th-bordercolor">
                <img src="{!! $r->slide_img !!}" alt="{!! $r->slide_img !!}" alt="{!! $r->title !!}">
            </a>
            <div class="related-text">
                <h6><a href="#">{!! $r->title !!}</a></h6>
            </div>
        </li>
        @endforeach
    </ul>
    @endif
</div>
@else
<div class="widget kode-recent-blog">
    <div class="kode-widget-title">
    <h2>Tin mới nhất</h2> 
    </div>
    <ul>
        @if($data['articlesRelated'])
            @foreach ($data['articlesRelated'] as $r)
        <li>
            <figure>
                <a class="kode-recent-thumb" href="#">
                    <img src="{!! $r->slide_img !!}" alt="{!! $r->title !!}" style="width:75x; height:57px; ">
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