@extends('client.layout.trangchu')
@section('product')
    <section class="bg0 p-t-23 p-b-130">
        <div class="container">
            <div class="p-b-10">
                <h3 class="ltext-103 cl5">
                    Product Overview
                </h3>
            </div>

            <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                <a href="{{ route('home') }}"
                    class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ request()->routeIs('client.index') ? 'how-active1' : '' }}">
                    All Products
                </a>


                @foreach ($categories as $category)
                    <a href="{{ route('client.category', $category->id) }}"
                        class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ request()->is("category/{$category->id}") ? 'how-active1' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach

            </div>


            <div class="row isotope-grid">
                @foreach ($product as $item)
                    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                        <!-- Block2 -->
                        <div class="block2">
                            <div class="block2-pic hov-img0 label-new" data-label="New">
                                <img src="{{ asset($item->image) }}" alt="IMG-PRODUCT">

                                <a href="#"
                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                    Quick View
                                </a>
                            </div>

                            <div class="block2-txt flex-w flex-t p-t-14">
                                <div class="block2-txt-child1 flex-col-l ">
                                    <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                        {{ $item->name }}
                                    </a>

                                    <span class="stext-105 cl3">
                                        ${{ $item->price }}
                                    </span>
                                </div>

                                <div class="block2-txt-child2 flex-r p-t-3">
                                    <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                        <img class="icon-heart1 dis-block trans-04"
                                            src="{{ asset('assets/images/icons/icon-hea') }}rt-01.png" alt="ICON">
                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                            src="{{ asset('assets/images/icons/icon-hea') }}rt-02.png" alt="ICON">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>

            <!-- Pagination -->
            @if ($product->hasPages())
                <div class="flex-c-m flex-w w-full p-t-38">

                    {{-- Nút trang trước --}}
                    @if ($product->onFirstPage())
                        <span class="flex-c-m how-pagination1 trans-04 m-all-7 disabled-pagination1">
                            <i class="fa fa-angle-left"></i>
                        </span>
                    @else
                        <a href="{{ $product->previousPageUrl() }}" class="flex-c-m how-pagination1 trans-04 m-all-7">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    @endif

                    {{-- Phân trang logic --}}
                    @php
                        $total = $product->lastPage();
                        $current = $product->currentPage();
                        $max = 5; // số trang muốn hiển thị
                        $half = floor($max / 2);
                        $start = max(1, $current - $half);
                        $end = min($total, $current + $half);

                        if ($start > 1) {
                            echo '<a href="' .
                                $product->url(1) .
                                '" class="flex-c-m how-pagination1 trans-04 m-all-7">1</a>';
                            if ($start > 2) {
                                echo '<span class="flex-c-m how-pagination1 trans-04 m-all-7">...</span>';
                            }
                        }

                        for ($i = $start; $i <= $end; $i++) {
                            $active = $i == $current ? 'active-pagination1' : '';
                            echo '<a href="' .
                                $product->url($i) .
                                '" class="flex-c-m how-pagination1 trans-04 m-all-7 ' .
                                $active .
                                '">' .
                                $i .
                                '</a>';
                        }

                        if ($end < $total) {
                            if ($end < $total - 1) {
                                echo '<span class="flex-c-m how-pagination1 trans-04 m-all-7">...</span>';
                            }
                            echo '<a href="' .
                                $product->url($total) .
                                '" class="flex-c-m how-pagination1 trans-04 m-all-7">' .
                                $total .
                                '</a>';
                        }
                    @endphp

                    {{-- Nút trang tiếp --}}
                    @if ($product->hasMorePages())
                        <a href="{{ $product->nextPageUrl() }}" class="flex-c-m how-pagination1 trans-04 m-all-7">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    @else
                        <span class="flex-c-m how-pagination1 trans-04 m-all-7 disabled-pagination1">
                            <i class="fa fa-angle-right"></i>
                        </span>
                    @endif

                </div>
            @endif

        </div>
    </section>
    {{-- {{$product->links()}} --}}
@endsection
