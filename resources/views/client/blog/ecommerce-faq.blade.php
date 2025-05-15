@extends('client.layout.ClientLayout')
@section('title', 'Giỏ Hàng')

@section('content')
<section class="ecommerce-about bg-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center">
                    <h1 class="text-white mb-0">Câu hỏi thường gặp</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light justify-content-center mt-4 fs-15">
                            <li class="breadcrumb-item"><a href="#">Cửa hàng</a></li>
                            <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="text-center">
                    <h3>Bạn có câu hỏi nào không?</h3>
                    <p class="text-muted mb-4">Bạn có thể hỏi bất kỳ điều gì liên quan đến sản phẩm hoặc dịch vụ của chúng tôi.</p>
                    <div class="hstack flex-wrap gap-2 justify-content-center">
                        <button type="button" class="btn btn-primary btn-label rounded-pill">
                            <i class="ri-mail-line label-icon align-middle rounded-pill fs-16"></i> Gửi Email
                        </button>
                        <button type="button" class="btn btn-info btn-label rounded-pill">
                            <i class="ri-twitter-line label-icon align-middle rounded-pill fs-16"></i> Nhắn tin trên Twitter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-3 col-md-6">
                <div class="card text-center mt-4 position-relative">
                    <div class="card-body">
                        <div class="avatar-md mx-auto mb-4">
                            <div class="avatar-title bg-success-subtle text-success rounded-circle h1 m-0">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        </div>
                        <h5 class="fs-16 mb-3"><a href="#" class="text-body stretched-link">Đơn hàng</a></h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card text-center mt-4">
                    <div class="card-body">
                        <div class="avatar-md mx-auto mb-4">
                            <div class="avatar-title bg-success-subtle text-success rounded-circle h1 m-0">
                                <i class="bi bi-cash-coin"></i>
                            </div>
                        </div>
                        <h5 class="fs-16 mb-3"><a href="#" class="text-body stretched-link">Thanh toán</a></h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card text-center mt-4">
                    <div class="card-body">
                        <div class="avatar-md mx-auto mb-4">
                            <div class="avatar-title bg-success-subtle text-success rounded-circle h1 m-0">
                                <i class="bi bi-truck"></i>
                            </div>
                        </div>
                        <h5 class="fs-16 mb-3"><a href="#" class="text-body stretched-link">Giao hàng</a></h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card text-center mt-4">
                    <div class="card-body">
                        <div class="avatar-md mx-auto mb-4">
                            <div class="avatar-title bg-success-subtle text-success rounded-circle h1 m-0">
                                <i class="bi bi-bag-dash"></i>
                            </div>
                        </div>
                        <h5 class="fs-16 mb-3"><a href="#" class="text-body stretched-link">Trả hàng</a></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4 justify-content-center mt-2">
            <div class="col-xxl-8 col-lg-8">
                <div>
                    <div class="mb-4">
                        <h5 class="fs-16 mb-0 fw-semibold">Câu hỏi chung</h5>
                    </div>

                    <div class="accordion accordion-border-box" id="genques-accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="genques-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseOne" aria-expanded="true" aria-controls="genques-collapseOne">
                                    Câu hỏi FAQ là gì?
                                </button>
                            </h2>
                            <div id="genques-collapseOne" class="accordion-collapse collapse show" aria-labelledby="genques-headingOne" data-bs-parent="#genques-accordion">
                                <div class="accordion-body">
                                    Trang FAQ <b>(Frequently Asked Questions - Câu hỏi thường gặp)</b> là nơi trên website cung cấp các câu trả lời cho những thắc mắc phổ biến, giúp khách hàng hiểu rõ hơn trước khi quyết định mua hàng.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="genques-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseTwo" aria-expanded="false" aria-controls="genques-collapseTwo">
                                    Quy trình xây dựng FAQ là gì?
                                </button>
                            </h2>
                            <div id="genques-collapseTwo" class="accordion-collapse collapse" aria-labelledby="genques-headingTwo" data-bs-parent="#genques-accordion">
                                <div class="accordion-body">
                                    FAQ là cơ hội để bạn tương tác với khách hàng đang cân nhắc mua hàng. Đây là nơi bạn trình bày các câu trả lời một cách rõ ràng và dễ hiểu cho các thắc mắc không được đề cập trong phần còn lại của website.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="genques-headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseThree" aria-expanded="false" aria-controls="genques-collapseThree">
                                    Mục đích của trang FAQ là gì?
                                </button>
                            </h2>
                            <div id="genques-collapseThree" class="accordion-collapse collapse" aria-labelledby="genques-headingThree" data-bs-parent="#genques-accordion">
                                <div class="accordion-body">
                                    Mục đích chính của FAQ là cung cấp thông tin nhanh chóng cho các câu hỏi phổ biến, từ đó giúp khách hàng tiết kiệm thời gian và tăng sự tin tưởng vào doanh nghiệp của bạn.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="genques-headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#genques-collapseFour" aria-expanded="false" aria-controls="genques-collapseFour">
                                    FAQ trực tuyến là gì?
                                </button>
                            </h2>
                            <div id="genques-collapseFour" class="accordion-collapse collapse" aria-labelledby="genques-headingFour" data-bs-parent="#genques-accordion">
                                <div class="accordion-body">
                                    FAQ trực tuyến là trang thông tin giúp khách hàng tìm được câu trả lời nhanh chóng cho các vấn đề thường gặp khi sử dụng sản phẩm hoặc dịch vụ trên website của bạn.
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end accordion-->
                </div>
            </div>
        </div>
    </div>
</section>

@endsection