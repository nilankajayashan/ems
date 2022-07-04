<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Home</div>
                <a class="nav-link" href="{{route('admin_dashboard',['state' => 'dashboard'])}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">customize</div>
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePagesOne" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-filter"></i></div>
                    Filters
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePagesOne" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="{{route('filter_employee',['state' => 'filter_employee'])}}">
                            Filter Employee
                        </a>
                        <a class="nav-link collapsed" href="dashboard.php?state=filter-division-head">
                            Filter Division Head
                        </a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePagesTwo" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                    New Users
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePagesTwo" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="dashboard.php?state=add-new-employee">
                            New Employee
                        </a>
                        <a class="nav-link collapsed" href="dashboard.php?state=add-new-division-head">
                            New Division Head
                        </a>
                    </nav>
                </div>
                <a class="nav-link" href="dashboard.php?state=assign-task">
                    <div class="sb-nav-link-icon"><i class="fas fa-bullhorn"></i></div>
                    Assign Tasks
                </a>
                <div class="sb-sidenav-menu-heading">Advance Options</div>
                <a class="nav-link" href="dashboard.php?state=custom-query">
                    <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                    Custom Operation
                </a>
                <a class="nav-link" href="dashboard.php?state=clear-attendance">
                    <div class="sb-nav-link-icon"><i class="fas fa-trash"></i></div>
                    <span data-toggle="tooltip" data-placement="bottom" title="This action removes the attendance information two months in advance">Clear Attendance</span>
                </a>
            </div>
        </div>
    </nav>
</div>
