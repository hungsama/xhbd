@extends ('backend.masters.be_master_view')

@section ('head.title')
Backend - Create new an article
@stop

@section ('body.content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>                    
            <li class="active"><a href="{!! route('be-article.show')!!}">Articles</a></li>                                        
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-sm-offset-2">

        <div class="block">
            @include('backend.notices.errors_view')
            <div class="header">
                <h2>Form create Article</h2>
            </div>
            <div class="content controls">
                <form class="cmxform form-horizontal" id="signupForm" method="post" action="{!! route('be-save-article.show') !!}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="form-row">
                        <div class="col-md-3">Title</div>
                        <div class="col-md-9">
                            <input type="text" name="title" class="form-control" value="{!! Input::old('title') !!}" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="block block-fill-white">
                                <div class="content np">
                                    <textarea class="txt_content" id="txt_content" name="content" required>
                                        {!! Input::old('content') !!}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Image slide</div>
                        <div class="col-md-9">
                            <div class="input-group file">                                    
                                <input type="text" class="form-control">
                                <input type="file" name="slide_img">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">Browse</button>
                                </span>
                            </div>                                
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Url video</div>
                        <div class="col-md-9">
                            <input type="text" name="url_video" class="form-control" value="{!! Input::old('url_video') !!}"/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Author</div>
                        <div class="col-md-9">
                            <input type="text" name="author" class="form-control" value="{!! Input::old('author') !!}" required/>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-3">Categories</div>
                        <div class="col-md-9">
                            @if ($data['categories'])
                            <div class="row">
                            @foreach ($data['categories'] as $k => $cate)
                            
                                <div class="col-md-6">
                                    <div class="checkbox-inline">
                                        <input type="checkbox" name="categories[]" value="{!! $cate->id !!}" @if (isset(Input::old()['categories']) && in_array($cate->id, Input::old()['categories'])) checked @endif  /> {!! $cate->name !!}
                                    </div>
                                </div>
                                
                            @endforeach
                            @else 
                            You must create new a category.
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Tags</div>
                        <div class="col-md-9">
                            @if ($data['tags'])
                            <div class="row">
                            @foreach ($data['tags'] as $k => $tag)
                            <div class="col-md-6">
                                <div class="checkbox-inline">
                                    <input type="checkbox" name="tags[]" value="{!! $tag->id !!}" @if (isset(Input::old()['tags']) && in_array($tag->id, Input::old()['tags'])) checked @endif  /> {!! substr($tag->name, 0, 20) !!} ...
                                </div>
                            </div>
                            @endforeach
                            @else 
                            You must create new a tag.
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 col-sm-offset-5">
                            <button type="reset" class="btn btn-default">Cancel</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>                                     
    </div>
</div>
<script type="text/javascript"> $(function() {  if(CKEDITOR.instances['txt_content']) { CKEDITOR.remove(CKEDITOR.instances['txt_content']); } CKEDITOR.config.width = 800; CKEDITOR.config.height = 989; CKEDITOR.replace('txt_content',{}); }) </script>
@stop
