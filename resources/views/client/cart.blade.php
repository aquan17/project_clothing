@extends('client.layout.ClientLayout')
@section('title', 'Giỏ Hàng')
@section('css')
   <link rel="stylesheet" href="{{ asset('client/css/cart.css') }}">
@section('content')
    <!-- breadcrumb -->
    <section class="page-wrapper bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center d-flex align-items-center justify-content-between">
                        <h4 class="text-white mb-0">Giỏ Hàng</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light justify-content-center mb-0 fs-15">
                                <li class="breadcrumb-item"><a href="#!">Cửa Hàng</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Giỏ Hàng</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section><!--end page-wrapper-->

    <section class="section">
        <div class="container">
            <form action="{{ route('client.checkout.index') }}" method="GET" id="checkout-form">
                @csrf

                <div class="row product-list justify-content-center">
                    {{-- <div class="empty-cart-message text-center fs-16" style="display: none;">
                        Giỏ hàng của bạn đang trống!
                    </div> --}}
                    
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center mb-4">
                            <h5 class="mb-0 flex-grow-1 fw-medium">
                                Có <span class="fw-bold product-count">{{ $cartItems->count() }}</span> sản phẩm trong giỏ
                                hàng của bạn
                            </h5>
                            <div class="flex-shrink-0">
                                <a href="#!" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-2"
                                    id="select-all">
                                    <i class="fas fa-check-square me-1"></i>Chọn Tất Cả
                                </a>
                                <a href="#!" class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                                    id="deselect-all" style="display: none;">
                                    <i class="fas fa-square me-1"></i>Bỏ Chọn Tất Cả
                                </a>
                                <a href="#!" class="btn btn-sm btn-danger rounded-pill px-3" id="clear-cart">
                                    <i class="fas fa-trash-alt me-1"></i>Xóa Giỏ Hàng
                                </a>
                            </div>
                        </div>
                        <p id="cartCleared" class="text-center"></p> <!-- Phần tử để hiển thị thông báo -->
                        <div class="cart-list">
                            @if ($cartItems->isEmpty())
                                <div class="text-center py-5">
                                  
                                    <h4 class="fw-semibold">Giỏ Hàng Của Bạn Hiện Đang Trống</h4>
                                    <p class="text-muted">Hãy thêm sản phẩm vào giỏ hàng của bạn</p>
                                    <a href="{{ route('client.products') }}" class="btn btn-primary">Mua Sắm Ngay</a>
                                </div>
                            @else
                                @foreach ($cartItems as $item)
                                    <div class="card product selectable mb-3" data-id="{{ $item->id }}"
                                        data-price="{{ $item->price }}">
                                        <input type="hidden" name="selected_items[]" class="selected-item-input"
                                            value="{{ $item->id }}">
                                        <div class="card-body p-4">
                                            <div class="row align-items-center">
                                                <div class="col-lg-3 col-md-4">
                                                    <div class="product-img bg-light rounded p-3" style="height: 120px;">
                                                        <img src="{{ asset('client/images/fashion/product/' . $item->productVariant->product->image) }}"
                                                            alt="" class="img-fluid h-100 object-fit-cover">
                                                    </div>
                                                </div>
                                                <div class="col-lg-9 col-md-8">
                                                    <div class="row align-items-center">
                                                        <div class="col-lg-7">
                                                            <div class="product-info">
                                                                <h5 class="fs-16 mb-2">
                                                                    <a href="{{ route('client.products.show', $item->productVariant->product->id) }}"
                                                                        class="text-dark">{{ $item->productVariant->product->name }}</a>
                                                                </h5>
                                                                <div class="product-meta d-flex align-items-center gap-3">
                                                                    <span class="badge bg-soft-primary text-primary">
                                                                        {{ $item->productVariant->color }}
                                                                    </span>
                                                                    <span class="badge bg-soft-info text-info">
                                                                        Size: {{ $item->productVariant->size }}
                                                                    </span>
                                                                </div>
                                                                <div class="mt-3">
                                                                    <div class="input-step custom-input-step">
                                                                        <button type="button" class="minus">–</button>
                                                                        <input type="number" class="product-quantity"
                                                                            value="{{ $item->quantity }}" min="1"
                                                                            max="100" readonly>
                                                                        <button type="button" class="plus">+</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <div class="text-lg-end mt-3 mt-lg-0">
                                                                <h5 class="fs-18 text-primary mb-1">
                                                                    ${{ number_format($item->price, 2) }}
                                                                </h5>
                                                                <p class="text-muted mb-0">
                                                                    Tổng: $<span class="product-line-price fw-medium">
                                                                        {{ number_format($item->price * $item->quantity, 2) }}
                                                                    </span>
                                                                </p>
                                                                <div class="mt-3">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-danger me-2"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#removeItemModal">
                                                                        <i class="ri-delete-bin-line me-1"></i>Xóa
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-soft-secondary">
                                                                        <i class="ri-heart-line me-1"></i>Yêu thích
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>


                        {{-- @php
                        dd($cartItems);
                        @endphp --}}
                    </div>
                    <div class="col-lg-4">
                        <div class="sticky-side-div">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h6 class="mb-3 fs-15">Bạn có <span class="fw-semibold">mã giảm giá</span> không?
                                        </h6>
                                    </div>
                                    <div class="voucher-input-group">
                                        <input type="text" class="form-control" id="voucher-code"
                                            placeholder="Nhập mã giảm giá">
                                        <div class="voucher-buttons">
                                            <button type="button" class="btn btn-primary" id="apply-voucher">
                                                <i class="ri-price-tag-3-line me-1"></i>Áp dụng
                                            </button>

                                            <button type="button" class="btn btn-danger" id="remove-voucher">
                                                Xóa
                                            </button>
                                        </div>
                                    </div>
                                    <div id="voucher-message" class="fs-14 text-danger mt-2"></div>
                                </div>
                            </div>
                            <div class="card overflow-hidden">
                                <div class="card-header border-bottom-dashed">
                                    <h5 class="card-title mb-0 fs-15">Tóm Tắt Đơn Hàng</h5>
                                </div>
                                <div class="card-body pt-4">
                                    <div class="table-responsive table-card">
                                        <table class="table table-borderless mb-0 fs-15">
                                            <tbody>
                                                <tr>
                                                    <td>Tổng phụ:</td>
                                                    <td class="text-end cart-subtotal">$0.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Giảm giá <span class="text-muted" id="voucher-name"></span>:</td>
                                                    <td class="text-end cart-discount">$0.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Phí vận chuyển:</td>
                                                    <td class="text-end cart-shipping">$0.00</td>
                                                </tr>
                                                <tr class="table-active">
                                                    <th>Tổng cộng (USD):</th>
                                                    <td class="text-end">
                                                        <span class="fw-semibold cart-total">$0.00</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="hstack gap-2 justify-content-end">
                                <a href="{{ route('client.products') }}" class="btn btn-hover btn-danger">Tiếp Tục Mua
                                    Sắm</a>
                                <button type="submit" class="btn btn-hover btn-success" id="checkout-button" disabled>
                                    Thanh Toán <i class="ri-logout-box-r-line align-bottom ms-1"></i>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
                <div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 11;"></div>
            </form>
        </div>
        <!--end container-->
    </section>

    <section class="section pt-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-1">
                        <h4 class="flex-grow-1 mb-0">Sản Phẩm Mới Từ Thương Hiệu</h4>
                        <div class="flex-shrink-0">
                            <a href="#!" class="link-effect link-primary">Tất Cả Sản Phẩm <i
                                    class="ri-arrow-right-line ms-1 align-bottom"></i></a>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
            <div class="row">
                <div class="col-xxl-3 col-lg-4 col-md-6">
                    <div
                        class="card ecommerce-product-widgets border-0 rounded-0 shadow-none overflow-hidden card-animate">
                        <div class="bg-light bg-opacity-50 rounded py-4 position-relative">
                            <img src="{{ asset('client/images/products/img-12.png') }}" alt=""
                                style="max-height: 200px;max-width: 100%;" class="mx-auto d-block rounded-2">
                            <div class="action vstack gap-2">
                                <button class="btn btn-danger avatar-xs p-0 btn-soft-warning custom-toggle product-action"
                                    data-bs-toggle="button"><span class="icon-on"><i
                                            class="ri-heart-line"></i></span><span class="icon-off"><i
                                            class="ri-heart-fill"></i></span></button>
                            </div>
                        </div>
                        <div class="pt-4">
                            <ul class="clothe-colors list-unstyled hstack gap-1 mb-3 flex-wrap">
                                <li><input type="radio" name="sizes10" id="product-color-102"><label
                                        class="avatar-xxs btn btn-secondary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                        for="product-color-102"></label></li>
                                <li><input type="radio" name="sizes10" id="product-color-103"><label
                                        class="avatar-xxs btn btn-dark p-0 d-flex align-items-center justify-content-center rounded-circle"
                                        for="product-color-103"></label></li>
                                <li><input type="radio" name="sizes10" id="product-color-104"><label
                                        class="avatar-xxs btn btn-danger p-0 d-flex align-items-center justify-content-center rounded-circle"
                                        for="product-color-104"></label></li>
                                <li><input type="radio" name="sizes10" id="product-color-105"><label
                                        class="avatar-xxs btn btn-light p-0 d-flex align-items-center justify-content-center rounded-circle"
                                        for="product-color-105"></label></li>
                            </ul>
                            <a href="#!">
                                <h6 class="text-capitalize fs-15 lh-base text-truncate mb-0">Ghế Lounge Carven Đỏ</h6>
                            </a>
                            <div class="mt-2">
                                <span class="float-end">4.1 <i
                                        class="ri-star-half-fill text-warning align-bottom"></i></span>
                                <h5 class="mb-0">$209.99</h5>
                            </div>
                            <div class="mt-3">
                                <a href="#!" class="btn btn-primary w-100 add-btn"><i class="mdi mdi-cart me-1"></i>
                                    Thêm Vào Giỏ</a>
                            </div>
                        </div>
                    </div>
                </div><!--end col-->
                <div class="col-xxl-3 col-lg-4 col-md-6">
                    <div
                        class="card ecommerce-product-widgets border-0 rounded-0 shadow-none overflow-hidden card-animate">
                        <div class="bg-light bg-opacity-50 rounded py-4 position-relative">
                            <img src="{{ asset('client/images/products/img-7.png') }}" alt=""
                                style="max-height: 200px;max-width: 100%;" class="mx-auto d-block rounded-2">
                            <div class="action vstack gap-2">
                                <button class="btn btn-danger avatar-xs p-0 btn-soft-warning custom-toggle product-action "
                                    data-bs-toggle="button"><span class="icon-on"><i
                                            class="ri-heart-line"></i></span><span class="icon-off"><i
                                            class="ri-heart-fill"></i></span></button>
                            </div>
                        </div>
                        <div class="pt-4">
                            <div>
                                <div class="avatar-xxs mb-4">
                                    <div class="avatar-title bg-light text-muted rounded cursor-pointer"><i
                                            class="ri-error-warning-line"></i></div>
                                </div>
                                <a href="#!">
                                    <h6 class="text-capitalize fs-15 lh-base text-truncate mb-0">Sách Giáo Dục Sáng Tạo
                                    </h6>
                                </a>
                                <div class="mt-2">
                                    <span class="float-end">4.7 <i
                                            class="ri-star-half-fill text-warning align-bottom"></i></span>
                                    <h5 class="mb-0">$96.26</h5>
                                </div>
                                <div class="mt-3">
                                    <a href="#!" class="btn btn-primary w-100 add-btn"><i
                                            class="mdi mdi-cart me-1"></i> Thêm Vào Giỏ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--end col-->
                <div class="col-xxl-3 col-lg-4 col-md-6">
                    <div
                        class="card ecommerce-product-widgets border-0 rounded-0 shadow-none overflow-hidden card-animate">
                        <div class="bg-light bg-opacity-50 rounded py-4 position-relative">
                            <img src="{{ asset('client/images/products/img-3.png') }}" alt=""
                                style="max-height: 200px;max-width: 100%;" class="mx-auto d-block rounded-2">
                            <div class="action vstack gap-2">
                                <button class="btn btn-danger avatar-xs p-0 btn-soft-warning custom-toggle product-action "
                                    data-bs-toggle="button"><span class="icon-on"><i
                                            class="ri-heart-line"></i></span><span class="icon-off"><i
                                            class="ri-heart-fill"></i></span></button>
                            </div>
                            <div class="avatar-xs label">
                                <div class="avatar-title bg-danger rounded-circle fs-11">20%</div>
                            </div>
                        </div>
                        <div class="pt-4">
                            <ul class="clothe-colors list-unstyled hstack gap-1 mb-3 flex-wrap">
                                <li><input type="radio" name="sizes11" id="product-color-112"><label
                                        class="avatar-xxs btn btn-secondary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                        for="product-color-112"></label></li>
                                <li><input type="radio" name="sizes11" id="product-color-113"><label
                                        class="avatar-xxs btn btn-primary p-0 d-flex align-items-center justify-content-center rounded-circle"
                                        for="product-color-113"></label></li>
                            </ul>
                            <a href="#!">
                                <h6 class="text-capitalize fs-15 lh-base text-truncate mb-0">Đồng Hồ Thông Minh Ninja Pro
                                    Max</h6>
                            </a>
                            <div class="mt-2">
                                <span class="float-end">3.5 <i
                                        class="ri-star-half-fill text-warning align-bottom"></i></span>
                                <h5 class="mb-0">$247.27 <span class="text-muted fs-12"><del>$309.09</del></span></h5>
                            </div>
                            <div class="mt-3">
                                <a href="#!" class="btn btn-primary w-100 add-btn"><i class="mdi mdi-cart me-1"></i>
                                    Thêm Vào Giỏ</a>
                            </div>
                        </div>
                    </div>
                </div><!--end col-->
                <div class="col-xxl-3 col-lg-4 col-md-6">
                    <div
                        class="card ecommerce-product-widgets border-0 rounded-0 shadow-none overflow-hidden card-animate">
                        <div class="bg-light bg-opacity-50 rounded py-4 position-relative">
                            <img src="{{ asset('client/images/products/img-2.png') }}" alt=""
                                style="max-height: 200px;max-width: 100%;" class="mx-auto d-block rounded-2">
                            <div class="action vstack gap-2">
                                <button class="btn btn-danger avatar-xs p-0 btn-soft-warning custom-toggle product-action "
                                    data-bs-toggle="button"><span class="icon-on"><i
                                            class="ri-heart-line"></i></span><span class="icon-off"><i
                                            class="ri-heart-fill"></i></span></button>
                            </div>
                        </div>
                        <div class="pt-4">
                            <ul class="clothe-colors list-unstyled hstack gap-1 mb-3 flex-wrap">
                                <li><input type="radio" name="sizes12" id="product-color-122"><label
                                        class="avatar-xxs btn btn-success p-0 d-flex align-items-center justify-content-center rounded-circle"
                                        for="product-color-122"></label></li>
                            </ul>
                            <a href="#!">
                                <h6 class="text-capitalize fs-15 lh-base text-truncate mb-0">Áo Thun Cổ Tròn Sọc Xanh Lá
                                    Opinion</h6>
                            </a>
                            <div class="mt-2">
                                <span class="float-end">4.1 <i
                                        class="ri-star-half-fill text-warning align-bottom"></i></span>
                                <h5 class="mb-0">$126.99</h5>
                            </div>
                            <div class="mt-3">
                                <a href="#!" class="btn btn-primary btn-hover w-100 add-btn"><i
                                        class="mdi mdi-cart me-1"></i> Thêm Vào Giỏ</a>
                            </div>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end Container-->
    </section>

@endsection
@push('scripts')
    <script src="{{ asset('client/js/cart.js') }}"></script>
@endpush
