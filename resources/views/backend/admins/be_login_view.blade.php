<!DOCTYPE html>
<html lang="en">
<head>        
    <title>Taurus</title>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <link rel="icon" type="image/ico" href="favicon.ico"/>
    
    <link href="{!! url() !!}/backend/css/stylesheets.css" rel="stylesheet" type="text/css" />        
    
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins/jquery/jquery.min.js'></script>
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins/jquery/jquery-ui.min.js'></script>   
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins/jquery/jquery-migrate.min.js'></script>
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins/jquery/globalize.js'></script>    
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins/bootstrap/bootstrap.min.js'></script>
    
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins/uniform/jquery.uniform.min.js'></script>
    
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins.js'></script>    
    <script type='text/javascript' src='{!! url() !!}/backend/js/actions.js'></script>    
    <script type='text/javascript' src='{!! url() !!}/backend/js/settings.js'></script>
    <script type='text/javascript' src="{!! url() !!}/backend/my-js/be_common.js"></script>
</head>
<body class="bg-img-num1"> 
    
    <div class="container">        

        <div class="login-block">
            <div class="block block-transparent">
                <div class="head">
                    <div class="user">
                        <div class="info user-change">                                                                                
                            <img src="/backend/img/example/user/dev-php.jpg" class="img-circle img-thumbnail"/>
                        </div>                            
                    </div>
                </div>
                <div class="content controls npt">
                @if (Session::has('list_errors'))
                   {!! Session::get('list_errors') !!}
                @endif
                @include('backend.notices.errors_view')
                    <form class="cmxform form-horizontal" id="signupForm" method="post" action="{!! route('be-action-login.show') !!}" >
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="icon-user"></span>
                                    </div>
                                    <input type="text" name="username" class="form-control" placeholder="Username"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span class="icon-key"></span>
                                    </div>
                                    <input type="password" name="password" class="form-control" placeholder="Password"/>
                                </div>
                            </div>
                        </div>                        
                        <div class="form-row">
                            <div class="col-md-4 col-sm-offset-4">
                                <button class="btn btn-default btn-block btn-clean" type="submit">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</body>
</html>