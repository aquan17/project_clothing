@extends('client.layout.ClientLayout')
@section('title', 'Giỏ Hàng')

@section('content')
<section class="term-condition bg-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">  
                <div class="text-center">
                    <h1 class="text-white mb-2">Hướng Dẫn Mua Hàng</h1>
                    <p class="text-white-75 mb-0">Cập nhật lần cuối: 24 Tháng 11, 2022</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="position-relative">
    <div class="svg-shape">
        <!-- SVG giữ nguyên -->
    </div>
</div>

<section class="section pt-0">
    <div class="container">
        <div class="card term-card mb-0">
            <div class="card-body p-5">
                <div class="row">
                    <div class="col-lg-12">
                        <h5 class="fs-18 mb-3">Đăng Ký Tài Khoản</h5>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">Trong một số trường hợp, việc sử dụng Website và Dịch vụ có thể yêu cầu bạn cung cấp thông tin cá nhân để xác minh, bao gồm email và thông tin nhân khẩu học để đăng ký.</p>
                        </div>
                        <ul class="text-muted vstack gap-2 fs-15 ps-5" style="list-style-type: circle;">
                            <li>Họ tên</li>
                            <li>Tuổi</li>
                            <li>Ngày sinh</li>
                            <li>Nghề nghiệp hiện tại</li>
                            <li>Số điện thoại</li>
                            <li>Địa chỉ email</li>
                            <li>Sở thích</li>
                            <li>Mạng xã hội</li>
                        </ul>

                        <h5 class="fs-18 my-3">Chọn Sản Phẩm</h5>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">Bạn có thể chọn sản phẩm thông qua 5 phương thức trong khu vực chọn sản phẩm:</p>
                        </div>
                        <ul class="text-muted vstack gap-2 fs-15 ps-5" style="list-style-type: circle;">
                            <li>Tìm kiếm</li>
                            <li>Danh sách sản phẩm</li>
                            <li>Cây lựa chọn sản phẩm</li>
                            <li>Nhóm sản phẩm</li>
                            <li>Tập hợp sản phẩm</li>
                        </ul>

                        <h5 class="fs-18 my-3">Xác Nhận Nội Dung Đơn Hàng</h5>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">Sau khi xác định nhu cầu và vấn đề của khách hàng, bạn cần xây dựng nội dung hướng dẫn mua hàng dựa trên các điểm khó khăn và đưa ra giải pháp tương ứng.</p>
                        </div>

                        <h5 class="fs-18 my-3">Hoàn Tất Giao Dịch</h5>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">Mọi giao dịch đều sẽ kết thúc bằng việc xác nhận hoặc hủy bỏ. Nếu xác nhận, tất cả thông tin sẽ được lưu lại vĩnh viễn. Nếu hủy bỏ, mọi thay đổi sẽ không được lưu.</p>
                        </div>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">Chuẩn bị: Giao dịch sẽ yêu cầu các tài nguyên xác nhận khả năng hoàn tất. Nếu bất kỳ tài nguyên nào phản hồi là hủy bỏ, toàn bộ giao dịch sẽ bị hủy. Nếu đồng ý, tài nguyên phải đảm bảo khả năng hoàn tất ngay cả khi có sự cố hệ thống.</p>
                        </div>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">Xác nhận: Nếu tất cả đều đồng ý xác nhận, giao dịch sẽ tiến hành hoàn tất và không thể quay lại.</p>
                        </div>
                        <div class="d-flex gap-2 mb-4">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">Sau khi giao dịch hoàn tất hoặc bị hủy, nó sẽ kết thúc và tách khỏi tiến trình đang chạy.</p>
                        </div>

                        <h5 class="fs-18 my-3">Chấp Nhận Thẻ Tín Dụng</h5>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">Thuế sẽ được tính dựa trên ngân hàng và vị trí của bạn.</p>
                        </div>
                        <ul class="text-muted vstack gap-2 fs-15 ps-5" style="list-style-type: circle;">
                            <li>Visa</li>
                            <li>Mastercard</li>
                            <li>American Express</li>
                            <li>Discover</li>
                        </ul>

                        <h5 class="fs-18 my-3">Tải Về Và Cài Đặt</h5>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">Bạn có thể sử dụng ứng dụng Cài Đặt Nội Dung để tìm, tải và cài đặt các nội dung từ Thư viện.</p>
                        </div>
                        <ul class="text-muted vstack gap-2 fs-15 ps-5 mb-0" style="list-style-type: circle;">
                            <li>Nội dung được cập nhật thường xuyên</li>
                            <li>Thanh toán an toàn và tiện lợi</li>
                            <li>Thanh toán chỉ với 1 cú nhấp</li>
                            <li>Bảng điều khiển người dùng thông minh, dễ sử dụng</li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection