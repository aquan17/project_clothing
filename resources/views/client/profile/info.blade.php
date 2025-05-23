@extends('client.layout.ClientLayout')
@section('title', 'Profile')
@section('content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif


    <section class="position-relative">
        <div class="profile-basic position-relative"
            style="background-image: url('{{ asset('client/images/profile-bg.jpg') }}');background-size: cover;background-position: center; height: 300px;">
            <div class="bg-overlay bg-primary" style="--bs-bg-opacity: 0.99;"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="pt-3">
                        <div class="mt-n5 d-flex gap-3 flex-wrap align-items-end">
                            <img src="{{ asset('client/images/users/meomeo.jpg') }}" alt=""
                                class="avatar-xl rounded p-1 bg-light mt-n3">
                            <div>
                                <h5 class="fs-18">{{ $user->name }}</h5>
                                <div class="text-muted">
                                    <i class="bi bi-geo-alt"></i> Việt Nam
                                </div>
                            </div>
                            <div class="ms-md-auto">
                                <a href="{{ route('client.products') }}" class="btn btn-success btn-hover"><i
                                        class="bi bi-cart4 me-1 align-middle"></i> Mua sắm ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills flex-column gap-3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fs-15" data-bs-toggle="tab" href="#custom-v-pills-profile"
                                        role="tab" aria-selected="true"><i
                                            class="bi bi-person-circle align-middle me-1"></i> Thông Tin Tài Khoản</a>
                                </li>
                                {{-- <li class="nav-item" role="presentation">
                                    <a class="nav-link fs-15" data-bs-toggle="tab" href="#custom-v-pills-list"
                                        role="tab" aria-selected="false" tabindex="-1"><i
                                            class="bi bi-bookmark-check align-middle me-1"></i> Danh Sách Yêu Thích</a>
                                </li> --}}
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fs-15" data-bs-toggle="tab" href="#custom-v-pills-order"
                                        role="tab" aria-selected="false" tabindex="-1"><i
                                            class="bi bi-bag align-middle me-1"></i> Lịch Sử Đơn Hàng</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fs-15" data-bs-toggle="tab" href="#custom-v-pills-setting"
                                        role="tab" aria-selected="false" tabindex="-1"><i class="bi bi-pencil-square align-middle me-1"></i> Chỉnh Sửa Thông Tin</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-15" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right align-middle me-1"></i> Đăng Xuất
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="tab-content text-muted">
                        <!-- Account Info Tab -->
                        <div class="tab-pane fade " id="custom-v-pills-profile" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex mb-4">
                                                <h6 class="fs-16 text-decoration-underline flex-grow-1 mb-0">Thông tin cá
                                                    nhân
                                                </h6>
                                                {{-- <div class="flex-shrink-0">
                                                    <a href="#!" class="badge bg-dark-subtle text-dark">Sửa</a>
                                                </div> --}}
                                            </div>

                                            <div class="table-responsive table-card px-1">
                                                <table class="table table-borderless table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td>Tên Khách Hàng</td>
                                                            <td class="fw-medium">{{ Auth::user()->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Số Điện Thoại</td>
                                                            <td class="fw-medium">
                                                                {{ Auth::user()->phone ?? 'Chưa cập nhật' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Địa chỉ email</td>
                                                            <td class="fw-medium">{{ Auth::user()->email }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td>Kể từ khi thành viên</td>
                                                            <td class="fw-medium">
                                                                {{ Auth::user()->created_at->format('d/m/Y H:i:s') }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="mt-4">
                                                <h6 class="fs-16 text-decoration-underline flex-grow-1 mb-0">Địa chỉ giao
                                                    hàng
                                                </h6>
                                                
                                            </div>

                                            <div class="row mt-4">
                                                @foreach ($shippingAddresses as $address)
                                                    <div class="col-md-6">
                                                        <div class="card mb-md-0">
                                                            <div class="card-body">
                                                                <div class="float-end clearfix">
                                                                    <a href="{{ route('address.index') }}"
                                                                        class="badge bg-primary-subtle text-primary">
                                                                        <i class="ri-pencil-fill align-bottom me-1"></i>
                                                                        Sửa
                                                                    </a>
                                                                </div>
                                                                <div>
                                                                    <span class="mb-3 text-uppercase fw-semibold d-block">
                                                                        {{ $address->is_default ? 'Địa Chỉ Mặc Định' : 'Địa Chỉ Giao Hàng' }}
                                                                    </span>
                                                                    <h6 class="fs-14 mb-2 d-block">{{ $address->name }}
                                                                    </h6>
                                                                    <span
                                                                        class="text-muted fw-normal text-wrap mb-1 d-block">
                                                                        {{ $address->ward }}, {{ $address->district }},
                                                                        {{ $address->province }}, {{ $address->country }}
                                                                    </span>
                                                                    <span class="text-muted fw-normal d-block">
                                                                        {{ $address->phone }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Wishlist Tab -->
                        {{-- <div class="tab-pane fade" id="custom-v-pills-list" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card overflow-hidden">
                                        <div class="card-body">
                                            <div class="table-responsive table-card">
                                                <table class="table fs-15 align-middle">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Sản Phẩm</th>
                                                            <th scope="col">Giá</th>
                                                            <th scope="col">Tình trạng hàng</th>
                                                            <th scope="col">Chức Năng</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($wishlists as $wishlist)
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex gap-3">
                                                                        <div class="avatar-sm flex-shrink-0">
                                                                            <div
                                                                                class="avatar-title bg-dark-subtle rounded">
                                                                                <img src="{{ asset('client/images/fashion/product/' . $wishlist->product->image) }}"
                                                                                    alt="" class="avatar-xs">
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex-grow-1">
                                                                            <a
                                                                                href="{{ route('client.products.show', $wishlist->product->id) }}">
                                                                                <h6 class="fs-16">
                                                                                    {{ $wishlist->product->name }}</h6>
                                                                            </a>
                                                                            <p class="mb-0 text-muted fs-13">
                                                                                {{ $wishlist->product->category->name }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>${{ number_format($wishlist->product->price) }}</td>
                                                                <td>
                                                                    <span
                                                                        class="badge bg-{{ $wishlist->product->stock > 0 ? 'success' : 'danger' }}-subtle text-{{ $wishlist->product->stock > 0 ? 'success' : 'danger' }}">
                                                                        {{ $wishlist->product->stock > 0 ? 'In Stock' : 'Out Of Stock' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <ul class="list-unstyled d-flex gap-3 mb-0">
                                                                        <li>
                                                                            <a href="{{ route('client.cart.add') }}"
                                                                                class="btn btn-soft-info btn-icon btn-sm">
                                                                                <i
                                                                                    class="ri-shopping-cart-2-line fs-13"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href=""
                                                                                class="btn btn-soft-danger btn-icon btn-sm">
                                                                                <i class="ri-close-line fs-13"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <!-- Orders Tab -->
                        <div class="tab-pane fade" id="custom-v-pills-order" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#all-orders">
                                                Tất Cả Đơn Hàng
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#processing-orders">
                                                Đang Xử Lý
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#shipping-orders">
                                                Đã xác nhận
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#completed-orders">
                                                Hoàn Thành
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#cancelled-orders">
                                                Đã Hủy
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <!-- All Orders -->
                                        <div class="tab-pane active" id="all-orders">
                                            @include('client.profile.components.order-table', [
                                                'orders' => $orders,
                                            ])
                                        </div>

                                        <!-- Processing Orders -->
                                        <div class="tab-pane" id="processing-orders">
                                            @include('client.profile.components.order-table', [
                                                'orders' => $processingOrders,
                                            ])
                                        </div>

                                        <!-- Shipping Orders -->
                                        <div class="tab-pane" id="shipping-orders">
                                            @include('client.profile.components.order-table', [
                                                'orders' => $shippingOrders,
                                            ])
                                        </div>

                                        <!-- Completed Orders -->
                                        <div class="tab-pane" id="completed-orders">
                                            @include('client.profile.components.order-table', [
                                                'orders' => $completedOrders,
                                            ])
                                        </div>

                                        <!-- Cancelled Orders -->
                                        <div class="tab-pane" id="cancelled-orders">
                                            @include('client.profile.components.order-table', [
                                                'orders' => $cancelledOrders,
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Orders Tab -->


                        <!-- Settings Tab -->
                        <div class="tab-pane fade" id="custom-v-pills-setting" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="{{ route('client.profile.update') }}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h5 class="fs-16 text-decoration-underline mb-4">Thông tin cá nhân
                                                        </h5>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Tên</label>
                                                            <input type="text" class="form-control" id="name"
                                                                name="name" value="{{ Auth::user()->name }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="phone" class="form-label">Số Điện Thoại</label>
                                                            <input type="text" class="form-control" id="phone"
                                                                name="phone" value="{{ Auth::user()->phone }}">
                                                        </div>
                                                    </div>
                                                      <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="email"
                                                                name="email" value="{{ Auth::user()->email }}">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="text-sm-end">
                                                    <button type="submit"
                                                        class="btn btn-secondary d-block d-sm-inline-block">
                                                        <i class="ri-edit-box-line align-middle me-2"></i> Cập nhật
                                                        thông tin
                                                    </button>
                                                </div>
                                            </form>

                                            <div class="mb-3" id="changePassword">
                                                <h5 class="fs-16 text-decoration-underline mb-4">Thay đổi mật khẩu</h5>
                                                <form action="{{ route('password.change') }}" method="POST">
                                                    @csrf
                                                    <div class="row g-2">
                                                        <div class="col-lg-4">
                                                            <div>
                                                                <label for="current_password" class="form-label">Mật Khẩu
                                                                    Cũ*</label>
                                                                <input type="password" class="form-control"
                                                                    id="current_password" name="current_password">
                                                                    @if ($errors->has('current_password'))
                                                                    <span class="text-danger">{{ $errors->first('current_password') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div>
                                                                <label for="password" class="form-label">Mật Khẩu
                                                                    Mới*</label>
                                                                <input type="password" class="form-control"
                                                                    id="password" name="password">
                                                                @if ($errors->has('password'))
                                                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div>
                                                                <label for="password_confirmation" class="form-label">Xác
                                                                    Nhận Mật Khẩu*</label>
                                                                <input type="password" class="form-control"
                                                                    id="password_confirmation"
                                                                    name="password_confirmation">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-sm-end mt-3">
                                                        <button type="submit" class="btn btn-primary">Thay Đổi Mật
                                                            Khẩu</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        /* Tab Container Styles */
        .nav-tabs-custom {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 0;
            position: relative;
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE and Edge */
        }

        .nav-tabs-custom::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }

        /* Tab Items */
        .nav-tabs-custom .nav-item {
            margin-bottom: -1px;
            white-space: nowrap;
        }

        .nav-tabs-custom .nav-link {
            position: relative;
            color: #6c757d;
            border: none;
            /* padding: 1rem 1.5rem; */
            font-weight: 500;
            transition: all 0.3s ease;
            margin-right: 5px;
        }

        /* Active & Hover States */
        .nav-tabs-custom .nav-link.active,
        .nav-tabs-custom .nav-link:hover {
            color: var(--vz-primary);
            background: transparent;
            border-bottom: 2px solid var(--vz-primary);
        }

        .nav-tabs-custom .nav-link.active::after {
            content: "";
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--vz-primary);
        }

        /* Tab Content */
        .tab-content {
            /* padding: 1.5rem 0; */
            min-height: 200px;
        }

        .tab-pane {
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .tab-pane.active {
            display: block;
            opacity: 1;
        }

        /* Card Styles */
        .card {
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .08);
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #dee2e6;
            padding: 1rem 1.5rem;
        }

        /* Table Styles */
        .table-responsive {
            margin: 0;
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        /* Responsive Fixes */
        @media (max-width: 768px) {
            .nav-tabs-custom .nav-link {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }

            .card-header {
                padding: 0.75rem 1rem;
            }

            .tab-content {
                padding: 1rem 0;
            }
        }

        /* Animation for Tab Switching */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tab-pane.active {
            animation: fadeIn 0.3s ease-in-out;
        }
    </style>

@endsection
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabKey = "activeTab";

        // Lấy tab đã lưu hoặc tab mặc định (tab đầu tiên)
        const savedTab = localStorage.getItem(tabKey);
        const defaultTab = "#custom-v-pills-profile";

        // Nếu có tab đã lưu, kích hoạt tab đó
        if (savedTab) {
            const triggerEl = document.querySelector(`[data-bs-toggle="tab"][href="${savedTab}"]`);
            if (triggerEl) {
                const tab = new bootstrap.Tab(triggerEl);
                tab.show();
            } else {
                // Nếu tab đã lưu không tồn tại, kích hoạt tab mặc định
                const defaultTriggerEl = document.querySelector(`[data-bs-toggle="tab"][href="${defaultTab}"]`);
                if (defaultTriggerEl) {
                    const tab = new bootstrap.Tab(defaultTriggerEl);
                    tab.show();
                    localStorage.setItem(tabKey, defaultTab);
                }
            }
        } else {
            // Nếu chưa có tab nào được lưu, kích hoạt tab mặc định
            const defaultTriggerEl = document.querySelector(`[data-bs-toggle="tab"][href="${defaultTab}"]`);
            if (defaultTriggerEl) {
                const tab = new bootstrap.Tab(defaultTriggerEl);
                tab.show();
                localStorage.setItem(tabKey, defaultTab);
            }
        }

        // Bắt sự kiện khi tab được click
        const tabLinks = document.querySelectorAll('[data-bs-toggle="tab"]');
        tabLinks.forEach(function (tabLink) {
            tabLink.addEventListener("shown.bs.tab", function (event) {
                const target = event.target.getAttribute("href");
                localStorage.setItem(tabKey, target);
            });
        });
    });
</script>
