<?php
// 1. THIẾT LẬP THEME
function hosotheme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
	// --- HỖ TRỢ UPLOAD LOGO ---
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    ));
    register_nav_menus(array(
        'primary' => 'Menu Chính (Bootstrap)',
        'footer'  => 'Menu Chân trang',
    ));
}
add_action('after_setup_theme', 'hosotheme_setup');

// 2. NHÚNG CSS & JS (BOOTSTRAP 5 + SELECT2)
function hosotheme_scripts() {
    // Bootstrap 5 CSS
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
    // FontAwesome
    wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
    // Select2 CSS
    wp_enqueue_style('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
    // Main Style
    wp_enqueue_style('main-style', get_stylesheet_uri(), array(), time());

    // Scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array(), '', true);
    wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), '', true);
}
add_action('wp_enqueue_scripts', 'hosotheme_scripts');

// 3. CHỐNG CACHE CSS
function hosotheme_force_load_style() {
    $theme_version = wp_get_theme()->get('Version');
    $version = $theme_version . '.' . time(); 
    wp_enqueue_style( 'flatsome-child-style', get_stylesheet_uri(), array(), $version );
}
add_action( 'wp_enqueue_scripts', 'hosotheme_force_load_style', 20 );

// 4. ĐĂNG KÝ POST TYPE CHÙA
function create_pagoda_cpt() {
    $labels = array(
        'name' => 'Danh sách Chùa', 'singular_name' => 'Hồ sơ Chùa', 'menu_name' => 'Quản lý Chùa',
        'add_new' => 'Thêm Chùa mới', 'add_new_item' => 'Thêm Hồ sơ Chùa mới', 'edit_item' => 'Sửa thông tin Chùa',
        'new_item' => 'Chùa mới', 'view_item' => 'Xem hồ sơ', 'search_items' => 'Tìm kiếm Chùa', 'not_found' => 'Không tìm thấy'
    );
    $args = array(
        'label' => 'Hồ sơ Chùa', 'labels' => $labels,
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'hierarchical' => false, 'public' => true, 'show_ui' => true,
        'show_in_menu' => true, 'menu_position' => 5,
        'menu_icon' => 'dashicons-bank', 
        'has_archive' => true, 'rewrite' => array( 'slug' => 'ho-so-chua' ),
    );
    register_post_type( 'chua', $args );
}
add_action( 'init', 'create_pagoda_cpt' );

