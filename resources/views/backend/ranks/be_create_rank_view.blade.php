@extends ('backend.masters.be_master_view')

@section ('head.title')
Backend - Create new a Club
@stop

@section ('body.content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>                    
            <li class="active"><a href="{!! route('be-clubs.show')!!}">Ranks</a></li>                                        
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-sm-offset-2">

        <div class="block">
            @include('backend.notices.errors_view')
            <div class="header">
                <h2>Form create a rank</h2>
            </div>
            <div class="content controls">
                <form class="cmxform form-horizontal" id="signupForm" method="post" action="{!! route('be-save-rank.show') !!}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="form-row">
                        <div class="col-md-3">Nations</div>
                        <div class="col-md-6">
                            @if (count($data['nations']) > 0)
                            <select class="form-control" name="nation_id" onchange="changeNation(this.value, 'club');" id="parent">
                                @foreach( $data['nations'] as $cate)
                                    <option value="{!! $cate->id !!}">{!! $cate->name !!}</option>
                                @endforeach
                            </select>
                            @else
                                <p class="text text-danger">No League, please first create it.</p>
                            @endif
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-3">Club</div>
                        <div class="col-md-6" id="club">
                            @if (count($data['clubs']) > 0)
                            <select class="form-control" name="club_id" id="parent">
                                @foreach( $data['clubs'] as $cb)
                                    <option value="{!! $cb->id !!}">{!! $cb->name !!}</option>
                                @endforeach
                            </select>
                            @else
                                <p class="text text-danger">No club, please first create it.</p>
                            @endif
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-3">Belog to league</div>
                        <div class="col-md-6">
                            @if (count($data['leagues']) > 0)
                            <select class="form-control" name="league_id" onchange="resetRank(this.value, 0);" id="parent">
                                @foreach( $data['leagues'] as $cate)
                                    <option value="{!! $cate->id !!}">{!! $cate->name !!}</option>
                                @endforeach
                            </select>
                            @else
                                <p class="text text-danger">No League, please first create it.</p>
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
<script src="/backend/my-js/be_rank.js"></script>
@stop
