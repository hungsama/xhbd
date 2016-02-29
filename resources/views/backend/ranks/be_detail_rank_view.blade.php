@extends ('backend.masters.be_master_view')

@section ('head.title')
Backend - Detail a ranks
@stop

@section ('body.content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>                    
            <li class="active"><a href="{!! route('be-ranks.show')!!}">Ranks</a></li>                                        
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
                <form class="cmxform form-horizontal" id="signupForm" method="post" action="{!! route('be-update-rank.show', $data['record']->id) !!}" enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PUT">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="form-row">
                        <div class="col-md-3">Belong to league</div>
                        <div class="col-md-9">
                            <p> {!! $data['record']->league_name !!}</p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Club Name</div>
                        <div class="col-md-9">
                            <p> {!! $data['record']->club_name !!}</p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Total Matchs</div>
                        <div class="col-md-9">
                            <p>{!! $data['record']->wins + $data['record']->dashs + $data['record']->loses !!}</p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Coefficient</div>
                        <div class="col-md-9">
                            <p>{!! $data['record']->goals_win - $data['record']->goals_lose !!}</p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Score</div>
                        <div class="col-md-9">
                            <p>{!! $data['record']->wins*3 + $data['record']->dashs !!}</p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Wins</div>
                        <div class="col-md-9">
                            <input type="text" name="wins" class="form-control" value="{!! $data['record']->wins !!}" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Dashs</div>
                        <div class="col-md-9">
                            <input type="text" name="dashs" class="form-control" value="{!! $data['record']->dashs !!}" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Loses</div>
                        <div class="col-md-9">
                            <input type="text" name="loses" class="form-control" value="{!! $data['record']->loses !!}" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Win goals</div>
                        <div class="col-md-9">
                            <input type="text" name="goals_win" class="form-control" value="{!! $data['record']->goals_win !!}" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Lose goals</div>
                        <div class="col-md-9">
                            <input type="text" name="goals_lose" class="form-control" value="{!! $data['record']->goals_lose !!}" required/>
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
<script src="/backend/my-js/be_rank.js"></script>
@stop
