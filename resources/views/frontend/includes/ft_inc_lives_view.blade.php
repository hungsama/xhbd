
<div class="kode-section-title">
    <h2>Tường thuật trực tiếp</h2> 
</div>
<div class="kode-fixer-list">
    <ul class="table-head thbg-color">
        <li>
            <h5>Upcoming Match</h5>
        </li>
        <li>
            <h5>Date & TIme</h5> 
        </li>
        <li>
            <h5>Venue</h5> 
        </li>
        <li class="fixer-pagination">
            <a href="#" class="fa fa-angle-right"></a>
            <a href="#" class="fa fa-angle-left"></a>
        </li>
    </ul>
    @if ($data['articlesLive'])
    @foreach($data['articlesLive']->items() as $l)
    <ul class="table-body">
        <li>
            <a href="#" class="list-thumb">
                <img src="{!! $l->home_logo !!}" alt="">{!! $l->home_name!!} </a>
            <span>vs</span>
            <a href="#" class="list-thumb">
                <img src="{!! $l->guest_logo !!}" alt="">{!! $l->guest_name!!} </a>
        </li>
        <li><small>{!! date('H:i d/m', $l->live_time) !!}</small>
        </li>
        <li><small>Wembley Stadium</small>
        </li>
        <li class="fixer-btn">
            <a href="{!! route('ft-live-detail.show', array($l->league_alias, $l->home_alias.'-vs-'.$l->guest_alias)) !!}">Xem</a>
            <a href="">Chia sẻ link</a>
        </li>
    </ul>
    @endforeach
    @endif
</div>
