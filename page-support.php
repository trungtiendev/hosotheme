<?php
/*
Template Name: Trang Hỗ Trợ Kỹ Thuật
*/
get_header(); ?>

<main class="bg-light pb-5">
    
    <section class="bg-primary-custom text-white py-5 mb-5 shadow-sm" style="background: linear-gradient(135deg, #003366 0%, #0055a5 100%);">
        <div class="container text-center">
            <h1 class="fw-bold display-6 mb-2">TRUNG TÂM HỖ TRỢ KỸ THUẬT</h1>
            <p class="lead opacity-75 mb-0">Chúng tôi luôn sẵn sàng hỗ trợ bạn giải quyết mọi vấn đề hệ thống.</p>
        </div>
    </section>

    <div class="container" style="margin-top: -80px;"> <div class="row g-4">
            
            <div class="col-lg-5">
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold text-primary-custom mb-1">Kênh liên hệ trực tiếp</h5>
                        <p class="text-muted small mb-4">Dành cho các trường hợp khẩn cấp cần xử lý ngay.</p>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-circle bg-primary bg-opacity-10 text-primary me-3" style="width:45px; height:45px; font-size:20px;">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <small class="text-uppercase text-muted fw-bold" style="font-size:11px;">Hotline Kỹ thuật</small>
                                <div class="fw-bold text-dark h6 mb-0">0969.143.533</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-circle bg-success bg-opacity-10 text-success me-3" style="width:45px; height:45px; font-size:20px;">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <small class="text-uppercase text-muted fw-bold" style="font-size:11px;">Email Quản trị viên</small>
                                <div class="fw-bold text-dark h6 mb-0">trungtiendev@gmail.com</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-info bg-opacity-10 text-info me-3" style="width:45px; height:45px; font-size:20px;">
                                <i class="fa-solid fa-comments"></i>
                            </div>
                            <div>
                                <small class="text-uppercase text-muted fw-bold" style="font-size:11px;">Chat Zalo</small>
                                <div class="fw-bold text-dark h6 mb-0">0969.143.533 (Trung Tiến)</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-primary-custom"><i class="fa-solid fa-circle-question me-2"></i> Câu hỏi thường gặp</h6>
                    </div>
                    <div class="accordion accordion-flush" id="faqAccordion">
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Tại sao tôi không tải được văn bản?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted small">
                                    Một số văn bản thuộc dạng "Mật" hoặc "Nội bộ" yêu cầu tài khoản cấp cao mới xem được. Vui lòng kiểm tra lại phân quyền của bạn hoặc liên hệ Admin.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Làm sao để tìm kiếm chính xác?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted small">
                                    Bạn nên nhập chính xác "Số hiệu" văn bản (ví dụ: 123/CV-HĐTS) hoặc một đoạn trích yếu đặc biệt vào ô tìm kiếm để có kết quả tốt nhất.
                                </div>
                            </div>
                        </div>

                         <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Tôi quên mật khẩu đăng nhập?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted small">
                                    Vui lòng nhấn vào nút "Quên mật khẩu" ở trang đăng nhập, hoặc liên hệ trực tiếp Admin qua Zalo để được cấp lại mật khẩu mới nhanh nhất.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-bold text-primary-custom"><i class="fa-solid fa-pen-to-square me-2"></i> Gửi yêu cầu hỗ trợ</h5>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        
                        <div class="support-form-wrapper">
                            <?php echo do_shortcode('[contact-form-7 id="d792ab6" title="Support"]'); ?>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<style>
    /* Chỉnh lại style input của CF7 cho giống Bootstrap */
    .support-form-wrapper input[type="text"],
    .support-form-wrapper input[type="email"],
    .support-form-wrapper input[type="tel"],
    .support-form-wrapper textarea,
    .support-form-wrapper select {
        display: block;
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        background-color: #f8f9fa;
        background-clip: padding-box;
        border: 1px solid #dee2e6;
        appearance: none;
        border-radius: 0.375rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        margin-bottom: 1rem;
    }

    .support-form-wrapper input:focus,
    .support-form-wrapper textarea:focus,
    .support-form-wrapper select:focus {
        color: #212529;
        background-color: #fff;
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
    }

    .support-form-wrapper label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.9rem;
        color: #555;
    }

    .support-form-wrapper input[type="submit"] {
        display: inline-block;
        font-weight: 700;
        line-height: 1.5;
        color: #fff;
        text-align: center;
        text-decoration: none;
        vertical-align: middle;
        cursor: pointer;
        user-select: none;
        background-color: #ff9f43; /* Màu cam */
        border: 1px solid #ff9f43;
        padding: 0.75rem 2rem;
        font-size: 1rem;
        border-radius: 50rem; /* Nút tròn */
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        width: 100%;
        margin-top: 1rem;
        text-transform: uppercase;
    }

    .support-form-wrapper input[type="submit"]:hover {
        background-color: #e68a30;
        border-color: #e68a30;
    }
    
    /* Accordion Custom */
    .accordion-button:not(.collapsed) {
        color: #003366;
        background-color: #e7f1ff;
        box-shadow: inset 0 -1px 0 rgba(0,0,0,.125);
    }
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0,0,0,.125);
    }
</style>

<?php get_footer(); ?>