<?php get_header(); 
function get_cat_count_bs($slug) {
    $cat = get_category_by_slug($slug);
    return $cat ? $cat->count : 0;
}
?>

<main class="py-4">
    
    <section class="container mb-5">
        <div class="bg-primary-custom rounded-4 p-5 text-center text-white shadow" style="background: linear-gradient(135deg, #003366 0%, #0055a5 100%);">
            <h1 class="fw-bold mb-3 text-uppercase">Hệ thống Quản lý Văn bản</h1>
            <p class="mb-4 opacity-75">Tra cứu nhanh chóng - Quản lý tập trung - Điều hành hiệu quả</p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form action="<?php echo home_url('/'); ?>" method="get" class="input-group input-group-lg shadow-sm">
                        <input type="text" name="s" class="form-control border-0" placeholder="Nhập số hiệu, trích yếu văn bản..." autocomplete="off">
                        <button class="btn btn-warning text-white fw-bold px-4" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i> TÌM KIẾM
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="row g-4">
            <div class="col-6 col-md-3">
                <div class="stats-card card-green">
                    <div class="stats-icon"><i class="fa-regular fa-envelope"></i></div>
                    <div class="stats-info">
                        <span class="stats-number"><?php echo get_cat_count_bs('cong-van-den'); ?></span>
                        <h3>Công văn Đến</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stats-card card-blue">
                    <div class="stats-icon"><i class="fa-regular fa-paper-plane"></i></div>
                    <div class="stats-info">
                        <span class="stats-number"><?php echo get_cat_count_bs('cong-van-di'); ?></span>
                        <h3>Công văn Đi</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stats-card card-orange">
                    <div class="stats-icon"><i class="fa-solid fa-file-lines"></i></div>
                    <div class="stats-info">
                        <span class="stats-number"><?php echo wp_count_posts()->publish; ?></span>
                        <h3>Tổng văn bản</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <a href="/ho-tro" class="text-decoration-none">
                    <div class="stats-card card-purple">
                        <div class="stats-icon"><i class="fa-solid fa-headset"></i></div>
                        <div class="stats-info">
                            <span class="stats-number" style="font-size:18px">Hỗ Trợ Kỹ Thuật</span>
                            <h3>Liên hệ Quản Trị Viên</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-primary-custom"><i class="fa-solid fa-place-of-worship me-2"></i> QUẢN LÝ TỰ VIỆN</h5>
                <?php if(current_user_can('edit_posts')): ?>
                    <a href="<?php echo admin_url('post-new.php?post_type=chua'); ?>" class="btn btn-sm btn-outline-primary fw-bold text-nowrap">
                        <i class="fa-solid fa-plus"></i> <span class="d-none d-sm-inline">Thêm mới</span>
                    </a>
                <?php endif; ?>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    
                    <div class="col-md-5">
                        <div class="bg-light p-4 rounded h-100 d-flex flex-column justify-content-center">
                            
                            <div>
                                <label class="fw-bold mb-2 small text-muted text-uppercase">TRA CỨU NHANH</label>
                                <select class="pagoda-frontend-select form-control" style="width: 100%;">
                                    <option></option> 
                                </select>
                                <small class="text-muted mt-2 d-block fst-italic">
                                    <i class="fa-solid fa-circle-info me-1"></i> Nhập tên chùa (ví dụ: Phật Quang) để xem hồ sơ.
                                </small>
                            </div>

                            <div class="mt-4 pt-3 border-top border-secondary border-opacity-10 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm text-primary me-3 border" style="width: 40px; height: 40px;">
                                        <i class="fa-solid fa-layer-group"></i>
                                    </div>
                                    <div class="line-height-sm">
                                        <span class="d-block small text-muted text-uppercase fw-bold">Tổng số Tự viện</span>
                                        <span class="d-block small text-muted" style="font-size: 11px;">Trong hệ thống</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="display-6 fw-bold text-primary-custom" style="font-size: 2rem;">
                                        <?php echo wp_count_posts('chua')->publish; ?>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-7 border-start-md">
                        <h6 class="fw-bold text-muted mb-3 small text-uppercase">Hồ sơ cập nhật gần đây</h6>
                        
                        <?php 
                            $pg_query = new WP_Query(array(
                                'post_type' => 'chua', 
                                'posts_per_page' => 3, // Lấy 3 chùa mới nhất
                                'orderby' => 'modified'
                            ));
                            
                            if ( $pg_query->have_posts() ) :
                                while($pg_query->have_posts()) : $pg_query->the_post();
                                $addr = get_post_meta(get_the_ID(), '_pg_address', true);
                        ?>
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width:45px; height:45px;">
                                <i class="fa-solid fa-vihara fs-5"></i>
                            </div>
                            <div class="flex-grow-1 me-2" style="min-width: 0;">
                                <a href="<?php the_permalink(); ?>" class="fw-bold text-dark text-decoration-none d-block text-truncate">
                                    <?php the_title(); ?>
                                </a>
                                <div class="small text-muted text-truncate">
                                    <?php echo $addr ? '<i class="fa-solid fa-location-dot me-1"></i> ' . $addr : 'Chưa cập nhật địa chỉ'; ?>
                                </div>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-light border flex-shrink-0 text-nowrap">
                                Chi tiết
                            </a>
                        </div>
                        <?php endwhile; wp_reset_postdata(); else: ?>
                            
                            <div class="text-center py-4 text-muted">
                                <div class="mb-2 opacity-25">
                                    <i class="fa-solid fa-gopuram fa-3x"></i>
                                </div>
                                <p class="mb-0 small fw-bold">Chưa có hồ sơ chùa nào được cập nhật.</p>
                                <p class="small opacity-75">Vui lòng thêm dữ liệu mới để hiển thị tại đây.</p>
                            </div>

                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="row g-4">
            
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-bold text-success border-bottom border-success border-3 d-flex justify-content-between align-items-center">
                        <span><i class="fa-solid fa-file-import me-2"></i> VĂN BẢN ĐẾN</span>
                        <a href="/cong-van-den" class="small text-decoration-none text-muted fw-normal">Xem tất cả <i class="fa-solid fa-angle-right"></i></a>
                    </div>
                    
                    <ul class="list-group list-group-flush">
                        <?php 
                        $q1 = new WP_Query(array('category_name' => 'cong-van-den', 'posts_per_page' => 5));
                        
                        if ( $q1->have_posts() ) :
                            while($q1->have_posts()): $q1->the_post(); ?>
                            <li class="list-group-item d-flex gap-3 py-3 border-bottom-0 align-items-start">
                                <div class="text-center bg-light rounded p-2 border" style="min-width:65px;">
                                    <span class="d-block fw-bold h5 mb-0 text-success"><?php echo get_the_date('d'); ?></span>
                                    <span class="d-block small text-uppercase fw-bold text-muted" style="font-size:10px;"><?php echo get_the_date('M'); ?></span>
                                </div>
                                <div>
                                    <a href="<?php the_permalink(); ?>" class="text-dark fw-bold text-decoration-none hover-primary line-clamp-2">
                                        <?php the_title(); ?>
                                    </a>
                                </div>
                            </li>
                            <?php endwhile; 
                        else : ?>
                            <li class="list-group-item text-center py-5 text-muted">
                                <div class="mb-2"><i class="fa-regular fa-folder-open fa-2x opacity-25"></i></div>
                                <span class="small">Chưa có văn bản trong mục này.</span>
                            </li>
                        <?php endif; wp_reset_postdata(); ?>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-bold text-primary border-bottom border-primary border-3 d-flex justify-content-between align-items-center">
                        <span><i class="fa-solid fa-file-export me-2"></i> VĂN BẢN ĐI</span>
                        <a href="/cong-van-di" class="small text-decoration-none text-muted fw-normal">Xem tất cả <i class="fa-solid fa-angle-right"></i></a>
                    </div>
                    
                    <ul class="list-group list-group-flush">
                        <?php 
                        $q2 = new WP_Query(array('category_name' => 'cong-van-di', 'posts_per_page' => 5));
                        
                        if ( $q2->have_posts() ) :
                            while($q2->have_posts()): $q2->the_post(); ?>
                            <li class="list-group-item d-flex gap-3 py-3 border-bottom-0 align-items-start">
                                <div class="text-center bg-primary bg-opacity-10 text-primary rounded p-2 border border-primary-subtle" style="min-width:65px;">
                                    <span class="d-block fw-bold h5 mb-0"><?php echo get_the_date('d'); ?></span>
                                    <span class="d-block small text-uppercase fw-bold" style="font-size:10px;"><?php echo get_the_date('M'); ?></span>
                                </div>
                                <div>
                                    <a href="<?php the_permalink(); ?>" class="text-dark fw-bold text-decoration-none hover-primary line-clamp-2">
                                        <?php the_title(); ?>
                                    </a>
                                </div>
                            </li>
                            <?php endwhile; 
                        else : ?>
                            <li class="list-group-item text-center py-5 text-muted">
                                <div class="mb-2"><i class="fa-regular fa-folder-open fa-2x opacity-25"></i></div>
                                <span class="small">Chưa có văn bản trong mục này.</span>
                            </li>
                        <?php endif; wp_reset_postdata(); ?>
                    </ul>
                </div>
            </div>

        </div>
    </section>

</main>

<?php get_footer(); ?>