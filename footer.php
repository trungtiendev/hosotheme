<footer id="system-footer">
    <div class="container py-5">
        <div class="row g-4">
            
            <div class="col-md-5">
                <h5 class="text-white text-uppercase fw-bold mb-3">
                    <?php echo get_theme_mod('footer_org_name', 'Chưa cập nhật Tên'); ?>
                </h5>
                
                <p class="small mb-2 text-white-50">
                    <i class="fa-solid fa-location-dot me-2"></i> 
                    <?php echo get_theme_mod('footer_address', 'Cập nhật địa chỉ tại Admin...'); ?>
                </p>
                
                <p class="small mb-2 text-white-50">
                    <i class="fa-solid fa-phone me-2"></i> 
                    <?php echo get_theme_mod('footer_phone', '09xx.xxx.xxx'); ?>
                </p>
                
                <p class="small text-white-50">
                    <i class="fa-solid fa-envelope me-2"></i> 
                    <?php echo get_theme_mod('footer_email', 'admin@example.com'); ?>
                </p>
            </div>

            <div class="col-md-3">
                <h6 class="text-warning text-uppercase fw-bold mb-3">Liên kết</h6>
                <?php
                if ( has_nav_menu( 'footer-menu' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'footer-menu',
                        'container'      => false,
                        'menu_class'     => 'list-unstyled small mb-0 footer-nav-list', // Class Bootstrap
                        'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                        'depth'          => 1,
                    ) );
                } else {
                    // Hiển thị mặc định nếu chưa cài menu
                    echo '<p class="small text-white-50">Vui lòng vào Giao diện -> Menu để cài đặt "Menu Chân trang".</p>';
                }
                ?>
            </div>

            <div class="col-md-4 text-center text-md-end">
                <p class="small mb-3 text-white-50">
                    Bản quyền © <?php echo date('Y'); ?>.<br>
                    <?php echo get_theme_mod('footer_copyright', 'Tên chủ quản.'); ?>
                </p>
                
                <?php if ( !is_user_logged_in() ): ?>
                    <a href="<?php echo wp_login_url(); ?>" class="btn btn-outline-light btn-sm rounded-pill px-4">
                        <i class="fa-solid fa-lock me-2"></i> Đăng nhập
                    </a>
                <?php else: ?>
                    <a href="<?php echo admin_url(); ?>" class="btn btn-warning btn-sm rounded-pill px-4 fw-bold text-white">
                        <i class="fa-solid fa-gauge me-2"></i> Trang quản trị
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</footer>

<style>
    .footer-nav-list li { margin-bottom: 0.5rem; }
    .footer-nav-list li a { 
        color: rgba(255,255,255,0.6); 
        text-decoration: none; 
        transition: 0.2s; 
    }
    .footer-nav-list li a:hover { 
        color: #ff9f43; /* Màu cam */
        padding-left: 5px; 
    }
</style>

<?php wp_footer(); ?>
</body>
</html>