<div class="header-8">
    <div class="container">
        <!--NAVIGATION START-->
        <div class="kode-navigation pull-left">
            <ul>
                <li @if($data['head_activated'] == 'home') class="active" @endif><a href="{!! url() !!}">Trang chủ</a>
                </li>
                @if (count($data['commons']['recordsMenu']) > 0)
                @foreach ($data['commons']['recordsMenu'] as $key => $cm)
                <li @if($data['head_activated'] == $cm->name_alias) class="active" @endif><a href="{!! route('ft-articles-in-category.show', $cm->name_alias) !!}">{!! $cm->name !!}</a>
                    @if (count($cm->catesChild) > 0)
                    <ul class="children">
                        @foreach ($cm->catesChild as $k => $ch)
                        <li><a href="{!! route('ft-articles-in-category.show', $ch->name_alias) !!}">{!! $ch->name !!}</a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
                @endif
            </ul>
        </div>
        <!--NAVIGATION END-->
        <!--LOGO START-->
        <div class="logo">
            <a href="index.html" class="logo">
                <img src="{!! url() !!}/frontend/images/logo.png" alt="">
            </a>
        </div>
        <!--LOGO END-->
        <!--NAVIGATION START-->
        <div class="kode-navigation">
            <ul>
                <li @if($data['head_activated'] == 'truc-tiep') class="active" @endif><a href="{!! route('ft-lives.show','tong-hop') !!}">Trực tiếp</a>
                    <ul class="children">
                        @if (count($data['commons']['videosMenu']) > 0)
                            @foreach ($data['commons']['videosMenu'] as $key => $cm)
                                <li><a href="{!! route('ft-lives.show', $cm->name_alias)!!}">{!! $cm->name !!}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
                <li @if($data['head_activated'] == 'videos') class="active" @endif><a href="{!! route('ft-videos.show','video-tong-hop') !!}">Video</a>
                    <ul class="children">
                        @if (count($data['commons']['videosMenu']) > 0)
                            @foreach ($data['commons']['videosMenu'] as $key => $cm)
                                <li><a href="{!! route('ft-videos.show', $cm->name_alias)!!}">{!! $cm->name !!}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
                <li @if($data['head_activated'] == 'ranks') class="active" @endif><a href="javascript:;">Bảng xếp hạng</a>
                    <ul class="children">
                        @if (count($data['commons']['ranksMenu']) > 0)
                            @foreach ($data['commons']['ranksMenu'] as $key => $cm)
                                <li><a href="{!! route('ft-rank-detail.show', $cm->name_alias)!!}">{!! $cm->name !!}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
        <!--NAVIGATION END-->
        <nav class="navbar navbar-default">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li @if($data['head_activated'] == 'home') class="active" @endif><a href="{!! url() !!}">Home</a>
                    </li>
                    @if (count($data['commons']['recordsMenu']) > 0)
                    @foreach ($data['commons']['recordsMenu'] as $key => $cm)
                    <li @if($data['head_activated'] == $cm->name_alias) class="active" @endif><a href="{!! route('ft-articles-in-category.show', $cm->name_alias) !!}">{!! $cm->name !!}</a>
                        @if (count($cm->catesChild) > 0)
                        <ul class="children">
                            @foreach ($cm->catesChild as $k => $ch)
                            <li><a href="{!! route('ft-articles-in-category.show', $ch->name_alias) !!}">{!! $ch->name !!}</a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
                    @endif
                    <li @if($data['head_activated'] == 'truc-tiep') class="active" @endif><a href="{!! route('ft-lives.show','tong-hop') !!}">Trực tiếp</a>
                    <ul class="children">
                        @if (count($data['commons']['videosMenu']) > 0)
                            @foreach ($data['commons']['videosMenu'] as $key => $cm)
                                <li><a href="{!! route('ft-lives.show', $cm->name_alias)!!}">{!! $cm->name !!}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
                <li @if($data['head_activated'] == 'videos') class="active" @endif><a href="{!! route('ft-videos.show','video-tong-hop') !!}">Video</a>
                    <ul class="children">
                        @if (count($data['commons']['videosMenu']) > 0)
                            @foreach ($data['commons']['videosMenu'] as $key => $cm)
                                <li><a href="{!! route('ft-videos.show', $cm->name_alias)!!}">{!! $cm->name !!}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
                <li @if($data['head_activated'] == 'ranks') class="active" @endif><a href="javascript:;">Bảng xếp hạng</a>
                    <ul class="children">
                        @if (count($data['commons']['ranksMenu']) > 0)
                            @foreach ($data['commons']['ranksMenu'] as $key => $cm)
                                <li><a href="{!! route('ft-rank-detail.show', $cm->name_alias)!!}">{!! $cm->name !!}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->

        </nav>
    </div>
</div>
