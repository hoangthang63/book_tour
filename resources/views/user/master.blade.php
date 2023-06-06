<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Thang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app-creative.min.css') }}" rel="stylesheet" type="text/css">
    @stack('css')
</head>

<body data-layout="topnav" data-layout-config='{"layoutBoxed":false,"darkMode":false,"showRightSidebarOnStart": true}'>
    <!-- Begin page -->
    <div class="wrapper">

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                @include('user.topbar')
                <!-- end Topbar -->
                @include('user.topnav')



                <!-- Start Content-->
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-left">
                                    @yield('title')
                                    <div class="col-2 pt-2 d-flex">
                                        @yield('list_app')
                                        @yield('popup')
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                        </div>
                    </div>
                </div>

                @yield('content')

                <!-- container -->

            </div>
            <!-- content -->

            <!-- Footer Start -->
            @include('user.footer')
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->

    <div class="rightbar-overlay"></div>
    <!-- /Right-bar -->

    <!-- bundle -->
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('js/vendor.min.js') }}"></script>
    @yield('open_popup')
    @yield('js')
    @stack('js')
</body>

</html>
