@extends('client.layout.ClientLayout')
@section('title', 'Sản Phẩm')

@section('content')
<style>
@media (max-width: 575.98px) {
  .product-card {
    padding: 0.5rem;
  }

  .product-card img {
    max-height: 140px !important;
  }

  .product-card h6 {
    font-size: 13px !important;
  }

  .product-card .btn {
    font-size: 13px !important;
    padding: 6px 8px;
  }

  .product-card .tn {
    margin-top: 0.5rem !important;
  }

  .product-card .float-end,
  .product-card span {
    font-size: 12px !important;
  }
}
</style>

    <section class="section pb-0 mt-4">
        <div class="container-fluid">
            <div class="position-relative rounded-3"
                style="background-image: url('{{ asset('client/images/ecommerce/banner.jpg') }}');background-size: cover;background-position: center;">
                <div class="row justify-content-end">
                    <div class="col-xxl-4">
                        <div class="text-end py-4 px-5 mx-xxl-5">
                            <h1 class="text-white display-5 lh-base text-capitalize ff-secondary mb-3 fst-italic">Âm thanh
                                gốc listem to nature</h1>
                            <div>
                                <a href="#!" class="link-effect link-light text-white">Hiển thị bộ sưu tập <i
                                        class="ri-arrow-right-line align-bottom ms-1"></i></a>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div>
        </div><!--end container-->
    </section>

    <div class="position-relative section">
        <div class="container-fluid">
            <div class="ecommerce-product gap-4">
                <div class="sidebar flex-shrink-0">
                    <div class="card overflow-hidden">
                        <div class="card-header">
                            <div class="d-flex mb-3">
                                <div class="flex-grow-1">
                                    <h5 class="fs-16">
                                        Bộ lọc</h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="#" class="text-decoration-underline" id="clearall">Xóa tất cả</a>
                                </div>
                            </div>
                            <div class="search-box">
                                <input type="text" class="form-control" id="searchProductList" autocomplete="off"
                                    placeholder="Search Products...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="accordion accordion-flush filter-accordion">
                            <!-- Bộ lọc danh mục -->
                            <div class="card-body border-bottom">
                                <div>
                                    <p class="text-muted text-uppercase fs-12 fw-medium mb-3">Danh Mục Sản Phẩm</p>
                                    <ul class="list-unstyled mb-0 filter-list">
                                        @foreach ($categories as $category)
                                            <li>
                                                <a href="#" class="d-flex py-1 align-items-center"
                                                    data-filter="category" data-value="{{ $category->name }}">
                                                    <div class="flex-grow-1">
                                                        <h5 class="fs-13 mb-0 listname">{{ $category->name }}</h5>
                                                    </div>
                                                    @if ($category->products_count > 0)
                                                        <div class="flex-shrink-0 ms-2">
                                                            <span
                                                                class="badge bg-light text-muted">{{ $category->products_count }}</span>
                                                        </div>
                                                    @endif
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <!-- Bộ lọc giá -->
                            <div class="card-body border-bottom">
                                <p class="text-muted text-uppercase fs-12 fw-medium mb-4">Giá</p>
                                <div id="product-price-range" data-slider-color="info"></div>
                                <div class="formCost d-flex gap-2 align-items-center mt-3">
                                    <input class="form-control form-control-sm" type="text" id="minCost"
                                        value="0" />
                                    <span class="fw-semibold text-muted">đến</span>
                                    <input class="form-control form-control-sm" type="text" id="maxCost"
                                        value="1000" />
                                </div>
                            </div>

                            <!-- Bộ lọc màu -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingColors">
                                    <button class="accordion-button bg-transparent shadow-none" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseColors"
                                        aria-expanded="true" aria-controls="flush-collapseColors">
                                        <span class="text-muted text-uppercase fs-12 fw-medium">Màu</span>
                                        <span class="badge bg-success rounded-pill align-middle ms-1 filter-badge"></span>
                                    </button>
                                </h2>
                                <div id="flush-collapseColors" class="accordion-collapse collapse show"
                                    aria-labelledby="flush-headingColors">
                                    <div class="accordion-body text-body pt-0">
                                        <ul class="clothe-colors list-unstyled hstack gap-3 mb-0 flex-wrap"
                                            id="color-filter">
                                            @foreach ($colors as $color)
                                                <li>
                                                    <input type="radio" name="colors" value="{{ $color }}"
                                                        id="color-{{ $color }}">
                                                    <label
                                                        class="avatar-xs p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        style="background-color: {{ $color }}; width: 20px; height: 20px;"
                                                        for="color-{{ $color }}"></label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Bộ lọc kích cỡ -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingSize">
                                    <button class="accordion-button bg-transparent shadow-none" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseSize" aria-expanded="true"
                                        aria-controls="flush-collapseSize">
                                        <span class="text-muted text-uppercase fs-12 fw-medium">Kích cỡ</span>
                                        <span class="badge bg-success rounded-pill align-middle ms-1 filter-badge"></span>
                                    </button>
                                </h2>
                                <div id="flush-collapseSize" class="accordion-collapse collapse show"
                                    aria-labelledby="flush-headingSize">
                                    <div class="accordion-body text-body pt-0">
                                        <ul class="clothe-size list-unstyled hstack gap-3 mb-0 flex-wrap" id="size-filter">
                                            @foreach ($sizes as $size)
                                                <li>
                                                    <input type="radio" name="size" value="{{ $size }}"
                                                        id="size-{{ $size }}">
                                                    <label
                                                        class="avatar-xs btn btn-soft-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="size-{{ $size }}">{{ $size }}</label>
                                                </li>
                                                {{-- @php
                                            dd($size);
                                            @endphp --}}
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Bộ lọc thương hiệu (giữ nguyên hoặc cập nhật nếu có dữ liệu) -->
                           

                            <!-- Bộ lọc đánh giá -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingRating">
                                    <button class="accordion-button bg-transparent shadow-none collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseRating"
                                        aria-expanded="false" aria-controls="flush-collapseRating">
                                        <span class="text-muted text-uppercase fs-12 fw-medium">Đánh giá</span>
                                        <span class="badge bg-success rounded-pill align-middle ms-1 filter-badge"></span>
                                    </button>
                                </h2>
                                <div id="flush-collapseRating" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingRating">
                                    <div class="accordion-body text-body">
                                        <div class="d-flex flex-column gap-2 filter-check" id="rating-filter">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="4"
                                                    id="productratingRadio4">
                                                <label class="form-check-label" for="productratingRadio4">
                                                    <span class="text-muted">
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star"></i>
                                                    </span> 4 & Above
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="3"
                                                    id="productratingRadio3">
                                                <label class="form-check-label" for="productratingRadio3">
                                                    <span class="text-muted">
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                    </span> 3 & Above
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="2"
                                                    id="productratingRadio2">
                                                <label class="form-check-label" for="productratingRadio2">
                                                    <span class="text-muted">
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                    </span> 2 & Above
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="productratingRadio1">
                                                <label class="form-check-label" for="productratingRadio1">
                                                    <span class="text-muted">
                                                        <i class="mdi mdi-star text-warning"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                        <i class="mdi mdi-star"></i>
                                                    </span> 1
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <div class="flex-grow-1" id="col-3-layout">
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <p class="text-muted flex-grow-1 mb-0"></p>

                        <div class="flex-shrink-0">
                            <div class="d-flex gap-2">
                                <div class="flex-shrink-0">
                                    <label for="sort-elem" class="col-form-label">Sắp xếp theo:</label>
                                </div>
                                <div class="flex-shrink-0">
                                    <select class="form-select w-md" id="sort-elem">
                                        <option value="">Tất cả</option>
                                        <option value="low_to_high">Thấp đến Cao</option>
                                        <option value="high_to_low">Cao đến thấp</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="product-grid"></div>

                    <div class="row" id="pagination-element">
                        <div class="col-lg-12">
                            <div
                                class="pagination-block pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0">
                                <div class="page-item">
                                    <a href="javascript:void(0);" class="page-link" id="page-prev">Trước</a>
                                </div>
                                <span id="page-num" class="pagination"></span>
                                <div class="page-item">
                                    <a href="javascript:void(0);" class="page-link" id="page-next">Kế tiếp</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row d-none" id="search-result-elem">
                        <div class="col-lg-12">
                            <div class="text-center py-5">
                                <div class="avatar-lg mx-auto mb-4">
                                    <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-24">
                                        <i class="bi bi-search"></i>
                                    </div>
                                </div>

                                <h4>Không tìm thấy hồ sơ phù hợp</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="offer-bar flex-shrink-0">
                    <div class="d-flex gap-3 flex-column">
                        <div class="card fs-13 border border-primary border-opacity-25">
                            <div class="card-header text-center bg-primary-subtle border-0">
                                <h6 class="card-title text-uppercase fs-13 mb-0 text-primary">Ưu đãi trong tuần</h6>
                            </div>
                            <div class="card-body">
                                <div class="px-5">
                                    <img src="{{ asset('client/images/products/img-16.png') }}" alt=""
                                        class="img-fluid d-block mx-auto">
                                </div>
                                <div class="mt-4 text-center">
                                    <h4 class="text-body mb-3">$63.00 <span
                                            class="text-muted fs-12"><del>$123.99</del></span></h4>
                                    <a href="#!" class="stretched-link">
                                        <h5 class="mb-4">Đồng hồ thông minh Ninja Pro Max</h5>
                                    </a>
                                </div>
                                <div class="progress animated-progress custom-progress">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 60%"
                                        aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-2">
                                    <div class="flex-grow-1 fw-medium fs-12">
                                        <span class="text-muted">Đã bán</span>: 451 Items
                                    </div>
                                    <div class="fw-medium fs-12">
                                        <span class="text-muted">Có sẵn</span>: 90 Items
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="offer-banner rounded-3"
                            style="background-image: url('{{ asset('client/images/ecommerce/offer-banner.jpg') }}');background-size: cover;background-position: center;">
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end conatiner-fluid-->
    </div>

    <section class="section pt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-1">
                        <h3 class="flex-grow-1 mb-0">Ưu đãi trong ngày</h3>
                        <div class="flex-shrink-0">
                            <a href="#!" class="link-effect link-success">Tất cả ưu đãi <i
                                    class="ri-arrow-right-line ms-1 align-bottom"></i></a>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="ecommerce-deals-widgets">
                        <div class="card overflow-hidden mb-0">
                            <div class="gallery-product">
                                <img src="{{ asset('client/images/ecommerce/img-5.jpg') }}" alt=""
                                    class="mx-auto d-block object-fit-cover">
                            </div>
                        </div>
                        <div class="content mx-4">
                            <div class="countdown-deals mb-3">
                                <div data-countdown="Oct 30, 2023" class="countdownlist"></div>
                            </div>
                            <div class="card border-0 p-4 position-relative rounded-3 shadow-lg">
                                <a href="#!">
                                    <h6 class="text-capitalize fs-16 lh-base text-truncate">Chiếc áo phông đắt nhất thế giới
                                    </h6>
                                </a>
                                <p class="text-muted"><i class="ri-star-fill text-warning align-bottom"></i> <i
                                        class="ri-star-fill text-warning align-bottom"></i> <i
                                        class="ri-star-fill text-warning align-bottom"></i> <i
                                        class="ri-star-fill text-warning align-bottom"></i> <i
                                        class="ri-star-half-fill text-warning align-bottom"></i> (4.9)</p>
                                <div class="mt-3 d-flex align-items-center">
                                    <h5 class="text-secondary flex-grow-1 mb-0">$124.99 <span
                                            class="text-muted fs-12"><del>$354.99</del></span></h5>
                                    <a href="#!" class="btn btn-primary btn-sm"><i
                                            class="ri-shopping-bag-line align-bottom me-1"></i> Thêm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--end col-->
                <div class="col-lg-4 col-md-6">
                    <div class="ecommerce-deals-widgets">
                        <div class="card overflow-hidden mb-0">
                            <div class="gallery-product">
                                <img src="{{ asset('client/images/ecommerce/img-3.jpg') }}" alt=""
                                    class="mx-auto d-block object-fit-cover">
                            </div>
                        </div>
                        <div class="content mx-4">
                            <div class="countdown-deals mb-3">
                                <div data-countdown="Oct 23, 2023" class="countdownlist"></div>
                            </div>
                            <div class="card border-0 p-4 position-relative rounded-3 shadow-lg">
                                <a href="#!">
                                    <h6 class="text-capitalize fs-16 lh-base text-truncate">Bộ sưu tập giày dép đẹp nhất</h6>
                                </a>
                                <p class="text-muted"><i class="ri-star-fill text-warning align-bottom"></i> <i
                                        class="ri-star-fill text-warning align-bottom"></i> <i
                                        class="ri-star-fill text-warning align-bottom"></i> <i
                                        class="ri-star-fill text-warning align-bottom"></i> <i
                                        class="ri-star-half-fill text-warning align-bottom"></i> (4.3)</p>
                                <div class="mt-3 d-flex align-items-center">
                                    <h5 class="text-secondary flex-grow-1 mb-0">$80.00 <span
                                            class="text-muted fs-12"><del>$180.00</del></span></h5>
                                    <a href="#!" class="btn btn-primary btn-sm"><i
                                            class="ri-shopping-bag-line align-bottom me-1"></i> Thêm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--end col-->
                <div class="col-lg-4 col-md-6">
                    <div class="ecommerce-deals-widgets">
                        <div class="card overflow-hidden mb-0">
                            <div class="gallery-product">
                                <img src="{{ asset('client/images/ecommerce/img-1.jpg') }}" alt=""
                                    class="mx-auto d-block object-fit-cover">
                            </div>
                        </div>
                        <div class="content mx-4">
                            <div class="countdown-deals mb-3">
                                <div data-countdown="Oct 20, 2023" class="countdownlist"></div>
                            </div>
                            <div class="card border-0 p-4 position-relative rounded-3 shadow-lg">
                                <a href="#!">
                                    <h6 class="text-capitalize fs-16 lh-base text-truncate">Thiết kế trang phục phương Tây thanh lịch
                                    </h6>
                                </a>
                                <p class="text-muted"><i class="ri-star-fill text-warning align-bottom"></i> <i
                                        class="ri-star-fill text-warning align-bottom"></i> <i
                                        class="ri-star-fill text-warning align-bottom"></i> <i
                                        class="ri-star-fill text-warning align-bottom"></i> <i
                                        class="ri-star-half-fill text-warning align-bottom"></i> (5.0)</p>
                                <div class="mt-3 d-flex align-items-center">
                                    <h5 class="text-secondary flex-grow-1 mb-0">$30.10 <span
                                            class="text-muted fs-12"><del>$121.99</del></span></h5>
                                    <a href="#!" class="btn btn-primary btn-sm"><i
                                            class="ri-shopping-bag-line align-bottom me-1"></i> Thêm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </section>



@endsection
@push('scripts')
    <script src="{{ asset('client/libs/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ asset('client/libs/wnumb/wNumb.min.js') }}"></script>
    <script>
        var productListData = @json($products);
    </script>

    <script src="{{ asset('client/js/frontend/product-grid.init.js') }}"></script>
    <script src="{{ asset('client/js/pages/coming-soon.init.js') }}"></script>
@endpush
