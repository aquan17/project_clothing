@extends('admin.layout.Adminlayout')
@section('title', 'Tạo sản phẩm')
@section('css')
    <link href="{{ asset('admin/assets/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Tạo sản phẩm</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Thương mại điện tử</a></li>
                                <li class="breadcrumb-item active">Tạo sản phẩm</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
      
            <form id="createproduct-form" autocomplete="off" class="needs-validation" novalidate method="POST"
                action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="product-title-input">Tên sản phẩm</label>
                                    <input type="hidden" class="form-control" id="formAction" name="formAction"
                                        value="add">
                                    <input type="text" class="form-control" id="product-title-input" name="name"
                                        value="{{ old('name') }}" placeholder="Nhập tên sản phẩm" required>
                                    <div class="invalid-feedback">Vui lòng nhập tên sản phẩm.</div>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="product-sku-input">Mã SKU</label>
                                    <input type="text" class="form-control" id="product-sku-input" name="sku"
                                        value="{{ old('sku') }}" placeholder="Nhập mã SKU" required>
                                    <div class="invalid-feedback">Vui lòng nhập mã SKU.</div>
                                    @error('sku')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label class="form-label">Mô tả sản phẩm</label>
                                    <textarea class="form-control" id="ckeditor-classic" name="description" rows="5">{{ old('description', 'Nhập mô tả sản phẩm...') }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- end card -->

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Hình ảnh sản phẩm</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <h5 class="fs-14 mb-1">Hình ảnh chính</h5>
                                    <p class="text-muted">Thêm hình ảnh chính của sản phẩm.</p>
                                    <div class="text-center">
                                        <div class="position-relative d-inline-block">
                                            <div class="position-absolute top-100 start-100 translate-middle">
                                                <label for="product-image-input" class="mb-0" data-bs-toggle="tooltip"
                                                    data-bs-placement="right" title="Chọn hình ảnh">
                                                    <div class="avatar-xs">
                                                        <div
                                                            class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                            <i class="ri-image-fill"></i>
                                                        </div>
                                                    </div>
                                                </label>
                                                <input class="form-control d-none" value="" id="product-image-input"
                                                    name="image" type="file" accept="image/png, image/gif, image/jpeg">
                                            </div>
                                            <div class="avatar-lg">
                                                <div class="avatar-title bg-light rounded">
                                                    <img src="#" id="product-img" class="avatar-md h-auto" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <!-- end card -->
                        <script>
                            document.getElementById("product-image-input").addEventListener("change", function(e) {
                                const file = e.target.files[0];
                                const img = document.getElementById("product-img");

                                if (file && img) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                        img.src = e.target.result;
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });
                        </script>


                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#addproduct-general-info"
                                            role="tab">
                                            Thông tin chung
                                        </a>
                                    </li>
                                    
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="addproduct-general-info" role="tabpanel">
                                      
                                        <div class="row">
                                            <div class="col-lg-3 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="stocks-input">Tổng số lượng</label>
                                                    <input type="number" class="form-control" id="stocks-input"
                                                        name="total_stock" value="{{ old('total_stock') }}"
                                                        placeholder="Nhập số lượng" required>
                                                    <div class="invalid-feedback">Vui lòng nhập tổng số lượng.</div>
                                                    @error('total_stock')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="product-price-input">Giá</label>
                                                    <div class="input-group has-validation mb-3">
                                                        <span class="input-group-text" id="product-price-addon">$</span>
                                                        <input type="number" step="0.01" class="form-control"
                                                            id="product-price-input" name="price"
                                                            value="{{ old('price') }}" placeholder="Nhập giá"
                                                            required>
                                                        <div class="invalid-feedback">Vui lòng nhập giá sản phẩm.</div>
                                                        @error('price')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                        <div class="text-end mb-3">
                            <button type="submit" class="btn btn-success w-sm">Gửi</button>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Xuất bản</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="choices-publish-status-input" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="choices-publish-status-input" name="status"
                                        data-choices data-choices-search-false>
                                        <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>
                                            Hoạt động</option>
                                        <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>
                                            Không hoạt động
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Danh mục sản phẩm</h5>
                            </div>
                            <div class="card-body">
                                <select class="form-select" id="choices-category-input" name="category_id" data-choices
                                    data-choices-search-false required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach (\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Vui lòng chọn một danh mục.</div>
                                @error('category_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                    </div>
                </div>
            </form>

        </div>
        <!-- container-fluid -->
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('admin/assets/libs/%40ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <!-- dropzone js -->
    <script src="{{ asset('admin/assets/libs/dropzone/dropzone-min.js') }}"></script>

    <script src="{{ asset('admin/assets/js/pages/ecommerce-product-create.init.js') }}"></script>
@endpush