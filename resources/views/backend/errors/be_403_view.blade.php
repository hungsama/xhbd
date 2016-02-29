@extends ('backend.masters.be_master_view')

@section ('head.title')
Backend - {!! $data['info']->label !!}
@stop

@section ('body.content')
<div class="container">        

    <div class="block-error">
        <div class="row">
            <div class="col-md-12">
                <div class="error-code">
                    ERROR: {!! $data['id'] !!} {!! $data['info']->label !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">            
                <div class="error-text">{!! $data['info']->content !!}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-default btn-clean btn-block" onClick="document.location.href = 'index.html';">Back to dashboard</button>
            </div>
            <div class="col-md-6">
                <button class="btn btn-default btn-clean btn-block" onClick="history.back();">Back</button>
            </div>
        </div>
    </div>

</div>
@stop