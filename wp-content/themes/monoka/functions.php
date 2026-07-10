<?php
function wp_include_css()
{
wp_enqueue_style('main-style', get_template_directory_uri().'/style.css', array(), false, 'all');
wp_enqueue_style('icon', get_template_directory_uri().'/assets/css/font-awesome.min.css', array(), false, 'all');
wp_enqueue_style('owl-css', get_template_directory_uri().'/assets/css/owl.carousel.css', array(), false, 'all');
wp_enqueue_style('owl-css2', get_template_directory_uri().'/assets/css/owl.theme.default.css', array(), false, 'all');
if (is_product_category() || is_singular('product') || is_page('sale')||is_page('sell-well')||is_page('recommended')) {
    wp_enqueue_style('product-category-style', get_template_directory_uri() . '/assets/css/product-category.css', array(), false, 'all');
};

if(is_page('my-account'))
{ 
wp_enqueue_style('track-order-style', get_template_directory_uri().'/assets/css/track-order.css', array(), false, 'all');

};

if(is_page('cart'))
{ 
wp_enqueue_style('cart-style', get_template_directory_uri().'/assets/css/cart.css', array(), false, 'all');
};

if(is_page('checkout'))
{ 
wp_enqueue_style('checkout-style', get_template_directory_uri().'/assets/css/checkout.css', array(), false, 'all');
};

if (is_singular('product')) {
        wp_enqueue_style('single-product-style', get_template_directory_uri() . '/assets/css/single-product.css', array(), false, 'all');
};

if(is_page('home'))
    { 
    wp_enqueue_style('home-style', get_template_directory_uri().'/assets/css/home.css', array(), false, 'all');
    }
}
add_action('wp_enqueue_scripts', 'wp_include_css');

// add js
function wp_include_js()
{
    wp_enqueue_script('jquery-js', get_template_directory_uri().'/assets/js/jquery-1.11.3.min.js', array(), false, true);
    wp_enqueue_script('owl-js', get_template_directory_uri().'/assets/js/owl.carousel.js', array(), false, true);
    wp_enqueue_script('owl-js2', get_template_directory_uri().'/assets/js/owl.carousel.min.js', array(), false, true);
    wp_enqueue_script('owl-setup', get_template_directory_uri().'/assets/js/owl-setup.js', array(), false, true);
    wp_enqueue_script('my-js', get_template_directory_uri().'/assets/js/my.js', array(), false, true);

    // Kiểm tra nếu đang ở trang sản phẩm của WooCommerce
 if (is_singular('product'))
    {
      wp_enqueue_script('product-single-script',get_template_directory_uri() . '/assets/js/single-product.js', array(), false, 'all');
    };


    // Kiểm tra nếu đang ở trang danh mục sản phẩm của WooCommerce
    if ( is_tax('product_cat') ) {wp_enqueue_script('product-category-js', get_template_directory_uri() . '/assets/js/product-category.js', 
            array('jquery-js'), false, true);
    }
};
add_action('wp_enqueue_scripts', 'wp_include_js');

// Cấu hình PHP hệ thống
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

// Thiết lập hằng số
define( 'THEME_URL', get_stylesheet_directory() );

// Cấu hình Theme hỗ trợ (Đổi hook sang 'after_setup_theme')
function thachpham_theme_setup() {
    $language_folder = THEME_URL . '/languages';
    load_theme_textdomain( 'thachpham', $language_folder );

    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
}
add_action ( 'after_setup_theme', 'thachpham_theme_setup' );

