<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Thang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">


    <!-- App css -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app-creative.min.css') }}" rel="stylesheet" type="text/css">
    @stack('css')
</head>

<body class=""
    data-layout-config="{&quot;leftSideBarTheme&quot;:&quot;dark&quot;,&quot;layoutBoxed&quot;:false, &quot;leftSidebarCondensed&quot;:false, &quot;leftSidebarScrollable&quot;:false,&quot;darkMode&quot;:false, &quot;showRightSidebarOnStart&quot;: true}"
    data-leftbar-theme="dark">
    <!-- Begin page -->
    @include('layout.sidebar')
    <div class="wrapper mm-active">
        @include('layout.header')

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Start -->
            @include('layout.footer')
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->


    <!-- bundle -->

    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('js/vendor.min.js') }}"></script>
    <script src="{{ asset('js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('js/vendor/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('js/vendor/jquery-jvectormap-world-mill-en.js') }}"></script>
    


    <svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1"
        xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
        style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
        <defs id="SvgjsDefs1002"></defs>
        <polyline id="SvgjsPolyline1003" points="0,0"></polyline>
        <path id="SvgjsPath1004" d="M0 0 "></path>
    </svg>
    <div class="daterangepicker ltr single auto-apply opensright">
        <div class="ranges"></div>
        <div class="drp-calendar left single" style="display: block;">
            <div class="calendar-table"></div>
            <div class="calendar-time" style="display: none;"></div>
        </div>
        <div class="drp-calendar right" style="display: none;">
            <div class="calendar-table"></div>
            <div class="calendar-time" style="display: none;"></div>
        </div>
        <div class="drp-buttons"><span class="drp-selected"></span><button class="cancelBtn btn btn-sm btn-default"
                type="button">Cancel</button><button class="applyBtn btn btn-sm btn-primary" disabled="disabled"
                type="button">Apply</button> </div>
    </div>
    <div class="jvectormap-label"></div>
    @yield('js')
    @stack('js')
</body>

</html>
