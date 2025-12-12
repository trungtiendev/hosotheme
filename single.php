<?php get_header(); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                
                <article class="bg-white p-5 rounded shadow-sm border">
                    <header class="text-center mb-5 border-bottom pb-4">
                        <h1 class="fw-bold text-primary-custom mb-3"><?php the_title(); ?></h1>
                        <div class="text-muted small">
                            <span class="me-3"><i class="fa-regular fa-clock"></i> <?php echo get_the_date('d/m/Y'); ?></span>
                            <span class="me-3"><i class="fa-regular fa-folder"></i> <?php the_category(', '); ?></span>
                        </div>
                    </header>

                    <div class="bg-light p-4 rounded mb-4 border">
                        <div class="row">
                            <?php 
                                $pagoda_id = get_post_meta(get_the_ID(), '_related_pagoda_id', true);
                                if($pagoda_id && is_numeric($pagoda_id)): 
                            ?>
                            <div class="col-12 mb-2">
                                <strong><i class="fa-solid fa-place-of-worship me-2"></i> Đơn vị:</strong> 
                                <a href="<?php echo get_permalink($pagoda_id); ?>" class="fw-bold text-danger">
                                    <?php echo get_the_title($pagoda_id); ?>
                                </a>
                            </div>
                            <?php endif; ?>
                            
                            <div class="col-12">
                                <strong><i class="fa-solid fa-tags me-2"></i> Ký hiệu:</strong> ... (Đang cập nhật)
                            </div>
                        </div>
                    </div>

                    <div class="entry-content" style="font-size: 1.1rem; line-height: 1.8;">
                        <?php the_content(); ?>
                    </div>

                </article>

            <?php endwhile; endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>