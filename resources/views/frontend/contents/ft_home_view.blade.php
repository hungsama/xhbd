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

<!--// Main Content //-->
<div class="kode-content">

    <!--// Page Content //-->
    <section class="kode-pagesection">
        <div class="container">
            <div class="row">

                <div class="kode-pagecontent col-md-9">
                    @include('frontend.includes.ft_inc_articles_new_view')
                </div>

                <aside class="kode-pagesidebar col-md-3">
                    @include('frontend.includes.ft_inc_facebook_interface_view')
                    @include('frontend.includes.ft_inc_articles_hot_view')
                </aside>

            </div>

            <div class="row">
                <div class="col-md-12">
                    @include('frontend.includes.ft_inc_lives_view')
                </div>
            </div>
        </div>
    </section>
    <!--// Page Content //-->

</div>
<!--// Main Content //-->
@stop