// 5. META BOX THÔNG TIN CHI TIẾT
function pagoda_add_meta_box() {
    add_meta_box( 'pagoda_info', 'Thông tin chi tiết', 'pagoda_meta_box_callback', 'chua', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'pagoda_add_meta_box' );

function pagoda_meta_box_callback( $post ) {
    $address = get_post_meta( $post->ID, '_pg_address', true );
    $abbot = get_post_meta( $post->ID, '_pg_abbot', true );
    $phone = get_post_meta( $post->ID, '_pg_phone', true );
    ?>
    <style> .pg-row { margin-bottom: 10px; } .pg-row label { display:block; font-weight:bold; } .pg-row input { width: 100%; } </style>
    <div class="pg-row"><label>Địa chỉ Chùa (Rất quan trọng để không nhằm lẫn khi trùng tên):</label><input type="text" name="pg_address" value="<?php echo esc_attr( $address ); ?>" placeholder="VD: Số 73 Quán Sứ, Hoàn Kiếm, Hà Nội" /></div>
    <div class="pg-row"><label>Trụ trì:</label><input type="text" name="pg_abbot" value="<?php echo esc_attr( $abbot ); ?>" /></div>
    <div class="pg-row"><label>Số điện thoại:</label><input type="text" name="pg_phone" value="<?php echo esc_attr( $phone ); ?>" /></div>
    <?php
}

function save_pagoda_meta( $post_id ) {
    if ( array_key_exists( 'pg_address', $_POST ) ) update_post_meta( $post_id, '_pg_address', sanitize_text_field( $_POST['pg_address'] ) );
    if ( array_key_exists( 'pg_abbot', $_POST ) ) update_post_meta( $post_id, '_pg_abbot', sanitize_text_field( $_POST['pg_abbot'] ) );
    if ( array_key_exists( 'pg_phone', $_POST ) ) update_post_meta( $post_id, '_pg_phone', sanitize_text_field( $_POST['pg_phone'] ) );
}
add_action( 'save_post', 'save_pagoda_meta' );

// 6. META BOX LIÊN KẾT (ADMIN)
function document_link_pagoda_box() {
    add_meta_box( 'doc_pagoda_link', 'Văn bản thuộc Chùa / Đơn vị', 'doc_pagoda_callback', 'post', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'document_link_pagoda_box' );

function save_doc_pagoda_link( $post_id ) {
    if ( array_key_exists( 'related_pagoda_id', $_POST ) ) update_post_meta( $post_id, '_related_pagoda_id', $_POST['related_pagoda_id'] );
}
add_action( 'save_post', 'save_doc_pagoda_link' );


/* =================================================================
   CORE LOGIC: AJAX SEARCH NÂNG CAO (HIỂN THỊ ĐỊA CHỈ)
   ================================================================= */

/**
 * A. XỬ LÝ AJAX (SERVER SIDE) - TRẢ VỀ THÊM ĐỊA CHỈ
 */
add_action( 'wp_ajax_search_pagodas_ajax', 'search_pagodas_callback' );
add_action( 'wp_ajax_nopriv_search_pagodas_ajax', 'search_pagodas_callback' );

function search_pagodas_callback() {
    $search_term = isset( $_GET['search'] ) ? sanitize_text_field( $_GET['search'] ) : '';

    $args = array(
        'post_type'      => 'chua',
        'post_status'    => 'publish',
        'posts_per_page' => 20,
        's'              => $search_term,
        'fields'         => 'ids' 
    );

    $query = new WP_Query( $args );
    $results = array();

    if ( $query->have_posts() ) {
        foreach ( $query->posts as $post_id ) {
            // Lấy địa chỉ để hiển thị kèm
            $address = get_post_meta($post_id, '_pg_address', true);
            if(!$address) $address = 'Chưa cập nhật địa chỉ';

            $results[] = array(
                'id'        => $post_id,
                'text'      => get_the_title( $post_id ),
                'address'   => $address, // Gửi thêm trường địa chỉ
                'permalink' => get_permalink( $post_id )
            );
        }
    } else {
        $results[] = array( 'id' => '', 'text' => 'Không tìm thấy...' );
    }

    wp_send_json( array( 'results' => $results ) );
}

/**
 * B. NHÚNG SCRIPT & CẤU HÌNH GIAO DIỆN SELECT2 (CLIENT SIDE)
 */
function load_pagoda_select2_assets() {
    global $pagenow;
    
    // Kiểm tra: Đang ở trang Sửa bài viết (Admin) HOẶC Trang chủ (Frontend)
    $is_admin_edit = ( $pagenow == 'post.php' || $pagenow == 'post-new.php' );
    $is_frontend_dash = ( !is_admin() && is_front_page() ); // <--- ĐÃ SỬA DÒNG NÀY

    if ( $is_admin_edit || $is_frontend_dash ) {
        
        // Load thư viện Select2
        wp_enqueue_style( 'select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css' );
        wp_enqueue_script( 'select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array( 'jquery' ), '4.1.0', true );

        $ajax_url = admin_url( 'admin-ajax.php' );
        
        // Script cấu hình
        $custom_js = "
        jQuery(document).ready(function($) {
            
            // Cấu hình chung cho AJAX
            var select2Config = {
                placeholder: 'Gõ tên Tự viện để tìm...',
                allowClear: true,
                width: '100%',
                minimumInputLength: 2,
                language: {
                    inputTooShort: function() { return 'Nhập ít nhất 2 ký tự...'; },
                    noResults: function() { return 'Không tìm thấy dữ liệu.'; },
                    searching: function() { return 'Đang tìm kiếm...'; }
                },
                ajax: {
                    url: '{$ajax_url}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            action: 'search_pagodas_ajax',
                            search: params.term
                        };
                    },
                    processResults: function (data) {
                        return { results: data.results };
                    },
                    cache: true
                }
            };

            // 1. Kích hoạt cho ADMIN (Lưu ID)
            $('.pagoda-ajax-select').select2(select2Config);

            // 2. Kích hoạt cho FRONTEND (Chuyển trang)
            var frontConfig = $.extend({}, select2Config); 
            $('.pagoda-frontend-select').select2(frontConfig).on('select2:select', function (e) {
                var link = e.params.data.permalink; 
                if(link) window.location.href = link;
            });
        });
        ";
        
        wp_add_inline_script( 'select2-js', $custom_js );
    }
}
add_action( 'wp_enqueue_scripts', 'load_pagoda_select2_assets' ); // Hook cho Frontend
add_action( 'admin_enqueue_scripts', 'load_pagoda_select2_assets' ); // Hook cho Admin

/**
 * C. HIỂN THỊ Ô CHỌN TRONG META BOX (ADMIN)
 */
function doc_pagoda_callback( $post ) {
    $selected_pagoda_id = get_post_meta( $post->ID, '_related_pagoda_id', true );
    
    echo '<p><strong>Tìm kiếm Đơn vị:</strong></p>';
    echo '<select name="related_pagoda_id" class="pagoda-ajax-select">';
    
    // Nếu đã có ID, hiển thị tên + địa chỉ ra
    if ( $selected_pagoda_id && is_numeric($selected_pagoda_id) ) {
        $pagoda_title = get_the_title( $selected_pagoda_id );
        $pagoda_addr  = get_post_meta($selected_pagoda_id, '_pg_address', true);
        
        if ( $pagoda_title ) {
            $display_text = $pagoda_title;
            if($pagoda_addr) $display_text .= ' (' . $pagoda_addr . ')';
            
            echo '<option value="' . $selected_pagoda_id . '" selected="selected">' . $display_text . '</option>';
        }
    }
    echo '</select>';
    echo '<p class="description" style="margin-top:5px; color:#666;">Nhập tên chùa để xem địa chỉ chi tiết và phân biệt.</p>';
}

/* ===============================================================
   DEBUG & ADMIN COLUMNS
   =============================================================== */
add_filter( 'manage_post_posts_columns', function($columns) {
    $columns['related_pagoda'] = 'Đơn vị / Chùa';
    return $columns;
});

add_action( 'manage_post_posts_custom_column', function($column_name, $post_id) {
    if ( 'related_pagoda' === $column_name ) {
        $pagoda_id = get_post_meta( $post_id, '_related_pagoda_id', true );

        if ( ! empty( $pagoda_id ) ) {
            if ( is_numeric($pagoda_id) ) {
                $title = get_the_title( $pagoda_id );
                $addr = get_post_meta($pagoda_id, '_pg_address', true);
                
                echo '<a href="'. get_edit_post_link($pagoda_id) .'" style="font-weight:bold; color:#003366;">' . esc_html( $title ) . '</a>';
                if($addr) echo '<br><small style="color:#666;"><span class="dashicons dashicons-location" style="font-size:12px;"></span> '. $addr .'</small>';
            } else {
                echo '<span style="color:red; font-size:11px;">⚠ Dữ liệu lỗi (URL)</span>';
            }
        } else {
            echo '<span style="color:#ccc;">—</span>';
        }
    }
}, 10, 2 );

// CSS Admin cho cột và Select2
function admin_custom_css_pagoda() {
    echo '<style>
        .select2-container .select2-selection--single { height: 35px !important; border-color: #ddd !important; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 35px !important; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 33px !important; }
        .column-related_pagoda { width: 250px; }
        /* Style cho kết quả dropdown */
        .pg-result-item { padding: 5px 0; border-bottom: 1px dashed #eee; }
        .pg-result-name { font-weight: bold; font-size: 14px; }
        .pg-result-addr { font-size: 12px; color: #888; margin-top: 2px; }
    </style>';
}
add_action('admin_head', 'admin_custom_css_pagoda');

/* =================================================================
   BOOTSTRAP 5 MENU HELPERS (TỰ ĐỘNG THÊM CLASS)
   ================================================================= */

// 1. Thêm class 'nav-item' vào thẻ <li>
function add_bootstrap_nav_item_class($classes, $item, $args) {
    if (isset($args->theme_location) && $args->theme_location == 'primary') {
        $classes[] = 'nav-item'; // Class chuẩn của Bootstrap
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_bootstrap_nav_item_class', 10, 3);

// 2. Thêm class 'nav-link' vào thẻ <a>
function add_bootstrap_nav_link_class($atts, $item, $args) {
    if (isset($args->theme_location) && $args->theme_location == 'primary') {
        $atts['class'] = 'nav-link'; // Class chuẩn của Bootstrap
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_bootstrap_nav_link_class', 10, 3);

// 3. (Tùy chọn) Thêm class 'active' cho mục đang xem
function add_bootstrap_active_class($classes, $item) {
    if (in_array('current-menu-item', $classes) || in_array('current-menu-parent', $classes)) {
        $classes[] = 'active';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_bootstrap_active_class', 10, 2);

/* =================================================================
   TÙY BIẾN FOOTER (CUSTOMIZER)
   ================================================================= */

// 1. Đăng ký vị trí Menu Footer (Để quản lý list liên kết)
function register_footer_menu() {
    register_nav_menu('footer-menu', 'Menu Chân trang (Footer)');
}
add_action( 'after_setup_theme', 'register_footer_menu' );

// 2. Đăng ký các ô nhập liệu (Tên, Địa chỉ, SĐT...)
function hosotheme_footer_customizer( $wp_customize ) {
    
    // Tạo Section mới: Cấu hình Footer
    $wp_customize->add_section( 'hosotheme_footer_section', array(
        'title'    => 'Cấu hình Footer',
        'priority' => 120,
    ));

    // --- Setting: Tên đơn vị ---
    $wp_customize->add_setting( 'footer_org_name', array( 'default' => 'Chưa Cập Nhật' ) );
    $wp_customize->add_control( 'footer_org_name', array(
        'label'    => 'Tên Đơn vị / Tổ chức',
        'section'  => 'hosottheme_footer_section',
        'type'     => 'text',
    ));

    // --- Setting: Địa chỉ ---
    $wp_customize->add_setting( 'footer_address', array( 'default' => 'Chưa cập nhật địa chỉ' ) );
    $wp_customize->add_control( 'footer_address', array(
        'label'    => 'Địa chỉ',
        'section'  => 'hosotheme_footer_section',
        'type'     => 'textarea', // Dùng textarea cho thoải mái
    ));

    // --- Setting: Số điện thoại ---
    $wp_customize->add_setting( 'footer_phone', array( 'default' => '0901.123.XXX' ) );
    $wp_customize->add_control( 'footer_phone', array(
        'label'    => 'Số điện thoại',
        'section'  => 'hosotheme_footer_section',
        'type'     => 'text',
    ));

    // --- Setting: Email ---
    $wp_customize->add_setting( 'footer_email', array( 'default' => 'VD: angiang.phatgiaotructuyen@gmail.com' ) );
    $wp_customize->add_control( 'footer_email', array(
        'label'    => 'Email liên hệ',
        'section'  => 'hosotheme_footer_section',
        'type'     => 'text',
    ));

    // --- Setting: Copyright Text ---
    $wp_customize->add_setting( 'footer_copyright', array( 'default' => 'Phật Giáo Trực Tuyên.' ) );
    $wp_customize->add_control( 'footer_copyright', array(
        'label'    => 'Dòng chữ bản quyền (Dưới năm)',
        'section'  => 'hosotheme_footer_section',
        'type'     => 'text',
    ));
}
add_action( 'customize_register', 'hosotheme_footer_customizer' );

/* =================================================================
   XỬ LÝ ĐĂNG NHẬP (REDIRECT KHI LỖI)
   ================================================================= */
function custom_login_failed() {
    // Thay 'dang-nhap' bằng đường dẫn (slug) trang bạn vừa tạo ở Bước 2
    $login_page = home_url( '/dang-nhap/' ); 
    wp_redirect( $login_page . '?login=failed' );
    exit;
}
add_action( 'wp_login_failed', 'custom_login_failed' );

function custom_verify_username_password( $user, $username, $password ) {
    // Thay 'dang-nhap' bằng slug trang của bạn
    $login_page = home_url( '/dang-nhap/' );
    if( $username == "" || $password == "" ) {
        wp_redirect( $login_page . '?login=empty' );
        exit;
    }
}
add_filter( 'authenticate', 'custom_verify_username_password', 1, 3);

/* =================================================================
   BẢO MẬT: BẮT BUỘC ĐĂNG NHẬP (FORCE LOGIN)
   ================================================================= */
function hosotheme_force_login() {
    // 1. Nếu đã đăng nhập rồi -> Cho qua
    if ( is_user_logged_in() ) {
        return;
    }

    // 2. Các trang "Công cộng" được phép truy cập khi chưa đăng nhập
    // (Bao gồm trang Đăng nhập và trang Quên mật khẩu)
    if ( is_page('dang-nhap') || is_page('quen-mat-khau') ) {
        return;
    }

    // 3. Cho phép các trang hệ thống của WP (để tránh lỗi reset pass mặc định)
    if ( in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {
        return;
    }

    // 4. Các trường hợp còn lại -> Đá về trang Đăng nhập
    wp_redirect( home_url( '/dang-nhap/' ) );
    exit;
}
add_action( 'template_redirect', 'hosotheme_force_login' );

/* =================================================================
   CHUYỂN HƯỚNG SAU KHI ĐĂNG NHẬP / ĐĂNG XUẤT
   ================================================================= */

// 1. Đăng nhập xong -> Về Trang chủ
function hosotheme_redirect_after_login( $redirect_to, $request, $user ) {
    // Nếu là Admin thì vẫn cho vào trang quản trị
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        if ( in_array( 'administrator', $user->roles ) ) {
            return home_url(); 
        }
    }
    // Nhân viên bình thường -> Về trang chủ Dashboard
    return home_url();
}
add_filter( 'login_redirect', 'hosotheme_redirect_after_login', 10, 3 );

// 2. Đăng xuất xong -> Về lại trang Đăng nhập (thay vì về form WP xấu)
function hosotheme_redirect_after_logout() {
    wp_redirect( home_url( '/dang-nhap/' ) );
    exit;
}
add_action( 'wp_logout', 'hosotheme_redirect_after_logout' );

/* =================================================================
   CUSTOM LOST PASSWORD URL
   ================================================================= */
function hosotheme_lost_password_url() {
    return home_url( '/quen-mat-khau/' );
}
add_filter( 'lostpassword_url', 'hosotheme_lost_password_url' );

// Sửa lại đường dẫn "Quên mật khẩu?" trong file page-login.php
// (Lưu ý: Bạn cần mở file page-login.php và sửa dòng wp_lostpassword_url() nếu cần, 
// nhưng với filter trên thì wp_lostpassword_url() sẽ tự động trả về link mới).

/* =================================================================
   TỰ ĐỘNG TẠO TRANG KHI KÍCH HOẠT THEME
   ================================================================= */
function hosotheme_auto_create_pages() {
    
    // Danh sách các trang cần tạo tự động
    $pages_to_create = array(
        // 1. Trang Đăng Nhập
        array(
            'title'    => 'Đăng nhập hệ thống',
            'slug'     => 'dang-nhap',
            'template' => 'page-login.php',
        ),
        // 2. Trang Quên Mật Khẩu
        array(
            'title'    => 'Quên mật khẩu',
            'slug'     => 'quen-mat-khau',
            'template' => 'page-lost-password.php',
        ),
        // 3. Trang Hỗ Trợ
        array(
            'title'    => 'Hỗ trợ kỹ thuật',
            'slug'     => 'ho-tro',
            'template' => 'page-support.php',
        ),
        // 4. Trang Công Văn Đến
        array(
            'title'    => 'Văn bản Đến',
            'slug'     => 'cong-van-den',
            'template' => 'template-list-vanban.php',
        ),
        // 5. Trang Công Văn Đi
        array(
            'title'    => 'Văn bản Đi',
            'slug'     => 'cong-van-di', // Slug cũ bạn đang dùng
            'template' => 'template-list-vanban.php',
        ),
        // 6. Trang Chủ Dashboard (Quan trọng nhất)
        array(
            'title'    => 'Trang Chủ',
            'slug'     => 'trang-chu',
            'template' => 'front-page.php', // WordPress tự nhận file này là home
            'is_home'  => true // Đánh dấu đây là trang chủ
        ),
    );

    // Bắt đầu vòng lặp tạo trang
    foreach ( $pages_to_create as $page ) {
        
        // Kiểm tra trang đã tồn tại chưa (theo slug)
        $existing_page = get_page_by_path( $page['slug'] );

        if ( ! $existing_page ) {
            // Cấu hình trang mới
            $new_page_id = wp_insert_post( array(
                'post_title'   => $page['title'],
                'post_name'    => $page['slug'],
                'post_content' => '', // Nội dung rỗng vì dùng Template
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_author'  => 1,
            ));

            // Gán Template cho trang (Nếu tạo thành công)
            if ( $new_page_id && ! is_wp_error( $new_page_id ) ) {
                if ( ! empty( $page['template'] ) ) {
                    update_post_meta( $new_page_id, '_wp_page_template', $page['template'] );
                }

                // Cài đặt làm Trang Chủ (Nếu có cờ is_home)
                if ( isset( $page['is_home'] ) && $page['is_home'] ) {
                    update_option( 'show_on_front', 'page' );
                    update_option( 'page_on_front', $new_page_id );
                }
            }
        }
    }
}
// Hook chạy 1 lần duy nhất khi bấm nút "Kích hoạt" theme
add_action( 'after_switch_theme', 'hosotheme_auto_create_pages' );