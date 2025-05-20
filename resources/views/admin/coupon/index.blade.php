@extends('admin.layout.Adminlayout')
@section('title', 'Quản lý mã giảm giá')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Mã giảm giá</h4>
                    </div>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="couponList">
                        <div class="card-header border-bottom-dashed">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm">
                                    <div>
                                        <h5 class="card-title mb-0">Danh sách mã giảm giá</h5>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <button type="button" class="btn btn-success add-coupon-btn" data-bs-toggle="modal"
                                        id="create-btn" data-bs-target="#showModal"
                                        data-store-url="{{ route('admin.coupons.store') }}">
                                        <i class="ri-add-line align-bottom me-1"></i> Thêm mã giảm giá
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="table-responsive table-card mb-1">
                                    <table class="table align-middle" id="couponTable">
                                        <thead class="table-light text-muted">
                                            <tr>
                                                <th scope="col" style="width: 40px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="checkAll"
                                                            value="option">
                                                    </div>
                                                </th>
                                                <th class="sort" data-sort="id" style="width: 60px;">Mã</th>
                                                <th class="sort" data-sort="code" style="width: 120px;">Mã giảm giá</th>
                                                <th class="sort" data-sort="discount_type" style="width: 100px;">Loại</th>
                                                <th class="sort" data-sort="discount_value" style="width: 100px;">Giá trị
                                                </th>
                                                <th class="sort" data-sort="start_date" style="width: 100px;">Bắt đầu</th>
                                                <th class="sort" data-sort="end_date" style="width: 100px;">Kết thúc</th>
                                                <th class="sort" data-sort="usage_limit" style="width: 80px;">Giới hạn
                                                </th>
                                                <th class="sort" data-sort="used_count" style="width: 80px;">Đã dùng</th>
                                                <th class="sort" data-sort="status" style="width: 80px;">Trạng thái</th>
                                                <th style="width: 120px;">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @foreach ($coupons as $coupon)
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="chk_child"
                                                                value="{{ $coupon->id }}">
                                                        </div>
                                                    </td>
                                                    <td class="id">{{ $coupon->id }}</td>
                                                    <td class="code">{{ $coupon->code }}</td>
                                                    <td class="discount_type">{{ $coupon->discount_type }}</td>
                                                    <td class="discount_value">
                                                        {{ $coupon->discount_type === 'percentage' ? $coupon->discount_value . '%' : $coupon->discount_value }}
                                                    </td>
                                                    <td class="start_date">{{ $coupon->start_date }}</td>
                                                    <td class="end_date">{{ $coupon->end_date }}</td>
                                                    <td class="usage_limit">{{ $coupon->usage_limit }}</td>
                                                    <td class="used_count">{{ $coupon->used_count }}</td>
                                                    <td class="status">
                                                        <span
                                                            class="badge bg-{{ $coupon->status === 'active' ? 'info' : 'warning' }} text-uppercase">
                                                            {{ $coupon->status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <button class="btn btn-sm btn-success edit-item-btn"
                                                                data-id="{{ $coupon->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#showModal"
                                                                data-coupon="{{ json_encode($coupon->toArray()) }}">
                                                                Chỉnh sửa
                                                            </button>
                                                            <div class="remove">
                                                                <button class="btn btn-sm btn-danger remove-item-btn"
                                                                    data-id="{{ $coupon->id }}" id="delete-btn">
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
                                        <form class="tablelist-form" autocomplete="off" method="POST" id="coupon-form">
                                            @csrf
                                            <input type="hidden" id="id-field" name="id" />
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="code-field" class="form-label">Mã giảm giá</label>
                                                    <input type="text" id="code-field" class="form-control"
                                                        name="code" placeholder="Nhập mã giảm giá" required />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="discount_type-field" class="form-label">Loại giảm
                                                        giá</label>
                                                    <select id="discount_type-field" class="form-control"
                                                        name="discount_type" required>
                                                        <option value="percentage">Phần trăm</option>
                                                        <option value="fixed">Cố định</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="discount_value-field" class="form-label">Giá trị giảm
                                                        giá</label>
                                                    <div class="input-group">
                                                        <input type="number" id="discount_value-field"
                                                            class="form-control" name="discount_value"
                                                            placeholder="Nhập giá trị giảm giá" required />
                                                        <span class="input-group-text" id="discount-symbol">%</span>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="usage_limit-field" class="form-label">Giới hạn sử
                                                        dụng</label>
                                                    <input type="number" id="usage_limit-field" class="form-control"
                                                        name="usage_limit" placeholder="Nhập giới hạn sử dụng" required />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="used_count-field" class="form-label">Số lần đã sử
                                                        dụng</label>
                                                    <input type="number" id="used_count-field" class="form-control"
                                                        name="used_count" placeholder="Nhập số lần đã sử dụng" required />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="status-field" class="form-label">Trạng thái</label>
                                                    <select id="status-field" class="form-control" name="status"
                                                        required>
                                                        <option value="active">Hoạt động</option>
                                                        <option value="inactive">Không hoạt động</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="start_date-field" class="form-label">Ngày bắt đầu</label>
                                                    <input type="datetime-local" id="start_date-field"
                                                        class="form-control" name="start_date" required />
                                                </div>
                                                <div class="mb-3">
                                                    <label for="end_date-field" class="form-label">Ngày kết thúc</label>
                                                    <input type="datetime-local" id="end_date-field" class="form-control"
                                                        name="end_date" required />
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-success"
                                                        id="add-btn">Thêm</button>
                                                    <button type="submit" class="btn btn-success" id="edit-btn">Cập
                                                        nhật</button>
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
    {{-- <script src="{{ asset('admin/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script> --}}
    <script src="{{ asset('admin/assets/js/pages/coupon-list.init.js') }}"></script>
@endpush