// Chỉnh độ dài mô tả ngắn (Excerpt)
function custom_excerpt_length( $length ) {
    return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length');

function custom_excerpt_more( $more ) {
    return '';
}
add_filter('excerpt_more', 'custom_excerpt_more');

// Đăng ký Menu
function register_my_menu() {
    register_nav_menu('footer-menu1', __( 'Menu footer 1', 'thachpham' ));
    register_nav_menu('footer-menu2', __( 'Menu footer 2', 'thachpham' ));
    register_nav_menu('Service-menu', __( 'menu dịch vụ', 'thachpham' ));
    register_nav_menu('main-menu', __( 'menu chính', 'thachpham' ));
    register_nav_menu('sidebar-menu', __( 'menu sidebar', 'thachpham' ));
}
add_action( 'init', 'register_my_menu' );

// 1. Thêm trường hiển thị trong Admin Menu
add_action( 'wp_nav_menu_item_custom_fields', 'gemini_menu_item_fields', 10, 4 );
function gemini_menu_item_fields( $item_id, $item, $depth, $args ) {
    $img_id = get_post_meta( $item_id, '_menu_item_img_id', true );
    $img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'thumbnail' ) : '';
    ?>
    <p class="field-custom description-wide">
        <label>Ảnh đại diện menu</label><br />
        <div class="menu-item-image-wrapper">
            <div class="menu-item-image-preview" style="margin: 5px 0;">
                <?php if ( $img_url ) : ?>
                    <img src="<?php echo esc_url( $img_url ); ?>" width="50" style="display:block; border:1px solid #ccd0d4;"/>
                <?php endif; ?>
            </div>
            <input type="hidden" class="menu-item-img-id" name="menu_item_img_id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $img_id ); ?>" />
            <button type="button" class="button select-img-menu">Chọn ảnh</button>
            <button type="button" class="button remove-img-menu" <?php echo !$img_id ? 'style="display:none;"' : ''; ?>>Xóa</button>
        </div>
    </p>
    <?php
}

// 2. QUAN TRỌNG: Lưu dữ liệu khi nhấn Lưu Menu
add_action( 'wp_update_nav_menu_item', 'gemini_save_menu_item_fields', 10, 3 );
function gemini_save_menu_item_fields( $menu_id, $menu_item_db_id, $menu_item_data ) {
    if ( isset( $_POST['menu_item_img_id'][$menu_item_db_id] ) ) {
        update_post_meta( $menu_item_db_id, '_menu_item_img_id', $_POST['menu_item_img_id'][$menu_item_db_id] );
    } else {
        delete_post_meta( $menu_item_db_id, '_menu_item_img_id' );
    }
}

// 3. Script mở Media Uploader
// 3. Script mở Media Uploader (Bản sửa lỗi không mở được bảng chọn ảnh)
add_action( 'admin_enqueue_scripts', function($hook) {
    if ( 'nav-menus.php' !== $hook ) return;
    wp_enqueue_media(); // Đảm bảo thư viện media luôn được nạp
});

add_action( 'admin_footer-nav-menus.php', 'gemini_menu_media_js_fixed' );
function gemini_menu_media_js_fixed() {
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Sử dụng delegated event để bắt được cả các menu item mới thêm
        $(document).on('click', '.select-img-menu', function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var $wrapper = $button.closest('.menu-item-image-wrapper');
            var frame;

            // Nếu khung media đã tồn tại, mở lại nó
            if ( frame ) {
                frame.open();
                return;
            }

            // Khởi tạo khung Media của WordPress
            frame = wp.media({
                title: 'Chọn ảnh cho Menu',
                button: { text: 'Sử dụng ảnh này' },
                multiple: false
            });

            // Khi một ảnh được chọn
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                
                // Đưa ID vào input ẩn
                $wrapper.find('.menu-item-img-id').val(attachment.id);
                
                // Hiển thị ảnh xem trước (ưu tiên size thumbnail nếu có)
                var thumb = attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                $wrapper.find('.menu-item-image-preview').html('<img src="'+thumb+'" width="50" style="display:block; border:1px solid #ccd0d4; margin-bottom:5px;"/>');
                
                // Hiện nút xóa
                $wrapper.find('.remove-img-menu').show();
                
                // Thông báo cho WordPress rằng menu đã thay đổi để nút "Lưu menu" sáng lên
                $wrapper.find('.menu-item-img-id').trigger('change');
            });

            frame.open();
        });

        // Xử lý nút Xóa ảnh
        $(document).on('click', '.remove-img-menu', function(e) {
            e.preventDefault();
            var $wrapper = $(this).closest('.menu-item-image-wrapper');
            $wrapper.find('.menu-item-img-id').val('');
            $wrapper.find('.menu-item-image-preview').empty();
            $(this).hide();
            $wrapper.find('.menu-item-img-id').trigger('change');
        });
    });
    </script>
    <?php
}

