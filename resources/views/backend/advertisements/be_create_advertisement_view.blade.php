@extends ('backend.masters.be_master_view')

@section ('head.title')
Backend - Create new an advertisement
@stop

@section ('body.content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>                    
            <li class="active"><a href="{!! route('be-advertisement.show')!!}">Advertisement</a></li>                                        
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-sm-offset-2">

        <div class="block">
            @include('backend.notices.errors_view')
            <div class="header">
                <h2>Form create Advertisement</h2>
            </div>
            <div class="content controls">
                <form class="cmxform form-horizontal" id="signupForm" method="post" action="{!! route('be-save-advertisement.show') !!}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="form-row">
                        <div class="col-md-3">Name</div>
                        <div class="col-md-9">
                            <input type="text" name="name" class="form-control" value="{!! Input::old('name') !!}" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Url redirect</div>
                        <div class="col-md-9">
                            <input type="text" name="url_redirect" class="form-control" value="{!! Input::old('url_redirect') !!}" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Url image</div>
                        <div class="col-md-9">
                            <div class="input-group file">                                    
                                <input type="text" class="form-control">
                                <input type="file" name="url_image">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">Browse</button>
                                </span>
                            </div>                                
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Belog to Advertiser</div>
                        <div class="col-md-6">
                            @if ($data['advertisers'])
                            <select class="form-control" name="advertiser_id">
                                @foreach( $data['advertisers'] as $adv)
                                    <option value="{!! $adv->id !!}">{!! $adv->name !!}</option>
                                @endforeach
                            </select>
                            @else
                                <p class="text text-danger">No advertiser, please first create it.</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Position</div>
                        <div class="col-md-6">
                            @if ($data['positions'])
                            <select class="form-control" name="position_id">
                                @foreach( $data['positions'] as $pos)
                                    <option value="{!! $pos->id !!}">{!! $pos->name !!}</option>
                                @endforeach
                            </select>
                            @else
                                <p class="text text-danger">No advertiser, please first create it.</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Mode</div>
                        <div class="col-md-9">
                            <div class="radiobox-inline custom">
                                <label>
                                    <input type="radio" name="mode" value="limited" checked/> Limited
                                </label>
                            </div>
                            <div class="radiobox-inline custom">
                                <label>
                                    <input type="radio" name="mode" value="unlimited"/> Unlimited
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Start Date</div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-calendar-empty"></span></div>
                                <input type="text" class="datepicker form-control" value="" name="time_start"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">End Date</div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-calendar-empty"></span></div>
                                <input type="text" class="datepicker form-control" value="" name="time_end"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Note</div>
                        <div class="col-md-9">
                            <input type="text" name="note" class="form-control" value="{!! Input::old('note') !!}" required/>
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
