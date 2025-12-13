<?php
/*
Template Name: Trang Đăng Ký Thành Viên
*/

// Nếu đã đăng nhập thì đá về trang chủ
if ( is_user_logged_in() ) {
    wp_redirect( home_url() );
    exit;
}

$errors = array();
$success = false;

// XỬ LÝ FORM ĐĂNG KÝ
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_register']) ) {
    
    // 1. Lấy dữ liệu và làm sạch
    $username   = sanitize_user( $_POST['username'] );
    $email      = sanitize_email( $_POST['email'] );
    $password   = $_POST['password'];
    $repassword = $_POST['repassword'];
    $fullname   = sanitize_text_field( $_POST['fullname'] );

    // 2. Kiểm tra lỗi
    if ( empty($username) || empty($email) || empty($password) ) {
        $errors[] = 'Vui lòng điền đầy đủ thông tin bắt buộc.';
    }
    if ( username_exists( $username ) ) {
        $errors[] = 'Tên đăng nhập đã tồn tại.';
    }
    if ( email_exists( $email ) ) {
        $errors[] = 'Email này đã được sử dụng.';
    }
    if ( $password !== $repassword ) {
        $errors[] = 'Mật khẩu nhập lại không khớp.';
    }
    if ( strlen($password) < 6 ) {
        $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    }

    // 3. Tạo tài khoản nếu không có lỗi
    if ( empty($errors) ) {
        $userdata = array(
            'user_login'    => $username,
            'user_email'    => $email,
            'user_pass'     => $password,
            'display_name'  => $fullname,
            'first_name'    => $fullname,
            'role'          => 'author' // QUAN TRỌNG: Gán quyền Tác giả
        );

        $user_id = wp_insert_user( $userdata );

        if ( ! is_wp_error( $user_id ) ) {
            $success = true;
        } else {
            $errors[] = $user_id->get_error_message();
        }
    }
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng ký thành viên | <?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* TẬN DỤNG CSS CỦA TRANG LOGIN CHO ĐỒNG BỘ */
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
        /* Banner bên trái */
        .login-banner {
            background: url('https://angiang.phatgiaotructuyen.com/wp-content/uploads/2023/11/chua-bai-dinh-2.jpg') center/cover no-repeat;
            width: 50%; position: relative; min-height: 550px; /* Cao hơn chút vì form dài */
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
        /* Form bên phải */
        .login-form-container {
            width: 50%; padding: 40px;
            display: flex; flex-direction: column; justify-content: center;
        }
        .form-control {
            height: 45px; border-radius: 5px; border: 1px solid #ddd; padding-left: 15px;
        }
        .form-control:focus {
            border-color: #003366; box-shadow: 0 0 0 0.2rem rgba(0, 51, 102, 0.15);
        }
        .btn-register {
            background-color: #2ecc71; /* Màu xanh lá cho nút đăng ký */
            color: #fff; font-weight: bold;
            height: 45px; border-radius: 5px; width: 100%; border: none;
            text-transform: uppercase; letter-spacing: 1px; transition: 0.3s;
        }
        .btn-register:hover { background-color: #27ae60; }
        .text-primary-custom { color: #003366; }

        @media (max-width: 768px) {
            .login-banner { display: none; }
            .login-form-container { width: 100%; padding: 30px 20px; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-card">
        
        <div class="login-banner">
            <div class="login-banner-content">
                <h2 class="fw-bold text-uppercase mb-3">Tham gia hệ thống</h2>
                <p class="opacity-75 mb-0">Đăng ký tài khoản để bắt đầu quản lý văn bản và hồ sơ tự viện.</p>
                <hr class="my-4 border-light opacity-50">
                <small class="opacity-75">© <?php echo date('Y'); ?> Văn phòng GHPGVN</small>
            </div>
        </div>

        <div class="login-form-container">
            
            <div class="text-center mb-4">
                <h3 class="fw-bold text-primary-custom">ĐĂNG KÝ TÀI KHOẢN</h3>
                <p class="text-muted small">Tạo tài khoản Tác giả mới</p>
            </div>

            <?php if ( $success ) : ?>
                <div class="alert alert-success p-4 text-center">
                    <i class="fa-solid fa-circle-check fa-3x mb-3 text-success"></i>
                    <h5 class="fw-bold">Đăng ký thành công!</h5>
                    <p class="small">Tài khoản của bạn đã được tạo.</p>
                    <a href="<?php echo home_url('/dang-nhap'); ?>" class="btn btn-primary btn-sm px-4">Đăng nhập ngay</a>
                </div>
            <?php else : ?>

                <?php if ( ! empty($errors) ) : ?>
                    <div class="alert alert-danger small py-2 mb-3">
                        <?php foreach($errors as $err) { echo '<i class="fa-solid fa-circle-exclamation me-1"></i> '.$err.'<br>'; } ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Họ và tên</label>
                        <input type="text" name="fullname" class="form-control" placeholder="Nhập họ tên đầy đủ" value="<?php echo isset($_POST['fullname']) ? esc_attr($_POST['fullname']) : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Tên đăng nhập <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" placeholder="Viết liền không dấu (vd: thichminhnhan)" required value="<?php echo isset($_POST['username']) ? esc_attr($_POST['username']) : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="example@email.com" required value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="******" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Nhập lại <span class="text-danger">*</span></label>
                            <input type="password" name="repassword" class="form-control" placeholder="******" required>
                        </div>
                    </div>

                    <button type="submit" name="submit_register" class="btn btn-register shadow-sm mt-2">
                        <i class="fa-solid fa-user-plus me-2"></i> Tạo tài khoản
                    </button>

                </form>

                <div class="text-center mt-4">
                    <span class="text-muted small">Đã có tài khoản?</span>
                    <a href="<?php echo home_url('/dang-nhap'); ?>" class="small fw-bold text-decoration-none text-primary-custom ms-1">
                        Đăng nhập
                    </a>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>

</body>
</html>