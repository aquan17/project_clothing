@extends('client.layout.clientlayout')

@section('content')
    <section class="page-wrapper bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center d-flex align-items-center justify-content-between">
                        <h4 class="text-white mb-0">Payment</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light justify-content-center mb-0 fs-15">
                                <li class="breadcrumb-item"><a href="#!">Shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Payment</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>

    <section class="section pb-4">
        <div class="container">
            <form action="{{ route('client.payment.handleCashOnDelivery') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-danger text-center text-capitalize mb-4 fs-14">
                            save up to <b>30%</b> to <b>40%</b> off omg! just look at the <b>great deals</b>!
                        </div>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const paymentTabs = document.querySelectorAll('.nav-link');
                        const paymentMethodInput = document.getElementById('payment_method');

                        paymentTabs.forEach(tab => {
                            tab.addEventListener('click', function() {
                                const selectedMethod = tab.getAttribute('data-method');
                                paymentMethodInput.value = selectedMethod; // Cập nhật giá trị cho hidden input
                                console.log('Selected payment method:',
                                selectedMethod); // Log giá trị để kiểm tra
                            });
                        });

                    });
                </script>
                <div class="row product-list">
                    <div class="col-xl-8">
                        <h5 class="mb-0 flex-grow-1">Payment Selection</h5>
                        <input type="hidden" name="payment_method" id="payment_method" value="cod">
                        <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3 mt-4 nav-justified custom-nav"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active py-3" data-bs-toggle="tab" href="#paypal" role="tab"
                                    data-method="paypal">
                                    <span class="d-block d-sm-none"><i class="ri-paypal-fill align-bottom"></i></span>
                                    <span class="d-none d-sm-block"><i class="ri-paypal-fill align-bottom pe-2"></i>
                                        Paypal</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link py-3" data-bs-toggle="tab" href="#credit" role="tab"
                                    data-method="credit_card">
                                    <span class="d-block d-sm-none"><i class="ri-bank-card-fill align-bottom"></i></span>
                                    <span class="d-none d-sm-block"> <i class="ri-bank-card-fill align-bottom pe-2"></i>
                                        Credit / Debit Card</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link py-3" data-bs-toggle="tab" href="#cash" role="tab"
                                    data-method="cash">
                                    <span class="d-block d-sm-none"><i
                                            class="ri-money-dollar-box-fill align-bottom"></i></span>
                                    <span class="d-none d-sm-block"> <i
                                            class="ri-money-dollar-box-fill align-bottom pe-2"></i> Cash on Delivery</span>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content text-muted">
                            <div class="tab-pane active" id="paypal" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row gy-3">
                                            <div class="col-md-12">
                                                <label for="buyers-name" class="form-label">Buyers First Name</label>
                                                <input type="text" class="form-control" id="buyers-name"
                                                    placeholder="Enter Name">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="buyers-last" class="form-label">Buyers Last Name</label>
                                                <input type="text" class="form-control" id="buyers-last"
                                                    placeholder="Enter Last Name">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="buyers-address" class="form-label">Email Address</label>
                                                <input type="text" class="form-control" id="buyers-address"
                                                    placeholder="Enter Email Address">
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label">Select your paypal account type</label>
                                                <div class="d-flex gap-4 mt-1">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="formRadios"
                                                            id="formRadios1" checked>
                                                        <label class="form-check-label" for="formRadios1">
                                                            Domestic
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="formRadios"
                                                            id="formRadios2">
                                                        <label class="form-check-label" for="formRadios2">
                                                            International
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="hstack gap-2 justify-content-end pt-4">
                                            <button type="button" class="btn btn-hover btn-primary"><i
                                                    class="ri-paypal-fill align-bottom align-bottom pe-2"></i> Log into my
                                                Paypal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="credit" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row gy-3">
                                            <div class="col-md-12">
                                                <label for="cc-name" class="form-label">Name on card</label>
                                                <input type="text" class="form-control" id="cc-name"
                                                    placeholder="Enter name">
                                                <small class="text-muted">Full name as displayed on card</small>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="cc-number" class="form-label">Credit card number</label>
                                                <input type="text" class="form-control" id="cc-number"
                                                    placeholder="xxxx xxxx xxxx xxxx">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="cc-expiration" class="form-label">Expiration</label>
                                                <input type="text" class="form-control" id="cc-expiration"
                                                    placeholder="MM/YY">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="cc-cvv" class="form-label">CVV</label>
                                                <input type="text" class="form-control" id="cc-cvv"
                                                    placeholder="xxx">
                                            </div>
                                        </div>

                                        <div class="hstack gap-2 justify-content-end pt-4">
                                            <button type="button" class="btn btn-hover w-md btn-primary">Pay<i
                                                    class="ri-logout-box-r-line align-bottom ms-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="cash" role="tabpanel">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center py-3">
                                            <div class="avatar-md mx-auto mb-4">
                                                <div
                                                    class="avatar-title bg-primary-subtle text-primary rounded-circle display-6">
                                                    <i class="bi bi-cash"></i>
                                                </div>
                                            </div>
                                            <h5 class="fs-16 mb-3">Cash on Delivery</h5>
                                            <p class="text-muted mt-3 mb-0 w-75 mx-auto">Integer vulputate metus eget purus
                                                maximus porttitor. Maecenas ut porta justo.
                                                Donec finibus nec nibh ut urna viverra semper.</p>
                                        </div>
                                        <div class="hstack gap-2 justify-content-end pt-3">
                                            <button type="submit" class="btn btn-hover w-md btn-primary">Continue<i
                                                    class="ri-logout-box-r-line align-bottom ms-2"></i></button>
                                        </div>
                                        {{-- @error('payment_method')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--end col-->
                    <div class="col-lg-4">
                        <div class="sticky-side-div">
                            @php
                                $order = session('order_info');
                                // dd($order);
                            @endphp
                            <div class="card overflow-hidden">
                                <div class="card-header border-bottom-dashed">
                                    <h5 class="card-title mb-0 fs-15">Order Summary</h5>
                                </div>
                                <div class="card-body pt-4">
                                    <div class="table-responsive table-card">
                                        <table class="table table-borderless mb-0 fs-15">
                                            <tbody>
                                                <tr>
                                                    <td>Tổng tiền hàng:</td>
                                                    {{-- Sửa dòng này: Hiển thị $subtotal từ Controller --}}
                                                    <td class="text-end">${{ number_format($order['subtotal'], 2) }}</td>
                                                </tr>
                                                {{-- Chỉ hiển thị dòng giảm giá nếu $discountAmount > 0 --}}
                                                @if (isset($order['discount']) && $order['discount'] > 0)
                                                    <tr>
                                                        <td>
                                                            Giảm giá
                                                            @if (isset($order['voucherCode']) && $order['voucherCode'])
                                                                <span
                                                                    class="text-muted">({{ $order['voucherCode'] }})</span>
                                                            @endif
                                                            :
                                                        </td>
                                                        <td class="text-end">-${{ number_format($order['discount'], 2) }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                {{-- Kết thúc kiểm tra hiển thị giảm giá --}}
                                                <tr>
                                                    <td>Phí vận chuyển:</td>
                                                    {{-- Sửa dòng này: Hiển thị $shippingFee từ Controller --}}
                                                    <td class="text-end">${{ number_format($order['shippingFee'], 2) }}
                                                    </td>
                                                </tr>
                                                {{-- Nếu bạn có tính thuế và truyền biến $taxAmount thì thêm dòng tương tự --}}
                                                <tr class="table-active">
                                                    <th>Tổng cộng:</th>
                                                    <td class="text-end">
                                                        {{-- Sửa dòng này: Hiển thị $finalTotal từ Controller --}}
                                                        <span
                                                            class="fw-semibold">${{ number_format($order['finalTotal'], 2) }}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!--end row-->
            </form>
        </div>
        <!--end container-->
    </section>

    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-1">
                        <h4 class="flex-grow-1 mb-0">Recently Viewed</h4>
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
        </div><!--end container-->
    </section>
@endsection
