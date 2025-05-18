@extends('client.layout.ClientLayout')

@section('content')
    <section class="page-wrapper bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center d-flex align-items-center justify-content-between">
                        <h4 class="text-white mb-0">Phương Thức Thanh Toán</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light justify-content-center mb-0 fs-15">
                                <li class="breadcrumb-item"><a href="#!">Cửa Hàng</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Thanh Toán</li>
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
                            Tiết kiệm đến <b>30%</b> - <b>40%</b>! Nhanh tay với <b>ưu đãi hấp dẫn</b>!
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
                        <h5 class="mb-0 flex-grow-1">Chọn Phương Thức Thanh Toán</h5>
                        <input type="hidden" name="payment_method" id="payment_method" value="cod">
                        <input type="hidden" name="payment_method" id="payment_method" value="momo">
                        <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3 mt-4 nav-justified custom-nav"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active py-3" data-bs-toggle="tab" href="#paypal" role="tab"
                                    data-method="paypal">
                                    <span class="d-block d-sm-none"><i class="ri-paypal-fill align-bottom"></i></span>
                                    <span class="d-none d-sm-block"><i class="ri-paypal-fill align-bottom pe-2"></i>
                                        PayPal</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link py-3" data-bs-toggle="tab" href="#credit" role="tab"
                                    data-method="credit_card">
                                    <span class="d-block d-sm-none"><i class="ri-bank-card-fill align-bottom"></i></span>
                                    <span class="d-none d-sm-block"> <i class="ri-bank-card-fill align-bottom pe-2"></i>
                                        Thẻ Tín Dụng / Ghi Nợ</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link py-3" data-bs-toggle="tab" href="#cash" role="tab"
                                    data-method="cash">
                                    <span class="d-block d-sm-none"><i
                                            class="ri-money-dollar-box-fill align-bottom"></i></span>
                                    <span class="d-none d-sm-block"> <i
                                            class="ri-money-dollar-box-fill align-bottom pe-2"></i> Thanh Toán Khi Nhận
                                        Hàng</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3" data-bs-toggle="tab" href="#momo" role="tab"
                                    data-method="momo">
                                    <span class="d-block d-sm-none"><i class="ri-smartphone-fill align-bottom"></i></span>
                                    <span class="d-none d-sm-block">
                                        <i class="ri-smartphone-fill align-bottom pe-2"></i> Momo
                                    </span>
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
                                                <label for="buyers-name" class="form-label">Tên Người Mua</label>
                                                <input type="text" class="form-control" id="buyers-name"
                                                    placeholder="Nhập tên">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="buyers-last" class="form-label">Họ Người Mua</label>
                                                <input type="text" class="form-control" id="buyers-last"
                                                    placeholder="Nhập họ">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="buyers-address" class="form-label">Địa Chỉ Email</label>
                                                <input type="text" class="form-control" id="buyers-address"
                                                    placeholder="Nhập địa chỉ email">
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label">Chọn loại tài khoản PayPal</label>
                                                <div class="d-flex gap-4 mt-1">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="formRadios"
                                                            id="formRadios1" checked>
                                                        <label class="form-check-label" for="formRadios1">
                                                            Nội địa
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="formRadios"
                                                            id="formRadios2">
                                                        <label class="form-check-label" for="formRadios2">
                                                            Quốc tế
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="hstack gap-2 justify-content-end pt-4">
                                            <button type="button" class="btn btn-hover btn-primary"><i
                                                    class="ri-paypal-fill align-bottom align-bottom pe-2"></i> Đăng nhập
                                                PayPal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="tab-pane" id="credit" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row gy-3">
                                            <div class="col-md-12">
                                                <label for="cc-name" class="form-label">Tên Trên Thẻ</label>
                                                <input type="text" class="form-control" id="cc-name"
                                                    placeholder="Nhập tên trên thẻ">
                                                <small class="text-muted">Họ tên đầy đủ như hiển thị trên thẻ</small>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="cc-number" class="form-label">Số Thẻ Tín Dụng</label>
                                                <input type="text" class="form-control" id="cc-number"
                                                    placeholder="xxxx xxxx xxxx xxxx">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="cc-expiration" class="form-label">Ngày Hết Hạn</label>
                                                <input type="text" class="form-control" id="cc-expiration"
                                                    placeholder="MM/YY">
                                            </div>

                                            <div class="col-md-3">
                                                <label for="cc-cvv" class="form-label">Mã CVV</label>
                                                <input type="text" class="form-control" id="cc-cvv"
                                                    placeholder="xxx">
                                            </div>
                                        </div>

                                        <div class="hstack gap-2 justify-content-end pt-4">
                                            <button type="button" class="btn btn-hover w-md btn-primary">Thanh Toán<i
                                                    class="ri-logout-box-r-line align-bottom ms-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

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
                                            <h5 class="fs-16 mb-3">Thanh Toán Khi Nhận Hàng</h5>
                                            <p class="text-muted mt-3 mb-0 w-75 mx-auto">Bạn chỉ cần thanh toán khi nhận
                                                được hàng. Đơn giản, tiện lợi và an toàn!</p>
                                        </div>
                                        <div class="hstack gap-2 justify-content-end pt-3">
                                            <button type="submit" class="btn btn-hover w-md btn-primary">Tiếp Tục<i
                                                    class="ri-logout-box-r-line align-bottom ms-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="momo" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center py-3">
                                            <div class="avatar-md mx-auto mb-4">
                                                <div class="avatar-title bg-pink text-white rounded-circle display-6">
                                                    <i class="ri-smartphone-line"></i>
                                                </div>
                                            </div>
                                            <h5 class="fs-16 mb-3">Thanh Toán Qua Ví Momo</h5>
                                            <p class="text-muted mt-3 mb-0 w-75 mx-auto">
                                                Sau khi nhấn "Thanh Toán", bạn sẽ được chuyển đến cổng Momo để hoàn tất giao
                                                dịch.
                                            </p>
                                        </div>
                                        <div class="hstack gap-2 justify-content-end pt-3">
                                            <button type="submit" class="btn btn-hover w-md btn-pink">
                                                Thanh Toán với Momo <i class="ri-external-link-line align-bottom ms-2"></i>
                                            </button>
                                        </div>
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
                            @endphp
                            <div class="card overflow-hidden">
                                <div class="card-header border-bottom-dashed">
                                    <h5 class="card-title mb-0 fs-15">Tóm Tắt Đơn Hàng</h5>
                                </div>
                                <div class="card-body pt-4">
                                    <div class="table-responsive table-card">
                                        <table class="table table-borderless mb-0 fs-15">
                                            <tbody>
                                                <tr>
                                                    <td>Tổng tiền hàng:</td>
                                                    <td class="text-end">${{ number_format($order['subtotal'], 2) }}</td>
                                                </tr>
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
                                                <tr>
                                                    <td>Phí vận chuyển:</td>
                                                    <td class="text-end">${{ number_format($order['shippingFee'], 2) }}
                                                    </td>
                                                </tr>
                                                <tr class="table-active">
                                                    <th>Tổng cộng:</th>
                                                    <td class="text-end">
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
@endsection
