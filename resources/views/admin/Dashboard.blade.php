@extends('admin.layout.Adminlayout')
@section('title', 'Bảng điều khiển')
@section('css')
    @include('admin.layout.component.head')
@endsection
@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col">

                    <div class="h-100">
                        <div class="row mb-3 pb-1">
                            <div class="col-12">
                                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                    <div class="flex-grow-1">
                                        <h4 class="fs-16 mb-1">Chào buổi sáng, {{ Auth::user()->name }}!</h4>
                                        <p class="text-muted mb-0">Đây là những gì đang diễn ra với cửa hàng của bạn hôm nay.</p>
                                    </div>
                                    <div class="mt-3 mt-lg-0">
                                        <form action="javascript:void(0);">
                                            <div class="row g-3 mb-0 align-items-center">
                                                <div class="col-sm-auto">
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control border-0 minimal-border dash-filter-picker shadow"
                                                            data-provider="flatpickr" data-range-date="true"
                                                            data-date-format="d M, Y"
                                                            data-deafult-date="01 Jan 2022 to 31 Jan 2022">
                                                        <div class="input-group-text bg-primary border-primary text-white">
                                                            <i class="ri-calendar-2-line"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-auto">
                                                    <button type="button"
                                                        class="btn btn-soft-success material-shadow-none"><i
                                                            class="ri-add-circle-line align-middle me-1"></i> Thêm sản phẩm</button>
                                                </div>
                                                <!--end col-->
                                                <div class="col-auto">
                                                    <button type="button"
                                                        class="btn btn-soft-info btn-icon waves-effect material-shadow-none waves-light layout-rightside-btn"><i
                                                            class="ri-pulse-line"></i></button>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div>
                                </div><!-- end card header -->
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->

                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Tổng doanh thu</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-success fs-14 mb-0">
                                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +16.24 %
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">$<span class="counter-value"
                                                        data-target="totalEarnings">0</span>k </h4>
                                                <a href="#" class="text-decoration-underline">Xem doanh thu ròng</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-success-subtle rounded fs-3">
                                                    <i class="bx bx-dollar-circle text-success"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Đơn hàng</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-danger fs-14 mb-0">
                                                    <i class="ri-arrow-right-down-line fs-13 align-middle"></i> -3.57 %
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                        data-target="totalOrders">0</span></h4>
                                                <a href="#" class="text-decoration-underline">Xem tất cả đơn hàng</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle rounded fs-3">
                                                    <i class="bx bx-shopping-bag text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Khách hàng</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-success fs-14 mb-0">
                                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +29.08 %
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                                        data-target="totalCustomers">0</span>M </h4>
                                                <a href="#" class="text-decoration-underline">Xem chi tiết</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-warning-subtle rounded fs-3">
                                                    <i class="bx bx-user-circle text-warning"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Số dư của tôi</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-muted fs-14 mb-0">
                                                    +0.00 %
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">$<span class="counter-value"
                                                        data-target="totalBalance">0</span>k </h4>
                                                <a href="#" class="text-decoration-underline">Rút tiền</a>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                    <i class="bx bx-wallet text-primary"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div> <!-- end row-->

                        <div class="row">
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-header border-0 align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Doanh thu</h4>
                                        <div class="d-flex align-items-center gap-3">
                                            <!-- Input Date Range -->
                                            <div class="input-group input-group-sm">
                                                <input type="date" class="form-control" id="startDate">
                                                <span class="input-group-text">đến</span>
                                                <input type="date" class="form-control" id="endDate">
                                                <button class="btn btn-primary btn-sm" id="filterDate" type="button">
                                                    <i class="ri-filter-2-fill"></i>
                                                </button>
                                            </div>

                                            <!-- Quick Filter Buttons -->
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" data-filter="all"
                                                    class="btn btn-soft-primary active">TẤT CẢ</button>
                                                <button type="button" data-filter="month"
                                                    class="btn btn-soft-primary">1 THÁNG</button>
                                                <button type="button" data-filter="halfYear"
                                                    class="btn btn-soft-primary">6 THÁNG</button>
                                                <button type="button" data-filter="year"
                                                    class="btn btn-soft-primary">1 NĂM</button>
                                            </div>
                                        </div>
                                    </div>
                                    <style>
                                        .input-group-sm .form-control {
                                            min-width: 120px;
                                        }

                                        .btn-group .btn.active {
                                            background-color: var(--vz-primary);
                                            color: #fff;
                                        }

                                        .input-group .btn {
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                        }
                                    </style>
                                    <div class="card-header p-0 border-0 bg-light-subtle">
                                        <div class="row g-0 text-center">
                                            <div class="col-6 col-sm-3">
                                                <div class="p-3 border border-dashed border-start-0">
                                                    <h5 class="mb-1"><span id="header-orders" class="counter-value"
                                                            data-target="0">0</span></h5>
                                                    <p class="text-muted mb-0">Đơn hàng</p>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-3">
                                                <div class="p-3 border border-dashed border-start-0">
                                                    <h5 class="mb-1"><span id="header-earnings" class="counter-value"
                                                            data-target="0">0</span>k</h5>
                                                    <p class="text-muted mb-0">Doanh thu</p>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-3">
                                                <div class="p-3 border border-dashed border-start-0">
                                                    <h5 class="mb-1"><span id="header-canceled" class="counter-value"
                                                            data-target="0">0</span></h5>
                                                    <p class="text-muted mb-0">Đơn hàng bị hủy</p>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-3">
                                                <div class="p-3 border border-dashed border-start-0 border-end-0">
                                                    <h5 class="mb-1 text-success"><span id="header-conversion"
                                                            class="counter-value" data-target="0">0</span>%</h5>
                                                    <p class="text-muted mb-0">Tỷ lệ chuyển đổi</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body p-0 pb-2">
                                        <div class="w-100">
                                            <div id="customer_impression_charts" class="apex-charts" dir="ltr">
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-4">
                                <!-- card -->
                                <div class="card card-height-100">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Doanh số theo khu vực</h4>
                                        <div class="flex-shrink-0">
                                            <button type="button"
                                                class="btn btn-soft-primary material-shadow-none btn-sm">
                                                Xuất báo cáo
                                            </button>
                                        </div>
                                    </div><!-- end card header -->

                                    <!-- card body -->
                                    <div class="card-body">

                                        <div id="sales-by-locations"
                                            data-colors='["--vz-light", "--vz-success", "--vz-primary"]'
                                            data-colors-interactive='["--vz-light", "--vz-info", "--vz-primary"]'
                                            style="height: 269px" dir="ltr"></div>

                                        <div class="px-2 py-2 mt-1">
                                            <p class="mb-1">Canada <span class="float-end">75%</span></p>
                                            <div class="progress mt-2" style="height: 6px;">
                                                <div class="progress-bar progress-bar-striped bg-primary"
                                                    role="progressbar" style="width: 75%" aria-valuenow="75"
                                                    aria-valuemin="0" aria-valuemax="75"></div>
                                            </div>

                                            <p class="mt-3 mb-1">Greenland <span class="float-end">47%</span>
                                            </p>
                                            <div class="progress mt-2" style="height: 6px;">
                                                <div class="progress-bar progress-bar-striped bg-primary"
                                                    role="progressbar" style="width: 47%" aria-valuenow="47"
                                                    aria-valuemin="0" aria-valuemax="47"></div>
                                            </div>

                                            <p class="mt-3 mb-1">Nga <span class="float-end">82%</span></p>
                                            <div class="progress mt-2" style="height: 6px;">
                                                <div class="progress-bar progress-bar-striped bg-primary"
                                                    role="progressbar" style="width: 82%" aria-valuenow="82"
                                                    aria-valuemin="0" aria-valuemax="82"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Sản phẩm bán chạy nhất</h4>
                                        <div class="flex-shrink-0">
                                            <div class="dropdown card-header-dropdown">
                                                <a class="text-reset dropdown-btn" href="#"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="fw-semibold text-uppercase fs-12">Sắp xếp theo:
                                                    </span><span class="text-muted">Hôm nay<i
                                                            class="mdi mdi-chevron-down ms-1"></i></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Hôm nay</a>
                                                    <a class="dropdown-item" href="#">Hôm qua</a>
                                                    <a class="dropdown-item" href="#">7 ngày qua</a>
                                                    <a class="dropdown-item" href="#">30 ngày qua</a>
                                                    <a class="dropdown-item" href="#">Tháng này</a>
                                                    <a class="dropdown-item" href="#">Tháng trước</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div class="table-responsive table-card">
                                            <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                                                <tbody>
                                                    @forelse($topProducts as $product)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar-sm bg-light rounded p-1 me-2">
                                                                        <img src="{{ asset('client/images/fashion/product/' . $product['image']) }}"
                                                                            alt="{{ $product['name'] }}"
                                                                            class="img-fluid d-block" />
                                                                    </div>
                                                                    <div>
                                                                        <h5 class="fs-14 my-1">
                                                                            <a href="{{ $product['url'] }}"
                                                                                class="text-reset">{{ $product['name'] }}</a>
                                                                        </h5>
                                                                        <span class="text-muted">{{ $product['created_at'] }}</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <h5 class="fs-14 my-1 fw-normal">${{ $product['price'] }}</h5>
                                                                <span class="text-muted">Giá</span>
                                                            </td>
                                                            <td>
                                                                <h5 class="fs-14 my-1 fw-normal">{{ $product['buyer_count'] }}</h5>
                                                                <span class="text-muted">Người mua</span>
                                                            </td>
                                                            <td>
                                                                <h5 class="fs-14 my-1 fw-normal">{{ $product['total_stock'] }}</h5>
                                                                <span class="text-muted">Tồn kho</span>
                                                            </td>
                                                            <td>
                                                                <h5 class="fs-14 my-1 fw-normal">${{ number_format($product['revenue'], 2) }}</h5>
                                                                <span class="text-muted">Doanh thu</span>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center">Không tìm thấy sản phẩm bán chạy</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        <div
                                            class="align-items-center mt-4 pt-2 justify-content-between row text-center text-sm-start">
                                            <div class="col-sm">
                                                <div class="text-muted">
                                                    Hiển thị <span class="fw-semibold">5</span> trong số <span
                                                        class="fw-semibold">25</span> kết quả
                                                </div>
                                            </div>
                                            <div class="col-sm-auto mt-3 mt-sm-0">
                                                <ul
                                                    class="pagination pagination-separated pagination-sm mb-0 justify-content-center">
                                                    <li class="page-item disabled">
                                                        <a href="#" class="page-link">←</a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a href="#" class="page-link">1</a>
                                                    </li>
                                                    <li class="page-item active">
                                                        <a href="#" class="page-link">2</a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a href="#" class="page-link">3</a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a href="#" class="page-link">→</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card card-height-100">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Người bán hàng đầu</h4>
                                        <div class="flex-shrink-0">
                                            <div class="dropdown card-header-dropdown">
                                                <a class="text-reset dropdown-btn" href="#"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted">Báo cáo<i
                                                            class="mdi mdi-chevron-down ms-1"></i></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Tải báo cáo</a>
                                                    <a class="dropdown-item" href="#">Xuất</a>
                                                    <a class="dropdown-item" href="#">Nhập</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div class="table-responsive table-card">
                                            <table class="table table-centered table-hover align-middle table-nowrap mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 me-2">
                                                                    <img src="{{ asset('admin/assets/images/companies/img-1.png') }}"
                                                                        alt="" class="avatar-sm p-2" />
                                                                </div>
                                                                <div>
                                                                    <h5 class="fs-14 my-1 fw-medium">
                                                                        <a href="apps-ecommerce-seller-details.html"
                                                                            class="text-reset">iTest Factory</a>
                                                                    </h5>
                                                                    <span class="text-muted">Oliver Tyler</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">Túi và Ví</span>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0">8547</p>
                                                            <span class="text-muted">Tồn kho</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">$541200</span>
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-14 mb-0">32%<i
                                                                    class="ri-bar-chart-fill text-success fs-16 align-middle ms-2"></i>
                                                            </h5>
                                                        </td>
                                                    </tr><!-- end -->
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 me-2">
                                                                    <img src="{{ asset('admin/assets/images/companies/img-2.png') }}"
                                                                        alt="" class="avatar-sm p-2" />
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <h5 class="fs-14 my-1 fw-medium"><a
                                                                            href="apps-ecommerce-seller-details.html"
                                                                            class="text-reset">Digitech Galaxy</a></h5>
                                                                    <span class="text-muted">John Roberts</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">Đồng hồ</span>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0">895</p>
                                                            <span class="text-muted">Tồn kho</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">$75030</span>
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-14 mb-0">79%<i
                                                                    class="ri-bar-chart-fill text-success fs-16 align-middle ms-2"></i>
                                                            </h5>
                                                        </td>
                                                    </tr><!-- end -->
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 me-2">
                                                                    <img src="{{ asset('admin/assets/images/companies/img-3.png') }}"
                                                                        alt="" class="avatar-sm p-2" />
                                                                </div>
                                                                <div class="flex-gow-1">
                                                                    <h5 class="fs-14 my-1 fw-medium"><a
                                                                            href="apps-ecommerce-seller-details.html"
                                                                            class="text-reset">Nesta Technologies</a></h5>
                                                                    <span class="text-muted">Harley Fuller</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">Phụ kiện xe đạp</span>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0">3470</p>
                                                            <span class="text-muted">Tồn kho</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">$45600</span>
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-14 mb-0">90%<i
                                                                    class="ri-bar-chart-fill text-success fs-16 align-middle ms-2"></i>
                                                            </h5>
                                                        </td>
                                                    </tr><!-- end -->
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 me-2">
                                                                    <img src="{{ asset('admin/assets/images/companies/img-8.png') }}"
                                                                        alt="" class="avatar-sm p-2" />
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <h5 class="fs-14 my-1 fw-medium"><a
                                                                            href="apps-ecommerce-seller-details.html"
                                                                            class="text-reset">Zoetic Fashion</a></h5>
                                                                    <span class="text-muted">James Bowen</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">Quần áo</span>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0">5488</p>
                                                            <span class="text-muted">Tồn kho</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">$29456</span>
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-14 mb-0">40%<i
                                                                    class="ri-bar-chart-fill text-success fs-16 align-middle ms-2"></i>
                                                            </h5>
                                                        </td>
                                                    </tr><!-- end -->
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 me-2">
                                                                    <img src="{{ asset('admin/assets/images/companies/img-5.png') }}"
                                                                        alt="" class="avatar-sm p-2" />
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <h5 class="fs-14 my-1 fw-medium">
                                                                        <a href="apps-ecommerce-seller-details.html"
                                                                            class="text-reset">Meta4Systems</a>
                                                                    </h5>
                                                                    <span class="text-muted">Zoe Dennis</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">Nội thất</span>
                                                        </td>
                                                        <td>
                                                            <p class="mb-0">4100</p>
                                                            <span class="text-muted">Tồn kho</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">$11260</span>
                                                        </td>
                                                        <td>
                                                            <h5 class="fs-14 mb-0">57%<i
                                                                    class="ri-bar-chart-fill text-success fs-16 align-middle ms-2"></i>
                                                            </h5>
                                                        </td>
                                                    </tr><!-- end -->
                                                </tbody>
                                            </table><!-- end table -->
                                        </div>

                                        <div
                                            class="align-items-center mt-4 pt-2 justify-content-between row text-center text-sm-start">
                                            <div class="col-sm">
                                                <div class="text-muted">
                                                    Hiển thị <span class="fw-semibold">5</span> trong số <span
                                                        class="fw-semibold">25</span> kết quả
                                                </div>
                                            </div>
                                            <div class="col-sm-auto mt-3 mt-sm-0">
                                                <ul
                                                    class="pagination pagination-separated pagination-sm mb-0 justify-content-center">
                                                    <li class="page-item disabled">
                                                        <a href="#" class="page-link">←</a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a href="#" class="page-link">1</a>
                                                    </li>
                                                    <li class="page-item active">
                                                        <a href="#" class="page-link">2</a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a href="#" class="page-link">3</a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a href="#" class="page-link">→</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div> <!-- .card-body-->
                                </div> <!-- .card-->
                            </div> <!-- .col-->
                        </div> <!-- end row-->

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card card-height-100">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Lượt truy cập cửa hàng theo nguồn</h4>
                                        <div class="flex-shrink-0">
                                            <div class="dropdown card-header-dropdown">
                                                <a class="text-reset dropdown-btn" href="#"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted">Báo cáo<i
                                                            class="mdi mdi-chevron-down ms-1"></i></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Tải báo cáo</a>
                                                    <a class="dropdown-item" href="#">Xuất</a>
                                                    <a class="dropdown-item" href="#">Nhập</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div id="store-visits-source"
                                            data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'
                                            data-colors-minimal='["--vz-primary", "--vz-primary-rgb, 0.85", "--vz-primary-rgb, 0.70", "--vz-primary-rgb, 0.60", "--vz-primary-rgb, 0.45"]'
                                            data-colors-interactive='["--vz-primary", "--vz-primary-rgb, 0.85", "--vz-primary-rgb, 0.70", "--vz-primary-rgb, 0.60", "--vz-primary-rgb, 0.45"]'
                                            data-colors-galaxy='["--vz-primary", "--vz-primary-rgb, 0.85", "--vz-primary-rgb, 0.70", "--vz-primary-rgb, 0.60", "--vz-primary-rgb, 0.45"]'
                                            class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div> <!-- .card-->
                            </div> <!-- .col-->

                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Đơn hàng gần đây</h4>
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-soft-info btn-sm material-shadow-none">
                                                <i class="ri-file-list-3-line align-middle"></i> Tạo báo cáo
                                            </button>
                                        </div>
                                    </div><!-- end card header -->

                                    <div class="card-body">
                                        <div class="table-responsive table-card">
                                            <table
                                                class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                <thead class="text-muted table-light">
                                                    <tr>
                                                        <th scope="col">Mã đơn hàng</th>
                                                        <th scope="col">Khách hàng</th>
                                                        <th scope="col">Sản phẩm</th>
                                                        <th scope="col">Số tiền</th>
                                                        <th scope="col">Trạng thái</th>
                                                        <th scope="col">Đánh giá</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($recentOrders as $order)
                                                        <tr>
                                                            <td>
                                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                                    class="fw-medium link-primary">{{ $order->order_code }}</a>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0 me-2">
                                                                        <img src="{{ $order->user->avatar ?? asset('admin/assets/images/users/avatar-1.jpg') }}"
                                                                            alt=""
                                                                            class="avatar-xs rounded-circle material-shadow" />
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        {{ $order->customer->user->name }}</div>
                                                                </div>
                                                            </td>
                                                            <td>{{ $order->items_count }} items</td>
                                                            <td>
                                                                <span
                                                                    class="text-success">${{ number_format($order->total_price, 2) }}</span>
                                                            </td>
                                                            {{-- <td>{{ $order->shop_name }}</td> --}}
                                                            <td>
                                                                <span
                                                                    class="badge bg-{{ $order->status_color }}-subtle text-{{ $order->status_color }}">
                                                                    {{ $order->status }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                @if ($order->rating)
                                                                    <h5 class="fs-14 fw-medium mb-0">
                                                                        {{ number_format($order->rating, 1) }}
                                                                        <span
                                                                            class="text-muted fs-11 ms-1">({{ $order->review_count }}
                                                                            votes)</span>
                                                                    </h5>
                                                                @else
                                                                    <span class="text-muted">No rating</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center">No recent orders found
                                                            </td>
                                                        </tr>
                                                    @endforelse

                                                </tbody><!-- end tbody -->
                                            </table><!-- end table -->
                                        </div>
                                    </div>
                                </div> <!-- .card-->
                            </div> <!-- .col-->
                        </div> <!-- end row-->

                    </div> <!-- end .h-100-->

                </div> <!-- end col -->

                <div class="col-auto layout-rightside-col">
                    <div class="overlay"></div>
                    <div class="layout-rightside">
                        <div class="card h-100 rounded-0">
                            <div class="card-body p-0">
                                <div class="p-3">
                                    <h6 class="text-muted mb-0 text-uppercase fw-semibold">Hoạt động gần đây</h6>
                                </div>
                                <div data-simplebar style="max-height: 410px;" class="p-3 pt-0">
                                    <div class="acitivity-timeline acitivity-main">
                                        <div class="acitivity-item d-flex">
                                            <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                                <div
                                                    class="avatar-title bg-success-subtle text-success rounded-circle material-shadow">
                                                    <i class="ri-shopping-cart-2-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 lh-base">Mua hàng bởi James Price</h6>
                                                <p class="text-muted mb-1">Sản phẩm đồng hồ thông minh noise evolve</p>
                                                <small class="mb-0 text-muted">02:14 CH Hôm nay</small>
                                            </div>
                                        </div>
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                                <div
                                                    class="avatar-title bg-danger-subtle text-danger rounded-circle material-shadow">
                                                    <i class="ri-stack-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 lh-base">Thêm mới <span class="fw-semibold">bộ sưu tập
                                                        phong cách</span></h6>
                                                <p class="text-muted mb-1">Bởi Nesta Technologies</p>
                                                <div class="d-inline-flex gap-2 border border-dashed p-2 mb-2">
                                                    <a href="apps-ecommerce-product-details.html"
                                                        class="bg-light rounded p-1">
                                                        <img src="{{ asset('admin/assets/images/products/img-8.png') }}"
                                                            alt="" class="img-fluid d-block" />
                                                    </a>
                                                    <a href="apps-ecommerce-product-details.html"
                                                        class="bg-light rounded p-1">
                                                        <img src="{{ asset('admin/assets/images/products/img-2.png') }}"
                                                            alt="" class="img-fluid d-block" />
                                                    </a>
                                                    <a href="apps-ecommerce-product-details.html"
                                                        class="bg-light rounded p-1">
                                                        <img src="{{ asset('admin/assets/images/products/img-10.png') }}"
                                                            alt="" class="img-fluid d-block" />
                                                    </a>
                                                </div>
                                                <p class="mb-0 text-muted"><small>9:47 Tối Hôm qua</small></p>
                                            </div>
                                        </div>
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('admin/assets/images/users/avatar-2.jpg') }}"
                                                    alt=""
                                                    class="avatar-xs rounded-circle acitivity-avatar material-shadow">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 lh-base">Natasha Carey đã thích sản phẩm</h6>
                                                <p class="text-muted mb-1">Cho phép người dùng thích sản phẩm trong cửa hàng WooCommerce của bạn.</p>
                                                <small class="mb-0 text-muted">25 Th12, 2021</small>
                                            </div>
                                        </div>
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-xs acitivity-avatar">
                                                    <div class="avatar-title rounded-circle bg-secondary material-shadow">
                                                        <i class="mdi mdi-sale fs-14"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 lh-base">Ưu đãi hôm nay bởi <a
                                                        href="apps-ecommerce-seller-details.html"
                                                        class="link-secondary">Digitech Galaxy</a></h6>
                                                <p class="text-muted mb-2">Ưu đãi áp dụng cho đơn hàng từ 500.000 VNĐ trở lên đối với các sản phẩm được chọn.</p>
                                                <small class="mb-0 text-muted">12 Th12, 2021</small>
                                            </div>
                                        </div>
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-xs acitivity-avatar">
                                                    <div
                                                        class="avatar-title rounded-circle bg-danger-subtle text-danger material-shadow">
                                                        <i class="ri-bookmark-fill"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 lh-base">Sản phẩm yêu thích</h6>
                                                <p class="text-muted mb-2">Esther James đã thêm sản phẩm vào yêu thích.</p>
                                                <small class="mb-0 text-muted">25 Th11, 2021</small>
                                            </div>
                                        </div>
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-xs acitivity-avatar">
                                                    <div class="avatar-title rounded-circle bg-secondary material-shadow">
                                                        <i class="mdi mdi-sale fs-14"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 lh-base">Flash sale bắt đầu <span
                                                        class="text-primary">Ngày mai.</span></h6>
                                                <p class="text-muted mb-0">Flash sale bởi <a href="javascript:void(0);"
                                                        class="link-secondary fw-medium">Zoetic Fashion</a></p>
                                                <small class="mb-0 text-muted">22 Th10, 2021</small>
                                            </div>
                                        </div>
                                        <div class="acitivity-item py-3 d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-xs acitivity-avatar">
                                                    <div
                                                        class="avatar-title rounded-circle bg-info-subtle text-info material-shadow">
                                                        <i class="ri-line-chart-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 lh-base">Báo cáo doanh số hàng tháng</h6>
                                                <p class="text-muted mb-2"><span class="text-danger">Còn 2 ngày</span>
                                                    để nộp báo cáo doanh số hàng tháng. <a
                                                        href="javascript:void(0);"
                                                        class="link-warning text-decoration-underline">Trình tạo báo cáo</a>
                                                </p>
                                                <small class="mb-0 text-muted">15 Th10</small>
                                            </div>
                                        </div>
                                        <div class="acitivity-item d-flex">
                                            <div class="flex-shrink-0">
                                                <img src="{{ asset('admin/assets/images/users/avatar-3.jpg') }}"
                                                    alt=""
                                                    class="avatar-xs rounded-circle acitivity-avatar material-shadow" />
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1 lh-base">Frank Hook đã bình luận</h6>
                                                <p class="text-muted mb-2 fst-italic">" Sản phẩm có đánh giá sẽ dễ bán hơn sản phẩm không có đánh giá. "</p>
                                                <small class="mb-0 text-muted">26 Th8, 2021</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 mt-2">
                                    <h6 class="text-muted mb-3 text-uppercase fw-semibold">Top 10 danh mục
                                    </h6>

                                    <ol class="ps-3 text-muted">
                                        <li class="py-1">
                                            <a href="#" class="text-muted">Điện thoại & Phụ kiện <span
                                                    class="float-end">(10,294)</span></a>
                                        </li>
                                        <li class="py-1">
                                            <a href="#" class="text-muted">Máy tính để bàn <span
                                                    class="float-end">(6,256)</span></a>
                                        </li>
                                        <li class="py-1">
                                            <a href="#" class="text-muted">Điện tử <span
                                                    class="float-end">(3,479)</span></a>
                                        </li>
                                        <li class="py-1">
                                            <a href="#" class="text-muted">Nhà cửa & Nội thất <span
                                                    class="float-end">(2,275)</span></a>
                                        </li>
                                        <li class="py-1">
                                            <a href="#" class="text-muted">Tạp hóa <span
                                                    class="float-end">(1,950)</span></a>
                                        </li>
                                        <li class="py-1">
                                            <a href="#" class="text-muted">Thời trang <span
                                                    class="float-end">(1,582)</span></a>
                                        </li>
                                        <li class="py-1">
                                            <a href="#" class="text-muted">Đồ gia dụng <span
                                                    class="float-end">(1,037)</span></a>
                                        </li>
                                        <li class="py-1">
                                            <a href="#" class="text-muted">Làm đẹp, Đồ chơi & Khác <span
                                                    class="float-end">(924)</span></a>
                                        </li>
                                        <li class="py-1">
                                            <a href="#" class="text-muted">Thực phẩm & Đồ uống <span
                                                    class="float-end">(701)</span></a>
                                        </li>
                                        <li class="py-1">
                                            <a href="#" class="text-muted">Đồ chơi & Trò chơi <span
                                                    class="float-end">(239)</span></a>
                                        </li>
                                    </ol>
                                    <div class="mt-3 text-center">
                                        <a href="javascript:void(0);" class="text-muted text-decoration-underline">Xem
                                            tất cả danh mục</a>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <h6 class="text-muted mb-3 text-uppercase fw-semibold">Đánh giá sản phẩm</h6>
                                    <!-- Swiper -->
                                    <div class="swiper vertical-swiper" style="height: 250px;">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="card border border-dashed shadow-none">
                                                    <div class="card-body">
                                                        <div class="d-flex">
                                                            <div class="flex-shrink-0 avatar-sm">
                                                                <div class="avatar-title bg-light rounded material-shadow">
                                                                    <img src="{{ asset('admin/assets/images/companies/img-1.png') }}"
                                                                        alt="" height="30">
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <div>
                                                                    <p
                                                                        class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                                        " Sản phẩm tuyệt vời và trông rất đẹp, nhiều tính năng. "
                                                                    </p>
                                                                    <div class="fs-11 align-middle text-warning">
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="text-end mb-0 text-muted">
                                                                    - bởi <cite title="Source Title">Force Medicines</cite>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="card border border-dashed shadow-none">
                                                    <div class="card-body">
                                                        <div class="d-flex">
                                                            <div class="flex-shrink-0">
                                                                <img src="{{ asset('admin/assets/images/users/avatar-3.jpg') }}"
                                                                    alt=""
                                                                    class="avatar-sm rounded material-shadow">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <div>
                                                                    <p
                                                                        class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                                        " Mẫu tuyệt vời, rất dễ hiểu và tùy chỉnh. "</p>
                                                                    <div class="fs-11 align-middle text-warning">
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-half-fill"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="text-end mb-0 text-muted">
                                                                    - bởi <cite title="Source Title">Henry Baird</cite>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="card border border-dashed shadow-none">
                                                    <div class="card-body">
                                                        <div class="d-flex">
                                                            <div class="flex-shrink-0 avatar-sm">
                                                                <div class="avatar-title bg-light rounded">
                                                                    <img src="{{ asset('admin/assets/images/companies/img-8.png') }}"
                                                                        alt="" height="30">
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <div>
                                                                    <p
                                                                        class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                                        "Sản phẩm rất đẹp và dịch vụ khách hàng rất hữu ích."</p>
                                                                    <div class="fs-11 align-middle text-warning">
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-line"></i>
                                                                        <i class="ri-star-line"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="text-end mb-0 text-muted">
                                                                    - bởi <cite title="Source Title">Zoetic Fashion</cite>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="card border border-dashed shadow-none">
                                                    <div class="card-body">
                                                        <div class="d-flex">
                                                            <div class="flex-shrink-0">
                                                                <img src="{{ asset('admin/assets/images/users/avatar-2.jpg') }}"
                                                                    alt=""
                                                                    class="avatar-sm rounded material-shadow">
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <div>
                                                                    <p
                                                                        class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                                        " Sản phẩm rất đẹp. Tôi thích nó. "</p>
                                                                    <div class="fs-11 align-middle text-warning">
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-fill"></i>
                                                                        <i class="ri-star-half-fill"></i>
                                                                        <i class="ri-star-line"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="text-end mb-0 text-muted">
                                                                    - bởi <cite title="Source Title">Nancy Martino</cite>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3">
                                    <h6 class="text-muted mb-3 text-uppercase fw-semibold">Đánh giá khách hàng</h6>
                                    <div class="bg-light px-3 py-2 rounded-2 mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="fs-16 align-middle text-warning">
                                                    <i class="ri-star-fill"></i>
                                                    <i class="ri-star-fill"></i>
                                                    <i class="ri-star-fill"></i>
                                                    <i class="ri-star-fill"></i>
                                                    <i class="ri-star-half-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h6 class="mb-0">4.5 trên 5</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-muted">Tổng cộng <span class="fw-medium">5.50k</span> đánh giá</div>
                                    </div>

                                    <div class="mt-3">
                                        <div class="row align-items-center g-2">
                                            <div class="col-auto">
                                                <div class="p-1">
                                                    <h6 class="mb-0">5 sao</h6>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-1">
                                                    <div class="progress animated-progress progress-sm">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: 50.16%" aria-valuenow="50.16" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="p-1">
                                                    <h6 class="mb-0 text-muted">2758</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->

                                        <div class="row align-items-center g-2">
                                            <div class="col-auto">
                                                <div class="p-1">
                                                    <h6 class="mb-0">4 sao</h6>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-1">
                                                    <div class="progress animated-progress progress-sm">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: 29.32%" aria-valuenow="29.32" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="p-1">
                                                    <h6 class="mb-0 text-muted">1063</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->

                                        <div class="row align-items-center g-2">
                                            <div class="col-auto">
                                                <div class="p-1">
                                                    <h6 class="mb-0">3 sao</h6>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-1">
                                                    <div class="progress animated-progress progress-sm">
                                                        <div class="progress-bar bg-warning" role="progressbar"
                                                            style="width: 18.12%" aria-valuenow="18.12" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="p-1">
                                                    <h6 class="mb-0 text-muted">997</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->

                                        <div class="row align-items-center g-2">
                                            <div class="col-auto">
                                                <div class="p-1">
                                                    <h6 class="mb-0">2 sao</h6>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-1">
                                                    <div class="progress animated-progress progress-sm">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: 4.98%" aria-valuenow="4.98" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-auto">
                                                <div class="p-1">
                                                    <h6 class="mb-0 text-muted">227</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->

                                        <div class="row align-items-center g-2">
                                            <div class="col-auto">
                                                <div class="p-1">
                                                    <h6 class="mb-0">1 sao</h6>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="p-1">
                                                    <div class="progress animated-progress progress-sm">
                                                        <div class="progress-bar bg-danger" role="progressbar"
                                                            style="width: 7.42%" aria-valuenow="7.42" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="p-1">
                                                    <h6 class="mb-0 text-muted">408</h6>
                                                </div>
                                            </div>
                                        </div><!-- end row -->
                                    </div>
                                </div>

                                <div class="card sidebar-alert bg-light border-0 text-center mx-4 mb-0 mt-3">
                                    <div class="card-body">
                                        <img src="{{ asset('admin/assets/images/giftbox.png') }}" alt="">
                                        <div class="mt-4">
                                            <h5>Mời người bán mới</h5>
                                            <p class="text-muted lh-base">Giới thiệu một người bán mới cho chúng tôi và nhận 100.000 VNĐ cho mỗi lượt giới thiệu.</p>
                                            <button type="button" class="btn btn-primary btn-label rounded-pill"><i
                                                    class="ri-mail-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
                                                Mời ngay</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end .rightbar-->

                </div> <!-- end col -->
            </div>

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

@endsection
@push('scripts')
    @include('admin.layout.component.script')
    <script src="{{ asset('admin/assets/js/revenue.js') }}"></script>
@endpush