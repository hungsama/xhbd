<!DOCTYPE html>
<html lang="en">
<head>        
    <title>@yield('head.title')</title>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <link rel="icon" type="image/ico" href="{!! url() !!}/backend/img/favicon.ico"/>
    
    <link href="{!! url() !!}/backend/css/stylesheets.css" rel="stylesheet" type="text/css" />   
    <link rel="stylesheet" type="text/css" href="{!! url() !!}/backend/my-css/common.css">
    <link rel="stylesheet" type="text/css" href="{!! url() !!}/backend/css/mcustomscrollbar/jquery.mCustomScrollbar.css">
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins/jquery/jquery.min.js'></script>
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins/jquery/jquery-ui.min.js'></script>   
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins/jquery/jquery-migrate.min.js'></script>
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins/jquery/globalize.js'></script>    
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins/bootstrap/bootstrap.min.js'></script>
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins/uniform/jquery.uniform.min.js'></script>
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins/datatables/jquery.dataTables.min.js'></script>
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins/fancybox/jquery.fancybox.pack.js'></script>
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js'></script>
    <script src="{!! url() !!}/backend/js/plugins/sweetalert-master/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{!! url() !!}/backend/js/plugins/sweetalert-master/dist/sweetalert.css">
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins/jquery/jquery-ui-timepicker-addon.js'></script>
    <script type='text/javascript' src='{!! url() !!}/backend/my-js/be_common.js'></script> 
    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins/ckeditor/ckeditor.js'></script>
    <!-- <script src="//cdn.ckeditor.com/4.5.6/full/ckeditor.js"></script>  -->

    <script type='text/javascript' src='{!! url() !!}/backend/js/plugins.js'></script>    
    <script type='text/javascript' src='{!! url() !!}/backend/js/actions.js'></script>
    <script type='text/javascript' src='{!! url() !!}/backend/js/settings.js'></script>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <script>
         var base_url = '{!! url() !!}/backend/';
    </script>
</head>
<body class="bg-img-num1"> 
    
    <div class="container"> 
        @include('backend.masters.be_navigation_view')
        @yield('body.content') 
    </div>
    
</body>
</html>