@extends('client.layout.ClientLayout')
@section('title', 'Sản Phẩm')
{{-- @section('header')
    @include('client.layout.components.header1') --}}
@section('content')

<section class="top-space-margin half-section bg-gradient-very-light-gray">
    <div class="container">
        <div class="row align-items-center justify-content-center" data-anime='{ "el": "childs", "translateY": [-15, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 100, "easing": "easeOutQuad" }'>
            <div class="col-12 col-xl-8 col-lg-10 text-center position-relative page-title-extra-large">
                <h1 class="alt-font fw-600 text-dark-gray mb-10px">Shop</h1> 
            </div>
            <div class="col-12 breadcrumb breadcrumb-style-01 d-flex justify-content-center">
                <ul>
                    <li><a href="demo-fashion-store.html">Home</a></li> 
                    <li>Shop</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- end section -->
<!-- start section -->
<section class="pt-0 ps-6 pe-6 lg-ps-2 lg-pe-2 sm-ps-0 sm-pe-0">
    <div class="container-fluid">
        <div class="row flex-row-reverse"> 
            <div class="col-xxl-10 col-lg-9 ps-5 md-ps-15px md-mb-60px">
                <ul class="shop-modern shop-wrapper grid-loading grid grid-4col xl-grid-3col sm-grid-2col xs-grid-1col gutter-extra-large text-center" data-anime='{ "el": "childs", "translateY": [-15, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                    <li class="grid-sizer"></li>
                    <!-- start shop item -->
                    @foreach ($products as $item)
                    <li class="grid-item">
                        <div class="shop-box mb-10px">
                            <div class="shop-image mb-20px">
                                <a href="demo-fashion-store-single-product.html">
                                    <img src="{{ asset($item->image) }}" alt=""> 
                                    <span class="lable new">New</span>
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
                                <a href="{{ route('products.show',$item->id) }}" class="alt-font text-dark-gray fs-19 fw-500 product-name">{{ $item->name }}</a>
                                <div class="price lh-22 fs-16">{{ $item->price }} VND</div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                    <!-- end shop item -->
                   
                </ul>
                <div class="w-100 d-flex mt-4 justify-content-center md-mt-30px">
                    <ul class="pagination pagination-style-01 fs-13 fw-500 mb-0">
                        <!-- Nút Previous -->
                        <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $products->previousPageUrl() }}" {{ $products->onFirstPage() ? 'aria-disabled="true"' : '' }}>
                                <i class="feather icon-feather-arrow-left fs-18 d-xs-none"></i>
                            </a>
                        </li>
                
                        <!-- Các trang -->
                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                            <li class="page-item {{ $products->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $products->url($i) }}">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</a>
                            </li>
                        @endfor
                
                        <!-- Nút Next -->
                        <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $products->nextPageUrl() }}" {{ $products->hasMorePages() ? '' : 'aria-disabled="true"' }}>
                                <i class="feather icon-feather-arrow-right fs-18 d-xs-none"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xxl-2 col-lg-3 shop-sidebar" data-anime='{ "el": "childs", "translateY": [-15, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                {{-- Filter by Category --}}
                <div class="mb-30px">
                    <span class="alt-font fw-500 fs-19 text-dark-gray d-block mb-10px">Filter by categories</span>
                    <ul class="shop-filter category-filter fs-16">
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ request()->fullUrlWithQuery(['category' => $category->slug]) }}">
                                    <span class="product-cb product-category-cb {{ request('category') == $category->slug ? 'active' : '' }}"></span>
                                    {{ $category->name }}
                                </a>
                                <span class="item-qty">{{ $category->products_count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            
                {{-- Filter by Color --}}
                <div class="mb-30px">
                    <span class="alt-font fw-500 fs-19 text-dark-gray d-block mb-10px">Filter by color</span>
                    <ul class="shop-filter color-filter fs-16">
                        @foreach ($colors as $color)
                            <li>
                                <a href="{{ request()->fullUrlWithQuery(['color' => $color]) }}">
                                    <span class="product-cb product-color-cb {{ request('color') == $color ? 'active' : '' }}" style="background-color: {{ strtolower($color) }}"></span>
                                    {{ ucfirst($color) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            
                {{-- Filter by Size --}}
                <div class="mb-30px">
                    <span class="alt-font fw-500 fs-19 text-dark-gray d-block mb-10px">Filter by size</span>
                    <ul class="shop-filter price-filter fs-16">
                        @foreach ($sizes as $size)
                            <li>
                                <a href="{{ request()->fullUrlWithQuery(['size' => $size]) }}">
                                    <span class="product-cb product-category-cb {{ request('size') == $size ? 'active' : '' }}"></span>
                                    {{ strtoupper($size) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
</section>
    
@endsection