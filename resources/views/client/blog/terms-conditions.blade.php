@extends('client.layout.ClientLayout')
@section('title', 'Giỏ Hàng')

@section('content')
<section class="term-condition bg-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center">
                    <h1 class="text-white mb-2">Điều Khoản và Điều Kiện</h1>
                    <p class="text-white-75 mb-0">Cập nhật lần cuối: 24 Tháng 11, 2022</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="position-relative">
    <div class="svg-shape">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="1440" height="120" preserveAspectRatio="none" viewBox="0 0 1440 120">
            <g mask="url(&quot;#SvgjsMask1039&quot;)" fill="none">
                <rect width="1440" height="120" x="0" y="0" fill="var(--tb-primary)"></rect>
                <path d="M 0,85 C 288,68.8 1152,20.2 1440,4L1440 120L0 120z" fill="var(--tb-body-bg)"></path>
            </g>
            <defs>
                <mask id="SvgjsMask1039">
                    <rect width="1440" height="120" fill="#ffffff"></rect>
                </mask>
            </defs>
        </svg>
    </div>
</div>

<section class="section pt-0">
    <div class="container">
        <div class="card term-card mb-0">
            <div class="card-body p-5">
                <div class="row">
                    <div class="col-lg-12">
                        <h5 class="fs-18 mb-3">Giới thiệu</h5>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Các Điều Khoản và Điều Kiện Tiêu Chuẩn trên trang web này sẽ điều chỉnh việc bạn sử dụng website của chúng tôi, Website Name tại địa chỉ Website.com. Khi truy cập website này, chúng tôi cho rằng bạn đồng ý với tất cả các điều khoản đã nêu. Nếu bạn không đồng ý với bất kỳ điều khoản nào, vui lòng ngừng sử dụng Website Name.
                            </p>
                        </div>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Các điều khoản này sẽ được áp dụng hoàn toàn và có hiệu lực đối với việc sử dụng Website này. Bạn không được sử dụng Website nếu bạn không đồng ý với bất kỳ điều khoản nào trong số này.
                            </p>
                        </div>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Người dưới 18 tuổi không được phép sử dụng Website này.
                            </p>
                        </div>

                        <h5 class="fs-18 my-3">Quyền & Hạn chế</h5>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Ngoại trừ nội dung do bạn sở hữu, theo các điều khoản này, Công ty và/hoặc các bên cấp phép của công ty sở hữu toàn bộ quyền sở hữu trí tuệ và tài liệu trên Website này.
                            </p>
                        </div>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Bạn chỉ được cấp giấy phép giới hạn để xem tài liệu trên Website.
                            </p>
                        </div>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">Bạn bị nghiêm cấm thực hiện các hành vi sau:</p>
                        </div>
                        <ul class="text-muted vstack gap-2 fs-15 ps-5" style="list-style-type: circle;">
                            <li>Xuất bản bất kỳ nội dung nào của Website trên bất kỳ phương tiện truyền thông nào khác;</li>
                            <li>Bán, cấp phép lại hoặc thương mại hóa bất kỳ nội dung nào trên Website;</li>
                            <li>Sao chép, nhân bản hoặc sao chép nội dung từ Website Name;</li>
                            <li>Phân phối lại nội dung từ Website Name;</li>
                            <li>Sử dụng Website theo cách gây hại hoặc có thể gây hại cho Website;</li>
                            <li>Sử dụng Website để quảng cáo hoặc tiếp thị.</li>
                        </ul>

                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Một số khu vực trên Website có thể bị hạn chế truy cập và Công ty có thể giới hạn quyền truy cập của bạn vào bất kỳ khu vực nào bất kỳ lúc nào theo toàn quyền quyết định. Tên đăng nhập và mật khẩu của bạn phải được giữ bí mật.
                            </p>
                        </div>

                        <h5 class="fs-18 my-3">Miễn trừ bảo đảm</h5>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Website này được cung cấp “nguyên trạng”, và Công ty không đưa ra bất kỳ bảo đảm hoặc cam kết nào liên quan đến Website hoặc nội dung trên Website. Không có nội dung nào trên Website được xem là lời khuyên.
                            </p>
                        </div>

                        <h5 class="fs-18 my-3">Giấy phép</h5>
                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Công ty có quyền giám sát tất cả các bình luận và xóa bất kỳ bình luận nào bị xem là không phù hợp, xúc phạm hoặc vi phạm các điều khoản này.
                            </p>
                        </div>

                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">Bạn cam kết và đảm bảo rằng:</p>
                        </div>
                        <ul class="text-muted vstack gap-2 fs-15 ps-5" style="list-style-type: circle;">
                            <li>Bạn có quyền đăng bình luận lên Website và có đầy đủ giấy phép để làm điều đó;</li>
                            <li>Bình luận không vi phạm bất kỳ quyền sở hữu trí tuệ nào của bên thứ ba, bao gồm bản quyền, sáng chế hoặc thương hiệu;</li>
                            <li>Bình luận không chứa nội dung phỉ báng, xúc phạm, khiêu dâm hoặc bất hợp pháp;</li>
                            <li>Bình luận không được sử dụng để quảng bá kinh doanh hoặc thực hiện hoạt động bất hợp pháp.</li>
                        </ul>

                        <div class="d-flex gap-2 mb-2">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Trừ khi được nêu rõ, Công ty và/hoặc các bên cấp phép sở hữu bản quyền toàn bộ nội dung trên Website. Bạn chỉ được truy cập nội dung cho mục đích cá nhân, không thương mại và phải tuân theo các điều khoản này.
                            </p>
                        </div>

                        <div class="d-flex gap-2 mb-4">
                            <div class="flex-shrink-0">
                                <i class="ri-flashlight-fill text-primary fs-15"></i>
                            </div>
                            <p class="text-muted fs-15 flex-grow-1 mb-0">
                                Bạn đồng ý cấp cho Công ty giấy phép không độc quyền để sử dụng, sao chép, chỉnh sửa và cấp phép lại các bình luận của bạn dưới mọi hình thức, định dạng hoặc phương tiện truyền thông.
                            </p>
                        </div>

                        <div class="alert alert-danger">
                            Việc sử dụng logo hoặc hình ảnh khác của Công ty sẽ không được phép nếu không có thỏa thuận cấp phép thương hiệu.
                        </div>

                        <div class="hstack justify-content-sm-end gap-2 mt-4">
                            <a href="#!" class="btn btn-ghost-danger btn-hover me-3"><i class="ri-close-line align-bottom me-1"></i> Từ chối</a>
                            <a href="#!" class="btn btn-success btn-hover">Chấp nhận</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection