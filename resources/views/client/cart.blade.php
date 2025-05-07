@extends('client.layout.ClientLayout')
@section('title', 'Giỏ Hàng')

@section('content')
    <!-- breadcrumb -->
    <section class="page-wrapper bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center d-flex align-items-center justify-content-between">
                        <h4 class="text-white mb-0">Shopping Cart</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light justify-content-center mb-0 fs-15">
                                <li class="breadcrumb-item"><a href="#!">Shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-danger text-center text-capitalize mb-4 fs-14">
                            Save up to <b>30%</b> to <b>40%</b> off OMG! Just look at the <b>great deals</b>!
                        </div>
                    </div>
                </div>
                <div class="row product-list justify-content-center">
                    <div class="empty-cart-message text-center fs-16" style="display: none;">
                        Giỏ hàng của bạn đang trống!
                    </div>
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center mb-4">
                            <h5 class="mb-0 flex-grow-1 fw-medium">
                                There are <span class="fw-bold product-count">{{ $cartItems->count() }}</span> products in your cart
                            </h5>
                            <div class="flex-shrink-0">
                                <a href="#!" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-2"
                                    id="select-all">
                                    <i class="fas fa-check-square me-1"></i>Select All
                                </a>
                                <a href="#!" class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                                    id="deselect-all" style="display: none;">
                                    <i class="fas fa-square me-1"></i>Deselect All
                                </a>
                                <a href="#!" class="btn btn-sm btn-danger rounded-pill px-3" id="clear-cart">
                                    <i class="fas fa-trash-alt me-1"></i>Clear Cart
                                </a>
                            </div>
                        </div>
                        <p id="cartCleared" class="text-center"></p> <!-- Phần tử để hiển thị thông báo -->
                      <div class="cart-list">
                        @if ($cartItems->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center">Giỏ Hàng Của Bạn Hiện Đang Trống</td>
                        </tr>
                    @else
                        @foreach ($cartItems as $item)
                            <div class="card product selectable" data-id="{{ $item->id }}" data-price="{{ $item->price }}">
                                <input type="hidden" name="selected_items[]" class="selected-item-input" value="{{ $item->id }}">
                                <div class="card-body p-4">
                                    <div class="row gy-3">
                                        <div class="col-sm-auto">
                                            <div class="avatar-lg h-100">
                                                <div class="avatar-title bg-light rounded py-3">
                                                    <img src="{{ asset('client/images/fashion/product/' . $item->productVariant->product->image) }}"
                                                        alt="" class="avatar-md">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <a
                                                href="{{ route('client.products.show', $item->productVariant->product->id) }}">
                                                <h5 class="fs-16 lh-base mb-1">
                                                    {{ $item->productVariant->product->name }}</h5>
                                            </a>
                                            <ul class="list-inline text-muted fs-13 mb-3">
                                                <li class="list-inline-item">Color: <span
                                                        class="fw-medium">{{ $item->productVariant->color }}</span></li>
                                                <li class="list-inline-item">Size: <span
                                                        class="fw-medium">{{ $item->productVariant->size }}</span></li>
                                            </ul>
                                            <div class="input-step">
                                                <button type="button" class="minus">–</button>
                                                <input type="number" class="product-quantity"
                                                    value="{{ $item->quantity }}" min="1" max="100"
                                                    readonly>
                                                <button type="button" class="plus">+</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto text-lg-end">
                                            <p class="text-muted mb-1 fs-12">Item Price:</p>
                                            <h5 class="fs-16">${{ number_format($item->price, 2) }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row align-items-center gy-3">
                                        <div class="col-sm">
                                            <div class="d-flex flex-wrap my-n1">
                                                <div>
                                                    <a href="#!" class="d-block text-body p-1 px-2"
                                                        data-bs-toggle="modal" data-bs-target="#removeItemModal">
                                                        <i class="ri-delete-bin-fill text-muted align-bottom me-1"></i>
                                                        Remove</a>
                                                </div>
                                                <div>
                                                    <a href="#!" class="d-block text-body p-1 px-2"><i
                                                            class="ri-star-fill text-muted align-bottom me-1">
                                                        </i> Add Wishlist</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto d-flex align-items-center gap-2 text-muted">
                                            <div>Total:</div>
                                            <h5 class="fs-14 mb-0">
                                                $<span
                                                    class="product-line-price">{{ number_format($item->price * $item->quantity, 2) }}</span>
                                            </h5>
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
                                        <h6 class="mb-3 fs-15">Have a <span class="fw-semibold">promo</span> code?</h6>
                                    </div>
                                    <div class="hstack gap-3 px-3 mx-n3">
                                        <input class="form-control me-auto" type="text" id="voucher-code"
                                            placeholder="Enter coupon code" value="">
                                        <button type="button" class="btn btn-primary w-xs"
                                            id="apply-voucher">Apply</button>
                                        <button class="btn btn-danger" type="button" id="remove-voucher"
                                            style="display: none;">Xóa</button>
                                    </div>
                                    <div id="voucher-message" class="fs-14 text-danger mt-2"></div>
                                </div>
                            </div>
                            <div class="card overflow-hidden">
                                <div class="card-header border-bottom-dashed">
                                    <h5 class="card-title mb-0 fs-15">Order Summary</h5>
                                </div>
                                <div class="card-body pt-4">
                                    <div class="table-responsive table-card">
                                        <table class="table table-borderless mb-0 fs-15">
                                            <tbody>
                                                <tr>
                                                    <td>Sub Total:</td>
                                                    <td class="text-end cart-subtotal">$0.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Discount <span class="text-muted" id="voucher-name"></span>:</td>
                                                    <td class="text-end cart-discount">$0.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping Charge:</td>
                                                    <td class="text-end cart-shipping">$0.00</td>
                                                </tr>
                                                <tr class="table-active">
                                                    <th>Total (USD):</th>
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
                                <a href="{{ route('client.products') }}" class="btn btn-hover btn-danger">Continue
                                    Shopping</a>
                                <button type="submit" class="btn btn-hover btn-success" id="checkout-button" disabled>
                                    Check Out <i class="ri-logout-box-r-line align-bottom ms-1"></i>
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
                        <h4 class="flex-grow-1 mb-0">New Branded Products</h4>
                        <div class="flex-shrink-0">
                            <a href="#!" class="link-effect link-primary">All Products <i
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
                                <h6 class="text-capitalize fs-15 lh-base text-truncate mb-0">Carven Lounge Chair Red</h6>
                            </a>
                            <div class="mt-2">
                                <span class="float-end">4.1 <i
                                        class="ri-star-half-fill text-warning align-bottom"></i></span>
                                <h5 class="mb-0">$209.99</h5>
                            </div>
                            <div class="mt-3">
                                <a href="#!" class="btn btn-primary w-100 add-btn"><i class="mdi mdi-cart me-1"></i>
                                    Add To Cart</a>
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
                                    <h6 class="text-capitalize fs-15 lh-base text-truncate mb-0">Innovative education book
                                    </h6>
                                </a>
                                <div class="mt-2">
                                    <span class="float-end">4.7 <i
                                            class="ri-star-half-fill text-warning align-bottom"></i></span>
                                    <h5 class="mb-0">$96.26</h5>
                                </div>
                                <div class="mt-3">
                                    <a href="#!" class="btn btn-primary w-100 add-btn"><i
                                            class="mdi mdi-cart me-1"></i> Add To Cart</a>
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
                                <h6 class="text-capitalize fs-15 lh-base text-truncate mb-0">Ninja Pro Max Smartwatch</h6>
                            </a>
                            <div class="mt-2">
                                <span class="float-end">3.5 <i
                                        class="ri-star-half-fill text-warning align-bottom"></i></span>
                                <h5 class="mb-0">$247.27 <span class="text-muted fs-12"><del>$309.09</del></span></h5>
                            </div>
                            <div class="mt-3">
                                <a href="#!" class="btn btn-primary w-100 add-btn"><i class="mdi mdi-cart me-1"></i>
                                    Add To Cart</a>
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
                                <h6 class="text-capitalize fs-15 lh-base text-truncate mb-0">Opinion Striped Round Neck
                                    Green T-shirt</h6>
                            </a>
                            <div class="mt-2">
                                <span class="float-end">4.1 <i
                                        class="ri-star-half-fill text-warning align-bottom"></i></span>
                                <h5 class="mb-0">$126.99</h5>
                            </div>
                            <div class="mt-3">
                                <a href="#!" class="btn btn-primary btn-hover w-100 add-btn"><i
                                        class="mdi mdi-cart me-1"></i> Add To Cart</a>
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
