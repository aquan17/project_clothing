@extends('client.layout.index')
@section('title', 'Home')
@section('product')

    {{-- 
  <pre>{{ print_r(session()->all(), true) }}</pre> --}}
    <section class="section">
        <div class="container-fluid container-custom">
            <div class="row align-items-center">
                <div class="col-lg-2">
                    <h2 class="title text-capitalize fw-medium lh-base mb-3"><b>Sản Phẩm bán </b>chạy nhất</h2>
                    <a href="{{ route('client.products') }}" class="btn btn-outline-warning btn-hover">Xem tất cả <i
                            class="bi bi-arrow-right"></i></a>
                </div>
                <style>
                    @media (max-width: 991.98px) {
                        .section .col-lg-2 {
                            text-align: center;
                            margin-bottom: 2rem;
                        }

                        .section .title {
                            font-size: 1.5rem;
                            margin-bottom: 1rem !important;
                        }

                        .section .btn-outline-warning {
                            margin-bottom: 2rem !important;
                        }
                    }
                </style>
                <div class="col-lg-10">
                    <!-- Swiper -->
                    <div class="swiper category-slider">
                        <div class="swiper-wrapper">
                            @foreach ($trendingProducts as $sp)
                                <div class="swiper-slide">
                                    <div class="category-widgets-main card border-0 shadow-none bg-light">
                                        <div class="effect">
                                            <img src="{{ asset('client/images/fashion/product/' . $sp->image) }}"
                                                alt="{{ $sp->name }}" class="img-fluid">
                                            <div class="widgets-wrapper position-absolute text-center">
                                                <a href="{{ route('client.products.show', $sp->id) }}"
                                                    class="btn btn-primary w-md rounded-0 stretched-link">
                                                    {{ Str::limit($sp->name, 20) }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section pt-0">
        <div class="container-fluid container-custom">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section-content text-center mb-5">
                        <h2 class="title fw-normal text-capitalize mb-3"><b>Sản Phẩm</b> Thịnh Hành</h2>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
            <div class="row row-cols-xxl-5 row-cols-lg-4 row-cols-md-2 row-cols-2" id="productList">
                @foreach ($product as $item)
                    <div class="col item">
                        <div class="card product-widget border-0 card-animate">
                            <div class="card-body p-2">
                                <div class="position-relative p-4 bg-light">
                                    <img src="{{ asset('client/images/fashion/product/' . $item->image) }}" alt=""
                                        class="img-fluid product-img-main">
                                    <img src="{{ asset('client/images/fashion/product/'.$item->image) }}" alt=""
                                        class="img-fluid product-img-2">
                                    <ul class="product-menu list-unstyled">
                                        <li class="mb-2">
                                            <a href="#!" class="rounded-circle bookmark" data-bs-toggle="button"><i
                                                    class="bi bi-star"></i></a>
                                        </li>
                                        <li>
                                            <a href="{{ route('client.products.show', $item->id) }}"
                                                class="rounded-circle"><i class="bi bi-eye"></i></a>
                                        </li>
                                    </ul>
                                    <div class="product-btn mx-auto">
                                        <a href="{{ route('client.products.show', $item->id) }}" class="btn btn-warning w-100"><i
                                                class="bi bi-bag align-baseline me-1"></i> Xem chi tiết</a>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('client.products.show', $item->id) }}">
                                        <h6 class="text-capitalize fs-17 text-truncate">{{ $item->name }}</h6>
                                    </a>
                                    <h6 class="fw-normal mb-3">${{ $item->price }}</h6>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach ($item->variants->pluck('color')->unique() as $color)
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                title="{{ $color }}" class="color-option">
                                                <button type="button"
                                                    class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 opacity-50"
                                                    style="background-color: {{ $color }}; border-color: {{ $color }};">
                                                    <i class="ri-checkbox-blank-circle-fill"
                                                        style="color: {{ $color }};"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>

                                    <style>
                                        @media (max-width: 575.98px) {
                                            .color-option {
                                                transform: scale(0.8);
                                            }

                                            .btn.avatar-xs {
                                                width: 24px !important;
                                                height: 24px !important;
                                            }

                                            .fs-20 {
                                                font-size: 16px !important;
                                            }

                                            .gap-1 {
                                                gap: 0.25rem !important;
                                            }
                                        }

                                        @media (max-width: 375.98px) {
                                            .color-option {
                                                transform: scale(0.7);
                                            }

                                            .btn.avatar-xs {
                                                width: 25px !important;
                                                height: 25px !important;
                                            }

                                            .fs-20 {
                                                font-size: 14px !important;
                                            }
                                        }
                                    </style>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                @endforeach
            </div><!--end row-->
            <div class="text-center mt-4">
                <a href="{{ route('client.products') }}" type="button" class="btn btn-warning btn-hover">
                    Xem tất cả sản phẩm <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div><!--end container-->
    </section>
@endsection
