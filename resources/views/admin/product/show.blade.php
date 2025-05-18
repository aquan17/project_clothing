@extends('admin.layout.Adminlayout')
@section('title', 'Chi tiết sản phẩm')
@section('css')
    <link href="{{ asset('admin/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Chi tiết sản phẩm</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Thương mại điện tử</a></li>
                            <li class="breadcrumb-item active">Chi tiết sản phẩm</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row gx-lg-5">
                            <div class="col-xl-4 col-md-8 mx-auto">
                                <div class="product-img-slider sticky-side-div">
                                    <div class="swiper product-thumbnail-slider p-2 rounded bg-light">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="{{ asset('client/images/fashion/product/'. $product->image) }}" alt="" class="img-fluid d-block" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('client/images/fashion/product/'. $product->image) }}" alt="" class="img-fluid d-block" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('client/images/fashion/product/'. $product->image) }}" alt="" class="img-fluid d-block" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="{{ asset('client/images/fashion/product/'. $product->image) }}" alt="" class="img-fluid d-block" />
                                            </div>
                                        </div>
                                        <div class="swiper-button-next material-shadow"></div>
                                        <div class="swiper-button-prev material-shadow"></div>
                                    </div>
                                    <!-- end swiper thumbnail slide -->
                                    <div class="swiper product-nav-slider mt-2">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="nav-slide-item">
                                                    <img src="{{ asset('client/images/fashion/product/'. $product->image) }}" alt="" class="img-fluid d-block" />
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="nav-slide-item">
                                                    <img src="{{ asset('client/images/fashion/product/'. $product->image) }}" alt="" class="img-fluid d-block" />
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="nav-slide-item">
                                                    <img src="{{ asset('client/images/fashion/product/'. $product->image) }}" alt="" class="img-fluid d-block" />
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="nav-slide-item">
                                                    <img src="{{ asset('client/images/fashion/product/'. $product->image) }}" alt="" class="img-fluid d-block" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end swiper nav slide -->
                                </div>
                            </div>
                            <!-- end col -->

                            <div class="col-xl-8">
                                <div class="mt-xl-0 mt-5">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <h4>{{ $product->name }}</h4>
                                            <div class="hstack gap-3 flex-wrap">
                                                {{-- <div><a href="#" class="text-primary d-block">{{ $product->brand->name }}</a></div> --}}
                                                <div class="vr"></div>
                                                <div class="text-muted">Người bán : <span class="text-body fw-medium">{{ $product->category->name }}</span></div>
                                                <div class="vr"></div>
                                                <div class="text-muted">Ngày đăng : <span class="text-body fw-medium">{{ $product->created_at->format('d M, Y') }}</span></div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div>
                                                <a href="apps-ecommerce-add-product.html" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Chỉnh sửa"><i class="ri-pencil-fill align-bottom"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                                        <div class="text-warning fs-5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="mdi mdi-star{{ $i <= floor($averageRating) ? '' : '-outline' }}"></i>
                                            @endfor
                                        </div>
                                        <div class="text-muted">
                                            ({{ number_format($reviewCount / 1000, 1) }}k Đánh giá khách hàng)
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="p-2 border border-dashed rounded">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-2">
                                                        <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                            <i class="ri-money-dollar-circle-fill"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted mb-1">Giá :</p>
                                                        <h5 class="mb-0">${{ number_format($product->price, 2) }} </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        {{-- <div class="col-lg-3 col-sm-6">
                                            <div class="p-2 border border-dashed rounded">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-2">
                                                        <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                            <i class="ri-file-copy-2-fill"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted mb-1">Số lượng đơn hàng :</p>
                                                        <h5 class="mb-0">{{ $product->order_count }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <!-- end col -->
                                        <div class="col-lg-3 col-sm-6">
                                            <div class="p-2 border border-dashed rounded">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-2">
                                                        <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                            <i class="ri-stack-fill"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted mb-1">Số lượng tồn kho :</p>
                                                        <h5 class="mb-0">{{ $product->total_stock }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        {{-- <div class="col-lg-3 col-sm-6">
                                            <div class="p-2 border border-dashed rounded">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-2">
                                                        <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                            <i class="ri-inbox-archive-fill"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted mb-1">Tổng doanh thu :</p>
                                                        <h5 class="mb-0">${{ number_format($product->total_revenue, 2) }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <!-- end col -->
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="mt-4">
                                                <h5 class="fs-14">Kích cỡ :</h5>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach ($product->variants->pluck('size')->unique() as $index => $size)
                                                        @php
                                                            $inputId = 'productsize-radio' . ($index + 1);
                                                            $stock = $product->variants->where('size', $size)->sum('stock');
                                                        @endphp
                                                
                                                        <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                            title="{{ $stock > 0 ? $stock . ' Sản phẩm có sẵn' : 'Hết hàng' }}">
                                                            <input type="radio" class="btn-check" name="productsize-radio" id="{{ $inputId }}" {{ $stock <= 0 ? 'disabled' : '' }}>
                                                            <label class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center"
                                                                for="{{ $inputId }}">{{ $size }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <!-- end col -->

                                        <div class="col-xl-6">
                                            <div class=" mt-4">
                                                <h5 class="fs-14">Màu sắc :</h5>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach ($product->variants->pluck('color')->unique() as $color)
                                                        @php
                                                            $stock = $product->variants->where('color', $color)->sum('stock');
                                                            $isSelected = old('color') == $color; // Kiểm tra nếu người dùng đã chọn màu này
                                                        @endphp
                                                
                                                        <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                                            title="{{ $stock > 0 ? $stock . ' Sản phẩm có sẵn' : 'Hết hàng' }}">
                                                            <button type="button"
                                                                class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border-0 rounded-circle fs-20"
                                                                style="background-color: {{ strtolower($color) }}; 
                                                                       width: 33px; height: 33px; 
                                                                       {{ $isSelected ? 'border: 2px solid #000;' : '' }}"
                                                                {{ $stock <= 0 ? 'disabled' : '' }}
                                                                onclick="this.form.color.value='{{ $color }}'"> 
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <div class="mt-4 text-muted">
                                        <h5 class="fs-14">Mô tả :</h5>
                                        <p>{{ $product->description }}</p>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mt-3">
                                                <h5 class="fs-14">Tính năng :</h5>
                                                <ul class="list-unstyled">
                                                    <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Tay dài</li>
                                                    <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Chất liệu cotton</li>
                                                    <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Có đủ kích cỡ</li>
                                                    <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> 4 màu khác nhau</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mt-3">
                                                <h5 class="fs-14">Dịch vụ :</h5>
                                                <ul class="list-unstyled product-desc-list">
                                                    <li class="py-1">Đổi trả trong 10 ngày</li>
                                                    <li class="py-1">Thanh toán khi nhận hàng</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-content mt-5">
                                        <h5 class="fs-14 mb-3">Mô tả sản phẩm :</h5>
                                        <nav>
                                            <ul class="nav nav-tabs nav-tabs-custom nav-success" id="nav-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="nav-speci-tab" data-bs-toggle="tab" href="#nav-speci" role="tab" aria-controls="nav-speci" aria-selected="true">Thông số kỹ thuật</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="false">Chi tiết</a>
                                                </li>
                                            </ul>
                                        </nav>
                                        <div class="tab-content border border-top-0 p-4" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-speci" role="tabpanel" aria-labelledby="nav-speci-tab">
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row" style="width: 200px;">Danh mục</th>
                                                                <td>{{ $product->category->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Thương hiệu</th>
                                                                <td>Tommy Hilfiger</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Màu sắc</th>
                                                                <td>{{ $product->variants->pluck('color')->unique()->implode(', ') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Chất liệu</th>
                                                                <td>Cotton</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Khối lượng</th>
                                                                <td>140 Gram</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">
                                                <div>
                                                    <h5 class="font-size-16 mb-3">Áo len Tommy Hilfiger cho nam (Hồng)</h5>
                                                    <p>Áo len nam Tommy Hilfiger màu hồng sọc. Được làm từ chất liệu cotton. Thành phần chất liệu là 100% cotton hữu cơ. Đây là một trong những thương hiệu phong cách sống hàng đầu thế giới và được công nhận quốc tế vì tôn vinh phong cách cổ điển Mỹ, mang nét trẻ trung với thiết kế độc đáo.</p>
                                                    <div>
                                                        <p class="mb-2"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Giặt máy</p>
                                                        <p class="mb-2"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Kiểu dáng: Thường</p>
                                                        <p class="mb-2"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> 100% Cotton</p>
                                                        <p class="mb-0"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Tay dài</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- product-content -->

                                    <div class="mt-5">
                                        <div>
                                            <h5 class="fs-14 mb-3">Đánh giá & Nhận xét</h5>
                                        </div>
                                        <div class="row gy-4 gx-0">
                                            <div class="col-lg-4">
                                                <div>
                                                    <div class="pb-3">
                                                        <div class="bg-light px-3 py-2 rounded-2 mb-2">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-grow-1">
                                                                    <div class="fs-16 align-middle text-warning">
                                                                        @for ($i = 0; $i < floor($averageRating); $i++)
                                                                            <i class="ri-star-fill"></i>
                                                                        @endfor
                                                                        @if ($averageRating - floor($averageRating) > 0)
                                                                            <i class="ri-star-half-fill"></i>
                                                                        @endif
                                                                        @for ($i = 0; $i < 5 - ceil($averageRating); $i++)
                                                                            <i class="ri-star-line"></i>
                                                                        @endfor
                                                                    </div>
                                                                </div>
                                                                <div class="flex-shrink-0">
                                                                    <h6 class="mb-0">{{ number_format($averageRating, 1) }} trên 5</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <div class="text-muted">Tổng cộng <span class="fw-medium">{{ $reviewCount }} đánh giá</span></div>
                                                        </div>
                                                    </div>
                                        
                                                    <!-- Progress bars for reviews -->
                                                    @foreach([5, 4, 3, 2, 1] as $star)
                                                        @php
                                                            $starCount = $product->ratings->where('rating', $star)->count();
                                                            $percentage = ($starCount / $reviewCount) * 100;
                                                        @endphp
                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0">{{ $star }} sao</h6>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="p-2">
                                                                    <div class="progress animated-progress progress-sm">
                                                                        <div class="progress-bar bg-{{ $star == 5 ? 'success' : ($star == 4 ? 'info' : ($star == 3 ? 'warning' : 'danger')) }}" role="progressbar" style="width: {{ number_format($percentage, 2) }}%" aria-valuenow="{{ number_format($percentage, 2) }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="p-2">
                                                                    <h6 class="mb-0 text-muted">{{ $starCount }}</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        
                                            <div class="col-lg-8">
                                                <div class="ps-lg-4">
                                                    <div class="d-flex flex-wrap align-items-start gap-3">
                                                        <h5 class="fs-14">Nhận xét: </h5>
                                                    </div>
                                        
                                                    <div class="me-lg-n3 pe-lg-4" data-simplebar style="max-height: 225px;">
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($product->comments as $comment)
                                                                <li class="py-2">
                                                                    <div class="border border-dashed rounded p-3">
                                                                        <div class="d-flex align-items-start mb-3">
                                                                            <div class="hstack gap-3">
                                                                                <div class="badge rounded-pill bg-success mb-0">
                                                                                    <i class="mdi mdi-star"></i> {{ $comment->rating }}
                                                                                </div>
                                                                                <div class="vr"></div>
                                                                                <div class="flex-grow-1">
                                                                                    <p class="text-muted mb-0">{{ $comment->content }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                        
                                                                        <div class="d-flex align-items-end">
                                                                            <div class="flex-grow-1">
                                                                                <h5 class="fs-14 mb-0">{{ $comment->customer->name }}</h5>
                                                                            </div>
                                        
                                                                            <div class="flex-shrink-0">
                                                                                <p class="text-muted fs-13 mb-0">{{ $comment->created_at->format('d M, Y') }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- end Ratings & Reviews -->
                                    </div>
                                    <!-- end card body -->
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </div>
    <!-- container-fluid -->
</div>

@endsection
@push('scripts')
    <script src="{{ asset('admin/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- ecommerce product details init -->
    <script src="{{ asset('admin/assets/js/pages/ecommerce-product-details.init.js') }}"></script>
@endpush