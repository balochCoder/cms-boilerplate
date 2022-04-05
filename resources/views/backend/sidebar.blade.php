    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">

        <div data-simplebar class="h-100">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title" key="t-menu">Menu</li>

                    <li>
                        <a href="{{ route('home') }}" class="waves-effect">
                            <i class="bx bx-home-circle"></i>
                            <span key="t-dashboards">Dashboard</span>
                        </a>
                    </li>

                   
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-layout"></i>
                                <span key="t-layouts">User Management</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="true">
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow" key="t-level-1-2">Roles</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="{{route('roles.index')}}" key="t-level-2-1">All Roles</a></li>
                                        <li><a href="{{route('roles.create')}}" key="t-level-2-2">Add Role</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);" class="has-arrow" key="t-level-1-2">Users</a>
                                    <ul class="sub-menu" aria-expanded="true">
                                        <li><a href="#" key="t-level-2-1">All Users</a></li>
                                        <li><a href="#" key="t-level-2-2">Add User</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                 



                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
    <!-- Left Sidebar End -->
