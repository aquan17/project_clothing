@extends('admin.layout.Adminlayout')
@section('title', 'Quản lý danh mục')
@section('css')
    {{-- <link href="{{ asset('admin/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" /> --}}
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Danh mục</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Thương mại điện tử</a></li>
                                <li class="breadcrumb-item active">Danh mục</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="categoryList">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0">Danh sách danh mục</h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                            <i class="ri-delete-bin-2-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-success add-category-btn" data-bs-toggle="modal"
                                            id="create-btn" data-bs-target="#showModal" data-store-url="{{ route('admin.categories.store') }}">
                                            <i class="ri-add-line align-bottom me-1"></i> Thêm danh mục
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-bottom-dashed border-bottom">
                            <form>
                                <div class="row g-3">
                                    <div class="col-xl-6">
                                        <div class="search-box">
                                            <input type="text" class="form-control search"
                                                placeholder="Tìm kiếm danh mục...">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="table-responsive table-card mb-1">
                                    <table class="table align-middle" id="categoryTable">
                                        <thead class="table-light text-muted">
                                            <tr>
                                                <th scope="col" style="width: 50px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll"
                                                            value="option">
                                                    </div>
                                                </th>
                                                <th class="sort" data-sort="id">Mã</th>
                                                <th class="sort" data-sort="category_name">Tên danh mục</th>
                                                <th class="sort" data-sort="action">Hành động</th>
                                            </tr>
                                        </thead>

                                        <tbody class="list form-check-all">
                                            @foreach ($categories as $category)
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                                value="{{ $category->id }}">
                                                        </div>
                                                    </td>
                                                    <td class="id">{{ $category->id }}</td>
                                                    <td class="category_name">{{ $category->name }}</td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <div class="edit">
                                                                <button class="btn btn-sm btn-success edit-item-btn"
                                                                    data-id="{{ $category->id }}" data-bs-toggle="modal"
                                                                    data-bs-target="#showModal">
                                                                    Chỉnh sửa
                                                                </button>
                                                            </div>
                                                            <div class="remove">
                                                                <button class="btn btn-sm btn-danger remove-item-btn"
                                                                    data-id="{{ $category->id }}">
                                                                    Xóa
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Đóng" id="close-modal"></button>
                                        </div>
                                        <form class="tablelist-form" autocomplete="off" method="POST" id="category-form"
                                            action="">
                                            @csrf
                                            <input type="hidden" id="id-field" name="id" />
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="category-name-field" class="form-label">Tên danh mục</label>
                                                    <input type="text" id="category-name-field" class="form-control"
                                                        name="category_name" placeholder="Nhập tên danh mục" required />
                                                    <div class="invalid-feedback">Vui lòng nhập tên danh mục.</div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-success"
                                                        id="add-btn">Thêm</button>
                                                    <button type="submit" class="btn btn-success"
                                                        id="edit-btn">Cập nhật</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{-- <script src="{{ asset('admin/assets/libs/list.js/list.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('admin/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('admin/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script> --}}
    <script src="{{ asset('admin/assets/js/pages/category-list.init.js') }}"></script> 
    {{-- <script src="{{ asset('admin/assets/js/app.min.js') }}"></script> --}}
@endpush