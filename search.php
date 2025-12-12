<?php
/**
 * Template Name: Search Results (Bootstrap 5)
 */
get_header(); ?>

<main class="bg-light pb-5">
    
    <section class="bg-primary-custom text-white py-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #003366 0%, #0055a5 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="fw-bold mb-3 h3 text-uppercase">
                        <i class="fa-solid fa-magnifying-glass me-2"></i> Kết quả tìm kiếm
                    </h1>
                    <p class="mb-4 opacity-75">
                        Từ khóa: <strong class="text-warning">"<?php echo get_search_query(); ?>"</strong> 
                        &bull; Tìm thấy <span class="badge bg-warning text-dark rounded-pill px-3"><?php echo $wp_query->found_posts; ?></span> kết quả
                    </p>
                    
                    <form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="input-group input-group-lg shadow-sm">
                        <input type="text" name="s" class="form-control border-0" placeholder="Nhập từ khóa khác..." value="<?php echo get_search_query(); ?>">
                        <button class="btn btn-warning text-dark fw-bold px-4" type="button">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="container" style="margin-top: -30px;">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        
                        <?php if ( have_posts() ) : ?>
                            <div class="list-group list-group-flush">
                                <?php while ( have_posts() ) : the_post(); ?>
                                    
                                    <div class="list-group-item list-group-item-action p-4 d-flex gap-3 align-items-start border-bottom">
                                        
                                        <div class="text-center bg-light rounded p-2 border flex-shrink-0" style="min-width: 70px;">
                                            <span class="d-block fw-bold h4 mb-0 text-primary-custom"><?php echo get_the_date('d'); ?></span>
                                            <span class="d-block small text-uppercase text-muted fw-bold"><?php echo get_the_date('M'); ?></span>
                                            <span class="d-block small text-muted" style="font-size:10px"><?php echo get_the_date('Y'); ?></span>
                                        </div>

                                        <div class="flex-grow-1">
                                            <h5 class="mb-2">
                                                <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none fw-bold hover-primary">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h5>
                                            
                                            <div class="mb-2 small text-muted">
                                                <span class="me-3">
                                                    <i class="fa-regular fa-folder-open me-1"></i> <?php the_category(', '); ?>
                                                </span>
                                                <?php 
                                                    // Hiển thị Chùa liên quan (nếu có)
                                                    $pagoda_id = get_post_meta( get_the_ID(), '_related_pagoda_id', true );
                                                    if($pagoda_id && is_numeric($pagoda_id)) {
                                                        echo '<span class="text-danger"><i class="fa-solid fa-place-of-worship me-1"></i> '.get_the_title($pagoda_id).'</span>';
                                                    }
                                                ?>
                                            </div>

                                            <div class="text-muted small d-none d-sm-block">
                                                <?php echo wp_trim_words( get_the_excerpt(), 30, '...' ); ?>
                                            </div>
                                        </div>

                                        <div class="d-none d-md-block align-self-center">
                                            <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                Xem chi tiết
                                            </a>
                                        </div>

                                    </div>
                                    <?php endwhile; ?>
                            </div>

                            <div class="p-4 d-flex justify-content-center bg-light rounded-bottom">
                                <nav aria-label="Page navigation">
                                    <?php
                                        echo paginate_links( array(
                                            'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                                            'format'    => '?paged=%#%',
                                            'current'   => max( 1, get_query_var( 'paged' ) ),
                                            'total'     => $wp_query->max_num_pages,
                                            'prev_text' => '<i class="fa-solid fa-chevron-left"></i>',
                                            'next_text' => '<i class="fa-solid fa-chevron-right"></i>',
                                            'type'      => 'list',
                                            'before_page_number' => '',
                                        ) );
                                    ?>
                                </nav>
                            </div>

                        <?php else : ?>

                            <div class="text-center py-5">
                                <div class="mb-3 text-muted opacity-25">
                                    <i class="fa-solid fa-file-circle-xmark fa-4x"></i>
                                </div>
                                <h4 class="fw-bold text-muted">Không tìm thấy kết quả nào</h4>
                                <p class="text-muted mb-4">Rất tiếc, hệ thống không tìm thấy văn bản phù hợp với từ khóa <strong>"<?php echo get_search_query(); ?>"</strong>.</p>
                                
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="<?php echo home_url(); ?>" class="btn btn-primary-custom">
                                        <i class="fa-solid fa-house me-2"></i> Về trang chủ
                                    </a>
                                    <button onclick="history.back()" class="btn btn-outline-secondary">
                                        <i class="fa-solid fa-arrow-left me-2"></i> Quay lại
                                    </button>
                                </div>
                            </div>

                        <?php endif; ?>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<style>
    /* CSS Tùy chỉnh riêng cho trang tìm kiếm */
    .hover-primary:hover {
        color: var(--primary-color) !important; /* Màu xanh navy */
    }
    
    /* Pagination Styles (Nếu chưa có trong style.css) */
    .page-numbers {
        display: flex; gap: 5px; list-style: none; padding: 0; margin: 0;
    }
    .page-numbers li a, .page-numbers li span {
        display: flex; align-items: center; justify-content: center;
        width: 35px; height: 35px; border-radius: 5px;
        border: 1px solid #dee2e6; background: #fff;
        color: #333; text-decoration: none; font-weight: bold;
    }
    .page-numbers li span.current, .page-numbers li a:hover {
        background: var(--primary-color); color: #fff; border-color: var(--primary-color);
    }
</style>

<?php get_footer(); ?>