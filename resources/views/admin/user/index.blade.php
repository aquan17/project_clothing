@extends('admin.layout.Adminlayout')
@section('title', 'Người dùng')
@section('css')
    <link href="{{ asset('admin/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/user.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Khách hàng</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Thương mại điện tử</a></li>
                                <li class="breadcrumb-item active">Khách hàng</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="customerList">
                        <div class="card-header border-bottom-dashed">

                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0">Danh sách khách hàng</h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div class="d-flex flex-wrap align-items-start gap-2">
                                        <button class="btn btn-soft-danger" id="remove-actions"
                                            onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                            id="create-btn" data-bs-target="#showModal"><i
                                                class="ri-add-line align-bottom me-1"></i> Thêm khách hàng</button>
                                        <button type="button" class="btn btn-info"><i
                                                class="ri-file-download-line align-bottom me-1"></i> Nhập dữ liệu</button>
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
                                                placeholder="Tìm kiếm khách hàng, email, số điện thoại, trạng thái hoặc nội dung khác...">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-xl-6">
                                        <div class="row g-3">
                                            <div class="col-sm-4">
                                                <div class="">
                                                    <input type="text" class="form-control" id="datepicker-range"
                                                        data-provider="flatpickr" data-date-format="d M, Y"
                                                        data-range-date="true" placeholder="Chọn ngày">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-sm-4">
                                                <div>
                                                    <select class="form-control" data-plugin="choices" data-choices
                                                        data-choices-search-false name="choices-single-default"
                                                        id="idStatus">
                                                        <option value="">Trạng thái</option>
                                                        <option value="all" selected>Tất cả</option>
                                                        <option value="Active">Hoạt động</option>
                                                        <option value="Block">Khóa</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->

                                            <div class="col-sm-4">
                                                <div>
                                                    <button type="button" class="btn btn-primary w-100"
                                                        onclick="SearchData();"> <i
                                                            class="ri-equalizer-fill me-2 align-bottom"></i>Bộ lọc</button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                    </div>
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                       

                        <div class="card-body">
                            <div>
                                <div class="table-responsive table-card mb-1">
                                    <table class="table align-middle" id="customerTable">
                                        <thead class="table-light text-muted">
                                            <tr>
                                                <th scope="col" style="width: 50px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll"
                                                            value="option">
                                                    </div>
                                                </th>
                                                <th class="sort" data-sort="customer_name">Khách hàng</th>
                                                <th class="sort" data-sort="email">Email</th>
                                                <th class="sort" data-sort="phone">Số điện thoại</th>
                                                <th class="sort" data-sort="password">Mật khẩu</th>
                                                <th class="sort" data-sort="date">Ngày tham gia</th>
                                                <th class="sort" data-sort="status">Trạng thái</th>
                                                <th class="sort" data-sort="role">Vai trò</th>
                                                <th class="sort" data-sort="action">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            <tr>
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="chk_child"
                                                            value="option1">
                                                    </div>
                                                </th>
                                                <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                        class="fw-medium link-primary">#VZ2101</a></td>
                                                <td class="customer_name" data-label="Khách hàng">Mary Cousar</td>
                                                <td class="email" data-label="Email">marycousar@velzon.com</td>
                                                <td class="phone" data-label="Số điện thoại">580-464-4694</td>
                                                <td class="password" data-label="Mật khẩu">123456</td>
                                                <td class="date" data-label="Ngày tham gia">06 Apr, 2021</td>
                                                <td class="status" data-label="Trạng thái">
                                                    <span class="badge bg-success-subtle text-success text-uppercase">Hoạt
                                                        động</span>
                                                </td>
                                                <td class="role" data-label="Vai trò">Quản trị viên</td>
                                                <td data-label="Hành động">
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top"
                                                            title="Chỉnh sửa">
                                                            <a href="#showModal" data-bs-toggle="modal"
                                                                class="text-primary d-inline-block edit-item-btn">
                                                                <i class="ri-pencil-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top"
                                                            title="Xóa">
                                                            <a class="text-danger d-inline-block remove-item-btn"
                                                                data-bs-toggle="modal" href="#deleteRecordModal">
                                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="noresult" style="display: none">
                                        <div class="text-center">
                                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                colors="primary:#121331,secondary:#08a88a"
                                                style="width:75px;height:75px"></lord-icon>
                                            <h5 class="mt-2">Xin lỗi! Không tìm thấy kết quả</h5>
                                            <p class="text-muted mb-0">Chúng tôi đã tìm kiếm hơn 150+ khách hàng nhưng
                                                không
                                                tìm thấy khách hàng nào theo yêu cầu của bạn.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="pagination-wrap hstack gap-2">
                                        <a class="page-item pagination-prev disabled" href="#">
                                            Trước
                                        </a>
                                        <ul class="pagination listjs-pagination mb-0"></ul>
                                        <a class="page-item pagination-next" href="#">
                                            Tiếp
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form class="tablelist-form" autocomplete="off">
                                            <div class="modal-body">
                                                <input type="hidden" id="id-field" />

                                                <div class="mb-3" id="modal-id" style="display: none;">
                                                    <label for="id-field1" class="form-label">ID</label>
                                                    <input type="text" id="id-field1" class="form-control"
                                                        placeholder="ID" readonly />
                                                </div>

                                                <div class="mb-3">
                                                    <label for="customername-field" class="form-label">Tên khách
                                                        hàng</label>
                                                    <input type="text" id="customername-field" class="form-control"
                                                        placeholder="Nhập tên" required />
                                                    <div class="invalid-feedback">Vui lòng nhập tên khách hàng.</div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="email-field" class="form-label">Email</label>
                                                    <input type="email" id="email-field" class="form-control"
                                                        placeholder="Nhập email" required />
                                                    <div class="invalid-feedback">Vui lòng nhập email.</div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password-field" class="form-label">Mật khẩu</label>
                                                    <input type="password" id="password-field" class="form-control"
                                                        placeholder="Nhập mật khẩu" required />
                                                    <div class="invalid-feedback">Vui lòng nhập mật khẩu.</div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phone-field" class="form-label">Số điện thoại</label>
                                                    <input type="text" id="phone-field" class="form-control"
                                                        placeholder="Nhập số điện thoại" required />
                                                    <div class="invalid-feedback">Vui lòng nhập số điện thoại.</div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="date-field" class="form-label">Ngày tham gia</label>
                                                    <input type="date" id="date-field" class="form-control"
                                                        data-provider="flatpickr" data-date-format="d M, Y" required
                                                        placeholder="Chọn ngày" />
                                                    <div class="invalid-feedback">Vui lòng chọn ngày.</div>
                                                </div>

                                                <div>
                                                    <label for="status-field" class="form-label">Trạng thái</label>
                                                    <select class="form-control" data-choices data-choices-search-false
                                                        name="status-field" id="status-field" required>
                                                        <option value="">Trạng thái</option>
                                                        <option value="active">Hoạt động</option>
                                                        <option value="locked">Khóa</option>
                                                        <option value="banned">Cấm</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label for="role-field" class="form-label">Vai trò</label>
                                                    <select class="form-control" data-choices data-choices-search-false
                                                        name="role-field" id="role-field" required>
                                                        <option value="">Vai trò</option>
                                                        <option value="admin">Quản trị viên</option>
                                                        <option value="user">Người dùng</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-success" id="add-btn">Thêm
                                                        khách hàng</button>
                                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Cập nhật</button> -->
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" id="deleteRecord-close"
                                                data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mt-2 text-center">
                                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                                    colors="primary:#f7b84b,secondary:#f06548"
                                                    style="width:100px;height:100px"></lord-icon>
                                                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                    <h4>Bạn có chắc không?</h4>
                                                    <p class="text-muted mx-4 mb-0">Bạn có chắc muốn xóa bản ghi này không?
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                                <button type="button" class="btn w-sm btn-light"
                                                    data-bs-dismiss="modal">Đóng</button>
                                                <button type="button" class="btn w-sm btn-danger" id="delete-record">Có,
                                                    xóa nó!</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end modal -->
                        </div>
                    </div>

                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>

@endsection
@push('scripts')
    <script src="{{ asset('admin/assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <!--ecommerce-customer init js -->
    <script src="{{ asset('admin/assets/js/pages/ecommerce-customer-list.init.js') }}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('admin/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush
