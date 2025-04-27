@extends('client.layout.ClientLayout')
@section('title', 'Thanh Toán')
@section('content')
    <section class="top-space-margin half-section bg-gradient-very-light-gray">
        <div class="container">
            <div class="row align-items-center justify-content-center"
                data-anime='{ "el": "childs", "translateY": [-15, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 200, "easing": "easeOutQuad" }'>
                <div class="col-12 col-xl-8 col-lg-10 text-center position-relative page-title-extra-large">
                    <h1 class="alt-font fw-600 text-dark-gray mb-10px">Checkout</h1>
                </div>
                <div class="col-12 breadcrumb breadcrumb-style-01 d-flex justify-content-center">
                    <ul>
                        <li><a href="demo-fashion-store.html">Home</a></li>
                        <li>Checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->
    <!-- start section -->
    <section class="pt-0">
        <div class="container">
            <div class="row justify-content-center mb-8 lg-mb-10 align-items-center">
                <div class="col-auto icon-with-text-style-08 lg-mb-10px">
                    <div class="feature-box feature-box-left-icon">
                        <div class="feature-box-icon me-5px">
                            <i class="feather icon-feather-user top-9px position-relative text-dark-gray icon-small"></i>
                        </div>
                        <div class="feature-box-content">
                            <span class="d-inline-block text-dark-gray align-middle alt-font fw-500">Returning customer? <a
                                    href="#" class="text-decoration-line-bottom fw-600 text-dark-gray">Click here to
                                    login</a></span>
                        </div>
                    </div>
                </div>
                <div class="col-auto d-none d-lg-inline-block">
                    <span class="w-1px h-20px bg-extra-medium-gray d-block"></span>
                </div>
                <div class="col-auto icon-with-text-style-08">
                    <div class="feature-box feature-box-left-icon">
                        <div class="feature-box-icon me-5px">
                            <i
                                class="feather icon-feather-scissors top-9px position-relative text-dark-gray icon-small"></i>
                        </div>
                        <div class="feature-box-content">
                            <span class="d-inline-block text-dark-gray align-middle alt-font fw-500">Have a coupon? <a
                                    href="#" class="text-decoration-line-bottom fw-600 text-dark-gray">Click here to
                                    enter your code</a></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-start">
                <div class="col-lg-7 pe-50px md-pe-15px md-mb-50px xs-mb-35px">
                    <span class="fs-26 alt-font fw-600 text-dark-gray mb-20px d-block">Billing details</span>
                    <form method="POST" action="">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-20px">
                                <label class="mb-10px">Thông tin liên hệ<span class="text-red">*</span></label>
                                <input name="name" class="border-radius-4px input-small" type="text" required
                                    value="{{ old('name') }}" placeholder="Nhập họ tên...">
                            </div>

                            <div class="col-12 mb-20px">
                                {{-- <label class="mb-10px">Số điện thoại <span class="text-red">*</span></label> --}}
                                <input name="phone" class="border-radius-4px input-small" type="text" required
                                    value="{{ old('phone') }}" placeholder="Nhập số điện thoại...">
                            </div>

                            <div class="col-12 mb-20px">
                                <label class="mb-10px">Thông tin địa chỉ <span class="text-red">*</span></label>
                                <input name="country" class="border-radius-4px input-small" type="text" value="Việt Nam"
                                    readonly>
                            </div>

                            <div class="col-12 mb-20px">
                                <!-- Tỉnh -->
                                <select id="province" class="border-radius-4px input-small" required>
                                    <option value="">Chọn tỉnh/thành</option>
                                    <!-- Options sẽ được điền qua JavaScript -->
                                </select>

                                <!-- Quận/Huyện -->
                                <select id="district" class="border-radius-4px input-small" required>
                                    <option value="">Chọn quận/huyện</option>
                                    <!-- Options sẽ được điền qua JavaScript -->
                                </select>

                                <!-- Xã/Phường -->
                                <select id="ward" class="border-radius-4px input-small" required>
                                    <option value="">Chọn xã/phường</option>
                                    <!-- Options sẽ được điền qua JavaScript -->
                                </select>
                                <textarea name="notes" class="border-radius-4px textarea-small" rows="3"
                                    placeholder="Ghi chú địa chỉ...">{{ old('notes') }}</textarea>
                            </div>
                            <div class="col-12 mb-20px">
                                <label class="mb-10px">Ghi chú đơn hàng (không bắt buộc)</label>
                                <textarea name="order_notes" class="border-radius-4px textarea-small" rows="5"
                                    placeholder="Ghi chú cho đơn hàng...">{{ old('order_notes') }}</textarea>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-5">
                    <div class="bg-very-light-gray border-radius-6px p-50px lg-p-25px your-order-box">
                        <span class="fs-26 alt-font fw-600 text-dark-gray mb-5px d-block">Your order</span>
                        <table class="w-100 total-price-table your-order-table">
                            <tbody>
                                <tr>
                                    <th class="w-60 lg-w-55 xs-w-50 fw-600 text-dark-gray alt-font">Product</th>
                                    <td class="fw-600 text-dark-gray alt-font">Total</td>
                                </tr>
                                <tr class="product">
                                    <td class="product-thumbnail">
                                        <a href="demo-jewellery-store-single-product.html"
                                            class="text-dark-gray fw-500 d-block lh-initial">Textured sweater x 1</a>
                                        <span class="fs-14 d-block">Color: Pink</span>
                                    </td>
                                    <td class="product-price" data-title="Price">$23.00</td>
                                </tr>
                               
                               
                                <tr class="shipping">
                                    <th class="fw-600 text-dark-gray alt-font">Shipping</th>
                                    <td data-title="Shipping">
                                        <ul class="p-0">
                                            <li class="d-flex align-items-center">
                                                <input id="free_shipping" type="radio" name="shipping-option"
                                                    class="d-block w-auto mb-0 me-10px p-0" checked="checked">
                                                <label class="md-line-height-18px" for="free_shipping">Free
                                                    shipping</label>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <input id="flat" type="radio" name="shipping-option"
                                                    class="d-block w-auto mb-0 me-10px p-0">
                                                <label class="md-line-height-18px" for="flat">Flat: $12.00</label>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <input id="local_pickup" type="radio" name="shipping-option"
                                                    class="d-block w-auto mb-0 me-10px p-0">
                                                <label class="md-line-height-18px" for="local_pickup">Local pickup</label>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr class="total-amount">
                                    <th class="fw-600 text-dark-gray alt-font">Total</th>
                                    <td data-title="Total">
                                        <h6 class="d-block fw-700 mb-0 text-dark-gray alt-font">$405.00</h6>
                                        <span class="fs-14">(Includes $19.29 tax)</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div
                            class="p-40px lg-p-25px bg-white border-radius-6px box-shadow-large mt-10px mb-30px sm-mb-25px checkout-accordion">
                            <div class="w-100" id="accordion-style-05">
                                <!-- start tab content -->
                                <div class="heading active-accordion">
                                    <label class="mb-5px">
                                        <input class="d-inline w-auto me-5px mb-0 p-0" type="radio"
                                            name="payment-option" checked="checked">
                                        <span class="d-inline-block text-dark-gray fw-500">Direct bank transfer</span>
                                        <a class="accordion-toggle" data-bs-toggle="collapse"
                                            data-bs-parent="#accordion-style-05" href="#style-5-collapse-1"></a>
                                    </label>
                                </div>
                                <div id="style-5-collapse-1" class="collapse show" data-bs-parent="#accordion-style-05">
                                    <div class="p-25px bg-very-light-gray mt-20px mb-20px fs-14 lh-24">Make your payment
                                        directly into our bank account. Please use your Order ID as the payment reference.
                                        Your order will not be shipped until the funds have cleared in our account.</div>
                                </div>
                                <!-- end tab content -->
                                <!-- start tab content -->
                                <div class="heading active-accordion">
                                    <label class="mb-5px">
                                        <input class="d-inline w-auto me-5px mb-0 p-0" type="radio"
                                            name="payment-option">
                                        <span class="d-inline-block text-dark-gray fw-500">Check payments</span>
                                        <a class="accordion-toggle" data-bs-toggle="collapse"
                                            data-bs-parent="#accordion-style-05" href="#style-5-collapse-2"></a>
                                    </label>
                                </div>
                                <div id="style-5-collapse-2" class="collapse" data-bs-parent="#accordion-style-05">
                                    <div class="p-25px bg-very-light-gray mt-20px mb-20px fs-14 lh-24">Please send a check
                                        to store name, store street, store town, store state / county, store postcode.</div>
                                </div>
                                <!-- end tab content -->
                                <!-- start tab content -->
                                <div class="heading active-accordion">
                                    <label class="mb-5px">
                                        <input class="d-inline w-auto me-5px mb-0 p-0" type="radio"
                                            name="payment-option">
                                        <span class="d-inline-block text-dark-gray fw-500">Cash on delivery</span>
                                        <a class="accordion-toggle" data-bs-toggle="collapse"
                                            data-bs-parent="#accordion-style-05" href="#style-5-collapse-3"></a>
                                    </label>
                                </div>
                                <div id="style-5-collapse-3" class="collapse" data-bs-parent="#accordion-style-05">
                                    <div class="p-25px bg-very-light-gray mt-20px mb-20px fs-14 lh-24">Pay with cash upon
                                        delivery.</div>
                                </div>
                                <!-- end tab content -->
                                <!-- start tab content -->
                                <div class="heading active-accordion">
                                    <label class="mb-5px">
                                        <input class="d-inline w-auto me-5px mb-0 p-0" type="radio"
                                            name="payment-option">
                                        <span class="d-inline-block text-dark-gray fw-500">PayPal <img
                                                src="images/paypal-logo.jpg" class="w-120px ms-10px"
                                                alt="" /></span>
                                        <a class="accordion-toggle" data-bs-toggle="collapse"
                                            data-bs-parent="#accordion-style-05" href="#style-5-collapse-4"></a>
                                    </label>
                                </div>
                                <div id="style-5-collapse-4" class="collapse" data-bs-parent="#accordion-style-05">
                                    <div class="p-25px bg-very-light-gray mt-20px fs-14 lh-24">You can pay with your credit
                                        card if you don't have a PayPal account.</div>
                                </div>
                                <!-- end tab content -->
                            </div>
                        </div>
                        <p class="fs-14 lh-24">Your personal data will be used to process your order, support your
                            experience throughout this website, and for other purposes described in our <a
                                class="text-decoration-line-bottom text-dark-gray fw-500" href="#">privacy
                                policy.</a></p>
                        <div class="position-relative terms-condition-box text-start d-flex align-items-center">
                            <label>
                                <input type="checkbox" name="terms_condition" value="1"
                                    class="check-box align-middle">
                                <span class="box fs-14 lh-28">I have agree to the website <a href="#"
                                        class="text-decoration-line-bottom text-dark-gray fw-500">terms and
                                        conditions.</a></span>
                            </label>
                        </div>
                        <a href="#"
                            class="btn btn-dark-gray btn-large btn-switch-text btn-round-edge btn-box-shadow w-100 mt-30px">
                            <span>
                                <span class="btn-double-text" data-text="Place order">Place order</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
