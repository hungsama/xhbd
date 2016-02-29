@extends ('backend.masters.be_master_view')

@section ('head.title')
Backend - Create new an advertisement
@stop

@section ('body.content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>                    
            <li class="active"><a href="{!! route('be-advertisement.show')!!}">Advertisers</a></li>                                        
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-sm-offset-2">

        <div class="block">
            @include('backend.notices.errors_view')
            <div class="header">
                <h2>Form create Advertiser</h2>
            </div>
            <div class="content controls">
                <form class="cmxform form-horizontal" id="signupForm" method="post" action="{!! route('be-update-advertiser.show') !!}" enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PUT">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="form-row">
                        <div class="col-md-3">Name</div>
                        <div class="col-md-9">
                            <input type="text" name="name" class="form-control" value="{!! $data['record']->name !!}" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Mobile</div>
                        <div class="col-md-9">
                            <input type="text" name="mobile" class="form-control" value="{!! $data['record']->mobile !!}" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Email</div>
                        <div class="col-md-9">
                            <input type="email" name="email" class="form-control" value="{!! $data['record']->email !!}" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3">Address</div>
                        <div class="col-md-9">
                            <input type="text" name="address" class="form-control" value="{!! $data['record']->address !!}" required/>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-3">Description</div>
                        <div class="col-md-9">
                            <input type="text" name="description" class="form-control" value="{!! $data['record']->description !!}" required/>
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
