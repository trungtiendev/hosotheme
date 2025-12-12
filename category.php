<?php
/**
 * Template Name: Category Archive (Bootstrap 5)
 */
get_header(); ?>

<main class="bg-light pb-5">
    
    <section class="bg-primary-custom text-white py-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #003366 0%, #0055a5 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2 opacity-75 small text-uppercase">
                            <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" class="text-white text-decoration-none">Trang chủ</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Danh mục</li>
                        </ol>
                    </nav>
                    
                    <h1 class="fw-bold display-6 mb-2 text-uppercase">
                        <i class="fa-solid fa-folder-open me-2"></i> <?php single_cat_title(); ?>
                    </h1>
                    
                    <?php if ( category_description() ) : ?>
                        <div class="lead fs-6 opacity-75 mb-0" style="max-width: 700px;">
                            <?php echo strip_tags(category_description()); ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="col-lg-4 text-lg-end d-none d-lg-block">
                    <div class="d-inline-block bg-white bg-opacity-10 rounded px-4 py-2 border border-white border-opacity-25">
                        <span class="d-block h2 fw-bold mb-0"><?php echo $wp_query->found_posts; ?></span>
                        <small class="text-uppercase opacity-75">Văn bản lưu trữ</small>
                    </div>
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
                                                <?php 
                                                    // Hiển thị Chùa liên quan (nếu có)
                                                    $pagoda_id = get_post_meta( get_the_ID(), '_related_pagoda_id', true );
                                                    if($pagoda_id && is_numeric($pagoda_id)) {
                                                        echo '<span class="text-danger me-3"><i class="fa-solid fa-place-of-worship me-1"></i> '.get_the_title($pagoda_id).'</span>';
                                                    }
                                                ?>
                                                <span class="me-3"><i class="fa-regular fa-user me-1"></i> <?php the_author(); ?></span>
                                            </div>

                                            <div class="text-muted small d-none d-sm-block text-truncate-2">
                                                <?php echo wp_trim_words( get_the_excerpt(), 25, '...' ); ?>
                                            </div>
                                        </div>

                                        <div class="d-none d-md-block align-self-center ms-3">
                                            <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 text-uppercase fw-bold">
                                                Chi tiết
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
                                    <i class="fa-regular fa-folder-open fa-4x"></i>
                                </div>
                                <h4 class="fw-bold text-muted">Chưa có dữ liệu</h4>
                                <p class="text-muted mb-4">Danh mục này hiện chưa có văn bản nào được cập nhật.</p>
                                <a href="<?php echo home_url(); ?>" class="btn btn-primary-custom">
                                    <i class="fa-solid fa-house me-2"></i> Quay về trang chủ
                                </a>
                            </div>

                        <?php endif; ?>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<style>
    /* CSS hỗ trợ cắt dòng */
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Hiệu ứng hover tiêu đề */
    .hover-primary:hover {
        color: var(--primary-color) !important;
    }
    
    /* Style Pagination */
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