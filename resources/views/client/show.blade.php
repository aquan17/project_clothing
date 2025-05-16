@extends('client.layout.ClientLayout')
@section('title', 'Chi tiết sản phẩm')

@section('content')
    <section class="ecommerce-about"
        style="background-image: url('{{ asset('client/images/profile-bg.jpg') }}'); background-size: cover;background-position: center;">
        <div class="bg-overlay bg-primary" style="opacity: 0.85;"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center">
                        <h1 class="text-white mb-0">Chi tiết sản phẩm</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light justify-content-center mt-4">
                                <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Chi tiết sản phẩm</li>
                            </ol>
                        </nav>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </section>

    <section class="section">
        <div id="toast-message" class="fixed top-5 right-5 z-50 hidden px-4 py-2 rounded text-white shadow-lg transition-all duration-300"></div>
        <div class="container">
            <form id="add-to-cart-form" action="{{ route('client.cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="row gx-2">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-2">
                                <div thumbsSlider="" class="swiper productSwiper mb-3 mb-lg-0">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="product-thumb rounded cursor-pointer">
                                                <img src="{{ asset('client/images/fashion/product/' . $product->image) }}"
                                                    alt="" class="img-fluid" />
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="product-thumb rounded cursor-pointer">
                                                <img src="{{ asset('client/images/fashion/product/' . $product->image) }}"
                                                    alt="" class="img-fluid" />
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="product-thumb rounded cursor-pointer">
                                                <img src="{{ asset('client/images/fashion/product/' . $product->image) }}"
                                                    alt="" class="img-fluid" />
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="product-thumb rounded cursor-pointer">
                                                <img src="{{ asset('client/images/fashion/product/' . $product->image) }}"
                                                    alt="" class="img-fluid" />
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="product-thumb rounded cursor-pointer">
                                                <img src="{{ asset('client/images/fashion/product/' . $product->image) }}"
                                                    class="img-fluid" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <div class="col-md-10">
                                <div class="bg-light rounded-2 position-relative ribbon-box overflow-hidden">
                                    <div class="ribbon ribbon-danger ribbon-shape trending-ribbon">
                                        <span class="trending-ribbon-text">Xu hướng</span> <i
                                            class="ri-flashlight-fill text-white align-bottom float-end ms-1"></i>
                                    </div>
                                    <div class="swiper productSwiper2">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide ">
                                                <img src="{{ asset('client/images/fashion/product/' . $product->image) }}"
                                                    alt="" class="img-fluid" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('client/images/fashion/product/' . $product->image) }}"
                                                    alt="" class="img-fluid" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('client/images/fashion/product/' . $product->image) }}"
                                                    alt="" class="img-fluid" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('client/images/fashion/product/' . $product->image) }}"
                                                    alt="" class="img-fluid" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('client/images/fashion/product/' . $product->image) }}"
                                                    alt="" class="img-fluid" />
                                            </div>
                                        </div>
                                        <div class="swiper-button-next bg-transparent"></div>
                                        <div class="swiper-button-prev bg-transparent"></div>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <div class="mt-3">
                                    <div class="hstack gap-2">
                                        <button type="submit" id="add-to-cart" disabled
                                            class="btn btn-success btn-hover w-100">
                                            <i class="bi bi-basket2 me-2"></i> Thêm vào giỏ hàng
                                        </button>
                                        <button type="button" class="btn btn-primary btn-hover w-100">
                                            <i class="bi bi-cart2 me-2"></i> Mua ngay
                                        </button>
                                        <button class="btn btn-soft-danger custom-toggle btn-hover" data-bs-toggle="button"
                                            aria-pressed="true"> <span class="icon-on"><i class="ri-heart-line"></i></span>
                                            <span class="icon-off"><i class="ri-heart-fill"></i></span> </button>
                                    </div>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end col-->
                    <div class="col-lg-5 ms-auto">
                        <div class="ecommerce-product-widgets mt-4 mt-lg-0">
                            <div class="mb-4">
                                <div class="d-flex gap-3 mb-2">
                                    <div class="fs-15 text-warning">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($averageRating))
                                                <i class="ri-star-fill align-bottom"></i>
                                            @elseif($i == ceil($averageRating) && $averageRating != floor($averageRating))
                                                <i class="ri-star-half-fill align-bottom"></i>
                                            @else
                                                <i class="ri-star-line align-bottom"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="fw-medium"> ({{ $reviewCount }} Review)</span>
                                </div>
                                <h4 class="lh-base mb-1">{{ $product->name }}</h4>
                                <p class="text-muted mb-4">{{ $product->description }} <a href="javascript:void(0);"
                                        class="link-info">Đọc thêm</a></p>
                                <h5 class="fs-24 mb-4">${{ number_format($product->price, 2) }}</h5>
                                <ul class="list-unstyled vstack gap-2">
                                    <li class=""><i
                                            class="bi bi-check2-circle me-2 align-middle text-success"></i>Còn hàng</li>
                                    <li class=""><i
                                            class="bi bi-check2-circle me-2 align-middle text-success"></i>Giao hàng miễn phícó sẵn</li>
                                    <li class=""><i
                                            class="bi bi-check2-circle me-2 align-middle text-success"></i>Giảm giá 10% Sử dụng mã: <b>distinctio</b></li>
                                </ul>
                            </div>
                            <div class="d-flex align-items-center mb-4">
                                <h5 class="fs-15 mb-0">Số lượng:</h5>
                                <div class="input-step ms-2">
                                    <button type="button" class="minus">–</button>
                                    <input type="number" class="product-quantity1" name="quantity" value="1"
                                        min="1" max="100" readonly="">
                                    <button type="button" class="plus">+</button>
                                </div>
                            </div>

                            <div class="row gy-3">
                                <div class="col-md-6">
                                    <div id="size-container">
                                        <h6 class="fs-14 fw-medium text-muted">Kích cỡ:</h6>
                                        <ul class="clothe-size list-unstyled hstack gap-2 mb-0 flex-wrap">
                                            @foreach ($product->variants->pluck('size')->unique() as $size)
                                                <li>
                                                    <input type="radio" name="size" id="size-{{ $size }}"
                                                        value="{{ $size }}">
                                                    <label
                                                        class="avatar-xs btn btn-soft-primary text-uppercase p-0 fs-12 d-flex align-items-center justify-content-center rounded-circle"
                                                        for="size-{{ $size }}">{{ $size }}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="color-container">
                                        <h6 class="fs-14 fw-medium text-muted">Màu: </h6>
                                        <ul class="clothe-colors list-unstyled hstack gap-1 mb-0 flex-wrap ms-2">
                                            @foreach ($product->variants->pluck('color')->unique() as $color)
                                                <li>
                                                    <input type="radio" name="color" id="color-{{ $color }}"
                                                        value="{{ $color }}">
                                                    <label
                                                        class="avatar-xs p-0 d-flex align-items-center justify-content-center rounded-circle"
                                                        style="background-color: {{ $color }};"
                                                        for="color-{{ $color }}"></label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </form>
        </div><!--end container-->
    </section>

    <section class="section pt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs nav-tabs-custom mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                Mô tả
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                               Xếp hạng & Đánh giá
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="home1" role="tabpanel">
                            <table class="table table-sm table-borderless align-middle">
                                <tr>
                                    <th>Danh Mục</th>
                                    <td>{{ $product->category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng Thái</th>
                                    <td>{{ ucfirst($product->status) }}</td>
                                </tr>
                                <tr>
                                    <th>Giá</th>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                </tr>
                            </table>

                            <p class="text-muted fs-15">{{ $product->description }}</p>
                        </div>
                        <div class="tab-pane" id="profile1" role="tabpanel">
                            <div>
                                <div class="d-flex flex-wrap gap-4 justify-content-between align-items-center mt-4">
                                    <div class="flex-shrink-0">
                                        <h5 class="fs-15 mb-3 fw-medium">Tổng đánh giá</h5>
                                        <h2 class="fw-bold mb-3">{{ $reviewCount }}</h2>
                                        <p class="text-muted mb-0">Tăng trưởng trong các đánh giá trong năm nay</p>
                                    </div>
                                    <hr class="vr">
                                    <div class="flex-shrink-0">
                                        <h5 class="fs-15 mb-3 fw-medium">Đánh giá trung bình</h5>
                                        <h2 class="fw-bold mb-3">{{ number_format($averageRating, 1) }} <span
                                                class="fs-16 align-middle text-warning ms-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($averageRating))
                                                        <i class="ri-star-fill"></i>
                                                    @elseif($i == ceil($averageRating) && $averageRating != floor($averageRating))
                                                        <i class="ri-star-half-fill"></i>
                                                    @else
                                                        <i class="ri-star-line"></i>
                                                    @endif
                                                @endfor
                                            </span></h2>
                                        <p class="text-muted mb-0">Đánh giá trung bình trong năm nay</p>
                                    </div>
                                    <hr class="vr">
                                    <div class="flex-shrink-0 w-xl">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <div class="row align-items-center g-3 align-items-center mb-2">
                                                <div class="col-auto">
                                                    <div>
                                                        <h6 class="mb-0 text-muted fs-13"><i
                                                                class="ri-star-fill text-warning me-1 align-bottom"></i>{{ $i }}
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div>
                                                        <div class="progress animated-progress progress-sm">
                                                            <div class="progress-bar bg-primary" role="progressbar"
                                                                style="width: {{ $ratingPercentages[$i] ?? 0 }}%"
                                                                aria-valuenow="{{ $ratingPercentages[$i] ?? 0 }}"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div>
                                                        <h6 class="mb-0 text-muted fs-13">{{ $ratingStats[$i] ?? 0 }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                                <div class="mt-4" data-simplebar style="max-height: 350px">
                                    @foreach ($product->comments as $comment)
                                        <div class="d-flex p-3 border-bottom border-bottom-dashed">
                                            <div class="flex-shrink-0 me-3">
                                                <img class="avatar-xs rounded-circle"
                                                    src="{{ asset('client/images/users/avatar-5.jpg') }}" alt="">
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex mb-3">
                                                    <div class="flex-grow-1">
                                                        <div>
                                                            <div class="mb-2 fs-12">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($i <= $comment->rating)
                                                                        <span><i
                                                                                class="ri-star-fill text-warning align-bottom"></i></span>
                                                                    @else
                                                                        <span><i
                                                                                class="ri-star-line text-warning align-bottom"></i></span>
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                            <h6 class="mb-0">{{ $comment->customer->name }}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <p class="mb-0 text-muted"><i
                                                                class="ri-calendar-event-fill me-2 align-middle"></i>{{ $comment->created_at->format('M d, Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h5 class="lh-base fs-15">{{ $comment->title }}</h5>
                                                    <p class="mb-0">{{ $comment->content }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="pt-3">
                                    <h5 class="fs-18">Thêm đánh giá</h5>
                                    <div>
                                        <form action="{{ route('client.products.review', $product->id) }}" method="POST"
                                            class="form">
                                            @csrf
                                            <div class="d-flex align-items-center mb-3">
                                                <span class="fs-14">Đánh giá của bạn:</span>
                                                <div class="ms-3">
                                                    <select name="rating" class="form-select">
                                                        <option value="5">5 sao</option>
                                                        <option value="4">4 sao</option>
                                                        <option value="3">3 sao</option>
                                                        <option value="2">2 sao</option>
                                                        <option value="1">1 sao</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <textarea class="form-control" name="content" placeholder="Enter your comments & reviews" rows="4" required></textarea>
                                                @error('content')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="text-end">
                                                <button class="btn btn-primary btn-hover" type="submit">Gửi đánh giá <i
                                                        class="ri-send-plane-2-line align-bottom ms-1"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
    </section>

    <div class="position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="mb-4">Bạn có thể quan tâm đến</h4>
                </div><!--end col-->
            </div><!--end row-->
            <div class="row gy-3">
                <div class="col-lg-4">
                    <a href="product-grid-right.html" class="card mb-3 card-animate stretched-link">
                        <div class="row g-0">
                            <div class="col-sm-4">
                                <img src="{{ asset('client/images/ecommerce/img-5.jpg') }}"
                                    class="img-fluid rounded-start h-100 object-fit-cover" alt="...">
                            </div>
                            <div class="col-sm-8">
                                <div class="card-body h-100 d-flex flex-column">
                                    <h6 class="fs-16">Áo phông nữ</h6>
                                    <p class="card-text text-muted">Giảm giá tối thiểu 50%</p>

                                    <div class="mt-auto">
                                        <div class="btn btn-soft-secondary btn-sm">Mua ngay</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div><!--end col-->
                <div class="col-lg-4">
                    <a href="product-grid-right.html" class="card mb-3 card-animate stretched-link">
                        <div class="row g-0">
                            <div class="col-sm-4">
                                <img src="{{ asset('client/images/ecommerce/img-2.jpg') }}"
                                    class="img-fluid rounded-start h-100 object-fit-cover" alt="...">
                            </div>
                            <div class="col-sm-8">
                                <div class="card-body h-100 d-flex flex-column">
                                    <h4 class="fs-16">Thời trang nam</h4>
                                    <p class="card-text text-muted">Giảm giá tối thiểu 20%</p>

                                    <div class="mt-auto">
                                        <div class="btn btn-soft-primary btn-sm">Mua ngay</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4">
                    <a href="product-grid-right.html" class="card mb-3 card-animate stretched-link">
                        <div class="row g-0">
                            <div class="col-sm-4">
                                <img src="{{ asset('client/images/ecommerce/img-3.jpg') }}"
                                    class="img-fluid rounded-start h-100 object-fit-cover" alt="...">
                            </div>
                            <div class="col-sm-8">
                                <div class="card-body h-100 d-flex flex-column">
                                    <h4 class="card-title">Giày nữ</h4>
                                    <p class="card-text text-muted">Giảm giá lên đến 40-50%</p>

                                    <div class="mt-auto">
                                        <div class="btn btn-soft-info btn-sm">Mua ngay</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </div>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-1">
                        <h4 class="flex-grow-1 mb-0">Sản phẩm tương tự</h4>
                        <div class="flex-shrink-0">
                            <a href="{{ route('client.products') }}" class="link-effect link-secondary">Tất cả sản phẩm<i
                                    class="ri-arrow-right-line ms-1 align-bottom"></i></a>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
            <div class="row">
                @foreach ($relatedProducts as $product)
                    <div class="col-xxl-3 col-lg-4 col-sm-6">
                        <div
                            class="card ecommerce-product-widgets border-0 rounded-0 shadow-none overflow-hidden card-animate">
                            <div class="bg-light bg-opacity-50 rounded py-4 position-relative">
                                <img src="{{ asset('client/images/fashion/product/' . $product->image) }}" alt=""
                                    style="max-height: 200px;max-width: 100%;" class="mx-auto d-block rounded-2">
                                <div class="action vstack gap-2">
                                    <button
                                        class="btn btn-danger avatar-xs p-0 btn-soft-warning custom-toggle product-action"
                                        data-bs-toggle="button">
                                        <span class="icon-on"><i class="ri-heart-line"></i></span>
                                        <span class="icon-off"><i class="ri-heart-fill"></i></span>
                                    </button>
                                </div>
                            </div>
                            <div class="pt-4">
                                <a href="{{ route('client.products.show', $product->id) }}">
                                    <h6 class="text-capitalize fs-15 lh-base text-truncate mb-0">{{ $product->name }}</h6>
                                </a>
                                <div class="mt-2">
                                    <span class="float-end">4.1 <i
                                            class="ri-star-half-fill text-warning align-bottom"></i></span>
                                    <h5 class="mb-0">${{ $product->price }}</h5>
                                </div>
                                <div class="mt-3">
                                    <a href="#" class="btn btn-primary w-100 add-btn"><i
                                            class="mdi mdi-cart me-1"></i>  Thêm vào giỏ hàng</a>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                @endforeach
            </div><!--end row-->
        </div><!--end container-->
    </section>
@endsection

<style>

</style>
@push('scripts')
    <script src="{{ asset('client/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('client/js/frontend/product-details.init.js') }}"></script>
@endpush
