@extends('client.layout.clientlayout')

@section('content')
<section class="page-wrapper bg-primary">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center d-flex align-items-center justify-content-between">
                    <h4 class="text-white mb-0">Order Confirm</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light justify-content-center mb-0 fs-15">
                            <li class="breadcrumb-item"><a href="#!">Shop</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Confirmation</li>
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
<!-- end page title -->

<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center">
                            <img src="{{ asset('client/images/users/avatar-1.jpg') }}" alt="success" class="w-25 rounded-circle">
                        </div>
                        <div class="text-center mt-5 pt-1">
                            <h4 class="mb-3 text-capitalize">Đơn hàng của bạn đã được đặt thành công!</h4>
                            <p class="text-muted mb-2">Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi.</p>
                            <p class="text-muted mb-0 fw-bold">Mã đơn hàng: {{ $order->order_code }}</p>
                        </div>

                        <hr class="my-4">

                        <h5>Thông tin giao hàng</h5>
                        <p class="mb-1"><strong>Họ tên:</strong> {{ $order->shippingAddress->name ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Địa chỉ:</strong> {{ $order->shippingAddress->province ?? 'N/A' }}, {{ $order->shippingAddress->district ?? 'N/A' }}, {{ $order->shippingAddress->ward ?? 'N/A' }}, {{ $order->shippingAddress->country ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Số điện thoại:</strong> {{ $order->shippingAddress->phone ?? 'N/A' }}</p>

                        <hr class="my-4">

                        <h5>Sản phẩm đã đặt</h5>
                        @foreach ($order->items as $item)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <div>
                                    <strong>{{ $item->productVariant->product->name ?? 'Sản phẩm' }}</strong><br>
                                    @if ($item->productVariant)
                                        <small>Phân loại: {{ $item->productVariant->color }} / {{ $item->productVariant->size }}</small>
                                    @endif
                                    <br>
                                    <small>Số lượng: {{ $item->quantity }}</small>
                                </div>
                                <div>
                                   ${{$item->productVariant->product->price * $item->quantity  }}
                                </div>
                            </div>
                           
                        @endforeach
                        

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <span><strong>Tổng tiền:</strong></span>
                            <span><strong>${{ $order->total_price }}</strong></span>
                        </div>

                        <div class="mt-4 pt-2 hstack gap-2 justify-content-center">
                            <a href="" class="btn btn-primary btn-hover">Xem lịch sử đơn hàng <i class="ri-arrow-right-line align-bottom ms-1"></i></a>
                            <a href="{{ route('client.home') }}" class="btn btn-soft-danger btn-hover">Về trang chủ <i class="ri-home-4-line align-bottom ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->
</section>

@endsection
