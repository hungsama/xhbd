@extends ('backend.masters.be_master_view')

@section ('head.title')
Backend - Detail a category
@stop

@section ('body.content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>                    
            <li class="active"><a href="{!! route('be-category.show')!!}">Cateogry</a></li>                                        
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
                <form class="cmxform form-horizontal" id="signupForm" method="post" action="{!! route('be-update-category.show', $data['record']->id) !!}" enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PUT">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="form-row">
                        <div class="col-md-3">name</div>
                        <div class="col-md-9">
                            <input type="text" name="name" class="form-control" value="{!! $data['record']->name !!}" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Content</div>
                        <div class="col-md-9">
                            <textarea class="form-control" name="description" required>{!! $data['record']->description !!}</textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Image category</div>
                        <div class="col-md-3">
                            <div class="input-group file">                                    
                                <input type="text" class="form-control">
                                <input type="file" name="image">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">Browse</button>
                                </span>
                            </div>                                
                        </div>
                        <div class="col-md-6">
                            @if ($data['record']->image !='')
                            <div class="block block-transparent">
                                <div class="content gallery-list">
                        
                                    <div class="gallery-item" style="margin: 13px;">
                                        <div class="gallery-image">
                                            <a class="fancybox" rel="group" href="{!! $data['record']->image !!}"><img src="{!! $data['record']->image !!}" class="img-thumbnail"></a>
                                        </div>
                                    </div>                        
                                </div>
                            </div>
                            @else
                                No Image
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Is Parent</div>
                        <div class="col-md-9">
                            <div class="radiobox-inline">
                                <label>
                                    @if($data['record']->parent!=0)
                                        No
                                    @else 
                                        Yes
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>
                    @if($data['record']->parent!=0)
                    <div class="form-row" id="cate-parent" @if($data['record']->parent==0) style="display:none" @endif>
                        <div class="col-md-3">Belong to category</div>
                        <div class="col-md-6">
                            @if (count($data['categories_parent']) > 0)
                            <select class="form-control" name="parent" onchange="resetRank(this.value, {!! $data['record']->rank !!});" id="parent">
                                @foreach( $data['categories_parent'] as $cate)
                                    <option value="{!! $cate->id !!}" @if($data['record']->parent == $cate->id) selected @endif>{!! $cate->name !!}</option>
                                @endforeach
                            </select>
                            @else
                                <p class="text text-danger">No parent category, please first create it.</p>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="form-row" id="place-show">
                        <div class="col-md-3">Place</div>
                        <div class="col-md-6">
                            <select class="form-control" name="rank" >
                                    <option value="1">First</option>
                                    @if (count($data['ranks']) > 0)
                                        @foreach( $data['ranks'] as $k=> $cate)
                                        <option value="{!! $cate->rank !!}" @if($data['record']->rank == $cate->rank) selected @endif>{!! ($k+1).'-'.$cate->name !!}</option>
                                        @endforeach
                                        <option value="last">Last</option>
                                    @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Status</div>
                        <div class="col-md-9">
                            <label class="switch">
                                <input type="checkbox" name="status" class="skip" @if($data['record']->status==1) checked @endif value="{!! $data['record']->status !!}">
                                <span></span>
                            </label>
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
<script src="/backend/my-js/be_category.js"></script>
@stop
