<?php get_header(); ?>

<main class="bg-light pb-5">
    
    <section class="bg-primary-custom text-white py-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #003366 0%, #0055a5 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2 opacity-75 small">
                            <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" class="text-white text-decoration-none">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo home_url('/ho-so-chua'); ?>" class="text-white text-decoration-none">Danh sách Tự viện</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page"><?php the_title(); ?></li>
                        </ol>
                    </nav>
                    <h1 class="fw-bold text-uppercase display-6 mb-0"><i class="fa-solid fa-place-of-worship me-2"></i> <?php the_title(); ?></h1>
                </div>
            </div>
        </div>
    </section>

    <div class="container" style="margin-top: -30px;">
        <div class="row g-4">
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4 text-center">
                        <div class="mb-4">
                            <?php if(has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('medium', ['class' => 'img-fluid rounded shadow-sm border p-1 bg-white', 'style' => 'max-height:250px; width:auto;']); ?>
                            <?php else: ?>
                                <div class="bg-light rounded d-flex align-items-center justify-content-center mx-auto text-muted" style="width:150px; height:150px; border:1px dashed #ccc;">
                                    <i class="fa-solid fa-image fa-3x opacity-25"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <ul class="list-group list-group-flush text-start small">
                            <li class="list-group-item px-0 py-3 border-top-0">
                                <span class="d-block text-muted text-uppercase fw-bold mb-1" style="font-size:11px;">Trụ trì / Đại diện</span>
                                <div class="fw-bold text-dark h6 mb-0">
                                    <i class="fa-solid fa-user-tie text-primary me-2"></i> 
                                    <?php echo get_post_meta(get_the_ID(), '_pg_abbot', true) ?: 'Đang cập nhật...'; ?>
                                </div>
                            </li>
                            <li class="list-group-item px-0 py-3">
                                <span class="d-block text-muted text-uppercase fw-bold mb-1" style="font-size:11px;">Địa chỉ</span>
                                <div class="text-dark">
                                    <i class="fa-solid fa-location-dot text-danger me-2"></i>
                                    <?php echo get_post_meta(get_the_ID(), '_pg_address', true) ?: 'Đang cập nhật...'; ?>
                                </div>
                            </li>
                            <li class="list-group-item px-0 py-3">
                                <span class="d-block text-muted text-uppercase fw-bold mb-1" style="font-size:11px;">Điện thoại</span>
                                <div class="text-dark font-monospace">
                                    <i class="fa-solid fa-phone text-success me-2"></i>
                                    <?php echo get_post_meta(get_the_ID(), '_pg_phone', true) ?: '---'; ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                
                <ul class="nav nav-pills mb-4 gap-2" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold text-uppercase px-4" id="pills-docs-tab" data-bs-toggle="pill" data-bs-target="#pills-docs" type="button" role="tab">
                            <i class="fa-solid fa-folder-open me-2"></i> Văn bản liên quan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold text-uppercase px-4 border" id="pills-info-tab" data-bs-toggle="pill" data-bs-target="#pills-info" type="button" role="tab">
                            <i class="fa-solid fa-circle-info me-2"></i> Giới thiệu chung
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    
                    <div class="tab-pane fade show active" id="pills-docs" role="tabpanel">
                        <div class="card border-0 shadow-sm">
                            <div class="list-group list-group-flush">
                                <?php 
                                    $current_pagoda_id = get_the_ID();
                                    $pg_query = new WP_Query(array(
                                        'post_type'      => 'post',
                                        'post_status'    => 'publish',
                                        'posts_per_page' => 20,
                                        'meta_query'     => array(
                                            array(
                                                'key'     => '_related_pagoda_id',
                                                'value'   => $current_pagoda_id,
                                                'compare' => '='
                                            )
                                        )
                                    ));

                                    if($pg_query->have_posts()) :
                                        while($pg_query->have_posts()) : $pg_query->the_post();
                                ?>
                                <div class="list-group-item list-group-item-action p-4 d-flex gap-3 align-items-start border-bottom">
                                    <div class="text-center bg-light rounded p-2 border" style="min-width: 65px;">
                                        <span class="d-block fw-bold h4 mb-0 text-primary"><?php echo get_the_date('d'); ?></span>
                                        <span class="d-block small text-uppercase text-muted fw-bold"><?php echo get_the_date('M'); ?></span>
                                        <span class="d-block small text-muted" style="font-size:10px"><?php echo get_the_date('Y'); ?></span>
                                    </div>

                                    <div class="flex-grow-1">
                                        <h6 class="mb-2">
                                            <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none fw-bold hover-link">
                                                <?php the_title(); ?>
                                            </a>
                                        </h6>
                                        <div class="small text-muted d-none d-sm-block">
                                            <?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?>
                                        </div>
                                    </div>

                                    <div class="d-none d-md-block align-self-center">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            Xem
                                        </a>
                                    </div>
                                </div>
                                <?php endwhile; else: ?>
                                    
                                    <div class="text-center py-5">
                                        <div class="mb-3 text-muted opacity-25">
                                            <i class="fa-regular fa-folder-open display-1"></i>
                                        </div>
                                        <h5 class="fw-bold text-muted">Chưa có dữ liệu</h5>
                                        <p class="text-muted small mb-0">Hiện chưa có văn bản nào được gán cho đơn vị này.</p>
                                    </div>

                                <?php endif; wp_reset_postdata(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-info" role="tabpanel">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4 p-lg-5">
                                <h5 class="fw-bold border-bottom pb-3 mb-4 text-uppercase text-primary-custom">Giới thiệu về <?php the_title(); ?></h5>
                                <div class="entry-content text-justify" style="line-height: 1.8;">
                                    <?php the_content() ?: '<p class="text-muted fst-italic">Nội dung giới thiệu đang được cập nhật...</p>'; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</main>

<style>
    /* CSS TÙY CHỈNH CHO TAB HỒ SƠ CHÙA */
    
    /* 1. Trạng thái MẶC ĐỊNH (Chưa chọn) */
    /* Bắt buộc nền trắng, chữ đen */
    .nav-pills .nav-link {
        background-color: #ffffff !important; 
        color: #333333 !important;            
        border: 1px solid #dee2e6 !important; 
        transition: all 0.3s ease;
    }

    /* 2. Hiệu ứng Hover (Di chuột vào) */
    .nav-pills .nav-link:hover {
        background-color: #f8f9fa !important; 
        color: var(--primary-color) !important; 
        transform: translateY(-2px);
    }

    /* 3. Trạng thái ACTIVE (Đang chọn) */
    /* Bắt buộc nền xanh, chữ trắng */
    .nav-pills .nav-link.active,
    .nav-pills .show > .nav-link {
        background-color: var(--primary-color) !important; 
        color: #ffffff !important; 
        border-color: var(--primary-color) !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    /* 4. Link hover trong danh sách bài viết */
    .hover-link:hover {
        color: var(--secondary-color) !important;
    }
</style>
<?php get_footer(); ?>