<nav class="navbar navbar-expand-lg ecommerce-navbar" id="navbar">
    <div class="container">
        <a class="navbar-brand d-none d-lg-block" href="{{ route('client.home') }}">
            <div class="logo-dark">
                <img src="{{ asset('client/images/logo-dark.png') }}" alt="" height="25">
            </div>
            <div class="logo-light">
                <img src="{{ asset('client/images/logo-light.png') }}" alt="" height="25">
            </div>
        </a>
        <button class="btn btn-soft-primary btn-icon d-lg-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Chuyển đổi điều hướng">
            <i class="bi bi-list fs-20"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-lg-auto mb-2 mb-lg-0" id="navigation-menu">
                <li class="nav-item d-block d-lg-none">
                    <a class="d-block p-3 h-auto text-center" href="{{ route('client.home') }}">
                        <img src="{{ asset('client/images/logo-dark.png') }}" alt="" height="25"
                            class="card-logo-dark mx-auto">
                        <img src="{{ asset('client/images/logo-light.png') }}" alt="" height="25"
                            class="card-logo-light mx-auto">
                    </a>
                </li>
                <style>
                    .navbar-collapse .nav-item:first-child {
                        margin-top: 30px;
                        /* Tạo khoảng cách để tránh bị che bởi header */
                    }
                </style>
                <li class="nav-item ">
                    <a class="nav-link " href="{{ route('client.home') }}">
                        Trang Chủ
                    </a>

                </li>
                <li class="nav-item dropdown dropdown-hover dropdown-mega-full">
                    <a class="nav-link dropdown-toggle" data-key="t-catalog" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Danh mục
                    </a>
                    <div class="dropdown-menu p-0">
                        <div class="row g-0 g-lg-4">
                            <div class="col-lg-2 d-none d-lg-block">
                                <div class="card rounded-start rounded-0 border-0 h-100 mb-0 overflow-hidden"
                                    style="background-image: url('{{ asset('client/images/ecommerce/img-1.jpg') }}');background-size: cover;">
                                    <div class="bg-overlay bg-light bg-opacity-25"></div>
                                    <div class="card-body d-flex align-items-center justify-content-center">
                                        <div class="text-center">
                                            <a href="product-grid-sidebar-banner.html"
                                                class="btn btn-secondary btn-hover"><i
                                                    class="ph-storefront align-middle me-1"></i> <span
                                                    data-key="t-shop-now">Mua ngay</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @foreach ($categoriesGrouped as $groupName => $categories)
                                <div class="col-lg-3"> <!-- Thay đổi từ col-lg-2 thành col-lg-3 -->
                                    <div class="p-3">
                                        <h6 class="mb-3 text-uppercase fs-13 fw-semibold text-muted">{{ $groupName }}
                                        </h6>
                                        <div class="row g-3">
                                            @foreach ($categories as $category)
                                                <div class="col-lg-6"> <!-- Hiển thị 2 cột trong mỗi nhóm -->
                                                    <a href="{{ route('client.products', ['category' => $category->slug]) }}"
                                                        class="category-item d-flex align-items-center">
                                                        @if ($category->icon)
                                                            <i class="{{ $category->icon }} me-2 text-muted fs-16"></i>
                                                        @endif
                                                        <span class="text-body">{{ $category->name }}</span>
                                                        <span
                                                            class="badge bg-light text-muted ms-2">{{ $category->products_count }}</span>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                            <div class="col-lg-2 d-none d-lg-block">
                                <div class="p-3">
                                    <p class="mb-3 text-uppercase fs-11 fw-medium text-muted" data-key="t-top-brands">
                                        Thương hiệu hàng đầu</p>
                                    <div class="row g-2">
                                        <div class="col-lg-4">
                                            <a href="#!"
                                                class="d-block p-2 border border-dashed text-center rounded-3">
                                                <img src="{{ asset('client/images/brands/img-8.png') }}" alt=""
                                                    class="avatar-sm">
                                            </a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="#!"
                                                class="d-block p-2 border border-dashed text-center rounded-3">
                                                <img src="{{ asset('client/images/brands/img-2.png') }}" alt=""
                                                    class="avatar-sm">
                                            </a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="#!"
                                                class="d-block p-2 border border-dashed text-center rounded-3">
                                                <img src="{{ asset('client/images/brands/img-3.png') }}" alt=""
                                                    class="avatar-sm">
                                            </a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="#!"
                                                class="d-block p-2 border border-dashed text-center rounded-3">
                                                <img src="{{ asset('client/images/brands/img-4.png') }}" alt=""
                                                    class="avatar-sm">
                                            </a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="#!"
                                                class="d-block p-2 border border-dashed text-center rounded-3">
                                                <img src="{{ asset('client/images/brands/img-5.png') }}"
                                                    alt="" class="avatar-sm">
                                            </a>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="#!"
                                                class="d-block p-2 border border-dashed text-center rounded-3">
                                                <img src="{{ asset('client/images/brands/img-6.png') }}"
                                                    alt="" class="avatar-sm">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown dropdown-hover">
                    <a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false" data-key="t-shop">
                        Cửa hàng
                    </a>
                    <div class="dropdown-menu dropdown-mega-menu-xl dropdown-menu-center p-0">
                        <div class="row g-0 g-lg-4">
                            <div class="col-lg-5 d-none d-lg-block">
                                <div class="card rounded-start rounded-0 border-0 h-100 mb-0 overflow-hidden"
                                    style="background-image: url('{{ asset('client/images/ecommerce/img-2.jpg') }}'); background-size: cover;">
                                    <div class="bg-overlay bg-primary" style="opacity: 0.90;"></div>
                                    <div
                                        class="card-body d-flex align-items-center justify-content-center position-relative">
                                        <div class="text-center">
                                            <h6 class="card-title text-white">Chào mừng đến với Toner</h6>
                                            <p class="text-white-75">Xem tất cả sản phẩm cùng một lúc.</p>
                                            <a href="{{ route('client.products') }}"
                                                class="btn btn-light btn-sm btn-hover">Mua ngay <i
                                                    class="ph-arrow-right align-middle"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="row g-0 g-lg-4">
                                    <div class="col-lg-6">
                                        <div class="py-3">
                                            <ul class="dropdown-menu-list list-unstyled mb-0">
                                                <li>
                                                    <p class="mb-2 text-uppercase fs-11 fw-medium text-muted menu-title"
                                                        data-key="t-checkout-pages">Đơn Hàng</p>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('client.cart.index') }}" class="nav-link"
                                                        data-key="t-shopping-cart">Giỏ hàng</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('client.profile') }}#custom-v-pills-order"
                                                        onclick="setTimeout(() => document.querySelector('[href=\'#custom-v-pills-order\']').click(), 100)"
                                                        class="nav-link" data-key="t-my-orders-order-history">Đơn hàng
                                                        của tôi / Lịch sử
                                                        đơn hàng</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('client.profile') }}#custom-v-pills-list"
                                                        onclick="setTimeout(() => document.querySelector('[href=\'#custom-v-pills-list\']').click(), 100)"
                                                        class="nav-link" data-key="t-wishlist">Danh
                                                        sách yêu thích</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="py-3">
                                            <ul class="dropdown-menu-list list-unstyled mb-0">
                                                <li>
                                                    <p
                                                        class="mb-2 text-uppercase fs-11 fw-medium text-muted menu-title">
                                                        Khám phá</p>
                                                </li>
                                                <li class="nav-item"><a href="{{ route('client.products') }}"
                                                        class="nav-link">Tất cả sản phẩm</a></li>
                                                <li class="nav-item"><a href="" class="nav-link">Bộ sưu
                                                        tập</a></li>
                                                <li class="nav-item"><a href="" class="nav-link">Voucher của
                                                        bạn</a></li>
                                                <li class="nav-item"><a href="" class="nav-link">Blog thời
                                                        trang</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown dropdown-hover">
                    <a class="nav-link dropdown-toggle" data-key="t-pages" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Trang
                    </a>
                    <ul class="dropdown-menu dropdown-menu-md dropdown-menu-center dropdown-menu-list submenu">
                        <li class="nav-item">
                            <a href="{{ route('client.blog.about') }}" class="nav-link" data-key="t-about">Giới
                                thiệu</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('client.blog.purchase') }}" class="nav-link"
                                data-key="t-purchase-guide">Hướng dẫn mua
                                hàng</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('client.blog.terms') }}" class="nav-link"
                                data-key="t-terms-of-service">Điều khoản
                                dịch vụ</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('client.blog.privacy') }}" class="nav-link"
                                data-key="t-privacy-policy">Chính sách bảo
                                mật</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('client.blog.ecommerce') }}" class="nav-link" data-key="t-faq">Câu hỏi
                                thường gặp</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('client.blog.contact') }}" data-key="t-contact">Liên hệ</a>
                </li>
            </ul>
        </div>
        <div class="bg-overlay navbar-overlay" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent.show"></div>

        <div class="d-flex align-items-center">
            <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle text-muted"
                data-bs-toggle="modal" data-bs-target="#searchModal">
                <i class="bx bx-search fs-22"></i>
            </button>
            <div class="topbar-head-dropdown ms-1 header-item">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle text-muted"
                    data-bs-toggle="offcanvas" data-bs-target="#ecommerceCart" aria-controls="ecommerceCart">
                    <i class="ph-shopping-cart fs-18"></i>
                    <span
                        class="position-absolute topbar-badge cartitem-badge fs-10 translate-middle badge rounded-pill bg-danger">{{ $cartItems->count() }}</span>
                </button>
            </div>

            <div class="dropdown topbar-head-dropdown ms-2 header-item dropdown-hover-end">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle text-muted"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bi bi-sun align-middle fs-20"></i>
                </button>
                <div class="dropdown-menu p-2 dropdown-menu-end" id="light-dark-mode">
                    <a href="#!" class="dropdown-item" data-mode="light"><i
                            class="bi bi-sun align-middle me-2"></i> Mặc định (chế độ sáng)</a>
                    <a href="#!" class="dropdown-item" data-mode="dark"><i
                            class="bi bi-moon align-middle me-2"></i> Tối</a>
                    <a href="#!" class="dropdown-item" data-mode="auto"><i
                            class="bi bi-moon-stars align-middle me-2"></i> Tự động (mặc định hệ thống)</a>
                </div>
            </div>
            <div class="dropdown header-item dropdown-hover-end">
                @if (Auth::check())
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user"
                            src="{{ asset('client/images/users/meomeo.jpg') }}" alt="Ảnh đại diện">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Chào mừng <span
                                class="fw-bold text-primary">{{ Auth::user()->name }}</span>!</h6>
                        <a class="dropdown-item" href="{{ route('client.profile') }}">
                            <i class="bi bi-person-circle text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Thông tin khách hàng</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('client.profile') }}#custom-v-pills-order"
                            onclick="setTimeout(() => document.querySelector('[href=\'#custom-v-pills-order\']').click(), 100)">
                            <i class="bi bi-cart4 text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Lịch sử đơn hàng</span>
                        </a>

                        {{-- <a class="dropdown-item" href="ecommerce-cart.html"><i
                                class="bi bi-bag text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Giỏ hàng</span></a> --}}
                        {{-- <a class="dropdown-item" href="track-order.html"><i
                                class="bi bi-truck text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Theo dõi đơn hàng</span></a>
                        <a class="dropdown-item" href="https://themesbrand.com/toner/html/backend/index.html"><i
                                class="bi bi-speedometer2 text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Bảng điều khiển</span></a>
                        <a class="dropdown-item" href="ecommerce-faq.html"><i
                                class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Trợ giúp</span></a> --}}
                        <div class="dropdown-divider"></div>
                        {{-- <a class="dropdown-item" href="account.html"><i
                                class="bi bi-coin text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Số dư : <b>$8451.36</b></span></a> --}}
                        <a class="dropdown-item" href="{{ route('client.profile') }}#custom-v-pills-setting"
                            onclick="setTimeout(() => document.querySelector('[href=\'#custom-v-pills-setting\']').click(), 100)">
                            <i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Cài đặt</span>
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                class="bi bi-box-arrow-right text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Đăng xuất</span></a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                @else
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="ph-user-circle fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        @php
                            function loginUrlWithRedirect()
                            {
                                return route('login', ['redirect' => url()->current()]);
                            }
                        @endphp
                        <a class="dropdown-item" href="{{ loginUrlWithRedirect() }}"><i
                                class="bi bi-key text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Đăng nhập</span></a>
                        <a class="dropdown-item" href="{{ route('register') }}"><i
                                class="bi bi-person-plus text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Đăng ký</span></a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</nav>

<!-- Giỏ hàng -->

<div id="mini-cart-container">
    @include('client.layout.component.mini_cart', ['cartItems' => $cartItems, 'cartTotal' => $cartTotal])
</div>

<!-- Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded">
            <div class="modal-header p-3">
                <div class="position-relative w-100">
                    <input type="text" class="form-control form-control-lg border-2"
                        placeholder="Tìm kiếm trên Toner..." autocomplete="off" id="search-options" value="">
                    <span class="bi bi-search search-widget-icon fs-17"></span>
                    <a href="javascript:void(0);"
                        class="search-widget-icon fs-14 link-secondary text-decoration-underline search-widget-icon-close d-none"
                        id="search-close-options">Xóa</a>
                </div>
            </div>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 overflow-hidden" id="search-dropdown">

                <div class="dropdown-head rounded-top">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 fs-14 text-muted fw-semibold"> TÌM KIẾM GẦN ĐÂY </h6>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown-item bg-transparent text-wrap">
                        <a href="index.html" class="btn btn-soft-secondary btn-sm btn-rounded">cách cài đặt <i
                                class="mdi mdi-magnify ms-1 align-middle"></i></a>
                        <a href="index.html" class="btn btn-soft-secondary btn-sm btn-rounded">nút <i
                                class="mdi mdi-magnify ms-1 align-middle"></i></a>
                    </div>
                </div>

                <div data-simplebar style="max-height: 300px;" class="pe-2 ps-3 my-3">
                    <div class="list-group list-group-flush border-dashed">
                        <div class="notification-group-list">
                            <h5 class="text-overflow text-muted fs-13 mb-2 mt-3 text-uppercase notification-title">
                                Trang ứng dụng</h5>
                            <a href="javascript:void(0);" class="list-group-item dropdown-item notify-item"><i
                                    class="bi bi-speedometer2 me-2"></i> <span>Bảng điều khiển phân tích</span></a>
                            <a href="javascript:void(0);" class="list-group-item dropdown-item notify-item"><i
                                    class="bi bi-filetype-psd me-2"></i> <span>Toner.psd</span></a>
                            <a href="javascript:void(0);" class="list-group-item dropdown-item notify-item"><i
                                    class="bi bi-ticket-detailed me-2"></i> <span>Vé hỗ trợ</span></a>
                            <a href="javascript:void(0);" class="list-group-item dropdown-item notify-item"><i
                                    class="bi bi-file-earmark-zip me-2"></i> <span>Toner.zip</span></a>
                        </div>

                        <div class="notification-group-list">
                            <h5 class="text-overflow text-muted fs-13 mb-2 mt-3 text-uppercase notification-title">
                                Liên kết</h5>
                            <a href="javascript:void(0);" class="list-group-item dropdown-item notify-item"><i
                                    class="bi bi-link-45deg me-2 align-middle"></i>
                                <span>www.themesbrand.com</span></a>
                        </div>

                        <div class="notification-group-list">
                            <h5 class="text-overflow text-muted fs-13 mb-2 mt-3 text-uppercase notification-title">
                                Người dùng</h5>
                            <a href="javascript:void(0);" class="list-group-item dropdown-item notify-item">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('client/images/users/meomeo.jpg') }}" alt=""
                                        class="avatar-xs rounded-circle flex-shrink-0 me-2">
                                    <div>
                                        <h6 class="mb-0">Ayaan Bowen</h6>
                                        <span class="fs-12 text-muted">Nhà phát triển React</span>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0);" class="list-group-item dropdown-item notify-item">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('client/images/users/avatar-7.jpg') }}" alt=""
                                        class="avatar-xs rounded-circle flex-shrink-0 me-2">
                                    <div>
                                        <h6 class="mb-0">Alexander Kristi</h6>
                                        <span class="fs-12 text-muted">Nhà phát triển React</span>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0);" class="list-group-item dropdown-item notify-item">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('client/images/users/avatar-5.jpg') }}" alt=""
                                        class="avatar-xs rounded-circle flex-shrink-0 me-2">
                                    <div>
                                        <h6 class="mb-0">Alan Carla</h6>
                                        <span class="fs-12 text-muted">Nhà phát triển React</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- removeItemModal -->
