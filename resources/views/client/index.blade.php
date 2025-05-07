@extends('client.layout.index')
@section('title', 'Home')
@section('product')
<section class="section pt-0">
    <div class="container-fluid container-custom">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="section-content text-center mb-5">
                    <h2 class="title fw-normal text-capitalize mb-3"><b>Trending</b> Products</h2>
                </div>
            </div><!--end col-->
        </div><!--end row-->
        <div class="row row-cols-xxl-5 row-cols-lg-4 row-cols-md-2 row-cols-1" id="productList">
            @foreach ($product as $item)
            <div class="col item">
                <div class="card product-widget border-0 card-animate">
                    <div class="card-body p-2">
                        <div class="position-relative p-4 bg-light">
                            <img src="{{ asset('client/images/fashion/product/'.$item->image) }}" alt="" class="img-fluid product-img-main">
                            <img src="{{ asset('client/images/fashion/product/img-15.png') }}" alt="" class="img-fluid product-img-2">
                            <ul class="product-menu list-unstyled">
                                <li class="mb-2">
                                    <a href="#!" class="rounded-circle bookmark" data-bs-toggle="button"><i class="bi bi-star"></i></a>
                                </li>
                                <li>
                                    <a href="{{ route('client.products.show', $item->id) }}" class="rounded-circle"><i class="bi bi-eye"></i></a>
                                </li>
                            </ul>
                            <div class="product-btn mx-auto">
                                <a href="shop-cart.html" class="btn btn-warning w-100"><i class="bi bi-bag align-baseline me-1"></i> Buy Now</a>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('client.products.show', $item->id) }}">
                                <h6 class="text-capitalize fs-17 text-truncate">{{ $item->name }}</h6>
                            </a>
                            <h6 class="fw-normal mb-3">${{ $item->price }}</h6>
                            <div class="d-flex flex-wrap gap-1">
                                <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Blue" data-bs-original-title="Blue">
                                    <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-primary opacity-50">
                                        <i class="ri-checkbox-blank-circle-fill"></i>
                                    </button>
                                </div>
                                <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Yellow" data-bs-original-title="Yellow">
                                    <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-warning opacity-50">
                                        <i class="ri-checkbox-blank-circle-fill"></i>
                                    </button>
                                </div>
                                <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Success" data-bs-original-title="Success">
                                    <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-success opacity-50">
                                        <i class="ri-checkbox-blank-circle-fill"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
         
            @endforeach
        </div><!--end row-->
        <div class="text-center mt-4">
            <a href="product-grid-sidebar-banner.html" type="button" class="btn btn-warning btn-hover">
                View All Products <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div><!--end container-->
</section>
@endsection
