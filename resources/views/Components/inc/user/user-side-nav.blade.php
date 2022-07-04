<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Home</div>
                <a class="nav-link" href="{{route('dashboard',['state' => 'dashboard'])}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="{{route('profile',['state' => 'profile'])}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-circle"></i></div>
                    Profile
                </a>
                <a class="nav-link" href="{{route('leave',['state' => 'leave'])}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-child "></i></div>
                    Request Leaves
                </a>
                <div class="sb-sidenav-menu-heading">Settings</div>
                <a class="nav-link" href="{{route('dashboard',['state' => 'change-password'])}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-key"></i></div>
                    Change Password
                </a>
            </div>
        </div>
    </nav>
</div>
