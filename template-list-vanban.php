<?php
/*
Template Name: Danh sách Văn bản (List View)
*/
get_header(); 

// 1. Tự động xác định tiêu đề và query dựa trên trang hiện tại
// Mặc định lấy tiêu đề trang làm tiêu đề danh sách
$page_title = get_the_title(); 

// Xác định chuyên mục cần lấy (Bạn có thể sửa slug ở đây nếu muốn cố định)
// Mẹo: Nếu trang này là "Công văn đến", hãy đảm bảo slug trang hoặc setup khớp với category
$category_slug = '';

if ( is_page('cong-van-den') || strpos($post->post_name, 'den') !== false ) {
    $category_slug = 'cong-van-den';
} elseif ( is_page('cong-van-phat-hanh') || strpos($post->post_name, 'phat-hanh') !== false || strpos($post->post_name, 'di') !== false ) {
    $category_slug = 'cong-van-di';
} else {
    // Mặc định lấy tất cả nếu không khớp
    $category_slug = ''; 
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="mb-5">
                <h2 class="fw-bold text-secondary text-uppercase mb-2"><?php echo $page_title; ?></h2>
                <div class="bg-secondary" style="width: 50px; height: 4px; border-radius: 2px;"></div>
            </div>

            <div class="cv-list-wrapper">
                <?php
                // Cấu hình Query
                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                $args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => 10,
                    'paged'          => $paged,
                    'orderby'        => 'date',
                    'order'          => 'DESC'
                );
                
                // Nếu xác định được category thì lọc, không thì lấy hết
                if( !empty($category_slug) ) {
                    $args['category_name'] = $category_slug;
                }

                $the_query = new WP_Query( $args );

                if ( $the_query->have_posts() ) :
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                ?>
                    <div class="cv-item d-flex align-items-center py-4 border-bottom">
                        
                        <div class="cv-date-box text-center me-4">
                            <span class="d-block cv-day"><?php echo get_the_date('d'); ?></span>
                            <span class="d-block cv-month">TH<?php echo get_the_date('m/y'); ?></span>
                        </div>

                        <div class="cv-content flex-grow-1 pe-3">
                            <h5 class="mb-1">
                                <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark fw-bold hover-primary">
                                    <?php the_title(); ?>
                                </a>
                            </h5>
                            <div class="text-muted small cv-excerpt">
                                <?php 
                                    // Hiển thị trích yếu hoặc mô tả ngắn
                                    if(has_excerpt()) {
                                        echo get_the_excerpt();
                                    } else {
                                        echo wp_trim_words(get_the_content(), 20, '...');
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="cv-action d-none d-sm-block">
                            <a href="<?php the_permalink(); ?>" class="btn btn-outline-custom text-uppercase fw-bold btn-sm px-3 py-2">
                                Xem chi tiết
                            </a>
                        </div>

                    </div>
                    <?php endwhile; ?>

                <div class="mt-5 d-flex justify-content-center">
                    <nav aria-label="Page navigation">
                        <?php
                        echo paginate_links( array(
                            'total'        => $the_query->max_num_pages,
                            'current'      => max( 1, get_query_var( 'paged' ) ),
                            'format'       => '?paged=%#%',
                            'prev_next'    => true,
                            'prev_text'    => '<i class="fa-solid fa-chevron-left"></i>',
                            'next_text'    => '<i class="fa-solid fa-chevron-right"></i>',
                            'type'         => 'list',
                            'before_page_number' => '',
                        ) );
                        ?>
                    </nav>
                </div>

                <?php else : ?>
                    <div class="alert alert-light text-center py-5">
                        <i class="fa-regular fa-folder-open fa-3x text-muted mb-3"></i>
                        <p class="mb-0 text-muted">Chưa có văn bản nào trong mục này.</p>
                    </div>
                <?php endif; wp_reset_postdata(); ?>
            </div>

        </div>
    </div>
</div>

<?php get_footer(); ?>