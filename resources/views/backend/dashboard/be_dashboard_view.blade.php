@extends ('backend.masters.be_master_view')

@section ('head.title')
Backend - Dashboard 
@stop

@section ('body.content')
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>                    
            <li class="active"><a href="{!! route('be-admin.show')!!}">Dashboard</a></li>                                        
        </ol>
    </div>
</div>
@stop
