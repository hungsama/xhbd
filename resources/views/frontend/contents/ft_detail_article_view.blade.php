@extends ('frontend.commons.ft_master_view')
@section ('head.title')
Trang chủ, tin tức bóng đá, cập nhật liên tục, ngoại hạng anh, laliga, seria, bundesliga
@stop
@section('body.content')
<div class="kode-subheader subheader-height">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Tin mới nhất</h1>
            </div>
            <div class="col-md-6">
                <ul class="kode-breadcrumb">
                    <!-- <li><a href="{!! route('ft-home.show') !!}">Home</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="kode-content">

    <!--// Page Content //-->
    <section class="kode-pagesection">
        <div class="container">
            <div class="row">

                <div class="kode-pagecontent col-md-9">

                    @include('frontend.includes.ft_inc_detail_article_view')
                    @include('frontend.includes.ft_inc_articles_related_view')

                    <!-- <div class="kode-postsection">
                        <h6 class="kode-prev"><a href="#" class="thcolorhover"><i class="fa fa-long-arrow-left"></i> Pervious Post</a></h6>
                        <h6 class="kode-next"><a href="#" class="thcolorhover">Next Post <i class="fa fa-long-arrow-right"></i></a></h6>
                    </div> -->

                    <div class="kode-admin-post">
                        <figure>
                            <a href="#">
                                <img src="{!! url() !!}/frontend/extra-images/admin-1.jpg" alt="">
                            </a>
                        </figure>
                        <div class="admin-info">
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta</p>
                            <h5><a href="#" class="thcolor">Jonathan Smith</a> <span class="thcolor">Auther</span></h5>
                        </div>
                    </div>

                    @include('frontend.includes.ft_inc_comment_view')

                </div>

                <aside class="kode-pagesidebar col-md-3">
                    @include('frontend.includes.ft_inc_facebook_interface_view')
                    @include('frontend.includes.ft_inc_articles_hot_view')
                </aside>

            </div>
        </div>
    </section>
    <!--// Page Content //-->

</div>
<!--// Main Content //-->
@stop