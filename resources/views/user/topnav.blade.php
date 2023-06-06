<div class="topnav shadow-sm">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{ route('user',
                        ['id_app' => 1]) }}" id="topnav-dashboards">
                            <i class="uil-dashboard mr-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{ route('coupon.list') }}" id="topnav-apps" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-apps mr-1"></i>List coupon
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-copy-alt mr-1"></i>Scan histories
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>