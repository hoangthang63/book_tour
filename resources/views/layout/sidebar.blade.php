<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu mm-show">

    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="assets/images/logo.png" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="assets/images/logo_sm.png" alt="" height="16">
        </span>
    </a>

    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-dark">
        <span class="logo-lg">
            <img src="assets/images/logo-dark.png" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="assets/images/logo_sm_dark.png" alt="" height="16">
        </span>
    </a>

    <div class="h-100 mm-active" id="left-side-menu-container" data-simplebar="init">
        <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                    <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                        <div class="simplebar-content" style="padding: 0px;">
                            
                            <!--- Sidemenu -->
                            <ul class="metismenu side-nav mm-show">
                                @if (session()->get('role') == 1)
                                <li class="side-nav-title side-nav-item">System admin</li>
                                
                                <li class="side-nav-item">
                                    <a href="{{ route('admin') }}" class="side-nav-link" aria-expanded="false">
                                        <i class="mdi mdi-format-list-bulleted-square"></i>
                                        <span> List company </span>
                                    </a>
                                </li>
                                <li class="side-nav-item">
                                    <a href="{{ route('app.admin') }}" class="side-nav-link" aria-expanded="false">
                                        <i class="mdi mdi-playlist-edit"></i>
                                        <span> List admin </span>
                                    </a>
                                </li>
                                @endif
                                

                                <li class="side-nav-title side-nav-item">Admin</li>

                                {{-- <li class="side-nav-item">
                                    <a href="#" class="side-nav-link" aria-expanded="false">
                                        <i class="mdi mdi-account-cog"></i>
                                        <span> Quản lý user </span>
                                    </a>
                                </li> --}}
                                <li class="side-nav-item">
                                    <a href="{{ route('tour.index') }}" class="side-nav-link" aria-expanded="false">
                                        <i class=" mdi mdi-file-settings-variant-outline"></i>
                                        <span> List Tour </span>
                                    </a>
                                </li>

                                <li class="side-nav-item">
                                    <a href="{{ route('tour.stat') }}" class="side-nav-link" aria-expanded="false">
                                        <i class="dripicons-article"></i>
                                        <span> Stat </span>
                                    </a>
                                </li>

                                <li class="side-nav-item">
                                    <a href="{{ route('tour.ratio') }}" class="side-nav-link" aria-expanded="false">
                                        <i class="dripicons-graph-pie"></i>
                                        <span> Ratio </span>
                                    </a>
                                </li>

                                {{-- <li class="side-nav-item">
                                    <a href="{{ route('setting.coupon') }}" class="side-nav-link" aria-expanded="false">
                                        <i class=" mdi mdi-file-settings-variant-outline"></i>
                                        <span> Setting coupon </span>
                                    </a>
                                </li>

                                <li class="side-nav-item">
                                    <a href="{{ route('setting.stamp') }}" class="side-nav-link" aria-expanded="false">
                                        <i class="mdi mdi-file-settings-variant"></i>
                                        <span> Setting stamp card </span>
                                    </a>
                                </li>

                                <li class="side-nav-item">
                                    <a href="{{ route('store.management') }}" class="side-nav-link" aria-expanded="false">
                                        <i class="mdi mdi-store-outline"></i>
                                        <span> Store management </span>
                                    </a>
                                </li>

                                <li class="side-nav-item">
                                    <a href="{{ route('coupon.winning.lists') }}" class="side-nav-link" aria-expanded="false">
                                        <i class="mdi mdi-file-export-outline"></i>
                                        <span> Export coupon data</span>
                                    </a>
                                </li> --}}


                                <!-- end Help Box -->
                                <!-- End Sidebar -->

                                <div class="clearfix"></div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="simplebar-placeholder" style="width: auto; height: 1431px;"></div>
        </div>
        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="width: 0px; display: none; transform: translate3d(0px, 0px, 0px);">
            </div>
        </div>
        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
            <div class="simplebar-scrollbar"
                style="height: 240px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
        </div>
    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
