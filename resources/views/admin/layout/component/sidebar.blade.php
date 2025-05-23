<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('client.home') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('admin/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('admin/assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('client.home') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('admin/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('admin/assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div class="dropdown sidebar-user m-1 rounded">
        <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center gap-2">
                <img class="rounded header-profile-user" src="{{ asset('admin/assets/images/users/avatar-1.jpg') }}"
                    alt="Header Avatar">
                <span class="text-start">
                    <span class="d-block fw-medium sidebar-user-name-text">{{ Auth::user()->name }}</span>
                    <span class="d-block fs-14 sidebar-user-name-sub-text"><i
                            class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span
                            class="align-middle">Online</span></span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header">Welcome {{ Auth::user()->name }}!</h6>
            <a class="dropdown-item" href="pages-profile.html"><i
                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Profile</span></a>
            <a class="dropdown-item" href="apps-chat.html"><i
                    class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Messages</span></a>
            <a class="dropdown-item" href="apps-tasks-kanban.html"><i
                    class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Taskboard</span></a>
            <a class="dropdown-item" href="pages-faqs.html"><i
                    class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Help</span></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="pages-profile.html"><i
                    class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance :
                    <b>$5971.67</b></span></a>
            <a class="dropdown-item" href="pages-profile-settings.html"><span
                    class="badge bg-success-subtle text-success mt-1 float-end">New</span><i
                    class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Settings</span></a>
            <a class="dropdown-item" href="auth-lockscreen-basic.html"><i
                    class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock
                    screen</span></a>
            <a class="dropdown-item" href="auth-logout-basic.html"><i
                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle"
                    data-key="t-logout">Logout</span></a>
        </div>
    </div>
    <div id="scrollbar">
        <div class="container-fluid">


            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Trang Quản Trị</span>
                    </a>

                </li> <!-- end Dashboard Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('admin/*') ? 'active' : '' }}" href="#sidebarApps"
                        data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ request()->is('admin/*') ? 'true' : 'false' }}" aria-controls="sidebarApps">
                        <i class="ri-apps-2-line"></i> <span data-key="t-Ứng Dụng">Ứng Dụng</span>
                    </a>

                    <div class="collapse menu-dropdown {{ request()->is('admin/*') ? 'show' : '' }}"
                        id="sidebarApps">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#sidebarEcommerce"
                                    class="nav-link {{ request()->is('admin/*') ? 'active' : '' }}"
                                    data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{ request()->is('admin/*') ? 'true' : 'false' }}"
                                    aria-controls="sidebarEcommerce">
                                    Thương mại điện tử
                                </a>
                                <div class="collapse menu-dropdown {{ request()->is('admin/*') ? 'show' : '' }}"
                                    id="sidebarEcommerce">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('admin.products.index') }}"
                                                class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}"
                                                data-key="t-Sản Phẩm"> Sản Phẩm </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.orders.index') }}"
                                                class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}"
                                                data-key="t-Đơn hàng"> Đơn hàng </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.categories.index') }}"
                                                class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}"
                                                data-key="t-Danh Mục"> Danh Mục </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.users.index') }}"
                                                class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}"
                                                data-key="t-Khách Hàng"> Khách Hàng </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.coupons.index') }}"
                                                class="nav-link {{ request()->is('admin/coupons*') ? 'active' : '' }}"
                                                data-key="t-Mã Giảm Giá"> Mã Giảm Giá </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.comments.index') }}"
                                                class="nav-link {{ request()->routeIs('admin.comments.index') ? 'active' : '' }}"
                                                data-key="t-Bình Luận"> Bình Luận </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.comments.trashed') }}"
                                                class="nav-link {{ request()->routeIs('admin.comments.trashed') ? 'active' : '' }}"
                                                data-key="t-Bình Luận"> Bình Luận đã ẩn </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
