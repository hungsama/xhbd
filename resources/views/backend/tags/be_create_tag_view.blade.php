@extends ('backend.masters.be_master_view')

@section ('head.title')
Backend - Create a tag
@stop

@section ('body.content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>                    
            <li class="active"><a href="{!! route('be-tag.show')!!}">Tags</a></li>                                        
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-sm-offset-2">

        <div class="block">
            @include('backend.notices.errors_view')
            <div class="header">
                <h2>Form create Tag</h2>
            </div>
            <div class="content controls">
                <form class="cmxform form-horizontal" id="signupForm" method="post" action="{!! route('be-save-tag.show') !!}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="form-row">
                        <div class="col-md-3">name</div>
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control" value="{!! Input::old('name') !!}" required/>
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
@stop
