<!DOCTYPE html>
<html lang="en">
<head>        
    <title>{!! $data['info']->label !!}</title>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <link rel="icon" type="{!! url() !!}/backend/image/ico" href="favicon.ico"/>
    
    <link href="{!! url() !!}/backend/css/stylesheets.css" rel="stylesheet" type="text/css" />        
    
    <script type='text/javascript' src='{!! url() !!}/public/backend/js/plugins/jquery/jquery.min.js'></script>
    <script type='text/javascript' src='{!! url() !!}/public/backend/js/plugins/jquery/jquery-ui.min.js'></script>   
    <script type='text/javascript' src='{!! url() !!}/public/backend/js/plugins/jquery/jquery-migrate.min.js'></script>
    <script type='text/javascript' src='{!! url() !!}/public/backend/js/plugins/jquery/globalize.js'></script>    
    <script type='text/javascript' src='{!! url() !!}/public/backend/js/plugins/bootstrap/bootstrap.min.js'></script>
    
    <script type='text/javascript' src='{!! url() !!}/public/backend/js/plugins/uniform/jquery.uniform.min.js'></script>
    
    <script type='text/javascript' src='{!! url() !!}/public/backend/js/plugins.js'></script>    
    <script type='text/javascript' src='{!! url() !!}/public/backend/js/actions.js'></script>
    <script type='text/javascript' src='{!! url() !!}/public/backend/js/settings.js'></script>
</head>
<body class="bg-cubs"> 
    
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
                    <button class="btn btn-default btn-clean btn-block" onClick="document.location.href = '{!! url('backend/dashboard') !!}';">Back to dashboard</button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-default btn-clean btn-block" onClick="{!! route('be-login-admin') !!}">Back to login</button>
                </div>
            </div>
        </div>

    </div>

</body>
</html>