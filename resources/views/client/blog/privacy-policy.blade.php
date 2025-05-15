@extends('client.layout.ClientLayout')
@section('title', 'Giỏ Hàng')

@section('content')
<section class="term-condition bg-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center">
                    <h1 class="text-white mb-2">Chính Sách Quyền Riêng Tư</h1>
                    <p class="text-white-75 mb-0">Chính sách quyền riêng tư này được công bố vào ngày 24 tháng 11 năm 2022.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="position-relative">
    <div class="svg-shape">
        <!-- Không cần dịch phần SVG -->
    </div>
</div>

<section class="section pt-0">
    <div class="container">
        <div class="card term-card mb-0">
            <div class="card-body p-lg-5">
                <div class="row">
                    <div class="col-lg-12">
                        <h5 class="fs-18 mb-3">Giới Thiệu</h5>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Chúng tôi có thể thu thập và sử dụng thông tin cá nhân cho nhiều mục đích khác nhau như: thanh toán, cung cấp sản phẩm và dịch vụ, hiểu rõ nhu cầu khách hàng, cải thiện trang web, sản phẩm và dịch vụ, cũng như liên hệ với khách hàng hoặc khách hàng tiềm năng liên quan đến sản phẩm và dịch vụ của chúng tôi hoặc bên thứ ba.
                            </p>
                        </div>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Clients on Demand, LLC cam kết bảo vệ thông tin cá nhân cũng như thông tin doanh nghiệp mà bạn chia sẻ hoặc lưu trữ với chúng tôi.
                            </p>
                        </div>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Chính sách quyền riêng tư này áp dụng cho các giao dịch, hoạt động và dữ liệu được thu thập thông qua website Clients on Demand và các tương tác của bạn với tài khoản mạng xã hội liên quan. Vui lòng kiểm tra chính sách này thường xuyên vì chúng tôi có thể thay đổi mà không cần thông báo.
                            </p>
                        </div>

                        <h5 class="fs-18 my-3">Thỏa Thuận Vận Chuyển</h5>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Chúng tôi có thể chia sẻ thông tin về người dùng ở dạng tổng hợp hoặc đã được ẩn danh. Chính sách quyền riêng tư này không hạn chế việc sử dụng hoặc chia sẻ thông tin đã được tổng hợp/ẩn danh theo bất kỳ cách nào.
                            </p>
                        </div>

                        <h5 class="fs-18 my-3">Chính Sách Hoàn Tiền</h5>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Thông tin chúng tôi thu thập được sử dụng cho nhiều mục đích như:
                            </p>
                        </div>
                        <ul class="text-muted vstack gap-2 fs-15 ps-5" style="list-style-type: circle;">
                            <li>giúp bạn sử dụng dịch vụ và yêu cầu các tính năng như tham gia hoặc gia hạn các dịch vụ trả phí, khảo sát, và diễn đàn</li>
                            <li>phân tích thống kê, nhân khẩu học và tiếp thị để cải thiện mối quan hệ với khách hàng</li>
                            <li>phục vụ mục đích phát triển sản phẩm và cung cấp thông tin cho nhà quảng cáo</li>
                            <li>cá nhân hóa trải nghiệm và hiển thị quảng cáo phù hợp</li>
                        </ul>

                        <h5 class="fs-18 my-3">Sử Dụng Cookie</h5>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Chúng tôi sử dụng “cookies,” Web beacons, bộ nhớ HTML5 và các công nghệ tương tự để quản lý truy cập, nhận dạng người dùng và cung cấp trải nghiệm cá nhân hóa. Một số chức năng có thể không hoạt động nếu thiết bị của bạn không chấp nhận cookie.
                            </p>
                        </div>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Chúng tôi không phản hồi các tín hiệu “không theo dõi” từ trình duyệt.
                            </p>
                        </div>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Chúng tôi có thể truyền dữ liệu sử dụng trang web không định danh đến bên thứ ba để hiển thị quảng cáo cho Clients on Demand khi bạn truy cập các trang web khác.
                            </p>
                        </div>

                        <h5 class="fs-18 my-3">Tuyên Bố Miễn Trừ</h5>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Chính sách quyền riêng tư này có thể được chúng tôi sửa đổi bất kỳ lúc nào và không cần thông báo. Các thay đổi sẽ có hiệu lực sau 30 ngày kể từ khi được đăng tải trên website, trừ khi có yêu cầu thực thi ngay lập tức.
                            </p>
                        </div>

                        <div class="alert alert-danger">
                            Không được phép sử dụng logo hoặc các hình ảnh khác của Công Ty nếu không có thỏa thuận cấp phép thương hiệu.
                        </div>

                        <div class="hstack justify-content-end gap-2 mt-4">
                            <a href="#!" class="btn btn-ghost-danger btn-hover"><i class="ri-close-line align-bottom me-1"></i> Từ chối</a>
                            <a href="#!" class="btn btn-success btn-hover">Đồng ý ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection