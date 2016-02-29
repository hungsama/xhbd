@extends ('backend.masters.be_master_view')

@section ('head.title')
Backend - Detail a lives
@stop

@section ('body.content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>                    
            <li class="active"><a href="{!! route('be-lives.show')!!}">Clubs</a></li>                                        
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-sm-offset-2">

        <div class="block">
            @include('backend.notices.errors_view')
            @if (Session::has('success'))
               {!! Session::get('success') !!}
            @endif
            <div class="header">
                <h2>Form detail Cateogry</h2>
            </div>
            <div class="content controls">
                <form class="cmxform form-horizontal" id="signupForm" method="post" action="{!! route('be-update-live.show', $data['record']->id) !!}" enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PUT">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="form-row">
                        <div class="col-md-3">Name</div>
                        <div class="col-md-9">
                            <input type="text" name="name" class="form-control" value="{!! $data['record']->name !!}" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Description</div>
                        <div class="col-md-9">
                            <input type="text" name="description" class="form-control" value="{!! $data['record']->description !!}" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Logo</div>
                        <div class="col-md-3">
                            <div class="input-group file">                                    
                                <input type="text" class="form-control">
                                <input type="file" name="logo">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">Browse</button>
                                </span>
                            </div>                                
                        </div>
                        <div class="col-md-6">
                            @if ($data['record']->logo !='')
                            <div class="block block-transparent">
                                <div class="content gallery-list">
                        
                                    <div class="gallery-item" style="margin: 13px;">
                                        <div class="gallery-image">
                                            <a class="fancybox" rel="group" href="{!! $data['record']->logo !!}"><img src="{!! $data['record']->logo !!}" class="img-thumbnail"></a>
                                        </div>
                                    </div>                        
                                </div>
                            </div>
                            @else
                                No Image
                            @endif
                        </div>
                    </div>

                    <div class="form-row" id="cate-parent">
                        <div class="col-md-3">Belog to category</div>
                        <div class="col-md-6">
                            @if (count($data['categories']) > 0)
                            <select class="form-control" name="cate_id" onchange="resetRank(this.value,0);" id="parent">
                                @foreach( $data['categories'] as $cate)
                                    <option value="{!! $cate->id !!}" @if($data['record']->cate == $cate->id) selected @endif>{!! $cate->name !!}</option>
                                @endforeach
                            </select>
                            @else
                                <p class="text text-danger">No parent category, please first create it.</p>
                            @endif
                        </div>
                    </div>

                    <div class="form-row" id="place-show">
                        <div class="col-md-3">Place</div>
                        <div class="col-md-6">
                            <select class="form-control" name="rank">
                                    <option value="first">First</option>
                                    @if (count($data['lives']) > 0)
                                        @foreach( $data['lives'] as $k=> $cb)
                                        <option value="{!! $k+1 !!}" @if($data['record']->rank == $cb->rank) selected @endif>{!! ($k+1).'-'.$cb->home_name.'-vs-'.$cb->guest_name !!}</option>
                                        @endforeach
                                        <option value="last">Last</option>
                                    @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 col-sm-offset-5">
                            <button type="reset" class="btn btn-default">Cancel</button>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>                                     
    </div>
</div>
<script src="/backend/my-js/be_live.js"></script>
@stop