add_filter( 'walker_nav_menu_start_el', 'display_menu_upload_img_all_locations', 10, 4 );
function display_menu_upload_img_all_locations( $item_output, $item, $depth, $args ) {
    $img_id = get_post_meta( $item->ID, '_menu_item_img_id', true );

    if ( $img_id ) {
        $img_url = wp_get_attachment_image_url( $img_id, 'thumbnail' );
        if ( $img_url ) {
            $image_html = '<img src="' . esc_url( $img_url ) . '" class="menu-custom-icon" style="width:20px; height:auto; margin-right:8px; vertical-align:middle;" />';
            
            // Chèn vào trước tiêu đề mục menu
            $item_output = str_replace( $args->link_before . $item->title, $image_html . $args->link_before . $item->title, $item_output );
        }
    }
    return $item_output;
}

// Thêm vào functions.php nếu muốn hiển thị duy nhất giá thấp nhất cho sản phẩm biến thể ngoài danh mục
add_filter( 'woocommerce_variable_sale_price_html', 'wps_custom_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wps_custom_variation_price_format', 10, 2 );

function wps_custom_variation_price_format( $price, $product ) {
    // Lấy giá thấp nhất
    $min_regular_price = $product->get_variation_regular_price( 'min', true );
    $min_sale_price = $product->get_variation_sale_price( 'min', true );
    
    if ( $product->is_on_sale() && $min_sale_price < $min_regular_price ) {
        $price = '<del>' . wc_price( $min_regular_price ) . '</del> <ins>' . wc_price( $min_sale_price ) . '</ins>';
    } else {
        $price = wc_price( $min_regular_price );
    }
    return $price;
}

add_filter('template_include', 'force_root_taxonomy_product_cat', 99);

function force_root_taxonomy_product_cat($template) {
    if (is_tax('product_cat')) {
        $root_template = locate_template('taxonomy-product_cat.php');
        if (!empty($root_template)) {
            return $root_template;
        }
    }
    return $template;
}

/**
 * Tối ưu số lượng sản phẩm hiển thị tại trang danh mục để fix lỗi 404 phân trang WP_Query
 */
function monoka_custom_product_category_query( $query ) {
    // Chỉ can thiệp khi ở môi trường Frontend, thuộc truy vấn chính (Main Query) và là trang danh mục sản phẩm
    if ( ! is_admin() && $query->is_main_query() && is_tax( 'product_cat' ) ) {
        $query->set( 'posts_per_page', 20 ); // Đặt số lượng sản phẩm hiển thị trùng với số lượng trong file template (10 sản phẩm)
    }
}
add_action( 'pre_get_posts', 'monoka_custom_product_category_query' );

/**
 * Chủ động ghi đè Cookie Sản phẩm vừa xem để tránh lỗi từ Theme
 */
