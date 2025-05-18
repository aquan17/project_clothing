@extends('admin.layout.Adminlayout')

@section('title', 'Danh sách đơn hàng')

@section('css')
<link href="{{ asset('admin/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Đơn hàng</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Thương mại điện tử</a></li>
                            <li class="breadcrumb-item active">Đơn hàng</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="orderList">
                    <div class="card-header border-0">
                        <div class="row align-items-center gy-3">
                            <div class="col-sm">
                                <h5 class="card-title mb-0">Lịch sử đơn hàng</h5>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex gap-1 flex-wrap">
                                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Tạo đơn hàng</button>
                                    <button type="button" class="btn btn-info"><i class="ri-file-download-line align-bottom me-1"></i> Nhập dữ liệu</button>
                                    <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border border-dashed border-end-0 border-start-0">
                        <form>
                            <div class="row g-3">
                                <div class="col-xxl-5 col-sm-6">
                                    <div class="search-box">
                                        <input type="text" class="form-control search" placeholder="Tìm kiếm theo mã đơn hàng, khách hàng, trạng thái đơn hàng hoặc nội dung khác...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-sm-6">
                                    <div>
                                        <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" id="demo-datepicker" placeholder="Chọn ngày">
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-sm-4">
                                    <div>
                                        <select class="form-control" data-choices data-choices-search-false name="choices-single-default" id="idStatus">
                                            <option value="">Trạng thái</option>
                                            <option value="all" selected>Tất cả</option>
                                            <option value="Pending">Chờ xử lý</option>
                                            <option value="Inprogress">Đang xử lý</option>
                                            <option value="Cancelled">Đã hủy</option>
                                            <option value="Pickups">Đang giao</option>
                                            <option value="Returns">Trả hàng</option>
                                            <option value="Completed">Đã giao</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-sm-4">
                                    <div>
                                        <select class="form-control" data-choices data-choices-search-false name="choices-single-default" id="idPayment">
                                            <option value="">Chọn phương thức thanh toán</option>
                                            <option value="all" selected>Tất cả</option>
                                            <option value="Mastercard">Mastercard</option>
                                            <option value="Paypal">Paypal</option>
                                            <option value="Visa">Visa</option>
                                            <option value="COD">Thanh toán khi nhận hàng</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xxl-1 col-sm-4">
                                    <div>
                                        <button type="button" class="btn btn-primary w-100" onclick="SearchData();"> <i class="ri-equalizer-fill me-1 align-bottom"></i> Bộ lọc</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body pt-0">
                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active All py-3" data-bs-toggle="tab" id="All" href="#home1" role="tab" aria-selected="true">
                                    <i class="ri-store-2-fill me-1 align-bottom"></i> Tất cả đơn hàng
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Completed" data-bs-toggle="tab" id="Completed" href="#completed" role="tab" aria-selected="false">
                                    <i class="ri-checkbox-circle-line me-1 align-bottom"></i> Đã hoàn thành <span class="badge bg-success align-middle ms-1">{{ $completedOrdersCount }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Pending" data-bs-toggle="tab" id="Pending" href="#pending" role="tab" aria-selected="false">
                                    <i class="ri-truck-line me-1 align-bottom"></i> Chờ xử lý <span class="badge bg-danger align-middle ms-1">{{ $pendingOrdersCount }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Confirmed" data-bs-toggle="tab" id="Confirmed" href="#confirmed" role="tab" aria-selected="false">
                                    <i class="ri-arrow-left-right-fill me-1 align-bottom"></i> Đã xác nhận <span class="badge bg-success align-middle ms-1">{{ $confirmedOrdersCount }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link py-3 Cancelled" data-bs-toggle="tab" id="Cancelled" href="#cancelled" role="tab" aria-selected="false">
                                    <i class="ri-close-circle-line me-1 align-bottom"></i> Đã hủy <span class="badge bg-danger align-middle ms-1">{{ $cancelledOrdersCount }}</span>
                                </a>
                            </li>
                        </ul>
                        <div class="table-responsive table-card mb-1">
                            
                            <table class="table table-nowrap align-middle" id="orderTable">
                                <thead class="text-muted table-light">
                                    <tr class="text-uppercase">
                                        <th scope="col" style="width: 25px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                            </div>
                                        </th>
                                        <th class="sort" data-sort="id">Mã đơn hàng</th>
                                        <th class="sort" data-sort="customer_name">Khách hàng</th>
                                        <th class="sort" data-sort="product_names">Sản phẩm</th>
                                        <th class="sort" data-sort="date">Ngày đặt hàng</th>
                                        <th class="sort" data-sort="amount">Số tiền</th>
                                        <th class="sort" data-sort="payment">Phương thức thanh toán</th>
                                        <th class="sort" data-sort="status">Trạng thái giao hàng</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="checkAll" value="option1">
                                            </div>
                                        </th>
                                        <td class="id"><a href="apps-ecommerce-order-details.html" class="fw-medium link-primary">#VZ2101</a></td>
                                        <td class="customer_name">Frank Hook</td>
                                        <td class="product_name">Áo thun Puma</td>
                                        <td class="date">20 Th12, 2021, <small class="text-muted">02:21 SA</small></td>
                                        <td class="amount">$654</td>
                                        <td class="payment">Mastercard</td>
                                        <td class="status"><span class="badge bg-warning-subtle text-warning text-uppercase">Chờ xử lý</span>
                                        </td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                  <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                    <a href="#" class="text-primary d-inline-block" title="View">
                                                        <i class="ri-eye-fill fs-16"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Chỉnh sửa">
                                                    <a href="#showModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn" >
                                                        <i class="ri-pencil-fill fs-16"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Xóa">
                                                    <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteOrder" >
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
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px"></lord-icon>
                                    <h5 class="mt-2">Xin lỗi! Không tìm thấy kết quả</h5>
                                    <p class="text-muted">Chúng tôi đã tìm kiếm hơn 150+ đơn hàng nhưng không tìm thấy đơn hàng nào phù hợp với yêu cầu của bạn.</p>
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
                                    Tiếp theo
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng" id="close-modal"></button>
                                </div>
                                <form class="tablelist-form" autocomplete="off">
                                    <div class="modal-body">
                                        <input type="hidden" id="id-field" />
                                        <div class="mb-3" id="modal-id">
                                            <label for="orderId" class="form-label">Mã đơn hàng</label>
                                            <input type="text" id="orderId" class="form-control" placeholder="Mã đơn hàng" readonly />
                                        </div>
                                        <div>
                                            <label for="status" class="form-label">Trạng thái giao hàng</label>
                                            <select class="form-control" data-trigger name="status" required id="status">
                                                <option value="">Chọn trạng thái</option>
                                                <option value="Pending">Chờ xử lý</option>
                                                <option value="Cancelled">Đã hủy</option>
                                                <option value="Completed">Đã hoàn thành</option>
                                                <option value="Confirmed">Đã xác nhận</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-success" id="add-btn">Thêm đơn hàng</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4>Bạn sắp xóa một đơn hàng?</h4>
                                        <p class="text-muted fs-15 mb-4">Việc xóa đơn hàng sẽ xóa tất cả thông tin của bạn khỏi cơ sở dữ liệu.</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Đóng</button>
                                            <button class="btn btn-danger" id="delete-record">Vâng, Xóa nó</button>
                                        </div>
                                    </div>
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

<script src="{{ asset('admin/assets/libs/list.js/list.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/pages/ecommerce-order.init.js') }}"></script>
<script src="{{ asset('admin/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush