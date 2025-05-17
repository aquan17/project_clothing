@extends('client.layout.ClientLayout')
@section('title', 'Giỏ Hàng')

@section('content')
    <!-- breadcrumb -->
    <section class="page-wrapper bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center d-flex align-items-center justify-content-between">
                        <h4 class="text-white mb-0">Địa chỉ giao hàng</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light justify-content-center mb-0 fs-15">
                                <li class="breadcrumb-item"><a href="#!">Cửa hàng</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Địa chỉ</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>
    <!-- end page title -->

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <div>
                        <h4 class="fs-18 mb-4">Chọn hoặc thêm địa chỉ</h4>
                        <div class="row g-4" id="address-list"> </div>
                        <div id="view-all-container" class="text-center mt-3" style="display: none;">
                            <button id="view-all-btn" class="btn btn-primary">Xem tất cả</button>
                        </div>

                        <!-- end row -->
                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <div class="text-center p-4 rounded-3 border border-2 border-dashed">
                                    <div class="avatar-md mx-auto mb-4">
                                        <div class="avatar-title bg-success-subtle text-success rounded-circle display-6">
                                            <i class="bi bi-house-add"></i>
                                        </div>
                                    </div>
                                    <h5 class="fs-16 mb-3">Thêm địa chỉ mới</h5>
                                    <button type="button"
                                        class="btn btn-success btn-sm w-xs stretched-link addAddress-modal"
                                        data-bs-toggle="modal" data-bs-target="#addAddressModal">Thêm</button>
                                </div>
                            </div>
                        </div>
                        <div class="hstack gap-2 justify-content-start mt-3">
                            <a href="{{ url()->previous() == url('/checkout') ? route('client.checkout.index') : url()->previous() }}"
                                class="btn btn-hover btn-danger">
                                Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            
                <!-- end col -->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>

    <!-- Modal -->
    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addAddressModalLabel">Thêm địa chỉ mới</h1>
                    <button type="button" id="addAddress-close" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" class="needs-validation createAddress-form" id="createAddress-form" novalidate>
                        <input type="hidden" id="addressid-input" class="form-control" value="">

                        <div>
                            <div class="mb-3">
                                <label for="addaddress-name" class="form-label">Tên</label>
                                <input type="text" name="name" class="form-control" id="addaddress-name"
                                    placeholder="Nhập tên" required value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="addaddress-phone" class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" id="addaddress-phone"
                                    placeholder="Nhập số điện thoại" required value="{{ old('phone') }}">
                                @error('phone')
                                    <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="country" class="form-label">Khu Vực</label>
                                <input type="text" name="country" class="form-control" id="country"
                                    placeholder="Enter country" required value="Việt Nam" readonly>
                                @error('country')
                                    <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="province" class="form-label">Tỉnh</label>
                                <select name="province" id="province" class="form-control" required>
                                    <option value="">Chọn tỉnh/thành</option>
                                </select>
                                @error('province')
                                    <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="addaddress-district" class="form-label">Huyện</label>
                                <select name="district" id="district" class="form-control" required>
                                    <option value="">Chọn quận/huyện</option>
                                </select>
                                @error('district')
                                    <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="addaddress-ward" class="form-label">Phường</label>
                                <select name="ward" id="ward" class="form-control">
                                    <option value="">Chọn xã/phường</option>
                                </select>
                                @error('ward')
                                    <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="addaddress-notes" class="form-label">Ghi chú</label>
                                <textarea name="notes" class="form-control" id="addaddress-notes" placeholder="Nhập bất kỳ ghi chú bổ sung"
                                    rows="2" value="{{ old('notes') }}"></textarea>
                                @error('notes')
                                    <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="addaddress-is_default" class="form-label">Đặt làm mặc định</label>
                                <div class="form-check">
                                    <input type="checkbox" name="is_default" class="form-check-input" id="toggleAddress"
                                        value="1" {{ old('is_default') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="addaddress-is_default">Có, đặt đây là địa chỉ mặc định</label>
                                    <span class="slider"></span>
                                    @error('is_default')
                                        <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" id="addNewAddress" class="btn btn-primary">Thêm</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!-- remove address Modal -->
    <div id="removeAddressModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" id="close-removeAddressModal" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you sure You want to remove this address ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="remove-address" class="btn w-sm btn-danger">Yes, Delete It!</button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
@push('scripts')
    <script>
        var addressListData = @json($addresses ?? []);
        console.log("Address data:", addressListData)
        // loadAddressList(addressListData);
    </script>
    <script src="{{ asset('client/js/frontend/address.init.js') }}"></script>
@endpush
