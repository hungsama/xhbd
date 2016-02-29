@extends ('backend.masters.be_master_view')

@section ('head.title')
Backend - Create new an position
@stop

@section ('body.content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>                    
            <li class="active"><a href="{!! route('be-position.show')!!}">Positions</a></li>                                        
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-sm-offset-2">

        <div class="block">
            @include('backend.notices.errors_view')
            <div class="header">
                <h2>Form create position</h2>
            </div>
            <div class="content controls">
                <form class="cmxform form-horizontal" id="signupForm" method="post" action="{!! route('be-save-position.show') !!}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="form-row">
                        <div class="col-md-3">Name</div>
                        <div class="col-md-9">
                            <input type="text" name="name" class="form-control" value="{!! Input::old('name') !!}" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Notes</div>
                        <div class="col-md-9">
                            <textarea class="form-control" name="notes" required>{!! Input::old('notes') !!}</textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Image</div>
                        <div class="col-md-3">
                            <div class="input-group file">                                    
                                <input type="text" class="form-control">
                                <input type="file" name="image_default">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">Browse</button>
                                </span>
                            </div>                                
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Limit Ads</div>
                        <div class="col-md-1">
                            <select class="form-control" name="limit_ads">
                                @for($i=1;$i<=5;$i++)
                                    <option value="{!! $i !!}">{!! $i !!}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Place</div>
                        <div class="col-md-2">
                            <select class="form-control"  name="place">
                                    <option value="header">Header</option>
                                    <option value="left">Left</option>
                                    <option value="right">Right</option>
                                    <option value="footer">Footer</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <select class="form-control" name="place_sub">
                                @for($i=1;$i<=4;$i++)
                                <option value="{!! $i !!}">{!! $i !!}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Type</div>
                        <div class="col-md-9">
                            <div class="radiobox-inline" style="margin-left: 10px">
                                <div class="form-row">
                                    <div class="col-md-2">
                                        <label>
                                            <input type="radio" name="type" value="normal" checked="checked" /> Normal
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label>
                                            <input type="radio" name="type" value="popup"/> Popup
                                        </label>
                                    </div>
                                </div>
                                
                            </div>
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