add_action( 'template_redirect', 'custom_force_track_recently_viewed', 20 );
function custom_force_track_recently_viewed() {
    // Chỉ chạy khi ở trang chi tiết sản phẩm và không phải trong Admin
    if ( is_admin() || ! is_singular( 'product' ) ) {
        return;
    }

    global $post;
    if ( ! $post ) return;

    // Lấy danh sách ID cũ từ cookie
    $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
    $viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

    // Nếu ID sản phẩm hiện tại chưa có, hoặc đã có thì đưa nó lên đầu danh sách
    if ( ! in_array( $post->ID, $viewed_products ) ) {
        array_unshift( $viewed_products, $post->ID );
    } else {
        $viewed_products = array_diff( $viewed_products, array( $post->ID ) );
        array_unshift( $viewed_products, $post->ID );
    }

    // Giới hạn lưu tối đa 12 sản phẩm gần nhất
    if ( count( $viewed_products ) > 12 ) {
        array_pop( $viewed_products );
    }

    // Thiết lập cookie lưu trong 30 ngày công khai để PHP/JS đều đọc được
    setcookie( 
        'woocommerce_recently_viewed', 
        implode( '|', $viewed_products ), 
        time() + ( 86400 * 30 ), 
        COOKIEPATH ? COOKIEPATH : '/', 
        COOKIE_DOMAIN, 
        false, 
        false 
    );
}


// 1. Tùy chỉnh các trường Checkout (Gộp tên, bỏ trường không cần thiết)
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
    // Gộp First name và Last name thành Họ và tên
    $fields['billing']['billing_first_name']['label'] = 'Họ và tên';
    $fields['billing']['billing_first_name']['placeholder'] = 'Nhập họ và tên đầy đủ';
    unset($fields['billing']['billing_last_name']);

    // Bỏ các trường không cần thiết theo yêu cầu
    unset($fields['billing']['billing_country']);     // Bỏ quốc gia
    unset($fields['billing']['billing_postcode']);    // Bỏ mã bưu điện
    unset($fields['billing']['billing_company']);     // Bỏ công ty
    unset($fields['billing']['billing_address_2']);   // Bỏ dòng địa chỉ 2
    unset($fields['billing']['billing_email']);       // BỎ TRƯỜNG EMAIL
    unset($fields['billing']['billing_city']);        // BỎ TRƯỜNG THÀNH PHỐ

    // SĐT bắt buộc
    $fields['billing']['billing_phone']['required'] = true;

    return $fields;
}

// 2. Di chuyển phần ghi chú đơn hàng vào cột bên trái (bên dưới form thanh toán)
add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
add_action( 'woocommerce_after_checkout_billing_form', 'move_order_notes_to_billing_form' );

function move_order_notes_to_billing_form( $checkout ) {
    echo '<div class="additional-fields" style="margin-top:20px;">';
    woocommerce_form_field( 'order_comments', array(
        'type'          => 'textarea',
        'class'         => array('notes'),
        'label'         => 'Thông tin bổ sung',
        'placeholder'   => 'Ghi chú về đơn hàng của bạn...',
    ), $checkout->get_value( 'order_comments' ));
    echo '</div>';
}

// Xóa phần ghi chú mặc định ở vị trí cũ để không bị lặp
add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );


// 1. XỬ LÝ ĐĂNG NHẬP AJAX
add_action('wp_ajax_nopriv_ajax_login', 'litesite_handle_ajax_login');
function litesite_handle_ajax_login() {
    // Kiểm tra bảo mật nonce
    check_ajax_referer('ajax-login-nonce', 'security');

    $info = array();
    $info['user_login']    = sanitize_user($_POST['username']);
    $info['user_password'] = $_POST['password'];
    $info['remember']      = true;

    // Thực hiện đăng nhập
    $user_signon = wp_signon($info, false);

    if (is_wp_error($user_signon)) {
        wp_send_json_error(array('message' => 'Tên đăng nhập hoặc mật khẩu không chính xác!'));
    } else {
        wp_send_json_success(array('message' => 'Đăng nhập thành công! Đang tải lại trang...'));
    }
}

