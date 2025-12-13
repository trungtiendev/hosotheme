<?php
/*
Template Name: Trang Đăng Nhập Hệ Thống
*/

// 1. Nếu đã đăng nhập thì đá về trang chủ
if ( is_user_logged_in() ) {
    wp_redirect( home_url() );
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập hệ thống | <?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS RIÊNG CHO TRANG LOGIN */
        body { 
            background-color: #f0f2f5; 
            font-family: 'Roboto', sans-serif;
            margin: 0;
        }
        
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #003366 0%, #0055a5 100%);
            padding: 20px;
        }
        
        .login-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            max-width: 900px;
            width: 100%;
            display: flex;
            flex-wrap: wrap;
        }

        .login-banner {
            background: url('https://angiang.phatgiaotructuyen.com/wp-content/uploads/2023/11/chua-bai-dinh-2.jpg') center/cover no-repeat;
            width: 50%;
            position: relative;
            min-height: 400px;
        }
        
        .login-banner::before {
            content: '';
            position: absolute; top:0; left:0; right:0; bottom:0;
            background: rgba(0, 51, 102, 0.6); /* Lớp phủ màu xanh */
        }

        .login-banner-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            color: #fff;
        }

        .login-form-container {
            width: 50%;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Form Styles */
        .form-control {
            height: 45px;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding-left: 15px;
        }
        .form-control:focus {
            border-color: #003366;
            box-shadow: 0 0 0 0.2rem rgba(0, 51, 102, 0.15);
        }
        .btn-login {
            background-color: #ff9f43;
            color: #fff;
            font-weight: bold;
            height: 45px;
            border-radius: 5px;
            width: 100%;
            border: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
        }
        .btn-login:hover {
            background-color: #e68a30;
        }
        .text-primary-custom { color: #003366; }

        /* Responsive Mobile */
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
                <h2 class="fw-bold text-uppercase mb-3">Phật Giáo Trực Tuyến</h2>
                <p class="opacity-75 mb-0">Hệ thống quản lý văn bản.</p>
                <hr class="my-4 border-light opacity-50">
                <small class="opacity-75">© <?php echo date('Y'); ?> Văn phòng GHPGVN</small>
            </div>
        </div>

        <div class="login-form-container">
            
            <div class="text-center mb-4">
                <h3 class="fw-bold text-primary-custom">ĐĂNG NHẬP</h3>
                <p class="text-muted small">Vui lòng nhập thông tin tài khoản của bạn</p>
            </div>

            <?php if ( isset( $_GET['login'] ) && $_GET['login'] == 'failed' ) : ?>
                <div class="alert alert-danger small py-2 mb-3">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> Tên đăng nhập hoặc mật khẩu không đúng.
                </div>
            <?php endif; ?>

            <form name="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
                
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Tên đăng nhập / Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-user text-muted"></i></span>
                        <input type="text" name="log" id="user_login" class="form-control border-start-0 ps-0" placeholder="Nhập tài khoản..." required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                        <input type="password" name="pwd" id="user_pass" class="form-control border-start-0 ps-0" placeholder="Nhập mật khẩu..." required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="rememberme" id="rememberme" value="forever">
                        <label class="form-check-label small text-muted" for="rememberme">Ghi nhớ tôi</label>
                    </div>
                    <div>
                        <a href="<?php echo home_url('/dang-ky'); ?>" class="small text-decoration-none text-success me-3 fw-bold">Đăng ký mới</a>
                        <a href="<?php echo wp_lostpassword_url(); ?>" class="small text-decoration-none text-primary-custom">Quên mật khẩu?</a>
                    </div>
                </div>

                <button type="submit" name="wp-submit" id="wp-submit" class="btn btn-login shadow-sm">
                    Truy cập hệ thống <i class="fa-solid fa-arrow-right ms-2"></i>
                </button>

                <input type="hidden" name="redirect_to" value="<?php echo home_url(); ?>" />

            </form>

        </div>
    </div>
</div>

</body>
</html>