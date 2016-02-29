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
            @if (Session::has('success'))
               {!! Session::get('success') !!}
            @endif
            <div class="header">
                <h2>Form detail position</h2>
            </div>
            <div class="content controls">
                <form class="cmxform form-horizontal" id="signupForm" method="post" action="{!! route('be-update-position.show', $data['record']->id) !!}" enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PUT">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="form-row">
                        <div class="col-md-3">Name</div>
                        <div class="col-md-9">
                            <input type="text" name="name" class="form-control" value="{!! $data['record']->name !!}" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Notes</div>
                        <div class="col-md-9">
                            <textarea class="form-control" name="notes" required>{!! $data['record']->notes !!}</textarea>
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
                        <div class="col-md-6">
                            @if($data['record']->image_default)
                            <div class="block block-transparent">
                                <div class="content gallery-list">
                        
                                    <div class="gallery-item" style="margin: 13px;">
                                        <div class="gallery-image">
                                            <a class="fancybox" rel="group" href="{!! $data['record']->image_default !!}"><img src="{!! $data['record']->image_default !!}" class="img-thumbnail"></a>
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
                        <div class="col-md-3">Limit Ads</div>
                        <div class="col-md-1">
                            <select class="form-control" name="limit_ads">
                                @for($i=1;$i<=5;$i++)
                                    <option value="{!! $i !!}" @if($i==$data['record']->limit_ads) selected @endif>{!! $i !!}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Place</div>
                        <div class="col-md-2">
                            <select class="form-control"  name="place">
                                    <option value="header" @if(strpos($data['record']->place, 'eader')) selected @endif>Header</option>
                                    <option value="left" @if(strpos($data['record']->place, 'eft')) selected @endif>Left</option>
                                    <option value="right" @if(strpos($data['record']->place, 'ight')) selected @endif>Right</option>
                                    <option value="footer" @if(strpos($data['record']->place, 'ooter')) selected @endif>Footer</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <select class="form-control" name="place_sub">
                                @for($i=1;$i<=4;$i++)
                                <option value="{!! $i !!}" @if(strpos($data['record']->place, $i)) selected @endif>{!! $i !!}</option>
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
                                            <input type="radio" name="type" value="normal" @if('normal'==$data['record']->type) checked @endif/> Normal
                                        </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label>
                                            <input type="radio" name="type" value="popup" @if('popup'==$data['record']->type) checked @endif/> Popup
                                        </label>
                                    </div>
                                </div>
                                
                            </div>
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
@stop
