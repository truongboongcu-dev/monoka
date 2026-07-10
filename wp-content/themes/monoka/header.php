<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="cưới hỏi ngọc link">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon"
        href="https://cuoihoingoclinh.com/wp-content/themes/cuoihoinew/assets/img/logo.webp">
    <?php wp_head(); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <!-- head start -->
    <div>tesst</div>
    <div class="wrap-head">
        <div class="container">
            <div class="head">
                <div class="left-head">
                    <a class="effect-shine" href="<?php bloginfo("url"); ?>"><img
                            src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/banner/logo.png" class="logo"
                            alt="logo"></a>
                    <div>
                        <div class="menu">
                            <?php wp_nav_menu(
                                array(
                                    'theme_location' => 'main-menu',
                                    'container' => 'false',
                                    'menu_id' => 'main-menu',
                                    'menu_class' => 'main-menu'
                                )
                            ); ?>
                        </div>
                    </div>
                </div>
                <div class="right-head">
                    <div class="head-search">
                        <input type="text" placeholder="Tìm kiếm........." id="myInput">
                        <div class="head-search-bnt">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="#ffffff"
                                    d="M480 272C480 317.9 465.1 360.3 440 394.7L566.6 521.4C579.1 533.9 579.1 554.2 566.6 566.7C554.1 579.2 533.8 579.2 521.3 566.7L394.7 440C360.3 465.1 317.9 480 272 480C157.1 480 64 386.9 64 272C64 157.1 157.1 64 272 64C386.9 64 480 157.1 480 272zM272 416C351.5 416 416 351.5 416 272C416 192.5 351.5 128 272 128C192.5 128 128 192.5 128 272C128 351.5 192.5 416 272 416z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="menu-head-right">
                        <?php if (is_user_logged_in()): ?>
                            <a id="tai-khoan"
                                href="<?php echo class_exists('WooCommerce') ? wc_get_page_permalink('myaccount') : admin_url('profile.php'); ?>"
                                class="menu-head-right-item">
                                <img src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/user.png"
                                    alt="tài khoản">
                                <div class="menu-head-right-item-text">Tài khoản</div>
                            </a>
                        <?php else: ?>
                            <a id="tai-khoan" href="#" class="log menu-head-right-item trigger-login-popup">
                                <img src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/user.png"
                                    alt="đăng nhập">
                                <div class="menu-head-right-item-text">Đăng nhập</div>
                            </a>
                        <?php endif; ?>
                        <a href="#" class="menu-head-right-item">
                            <img src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/store.png" alt="logo">
                            <div class="menu-head-right-item-text">Cửa hàng</div>
                        </a>
                        <a href="/cart" class="menu-head-right-item">
                            <div class="cart-icon-wrapper">
                                <img src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/shopping-bag.png"
                                    alt="logo">
                                <?php if (class_exists('WooCommerce')): ?>
                                    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="menu-head-right-item-text">Giỏ hàng</div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="log-box">
        <div class="log-main dang-nhap">
            <form id="litesite-login-form">
                <div class="log-input">
                    <input type="text" id="user_login" placeholder="Tên đăng nhập" class="input" required>
                    <input type="password" id="user_pass" placeholder="Mật khẩu" class="input" required>
                </div>

                <div class="log-btn">
                    <button type="submit" class="btn-login-d">Đăng Nhập</button>
                    <button class="btn-dk register">Đăng Ký</button>
                </div>
                <div class="login-message" style="margin-top: 10px; color: red;"></div>
                <a href="<?php echo wp_lostpassword_url(); ?>">Bạn quên mật khẩu?</a>

                <input type="hidden" id="login_security" value="<?php echo wp_create_nonce('ajax-login-nonce'); ?>">
            </form>
        </div>

        <div class="log-main dang-ky">
            <div class="log-note">* Vui lòng điền đầy đủ thông tin để đăng ký tài khoản</div>
            <form id="litesite-register-form">
                <div class="log-input">
                    <div>Địa chỉ</div>
                    <input type="text" id="reg_address" placeholder="" class="input" required>
                    <div>Tên đăng nhập</div>
                    <input type="text" id="reg_user" placeholder="" class="input" required>
                    <div>Số điện thoại</div>
                    <input type="tel" id="reg_tel" placeholder="" class="input" required>
                    <div class="boder"></div>
                    <div>Mật Khẩu</div>
                    <input type="password" id="reg_pass" placeholder="" class="input" required>
                    <div>Nhập lại mật khẩu</div>
                    <input type="password" id="reg_pass_confirm" placeholder="" class="input" required>
                </div>

                <div class="log-btn">
                    <button type="submit" class="btn-login-d">Đăng Ký Ngay</button>
                    <button class="btn-dk log" style="text-align: center; text-decoration: none;">Đăng Nhập</button>
                </div>

                <div class="registration-message" style="margin-top: 10px; color: red;"></div>

                <input type="hidden" id="register_security"
                    value="<?php echo wp_create_nonce('ajax-register-nonce'); ?>">
            </form>
        </div>
    </div>

    <script>
        jQuery(document).ready(function ($) {
            var ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';

            // Xử lý Đăng Nhập
            $('#litesite-login-form').on('submit', function (e) {
                e.preventDefault();
                var $messageBox = $('.login-message');
                $messageBox.css('color', 'blue').text('Đang xử lý...');

                var login_data = {
                    action: 'ajax_login',
                    username: $('#user_login').val(),
                    password: $('#user_pass').val(),
                    security: $('#login_security').val()
                };

                $.post(ajax_url, login_data, function (res) {
                    // Kiểm tra an toàn bảo vệ script không bị crash
                    if (res && res.data && res.data.message) {
                        $messageBox.text(res.data.message);
                    } else {
                        $messageBox.text('Có lỗi xảy ra từ hệ thống!');
                    }

                    if (res.success) {
                        $messageBox.css('color', 'green');
                        window.location.reload();
                    } else {
                        $messageBox.css('color', 'red');
                    }
                }).fail(function () {
                    $messageBox.css('color', 'red').text('Không thể kết nối đến máy chủ!');
                });
            });

            // Xử lý Đăng Ký
            $('#litesite-register-form').on('submit', function (e) {
                e.preventDefault();
                var $messageBox = $('.registration-message');
                $messageBox.css('color', 'blue').text('Đang xử lý đăng ký...');

                var reg_data = {
                    action: 'litesite_ajax_register',
                    username: $('#reg_user').val(),
                    password: $('#reg_pass').val(),
                    confirm_password: $('#reg_pass_confirm').val(),
                    address: $('#reg_address').val(),
                    tel: $('#reg_tel').val(), // Đã bổ sung số điện thoại bị thiếu
                    security: $('#register_security').val()
                };

                $.post(ajax_url, reg_data, function (res) {
                    if (res && res.data && res.data.message) {
                        $messageBox.text(res.data.message);
                    } else {
                        $messageBox.text('Có lỗi xảy ra từ hệ thống!');
                    }

                    if (res.success) {
                        $messageBox.css('color', 'green');
                        $('#litesite-register-form')[0].reset(); // Xóa sạch form
                        window.location.reload(); // Reload để nhận trạng thái đăng nhập mới
                    } else {
                        $messageBox.css('color', 'red');
                    }
                }).fail(function () {
                    $messageBox.css('color', 'red').text('Không thể kết nối đến máy chủ!');
                });
            });
        });
    </script>
    <!-- head end -->