<div id="removeItemModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"
                    id="close-modal"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                        colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Bạn có chắc không?</h4>
                        <p class="text-muted mx-4 mb-0">Bạn có chắc muốn xóa sản phẩm này không?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn w-sm btn-danger" id="remove-product">Có, Xóa nó!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- end modal -->

@if (Auth::check() && Auth::user()->role === 'admin')
    <a href="{{ route('admin.dashboard') }}"
        class="btn btn-warning position-fixed bottom-0 start-0 m-5 z-3 btn-hover d-none d-lg-block">
        <i class="bi bi-database align-middle me-1"></i> Backend
    </a>
@endif

<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-info btn-icon" style="bottom: 50px;" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->


<!-- Remove the collapse class and add custom styling -->
{{-- <div id="chat-box" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
    <div class="card shadow-lg border-0 rounded mb-0">
        <div class="card-body p-0">
            <div id="users-chat-widget">
                <df-messenger chat-title="Anh Quân" agent-id="d831c92e-2302-4a28-be76-77507535dc51"
                    language-code="vi">
                </df-messenger>
            </div>
        </div>
    </div>
</div> --}}
{{-- <style>
    df-messenger {
        --df-messenger-bot-message: #878a99;
        --df-messenger-button-titlebar-color: #405189;
        --df-messenger-chat-background-color: #fafafa;
        --df-messenger-font-color: white;
        --df-messenger-send-icon: #405189;
        --df-messenger-user-message: #405189;
    }

    #chat-box {
        left: 500px;
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999 !important;
        /* Increased z-index to be above top component */
    }

    /* Custom styling for chat container */
    df-messenger {
        z-index: 9999 !important;
    }

    /* Ensure the chat window is above all components */
    df-messenger-chat {
        z-index: 10000 !important;
    }

    /* Adjust titlebar visibility */
    df-messenger-titlebar {
        position: relative;
        z-index: 10001 !important;
    }

    @media (max-width: 768px) {
        #chat-box {
            bottom: 70px;
            /* Increased bottom margin for mobile */
            right: 10px;
        }
    }
</style>
<!-- Add custom styling -->

<script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script> --}}
