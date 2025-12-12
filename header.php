<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header>
    <nav class="navbar navbar-expand-lg navbar-custom navbar-dark sticky-top shadow-sm">
        <div class="container">
            
            <a class="navbar-brand d-flex align-items-center" href="<?php echo home_url(); ?>">
                
                <div class="brand-logo me-2">
                    <?php
                    $custom_logo_id = get_theme_mod( 'custom_logo' );
                    $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );

                    if ( has_custom_logo() ) {
                        // Nếu có Logo ảnh
                        echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '" class="img-fluid" style="max-height: 50px;">';
                    } else {
                        // Nếu không có Logo -> Hiện Icon Sách
                        echo '<i class="fa-solid fa-book-open fa-lg"></i>';
                    }
                    ?>
                </div>

                <div class="brand-text d-flex flex-column justify-content-center" style="line-height: 1.2;">
                    
                    <?php if ( ! has_custom_logo() ) : ?>
                        <span class="fw-bold text-uppercase brand-title" style="font-size: 1.1rem;">
                            <?php bloginfo( 'name' ); ?>
                        </span>
                    <?php endif; ?>
                    
                    <?php
                    $description = get_bloginfo( 'description', 'display' );
                    if ( $description || is_customize_preview() ) : ?>
                        <span class="brand-tagline text-white-50" style="font-size: 0.75rem; font-weight: normal; letter-spacing: 0.5px;">
                            <?php echo $description; ?>
                        </span>
                    <?php endif; ?>
                    
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'navbar-nav ms-auto mb-2 mb-lg-0',
                    'fallback_cb'    => false,
                    'items_wrap'     => '<ul class="navbar-nav ms-auto mb-2 mb-lg-0">%3$s</ul>',
                    'depth'          => 2,
                ));
                ?>
            </div>
        </div>
    </nav>
</header>