// 2. XỬ LÝ ĐĂNG KÝ AJAX
add_action('wp_ajax_nopriv_litesite_ajax_register', 'litesite_handle_ajax_register');
function litesite_handle_ajax_register() {
    // Kiểm tra bảo mật nonce
    check_ajax_referer('ajax-register-nonce', 'security');

    $username = sanitize_user($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $address  = sanitize_text_field($_POST['address']);
    $tel      = sanitize_text_field($_POST['tel']); // Lấy thêm số điện thoại

    // Kiểm tra mật khẩu khớp nhau
    if ($password !== $confirm_password) {
        wp_send_json_error(array('message' => 'Mật khẩu nhập lại không trùng khớp!'));
    }

    // Kiểm tra user tồn tại chưa
    if (username_exists($username)) {
        wp_send_json_error(array('message' => 'Tên đăng nhập này đã có người sử dụng!'));
    }

    // Tạo tài khoản mới
    $user_id = wp_insert_user(array(
        'user_login' => $username,
        'user_pass'  => $password,
        'role'       => 'customer' // Phân quyền khách hàng mua sắm
    ));

    if (is_wp_error($user_id)) {
        wp_send_json_error(array('message' => $user_id->get_error_message()));
    }

    // Lưu địa chỉ & SĐT vào Meta để đồng bộ với WooCommerce nếu có
    update_user_meta($user_id, 'billing_address_1', $address);
    update_user_meta($user_id, 'billing_phone', $tel);

    // Tự động đăng nhập luôn sau khi đăng ký thành công
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);

    wp_send_json_success(array('message' => 'Đăng ký thành công! Hệ thống đang đăng nhập...'));
}

// 1. BACKEND XỬ LÝ SỬA NHANH THÔNG TIN (INLINE EDIT)
add_action('wp_ajax_update_user_inline_meta', 'litesite_handle_inline_meta_update');
function litesite_handle_inline_meta_update() {
    check_ajax_referer('litesite-inline-update', 'security');
    
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Bạn cần phải đăng nhập!'));
    }
    
    $user_id = get_current_user_id();
    $field   = sanitize_text_field($_POST['field']);
    $value   = sanitize_text_field($_POST['value']);
    
    // Bảo vệ chỉ cho phép cập nhật 2 trường này để tránh inject phá tài khoản
    if (in_array($field, array('billing_phone', 'billing_address_1'))) {
        update_user_meta($user_id, $field, $value);
        wp_send_json_success(array('message' => 'Cập nhật thông tin thành công!'));
    }
    
    wp_send_json_error(array('message' => 'Dữ liệu không hợp lệ.'));
}

// 2. BACKEND XỬ LÝ HỦY ĐƠN HÀNG QUA AJAX
add_action('wp_ajax_litesite_ajax_cancel_order', 'litesite_handle_ajax_cancel_order');
function litesite_handle_ajax_cancel_order() {
    // Kiểm tra nonce bảo mật bảo vệ đơn hàng
    check_ajax_referer('litesite-cancel-order-nonce', 'security');

    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Vui lòng đăng nhập trước khi thực hiện.'));
    }

    $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $order    = wc_get_order($order_id);

    // Xác minh đơn hàng hợp lệ và thuộc về chính khách hàng đang đăng nhập
    if (!$order || $order->get_user_id() !== get_current_user_id()) {
        wp_send_json_error(array('message' => 'Đơn hàng không hợp lệ hoặc không thuộc quyền sở hữu của bạn.'));
    }

    // Các trạng thái đơn hàng hợp lệ được phép yêu cầu hủy
    $allowed_statuses = array('pending', 'on-hold', 'processing');
    if (!in_array($order->get_status(), $allowed_statuses)) {
        wp_send_json_error(array('message' => 'Đơn hàng này không còn ở trạng thái có thể hủy!'));
    }

    // Thực hiện đổi trạng thái đơn sang HỦY và đính kèm ghi chú hệ thống
    $order->update_status('cancelled', __('Khách hàng chủ động hủy đơn hàng qua trang tài khoản.', 'woocommerce'));

    wp_send_json_success(array('message' => 'Đơn hàng #' . $order->get_order_number() . ' đã hủy thành công!'));
}