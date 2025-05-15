@extends('client.layout.ClientLayout')
@section('title', 'Thanh Toán')
@section('content')
    <section class="page-wrapper bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center d-flex align-items-center justify-content-between">
                        <h4 class="text-white mb-0">Checkout</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light justify-content-center mb-0 fs-15">
                                <li class="breadcrumb-item"><a href="#!">Shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
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

    <form action="{{ route('client.payment.showPaymentPage') }}" method="GET">
        @csrf
        {{-- <!-- Địa chỉ giao hàng -->
        <input type="hidden" name="shipping_address_id" value="{{ $defaultAddress->id }}"> --}}

        <!-- Danh sách sản phẩm đã chọn -->
        @foreach ($selectedItems as $item)
            <input type="hidden" name="selected_items[]" value="{{ $item->id }}">
        @endforeach

        <!-- Mã voucher, nếu có -->
        <input type="hidden" name="voucher_code" value="{{ session('voucher.code') ?? '' }}">

        <!-- Tổng tiền cuối cùng -->
        <input type="hidden" name="total_price" value="{{ $finalTotal }}">

        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
                            <i class="bi bi-box-arrow-in-right icons"></i>Returning customer?<a
                                href="auth-signin-basic.html" class="link-danger"><strong> Click here to login</strong>.</a>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table align-middle table-borderless table-nowrap text-center mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Product</th>
                                                <th scope="col">Rate</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($selectedItems as $item)
                                                <tr>
                                                    <td class="text-start">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="avatar-sm flex-shrink-0">
                                                                <div class="avatar-title bg-success-subtle rounded-3">
                                                                    <img src="{{ asset('client/images/fashion/product/' . $item->productVariant->product->image) }}"
                                                                        alt="" class="avatar-xs">
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6>{{ $item->productVariant->product->name }}</h6>
                                                                <p class="text-muted mb-0">Color:
                                                                    {{ $item->productVariant->color }} - Size:
                                                                    {{ $item->productVariant->size }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        ${{ $item->productVariant->product->price }}
                                                    </td>
                                                    <td>
                                                        {{ $item->quantity }}
                                                    </td>
                                                    <td class="text-end">
                                                        ${{ $item->productVariant->product->price * $item->quantity }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-2">
                            <div class="d-flex align-items-center mb-4">
                                <div class="flex-grow-1">
                                    <h5 class="mb-0">Shipping Address</h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('address.index') }}"
                                        class="badge bg-secondary-subtle text-secondary  link-secondary">
                                        Add Address
                                    </a>
                                </div>
                            </div>
                            @if ($defaultAddress)
                                {{--  --}}
                                <div class="row gy-3">
                                    <div class="col-12"> {{-- Chỉ hiển thị 1 địa chỉ được chọn --}}
                                        <div class="form-check card-radio">
                                            <input id="shippingAddress_{{ $defaultAddress->id }}"
                                                name="selected_shipping_address_radio" {{-- Đổi tên radio để tránh trùng với input ẩn --}} type="radio"
                                                class="form-check-input" value="{{ $defaultAddress->id }}" checked>
                                            {{-- Luôn check cái này ban đầu --}}
                                            <label class="form-check-label w-100"
                                                for="shippingAddress_{{ $defaultAddress->id }}">
                                                <span class="mb-3 text-uppercase fw-semibold d-block">
                                                    {{ $defaultAddress->is_default ? 'Địa chỉ mặc định' : 'Địa chỉ giao hàng' }}
                                                </span>
                                                <span
                                                    class="fs-14 mb-2 d-block fw-semibold">{{ $defaultAddress->name }}</span>
                                                @php
                                                    $fullAddress = implode(
                                                        ', ',
                                                        array_filter([
                                                            $defaultAddress->notes,
                                                            $defaultAddress->ward,
                                                            $defaultAddress->district,
                                                            $defaultAddress->province,
                                                            $defaultAddress->country,
                                                        ]),
                                                    );
                                                @endphp
                                                <span
                                                    class="text-muted fw-normal text-wrap mb-1 d-block">{{ $fullAddress }}</span>
                                                <span class="text-muted fw-normal d-block">SĐT:
                                                    {{ $defaultAddress->phone }}</span>
                                            </label>
                                        </div>
                                        {{-- Bỏ nút Edit/Remove ở đây, chỉ giữ nút quản lý chung --}}
                                        {{-- <div class="d-flex flex-wrap p-2 py-1 bg-light rounded-bottom border mt-n1"> ... </div> --}}
                                    </div>
                                </div>
                                {{-- Nút để thay đổi địa chỉ (tùy chọn) --}}
                                <div class="mt-3 text-center">
                                    <a href="{{ route('address.index') }}"
                                        class="btn btn-outline-primary btn-sm rounded-pill px-4">
                                        <i class="bi bi-house-gear me-1"></i>
                                        Chọn hoặc thay đổi địa chỉ khác
                                    </a>
                                </div>
                            @else
                                {{-- Không tìm thấy địa chỉ nào --}}
                                <div class="alert alert-warning" role="alert">
                                    Bạn chưa có địa chỉ giao hàng. Vui lòng <a href="{{ route('address.index') }}"
                                        class="alert-link">Thêm địa chỉ mới</a>.
                                </div>
                            @endif

                        </div>


                    </div>
                    <!-- end col -->
                    <div class="col-lg-4">
                        <div class="sticky-side-div">

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
                                                    <td class="text-end">${{ number_format($subtotal, 2) }}</td>
                                                </tr>
                                                {{-- Chỉ hiển thị dòng giảm giá nếu $discountAmount > 0 --}}
                                                @if ($discount > 0)
                                                    <tr>
                                                        <td>
                                                            Giảm giá
                                                            @if ($voucherCode)
                                                                <span class="text-muted">({{ $voucherCode }})</span>
                                                            @endif
                                                            :
                                                        </td>
                                                        <td class="text-end">-${{ number_format($discount, 2) }}</td>
                                                    </tr>
                                                @endif
                                                {{-- Kết thúc kiểm tra hiển thị giảm giá --}}
                                                <tr>
                                                    <td>Phí vận chuyển:</td>
                                                    {{-- Sửa dòng này: Hiển thị $shippingFee từ Controller --}}
                                                    <td class="text-end">${{ number_format($shippingFee ?? 0, 2) }}</td>
                                                </tr>
                                                {{-- Nếu bạn có tính thuế và truyền biến $taxAmount thì thêm dòng tương tự --}}
                                                <tr class="table-active">
                                                    <th>Tổng cộng:</th>
                                                    <td class="text-end">
                                                        {{-- Sửa dòng này: Hiển thị $finalTotal từ Controller --}}
                                                        <span
                                                            class="fw-semibold">${{ number_format($finalTotal, 2) }}</span>
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
                                <button type="submit" class="btn btn-hover btn-success" id="checkout-button">
                                    Check Out <i class="ri-logout-box-r-line align-bottom ms-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div><!--end row-->
                <div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 11;"></div>
            </div><!--end container-->
        </section>
    </form>

@endsection
@push('scripts')
    <script src="{{ asset('client/js/pages/form-wizard.init.js') }}"></script>
    {{-- <script src="{{ asset('client/js/cart.js') }}"></script> --}}
@endpush
