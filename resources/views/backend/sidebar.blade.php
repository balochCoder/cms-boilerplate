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
                    @canany(['users-add', 'users-edit', 'users-view', 'users-delete', 'roles-add', 'roles-edit',
                        'roles-view', 'roles-delete'])
                        <li class="menu-title" key="t-menu">Access Control</li>
                        @canany(['roles-add', 'roles-edit', 'roles-view', 'roles-delete'])
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-key"></i>
                                    <span key="t-layouts">Roles</span>
                                </a>

                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="{{ route('roles.index') }}" key="t-level-2-1">All Roles</a></li>
                                    @can('roles-add')
                                        <li><a href="{{ route('roles.create') }}" key="t-level-2-2">Add Role</a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany

                        @canany(['users-add', 'users-edit', 'users-view', 'users-delete'])
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-user"></i>
                                    <span key="t-layouts">Users</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="{{ route('users.index') }}" key="t-level-2-1">All Users</a></li>
                                    @can('users-add')
                                        <li><a href="{{ route('users.create') }}" key="t-level-2-2">Add User</a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany
                    @endcanany

                    @canany(['faqs-add', 'faqs-edit', 'faqs-view', 'faqs-delete'])
                        <li class="menu-title" key="t-menu">CMS</li>

                        @canany(['faqs-add', 'faqs-edit', 'faqs-view', 'faqs-delete', 'websettings-add', 'websettings-edit',
                            'websettings-view', 'websettings-delete'])
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bxs-comment-detail"></i>
                                    <span key="t-layouts">FAQ's</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="{{route('faqs.index')}}" key="t-level-2-1">All FAQ's</a></li>
                                    @can('faqs-add')
                                        <li><a href="{{route('faqs.create')}}" key="t-level-2-2">Add FAQ</a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany


                        @canany(['websettings-add', 'websettings-edit', 'websettings-view', 'websettings-delete'])
                            <li>
                                <a href="{{ route('websettings.index') }}" class=" waves-effect">
                                    <i class="bx bx-globe"></i>
                                    <span key="t-layouts">Web Settings</span>
                                </a>
                            </li>
                        @endcanany

                    @endcanany

                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
    <!-- Left Sidebar End -->
