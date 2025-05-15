@extends('client.layout.ClientLayout')
@section('title', 'Giỏ Hàng')

@section('content')
<section class="ecommerce-about">
    <div class="effect d-none d-md-block">
        <div class="ecommerce-effect bg-primary"></div>
        <div class="ecommerce-effect bg-info"></div>
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="fw-bold mb-3">👋 Về Chúng Tôi</h1>
                <p class="fs-16 text-muted mb-5 mb-lg-3">
                    Chúng tôi là một đơn vị độc lập, không thiên vị, và mỗi ngày tạo ra các chương trình và nội dung đặc sắc, đẳng cấp thế giới để thông tin, giáo dục và giải trí cho hàng triệu người trên toàn thế giới. Quá trình suy nghĩ đã dẫn đến việc tạo ra và bán các sản phẩm.
                </p>
            </div>
            <div class="col-lg-6">
                <div>
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="position-relative">
                                <img src="{{ asset('client/images/ecommerce/img-4.jpg') }}" alt="" class="img-fluid rounded">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="vstack gap-4">
                                <img src="{{ asset('client/images/ecommerce/img-1.jpg') }}" alt="" class="img-fluid rounded">
                                <img src="{{ asset('client/images/ecommerce/img-3.jpg') }}" alt="" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="ecommerce-about-cta">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-animate border-0">
                    <div class="card-body">
                        <lord-icon src="https://cdn.lordicon.com/fcoczpqi.json" trigger="hover" target="div" style="width:70px;height:70px">
                        </lord-icon>
                        <h5 class="fs-16 mt-3">25.000+ Khách Hàng Hài Lòng</h5>
                        <p class="text-muted">Sự hài lòng của khách hàng vượt qua mong đợi bằng cách tạo ra sự kết nối cảm xúc với thương hiệu.</p>
                        <div>
                            <a href="#!" class="link-effect link-primary">Xem Thêm <i class="bi bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-animate border-0">
                    <div class="card-body">
                        <lord-icon src="https://cdn.lordicon.com/hbwqfgcf.json" trigger="hover" target="div" style="width:70px;height:70px">
                        </lord-icon>
                        <h5 class="fs-16 mt-3">Hơn 6 Năm Kinh Nghiệm</h5>
                        <p class="text-muted">Số năm kinh nghiệm thể hiện quá trình làm việc và những kỹ năng bạn đã tích lũy được.</p>
                        <div>
                            <a href="#!" class="link-effect link-primary">Xem Thêm <i class="bi bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-animate border-0">
                    <div class="card-body">
                        <lord-icon src="https://cdn.lordicon.com/xhbsnkyp.json" trigger="hover" target="div" style="width:70px;height:70px">
                        </lord-icon>
                        <h5 class="fs-16 mt-3">14 Giải Thưởng Đạt Được</h5>
                        <p class="text-muted">Các giải thưởng nội dung toàn cầu tôn vinh sự xuất sắc trong lĩnh vực tiếp thị nội dung và ghi nhận các agency cũng như đội ngũ nội bộ.</p>
                        <div>
                            <a href="#!" class="link-effect link-primary">Xem Thêm <i class="bi bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="ecommerce-about-team bg-light bg-opacity-50">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center mb-5">
                    <h2 class="mb-3">Đội Ngũ Quản Lý Chuyên Gia</h2>
                    <p class="text-muted fs-15">Một nhà lãnh đạo chuyên gia là người có kiến thức chuyên sâu trong lĩnh vực mà họ đang lãnh đạo.</p>
                </div>
            </div>
        </div>
        <div class="row gy-4">
            <div class="col-xl-3 col-md-6">
                <div class="team-box text-center">
                    <div class="team-img">
                        <img src="{{ asset('client/images/users/avatar-7.jpg') }}" alt="" class="img-fluid rounded rounded-circle border border-dashed border-dark border-opacity-25">
                    </div>
                    <div class="mt-4 pt-1">
                        <a href="#!">
                            <h5>Rachael Larson</h5>
                        </a>
                        <p class="text-muted mb-0">Người Sáng Lập</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="team-box text-center">
                    <div class="team-img">
                        <img src="{{ asset('client/images/users/avatar-1.jpg') }}" alt="" class="img-fluid rounded rounded-circle border border-dashed border-dark border-opacity-25">
                    </div>
                    <div class="mt-4 pt-1">
                        <a href="#!">
                            <h5>Jennifer Thompson</h5>
                        </a>
                        <p class="text-muted mb-0">Quản Lý Cấp Cao</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="team-box text-center">
                    <div class="team-img">
                        <img src="{{ asset('client/images/users/avatar-2.jpg') }}" alt="" class="img-fluid rounded rounded-circle border border-dashed border-dark border-opacity-25">
                    </div>
                    <div class="mt-4 pt-1">
                        <a href="#!">
                            <h5>Amanda Rivera</h5>
                        </a>
                        <p class="text-muted mb-0">Chuyên Viên Marketing</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="team-box text-center">
                    <div class="team-img">
                        <img src="{{ asset('client/images/users/avatar-8.jpg') }}" alt="" class="img-fluid rounded rounded-circle border border-dashed border-dark border-opacity-25">
                    </div>
                    <div class="mt-4 pt-1">
                        <a href="#!">
                            <h5>Donald Schmidt</h5>
                        </a>
                        <p class="text-muted mb-0">Chuyên Viên Kế Toán</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div>
                    <img src="{{ asset('client/images/ecommerce/img-5.jpg') }}" alt="" class="img-fluid rounded">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mt-4 mt-lg-0">
                    <p class="text-uppercase fw-medium text-muted">Sản Phẩm Bán Chạy Nhất</p>
                    <h2 class="lh-base fw-semibold mb-3">Thiết kế không gian để thúc đẩy sự phát triển doanh nghiệp</h2>
                    <p class="text-muted fs-16">
                        Không gian văn phòng thực tế giúp thúc đẩy sự hợp tác và thấu hiểu. Việc có một địa điểm cụ thể giúp bạn xây dựng công ty theo cách bạn mong muốn trong môi trường nơi nhân viên có thể giao tiếp trực tiếp mà không cần qua nhiều bước trung gian.
                    </p>
                    <a href="#!" class="fw-medium link-effect">Mua Ngay <i class="bi bi-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection