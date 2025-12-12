<?php get_header(); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <header class="mb-4 pb-3 border-bottom d-flex justify-content-between align-items-center">
                <h1 class="h3 fw-bold text-primary-custom mb-0 text-uppercase">
                    <?php
                    if ( is_search() ) {
                        printf( '<i class="fa-solid fa-magnifying-glass me-2"></i> Kết quả tìm kiếm: "%s"', get_search_query() );
                    } elseif ( is_category() || is_tag() || is_tax() ) {
                        echo '<i class="fa-solid fa-folder-open me-2"></i> ';
                        single_term_title();
                    } elseif ( is_home() ) {
                        echo '<i class="fa-solid fa-newspaper me-2"></i> Tin tức & Văn bản mới';
                    } else {
                        the_archive_title();
                    }
                    ?>
                </h1>
                <span class="badge bg-secondary rounded-pill">
                    <?php echo $wp_query->found_posts; ?> văn bản
                </span>
            </header>

            <?php if ( have_posts() ) : ?>
                <div class="card border-0 shadow-sm">
                    <div class="list-group list-group-flush">
                        
                        <?php while ( have_posts() ) : the_post(); ?>
                            <article class="list-group-item list-group-item-action p-4 d-flex gap-3 align-items-start border-bottom">
                                
                                <div class="text-center bg-light rounded p-2 border" style="min-width: 75px;">
                                    <span class="d-block fw-bold h3 mb-0 text-primary-custom" style="line-height:1"><?php echo get_the_date('d'); ?></span>
                                    <span class="d-block small text-uppercase text-muted fw-bold"><?php echo get_the_date('M'); ?></span>
                                    <span class="d-block small text-muted" style="font-size:10px"><?php echo get_the_date('Y'); ?></span>
                                </div>

                                <div class="flex-grow-1">
                                    <h5 class="mb-2">
                                        <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none fw-bold hover-link">
                                            <?php the_title(); ?>
                                        </a>
                                    </h5>

                                    <div class="small text-muted mb-2">
                                        <span class="me-3"><i class="fa-regular fa-folder me-1"></i> <?php the_category(', '); ?></span>
                                        <?php 
                                            // Hiển thị Chùa liên quan (nếu có)
                                            $pagoda_id = get_post_meta( get_the_ID(), '_related_pagoda_id', true );
                                            if($pagoda_id && is_numeric($pagoda_id)) {
                                                echo '<span class="text-danger"><i class="fa-solid fa-place-of-worship me-1"></i> '.get_the_title($pagoda_id).'</span>';
                                            }
                                        ?>
                                    </div>

                                    <div class="text-muted small d-none d-sm-block">
                                        <?php echo wp_trim_words( get_the_excerpt(), 25, '...' ); ?>
                                    </div>
                                </div>

                                <div class="d-none d-md-block align-self-center">
                                    <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        Xem <i class="fa-solid fa-angle-right ms-1"></i>
                                    </a>
                                </div>

                            </article>
                        <?php endwhile; ?>

                    </div>
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    <nav aria-label="Page navigation">
                        <?php
                        echo paginate_links( array(
                            'mid_size'  => 2,
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
                        <i class="fa-regular fa-folder-open display-1"></i>
                    </div>
                    <h4>Không tìm thấy dữ liệu</h4>
                    <p class="text-muted">Vui lòng thử lại với từ khóa khác hoặc quay về trang chủ.</p>
                    <a href="<?php echo home_url(); ?>" class="btn btn-primary-custom px-4 mt-3">
                        <i class="fa-solid fa-house me-2"></i> Quay về Dashboard
                    </a>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>