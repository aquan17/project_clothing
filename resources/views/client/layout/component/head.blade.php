<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Toner - eCommerce + Admin HTML Template Build with HTML, React, Laravel, Nodejs" name="description">
    <meta content="Themesbrand" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('client/images/favicon.ico') }}">
    
<!--Start of Fchat.vn--><script type="text/javascript" src="https://cdn.fchat.vn/assets/embed/webchat.js?id=68296bd84c102cde9c026b90" async="async"></script><!--End of Fchat.vn-->
    <!--Swiper slider css-->
    <link href="{{ asset('client/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('client/libs/nouislider/nouislider.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link rel="stylesheet" href="{{ asset('client/css/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/materialdesignicons.min.css') }}"> --}}
    
    <!-- Bootstrap Css -->
    <link href="{{ asset('client/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{ asset('client/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ asset('client/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <!-- custom Css-->
    <link href="{{ asset('client/css/custom.min.css') }}" rel="stylesheet" type="text/css">

</head>