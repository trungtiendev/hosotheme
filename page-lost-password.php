<?php
/*
Template Name: Trang Quên Mật Khẩu
*/

// Nếu đã đăng nhập thì không cần vào đây nữa
if ( is_user_logged_in() ) {
    wp_redirect( home_url() );
    exit;
}

// Xử lý Logic khi bấm Gửi
$error_msg = '';
$success_msg = '';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_login']) ) {
    $user_login = sanitize_text_field($_POST['user_login']);
    
    if ( empty( $user_login ) ) {
        $error_msg = 'Vui lòng nhập tên đăng nhập hoặc email.';
    } else {
        // Hàm này của WP tự động kiểm tra và gửi mail
        $errors = retrieve_password(); 
        
        if ( is_wp_error( $errors ) ) {
            $error_msg = $errors->get_error_message();
        } else {
            $success_msg = 'Link khôi phục mật khẩu đã được gửi vào email của bạn. Vui lòng kiểm tra hộp thư (cả mục Spam).';
        }
    }
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Khôi phục mật khẩu | <?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS DÙNG CHUNG VỚI TRANG LOGIN */
        body { background-color: #f0f2f5; font-family: 'Roboto', sans-serif; margin: 0; }
        .login-wrapper {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #003366 0%, #0055a5 100%);
            padding: 20px;
        }
        .login-card {
            background: #fff; border-radius: 15px; overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            max-width: 900px; width: 100%;
            display: flex; flex-wrap: wrap;
        }
        .login-banner {
            background: url('https://angiang.phatgiaotructuyen.com/wp-content/uploads/2023/11/chua-bai-dinh-2.jpg') center/cover no-repeat;
            width: 50%; position: relative; min-height: 400px;
        }
        .login-banner::before {
            content: ''; position: absolute; top:0; left:0; right:0; bottom:0;
            background: rgba(0, 51, 102, 0.6);
        }
        .login-banner-content {
            position: relative; z-index: 2; height: 100%;
            display: flex; flex-direction: column; justify-content: center;
            padding: 40px; color: #fff;
        }
        .login-form-container {
            width: 50%; padding: 50px 40px;
            display: flex; flex-direction: column; justify-content: center;
        }
        .form-control {
            height: 45px; border-radius: 5px; border: 1px solid #ddd; padding-left: 15px;
        }
        .form-control:focus {
            border-color: #003366; box-shadow: 0 0 0 0.2rem rgba(0, 51, 102, 0.15);
        }
        .btn-login {
            background-color: #ff9f43; color: #fff; font-weight: bold;
            height: 45px; border-radius: 5px; width: 100%; border: none;
            text-transform: uppercase; letter-spacing: 1px; transition: 0.3s;
        }
        .btn-login:hover { background-color: #e68a30; }
        .text-primary-custom { color: #003366; }

        @media (max-width: 768px) {
            .login-banner { display: none; }
            .login-form-container { width: 100%; padding: 40px 20px; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-card">
        
        <div class="login-banner">
            <div class="login-banner-content">
                <h2 class="fw-bold text-uppercase mb-3">Hồ Sơ Lưu</h2>
                <p class="opacity-75 mb-0">Hệ thống quản lý văn bản điện tử và hồ sơ tự viện tập trung.</p>
                <hr class="my-4 border-light opacity-50">
                <small class="opacity-75">© <?php echo date('Y'); ?> Văn phòng GHPGVN</small>
            </div>
        </div>

        <div class="login-form-container">
            
            <div class="text-center mb-4">
                <h3 class="fw-bold text-primary-custom">KHÔI PHỤC MẬT KHẨU</h3>
                <p class="text-muted small">Nhập email của bạn để nhận hướng dẫn.</p>
            </div>

            <?php if ( $error_msg ) : ?>
                <div class="alert alert-danger small py-2 mb-3">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> <?php echo $error_msg; ?>
                </div>
            <?php endif; ?>

            <?php if ( $success_msg ) : ?>
                <div class="alert alert-success small py-3 mb-3">
                    <i class="fa-solid fa-circle-check me-1"></i> <?php echo $success_msg; ?>
                </div>
                <div class="text-center mt-3">
                    <a href="<?php echo home_url('/dang-nhap'); ?>" class="btn btn-outline-secondary btn-sm">Quay lại Đăng nhập</a>
                </div>
            <?php else : ?>

                <form method="post">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Tên đăng nhập hoặc Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                            <input type="text" name="user_login" class="form-control border-start-0 ps-0" placeholder="Nhập email..." required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login shadow-sm">
                        Gửi link khôi phục <i class="fa-solid fa-paper-plane ms-2"></i>
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="<?php echo home_url('/dang-nhap'); ?>" class="small text-muted text-decoration-none">
                        <i class="fa-solid fa-arrow-left me-1"></i> Quay về Đăng nhập
                    </a>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>

</body>
</html>