@extends('client.layout.ClientLayout')
@section('title', 'Profile')
@section('content')
    <section class="page-wrapper bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center d-flex align-items-center justify-content-between">
                        <h4 class="text-white mb-0">Order Details</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light justify-content-center mb-0 fs-15">
                                <li class="breadcrumb-item"><a href="{{ route('client.profile') }}">Profile</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Order Details</li>
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
            <div class="card mb-0" id="demo">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-header border-bottom-dashed p-4">
                            <div class="d-sm-flex">
                                <div class="flex-grow-1">
                                    <img src="{{ asset('client/images/logo-dark.png') }}" class="card-logo card-logo-dark"
                                        alt="logo dark" height="26">
                                    <img src="{{ asset('client/images/logo-light.png') }}" class="card-logo card-logo-light"
                                        alt="logo light" height="26">
                                    <div class="mt-sm-5 mt-4">
                                        <h6 class="text-muted text-uppercase fw-semibold fs-14">Country</h6>
                                        <p class="text-muted mb-1">{{ $shippingAddress->country }}</p>

                                    </div>
                                </div>
                                <div class="flex-shrink-0 mt-sm-0 mt-3">
                                    <h6><span class="text-muted fw-normal">Email: quanpc2004@gmail.com</span></h6>
                                    <h6><span class="text-muted fw-normal">Website:</span> <a
                                            href="https://themesbrand.com/" class="link-primary" target="_blank"
                                            id="website">www.themesbrand.com</a></h6>
                                    <h6 class="mb-0"><span class="text-muted fw-normal">Status: </span>
                                        <h6 class="mb-0"><span class="text-muted fw-normal">Contact No: </span><span
                                                id="contact-no">0862579104</span></h6>
                                        <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold fs-14">Invoice No</p>
                                    <h5 class="fs-15 mb-0">{{ $order->order_code }}</h5>
                                </div>
                                <!--end col-->
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold fs-14">Date</p>
                                    <h5 class="fs-15 mb-0"><span
                                            id="invoice-date">{{ $order->created_at->format('d M, Y') }}</span> <small
                                            class="text-muted"
                                            id="invoice-time">{{ $order->created_at->format('H:i') }}</small></h5>
                                </div>
                                <!--end col-->
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold fs-14">Payment Status
                                    </p>
                                    <span class="badge bg-success-subtle text-success "
                                        id="payment-status">{{ ucfirst($order->payment_status) }}</span>
                                </div>
                                <!--end col-->
                                <div class="col-lg-3 col-6">
                                    <p class="text-muted mb-2 text-uppercase fw-semibold fs-14">Total Amount</p>
                                    <h5 class="fs-15 mb-0">$<span id="total-amount">{{ $order->total_price }}</span></h5>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div><!--end col-->
                    <div class="col-lg-12">
                        <div class="card-body p-4 border-top border-top-dashed">
                            <div class="row g-3">

                                <!--end col-->
                                <div class="col-6">
                                    @if (property_exists($shippingAddress, 'is_default') && $shippingAddress->is_default)
                                        <h6 class="text-muted text-uppercase fw-semibold fs-14 mb-3">
                                            {{ $shippingAddress->is_default ? 'Default Address' : 'Shipping Address' }}
                                        </h6>
                                        <p class="fw-medium mb-2 fs-16" id="shipping-name">{{ $shippingAddress->name }}</p>
                                        <p class="text-muted mb-1" id="shipping-address-line-1">
                                            {{ $shippingAddress->address }}</p>
                                        <p class="text-muted mb-1"><span>Phone: +</span><span
                                                id="shipping-phone-no">{{ $shippingAddress->phone }}</span></p>
                                    @endif
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div><!--end col-->
                    <div class="col-lg-12">
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr class="table-active">
                                            <th scope="col" style="width: 50px;">#</th>
                                            <th scope="col">Product Details</th>
                                            <th scope="col">Rate</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col" class="text-end">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->items as $index => $item)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>
                                                    <div class="d-flex gap-3">
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <div class="avatar-title bg-dark-subtle rounded">
                                                                <img src="{{ asset('client/images/fashion/product/' . $item->productVariant->product->image) }}"
                                                                    alt="" class="avatar-xs">
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <a
                                                                href="{{ route('client.products.show', $item->productVariant->product->id) }}">
                                                                <h6 class="fs-16">
                                                                    {{ $item->productVariant->product->name }}</h6>
                                                            </a>
                                                            <p class="mb-0 text-muted fs-13">
                                                                {{ $item->productVariant->product->category->name }},
                                                                {{ $item->productVariant->color }},
                                                                {{ $item->productVariant->size }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>${{ number_format($item->price, 2) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td class="text-end">
                                                    ${{ number_format($item->price * $item->quantity, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="border-top border-top-dashed mt-2">
                                <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto"
                                    style="width:250px">
                                    <tbody>
                                        <tr>
                                            <td>Sub Total</td>
                                            <td class="text-end">${{ number_format($subtotal, 2) }}</td>
                                        </tr>

                                        @if ($discount > 0)
                                            <tr>
                                                <td>Discount</td>
                                                <td class="text-end">- ${{ number_format($discount, 2) }}
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>Shipping</td>
                                            <td class="text-end">${{ number_format($shipping, 2) }}</td>
                                        </tr>
                                        <tr class="border-top border-top-dashed fs-15">
                                            <th scope="row">Total Amount</th>
                                            <th class="text-end">${{ number_format($total, 2) }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <h6 class="text-muted text-uppercase fw-semibold mb-3">Payment Details:</h6>
                                <p class="text-muted mb-1">Payment Method: <span
                                        class="fw-medium">{{ $order->payment_method }}</span></p>
                                <p class="text-muted mb-1">Payment Status: <span
                                        class="fw-medium">{{ ucfirst($order->payment_status) }}</span></p>
                            </div>
                            <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                @if ($order->status == 'pending')
                                    <a href="{{ route('client.profile.cancelled', $order->id) }}" onclick="return confirm('Are you sure you want to cancel this order?')"
                                        class="btn btn-danger"><i class="ri-delete-bin-5-line align-bottom me-1"></i>
                                        Cancel Order</a>
                                @endif
                                <a href="javascript:window.print()" class="btn btn-success"><i
                                        class="ri-printer-line align-bottom me-1"></i> Print</a>
                                <a href="javascript:void(0);" class="btn btn-primary"><i
                                        class="ri-download-2-line align-bottom me-1"></i> Download</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
