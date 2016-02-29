<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>@yield('head.title')</title>

    <!-- Css Files -->
    <link href="/frontend/css/bootstrap.css" rel="stylesheet">
    <link href="/frontend/css/font-awesome.css" rel="stylesheet">
    <link href="/frontend/css/themetypo.css" rel="stylesheet">
    <link href="/frontend/style.css" rel="stylesheet">
    <link href="/frontend/css/widget.css" rel="stylesheet">
    <link href="/frontend/css/color.css" rel="stylesheet">
    <link href="/frontend/css/flexslider.css" rel="stylesheet">
    <link href="/frontend/css/owl.carousel.css" rel="stylesheet">

    <link href="/frontend/css/responsive.css" rel="stylesheet">
    <link rel="shortcut icon" href="/frontend/images/favicon.ico" type="image/x-icon">

    <meta property="og:url"           content="@yield('fb-url')" />
    <meta property="og:type"          content="@yield('fb-type')" />
    <meta property="og:title"         content="@yield('fb-title')" />
    <meta property="og:description"   content="@yield('fb-desc')" />
    <meta property="og:image"         content="@yield('fb-img')" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <!--// Wrapper //-->
    <div class="kode-wrapper">
        <header id="mainheader" class="kode-header-absolute">

            <!--// TopBaar //-->
            @include('frontend.commons.ft_topbar_view')
            <!--// TopBaar //-->

            <!--// Header //-->
            @include('frontend.commons.ft_header_view')
            <!--// Header //-->
        </header>
        
        <!--// Main Content //-->
        @yield('body.content')
        <!--// Main Content //-->

        <!--// Footer //-->
        @include('frontend.commons.ft_footer_view')
        <!--// Footer //-->
    </div>
    <!--// Wrapper //-->

    <!-- jQuery (necessary for JavaScript plugins) -->
    <script src="/frontend/js/jquery.js"></script>
    <script src="/frontend/js/bootstrap.min.js"></script>
    <script src="/frontend/js/jquery.flexslider.js"></script>
    <script src="/frontend/js/owl.carousel.min.js"></script>

    <script src="/frontend/js/jquery.countdown.js"></script>
    <script src="/frontend/js/jquery.bxslider.min.js" type="text/javascript"></script>
    <script src="/frontend/js/bootstrap-progressbar.js"></script>
    <script src="/frontend/js/jquery.prettyphoto.js"></script>
    <script src="/frontend/js/kode_pp.js"></script>
    <script src="/frontend/js/functions.js"></script>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
</body>

</html>