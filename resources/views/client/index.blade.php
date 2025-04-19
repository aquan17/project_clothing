@extends('client.layout.index')
@section('product')
<section class="ps-7 pe-7 pb-3 lg-ps-3 lg-pe-3 sm-pb-6 xs-px-0">
    <div class="container">
        <div class="row mb-5 xs-mb-8">
            <div class="col-12 text-center">
                <h2 class="alt-font text-dark-gray mb-0 ls-minus-2px">Best seller <span class="text-highlight fw-600">products<span class="bg-base-color h-5px bottom-2px"></span></span></h2>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <ul class="shop-modern shop-wrapper grid-loading grid grid-4col lg-grid-4col md-grid-3col sm-grid-2col xs-grid-1col gutter-extra-large text-center" data-anime='{ "el": "childs", "translateY": [-15, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 100, "easing": "easeOutQuad" }'>
                    <li class="grid-sizer"></li>
                    <!-- start shop item -->
                    @foreach ( $product as $item)
                    <li class="grid-item">
                        <div class="shop-box mb-10px">
                            <div class="shop-image mb-20px">
                                <a href="demo-fashion-store-single-product.html">
                                    <img src="{{ asset( $item->image)}}" alt=""> 
                                    <span class="lable hot">Hot</span>
                                    <div class="shop-overlay bg-gradient-gray-light-dark-transparent"></div>
                                </a>
                                <div class="shop-buttons-wrap">
                                    <a href="demo-fashion-store-single-product.html" class="alt-font btn btn-small btn-box-shadow btn-white btn-round-edge left-icon add-to-cart">
                                        <i class="feather icon-feather-shopping-bag"></i><span class="quick-view-text button-text">Add to cart</span>
                                    </a>
                                </div>
                                <div class="shop-hover d-flex justify-content-center"> 
                                    <ul>
                                        <li>
                                            <a href="#" class="w-40px h-40px bg-white text-dark-gray d-flex align-items-center justify-content-center rounded-circle ms-5px me-5px" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist"><i class="feather icon-feather-heart fs-16"></i></a>
                                        </li>
                                        <li>
                                            <a href="#" class="w-40px h-40px bg-white text-dark-gray d-flex align-items-center justify-content-center rounded-circle ms-5px me-5px" data-bs-toggle="tooltip" data-bs-placement="left" title="Quick shop"><i class="feather icon-feather-eye fs-16"></i></a>
                                        </li>
                                    </ul> 
                                </div>
                            </div>
                            <div class="shop-footer text-center">
                                <a href="demo-fashion-store-single-product.html" class="alt-font text-dark-gray fs-19 fw-500 product-name">{{ $item->name }}</a>
                                <div class="price lh-22 fs-16">{{ $item->price }} VND</div>
                            </div>
                        </div>
                    </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>
</section>
@endsection