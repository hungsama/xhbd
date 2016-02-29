@extends ('backend.masters.be_master_view')

@section ('head.title')
Backend - Create new a Live
@stop

@section ('body.content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>                    
            <li class="active"><a href="{!! route('be-lives.show')!!}">Lives</a></li>                                        
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-sm-offset-2">

        <div class="block">
            @include('backend.notices.errors_view')
            <div class="header">
                <h2>Form create a live</h2>
            </div>
            <div class="content controls">
                <form class="cmxform form-horizontal" id="signupForm" method="post" action="{!! route('be-save-live.show') !!}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="form-row" id="cate-parent">
                        <div class="col-md-3">Home National</div>
                        <div class="col-md-6">
                            @if (count($data['nations']) > 0)
                            <select class="form-control" name="cate_id" onchange="changeNation(this.value, 'home-club');" id="parent">
                                @foreach( $data['nations'] as $cate)
                                    <option value="{!! $cate->id !!}">{!! $cate->name !!}</option>
                                @endforeach
                            </select>
                            @else
                                <p class="text text-danger">No parent nations, please first create it.</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-row" id="cate-parent">
                        <div class="col-md-3">Home Club</div>
                        <div class="col-md-6" id="home-club">
                            @if (count($data['clubs']) > 0)
                            <select class="form-control" name="home_id" onchange="resetRank(this.value, 0);" id="parent">
                                @foreach( $data['clubs'] as $cate)
                                    <option value="{!! $cate->id !!}">{!! $cate->name !!}</option>
                                @endforeach
                            </select>
                            @else
                                <p class="text text-danger">No parent category, please first create it.</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-row" id="cate-parent">
                        <div class="col-md-3">Guest National</div>
                        <div class="col-md-6">
                            @if (count($data['nations']) > 0)
                            <select class="form-control" name="cate_id" onchange="changeNation(this.value, 'guest-club');" id="parent">
                                @foreach( $data['nations'] as $cate)
                                    <option value="{!! $cate->id !!}">{!! $cate->name !!}</option>
                                @endforeach
                            </select>
                            @else
                                <p class="text text-danger">No club, please first create it.</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-row" id="cate-parent">
                        <div class="col-md-3">Guest Club</div>
                        <div class="col-md-6" id="guest-club">
                            @if (count($data['clubs']) > 0)
                            <select class="form-control" name="guest_id" onchange="resetRank(this.value, 0);" id="parent">
                                @foreach( $data['clubs'] as $cate)
                                    <option value="{!! $cate->id !!}">{!! $cate->name !!}</option>
                                @endforeach
                            </select>
                            @else
                                <p class="text text-danger">No parent nations, please first create it.</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Date and time:</div>
                        <div class="col-md-6">                                                    
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-globe"></span></div>
                                <input type="text" class="datetimepicker form-control" name="live_time" value=""/>
                            </div>                                                                              
                        </div>
                    </div>

                    <div class="form-row" id="cate-parent">
                        <div class="col-md-3">Belong to leagues</div>
                        <div class="col-md-6">
                            @if (count($data['leagues']) > 0)
                            <select class="form-control" name="league_id" onchange="resetRank(this.value, 0);" id="parent">
                                @foreach( $data['leagues'] as $cate)
                                    <option value="{!! $cate->id !!}">{!! $cate->name !!}</option>
                                @endforeach
                            </select>
                            @else
                                <p class="text text-danger">No Club, please first create it.</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-3">Description</div>
                        <div class="col-md-6">
                            <input type="text" name="description" class="form-control" value="{!! Input::old('description') !!}" required/>
                        </div>
                    </div>

                    <div class="form-row" id="place-show">
                        <div class="col-md-3">Place</div>
                        <div class="col-md-6">
                            <select class="form-control" name="rank">
                                    <option value="first">First</option>
                                    @if (count($data['lives']) > 0)
                                        @foreach( $data['lives'] as $k => $cb)
                                        <option value="{!! $k+1 !!}">{!! ($k+1).'-'.$cb->home_alias.'-vs-'.$cb->guest_name !!}</option>
                                        @endforeach
                                        <option value="last">Last</option>
                                    @endif
                            </select>
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
<script src="/backend/my-js/be_live.js"></script>
@stop
