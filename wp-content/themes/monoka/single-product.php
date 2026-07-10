<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php
// Lấy các thông tin cần thiết của sản phẩm WooCommerce
global $product;
if ( ! is_a( $product, 'WC_Product' ) ) {
    $product = wc_get_product( get_the_ID() );
}
?>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>

<div class="container product-detail-wrapper">
   <div class="breadcrumb-list">
      <a href="<?php echo home_url(); ?>" class="breadcrumb-item">Trang chủ</a>
      <?php
         $terms = get_the_terms(get_the_ID(), 'product_cat');
         if ($terms && !is_wp_error($terms)) {
             $main_term = $terms[0];
             $ancestors = array_reverse(get_ancestors($main_term->term_id, 'product_cat'));
             foreach ($ancestors as $ancestor_id) {
                 $ancestor = get_term($ancestor_id, 'product_cat');
                 echo '<a href="' . get_term_link($ancestor) . '" class="breadcrumb-item">' . esc_html($ancestor->name) . '</a>';
             }
             echo '<a href="' . get_term_link($main_term) . '" class="breadcrumb-item">' . esc_html($main_term->name) . '</a>';
         }
         ?>
      <span class="breadcrumb-item"><?php the_title(); ?></span>
   </div>

   <div class="product-main-content">
        <div class="product-img">
            <?php 
            $post_thumbnail_id = $product->get_image_id();
            $attachment_ids = $product->get_gallery_image_ids();
            $all_images = array_unique(array_merge(array($post_thumbnail_id), $attachment_ids));
            ?>

            <div class="product-gallery-container">
                <div class="product-img-slider vertical-nav">
                    <?php foreach ( $all_images as $attachment_id ) : 
                        $img_url = wp_get_attachment_image_url($attachment_id, 'thumbnail'); ?>
                        <div class="thumb-item">
                            <div class="thumb-inner">
                                <img src="<?php echo $img_url; ?>" alt="Thumbnail">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="product-img-thumbnail main-for">
                    <?php foreach ( $all_images as $attachment_id ) : 
                        $img_full_url = wp_get_attachment_image_url($attachment_id, 'full'); ?>
                        <div class="main-img-item" data-fancybox="product-gallery" href="<?php echo $img_full_url; ?>">
                            <img src="<?php echo $img_full_url; ?>" alt="Main Image">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="product-info">
            <h1><?php the_title(); ?></h1>
            <div class="price"><?php echo $product->get_price_html(); ?></div>
            
            <!-- KIỂM TRA NẾU SẢN PHẨM ĐANG GIẢM GIÁ THÌ MỚI HIỂN THỊ COUNTDOWN -->
            <?php if ( $product->is_on_sale() ) : ?>
                <div class="countdown">
                    <div class="flash-deal-banner" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/img/Detail_desktop_web.png');">
                        <div class="countdown-wrapper" id="product-flash-countdown">
                            <div class="countdown-title">KẾT THÚC SAU</div>
                            <div class="countdown-timer">
                                <div class="timer-box"><span class="00">00</span></div>
                                <div class="timer-box"><span class="hours">23</span></div>
                                <div class="timer-box"><span class="minutes">00</span></div>
                                <div class="timer-box"><span class="seconds">00</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="product-cart-actions-wrapper">
                <?php
                // 1. HIỂN THỊ KHỐI SWATCHES CHO THUỘC TÍNH MẪU (pa_mau) TRƯỚC
                if ( $product->is_type( 'variable' ) ) {
                    $mau_terms = get_the_terms( $product->get_id(), 'pa_mau' );
                    
                    if ( $mau_terms && ! is_wp_error( $mau_terms ) ) {
                        $variations = $product->get_available_variations();
                        $mau_images = array();
                        
                        foreach ( $variations as $variation ) {
                            $attr_value = isset( $variation['attributes']['attribute_pa_mau'] ) ? $variation['attributes']['attribute_pa_mau'] : '';
                            if ( $attr_value && empty( $mau_images[$attr_value] ) ) {
                                $mau_images[$attr_value] = !empty($variation['image']['thumb_src']) ? $variation['image']['thumb_src'] : $variation['image']['src'];
                            }
                        }
                        ?>
                        <div class="custom-swatches-wrapper">
                            <div class="swatch-label">Chọn Mẫu: </div>
                            <div class="swatch-options">
                                <?php foreach ( $mau_terms as $term ) : 
                                    $img_src = isset( $mau_images[$term->slug] ) ? $mau_images[$term->slug] : wp_get_attachment_image_url($product->get_image_id(), 'thumbnail');
                                ?>
                                    <div class="swatch-item" data-slug="<?php echo esc_attr($term->slug); ?>">
                                        <img src="<?php echo esc_url($img_src); ?>" alt="<?php echo esc_attr($term->name); ?>">
                                        <span><?php echo esc_html( $term->name ); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php
                    }
                }

                // 2. HOOK NÚT "MUA NGAY" VÀO TRONG FORM NẰM NGAY DƯỚI NÚT "THÊM VÀO GIỎ" MẶC ĐỊNH
                if ( ! function_exists( 'custom_variable_buy_now_button' ) ) {
                    function custom_variable_buy_now_button() {
                        echo '<button type="button" class="custom-buy-now-btn">MUA NGAY</button>';
                    }
                }
                add_action( 'woocommerce_after_add_to_cart_button', 'custom_variable_buy_now_button' );

                // 3. GỌI HÀM SINH FORM GỐC CỦA WOOCOMMERCE
                woocommerce_template_single_add_to_cart();

                // 4. XÓA HOOK NGAY SAU KHI CHẠY XONG ĐỂ TRÁNH LỖI TRANG KHÁC
                remove_action( 'woocommerce_after_add_to_cart_button', 'custom_variable_buy_now_button' );
                ?>
            </div>
            <div class="mo-ta">
                <?php echo apply_filters( 'woocommerce_short_description', get_the_excerpt() ); ?>
            </div>
        </div>   
    </div>

    <div class="home-endow">
        <div class="home-endow-item">
            <div class="home-endow-item-img">
                <img src="https://monoka.reviewcode.info/wp-content/uploads/2026/05/hand.png" alt="icon home">
            </div>
            <div class="endow-item-text">
                <b> Thanh toán khi nhận hàng (COD)</b>
                <p>Giao hàng toàn quốc.</p>
            </div>
        </div>
        <div class="home-endow-item">
            <div class="home-endow-item-img">
                <img src="https://monoka.reviewcode.info/wp-content/uploads/2026/05/truck.png" alt="icon home">
            </div>
            <div class="endow-item-text">
                <b>Hàng đẹp chất lượng cao</b>
                <p>Khác biệt so với hàng rẻ trên thị trường</p>
            </div>
        </div>
        <div class="home-endow-item">
            <div class="home-endow-item-img">
                <img src="https://monoka.reviewcode.info/wp-content/uploads/2026/05/goods.png" alt="icon home">
            </div>
            <div class="endow-item-text">
                <b>Bảo hành dài hạn</b>
                <p>Bảo hành 24 tháng</p>
            </div>
        </div>
    </div>

    <div class="information-prd">
        <div class="information-prd-title">
            <b>THÔNG TIN SẢN PHẨM</b>
        </div>
        <div class="main-content-wrapper">
            <div class="main-content">
                <?php 
                $product_desc = $product->get_description(); 
                echo wpautop( do_shortcode( $product_desc ) ); 
                ?>
            </div>
            <div class="content-overlay"></div>
            
            <div class="readmore-btn-wp">
                <button id="toggle-content-btn" class="view-more-btn">
                    Xem thêm <span class="arrow">▼</span>
                </button>
            </div>
        </div>
    </div>
    <div class="cmt-slider">
        <h2>Đánh giá từ khách hàng</h2>
        <div class="owl-carousel owl-theme">
            <div class="item">
                <div class="cmt-slider-hear">
                    <img class="cmt-slider-avt" src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/banner/474661710_3604127249891581_892642856226634571_n.jpg" alt="cmt avatar">
                    <div class="cmt-slider-info-wrap">
                        <div class="cmt-slider-info">
                            <div class="cmt-slider-name">Long Nguyễn</div>
                            <div class="cmt-slider-time">1 tuần trước</div>
                        </div>
                        <img class="google" src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/google.png" alt="google icon">
                    </div>
                </div>
                <div class="cmt-slider-star">
                    <i class="fa fa-star" style="color: rgb(255, 212, 59);"></i>
                    <i class="fa fa-star" style="color: rgb(255, 212, 59);"></i>
                    <i class="fa fa-star" style="color: rgb(255, 212, 59);"></i>
                    <i class="fa fa-star" style="color: rgb(255, 212, 59);"></i>
                    <i class="fa fa-star" style="color: rgb(255, 212, 59);"></i>
                    <img src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/success.png">
                </div>
                <div class="cmt-slider-bottum">
                    <div class="cmt-slider-text">tranh đẹp ưng</div>
                    <img class="cmt-slider-img" src="https://monoka.reviewcode.info/wp-content/uploads/2026/05/sg-11134201-8262g-mmfn0fxjjmkkf8-300x300.webp" alt="cmt img">
                </div>
            </div>
        </div>
    </div>
    <div class="slider-prd-2">
        <div class="home-category-link">
            <h2 class="icon-after">Sản Phẩm tương tự</h2> 
            <a class="see-more" href="<?php
                $term_link = '#';
                $terms = get_the_terms( get_the_ID(), 'product_cat' );

                if ( $terms && ! is_wp_error( $terms ) ) {
                    $first_term = array_shift( $terms );
                    $link = get_term_link( $first_term );
                    if ( ! is_wp_error( $link ) ) {
                        $term_link = $link;
                    }
                }

                echo esc_url( $term_link ); 
                ?>">Xem Thêm <i class="fa fa-angle-right"></i>
            </a>
        </div>
        <div class="owl-carousel owl-theme">
            <?php 
            $current_product_id = get_the_ID();
            $terms = get_the_terms( $current_product_id, 'product_cat' );
            $term_ids = array();

            if ( $terms && ! is_wp_error( $terms ) ) {
                foreach ( $terms as $term ) {
                    $term_ids[] = $term->term_id;
                }
            }

            $related_args = array(
                'post_type'      => 'product',
                'posts_per_page' => 10,
                'post__not_in'   => array( $current_product_id ),
                'orderby'        => 'date',
                'order'          => 'DESC',
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'term_id',
                        'terms'    => $term_ids,
                    ),
                ),
            );

            $related_query = new WP_Query( $related_args );

            if ( $related_query->have_posts() ) :
                while ( $related_query->have_posts() ) : $related_query->the_post();
                    global $product;
                    $product = wc_get_product( get_the_ID() ); 
                    include( locate_template( 'product-item-ui.php' ) ); 
                endwhile;
                wp_reset_postdata();
            else:
                echo '<p>Không có sản phẩm cùng danh mục nào.</p>';
            endif;
            ?>
        </div>
    </div>
    <div class="slider-prd-2">
        <div class="home-category-link">
            <h2 class="icon-after">Sản phẩm vừa xem</h2> 
            <a class="see-more" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
                Xem Thêm <i class="fa fa-angle-right"></i>
            </a>
        </div>
        <div class="owl-carousel owl-theme">
            <?php 
            $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
            $viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

            if ( is_singular( 'product' ) ) {
                $viewed_products = array_diff( $viewed_products, array( get_the_ID() ) );
            }

            if ( ! empty( $viewed_products ) ) :
                $recent_args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 10,
                    'post__in'       => $viewed_products,
                    'orderby'        => 'post__in',
                );

                $recent_query = new WP_Query( $recent_args );

                if ( $recent_query->have_posts() ) :
                    while ( $recent_query->have_posts() ) : $recent_query->the_post();
                        global $product;
                        $product = wc_get_product( get_the_ID() ); 
                        include( locate_template( 'product-item-ui.php' ) ); 
                    endwhile;
                    wp_reset_postdata();
                else:
                    echo '<p class="no-products">Bạn chưa xem sản phẩm nào.</p>';
                endif;
            else:
                echo '<p class="no-products">Bạn chưa xem sản phẩm nào.</p>';
            endif;
            ?>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // 1. Khởi tạo slider ảnh lớn
    if ($('.main-for').length > 0) {
        $('.main-for').slick({ slidesToShow: 1, slidesToScroll: 1, arrows: false, fade: true, asNavFor: '.vertical-nav' });
    }

    // 2. Khởi tạo slider ảnh nhỏ
    if ($('.vertical-nav').length > 0) {
        $('.vertical-nav').slick({
            slidesToShow: 6, slidesToScroll: 1, asNavFor: '.main-for', vertical: true, verticalSwiping: true, focusOnSelect: true, arrows: true, infinite: true,
            prevArrow: '<button type="button" class="slick-prev">Previous</button>',
            nextArrow: '<button type="button" class="slick-next">Next</button>',
            responsive: [ { breakpoint: 768, settings: { vertical: false, verticalSwiping: false, slidesToShow: 4 } } ]
        });
    }

    // 3. Cấu hình popup xem ảnh mở rộng
    if (typeof Fancybox !== 'undefined') {
        Fancybox.bind('[data-fancybox="product-gallery"]', { loop: true, transitionEffect: "fade", Thumbs: { autoStart: true, type: "classic" } });
    }

    // 4. Khởi chạy bộ đếm ngược 23 tiếng
    if ($('#product-flash-countdown').length > 0) {
        function initCountdown() {
            var countdownId = 'flash_sale_end_time'; var localStorageTime = localStorage.getItem(countdownId); var finalDate;
            if (localStorageTime) { finalDate = parseInt(localStorageTime, 10); if (finalDate < new Date().getTime()) { finalDate = new Date().getTime() + (23 * 60 * 60 * 1000); localStorage.setItem(countdownId, finalDate); } } 
            else { finalDate = new Date().getTime() + (23 * 60 * 60 * 1000); localStorage.setItem(countdownId, finalDate); }
            var x = setInterval(function() {
                var now = new Date().getTime(); var distance = finalDate - now;
                var hours = Math.floor(distance / (1000 * 60 * 60)); var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)); var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                hours = hours < 10 ? "0" + hours : hours; minutes = minutes < 10 ? "0" + minutes : minutes; seconds = seconds < 10 ? "0" + seconds : seconds;
                $('#product-flash-countdown .hours').text(hours); $('#product-flash-countdown .minutes').text(minutes); $('#product-flash-countdown .seconds').text(seconds);
                if (distance < 0) { finalDate = new Date().getTime() + (23 * 60 * 60 * 1000); localStorage.setItem(countdownId, finalDate); }
            }, 1000);
        }
        initCountdown();
    }

jQuery(document).ready(function($) {
    var $priceContainer = $('.product-info > .price');
    var originalPrice = $priceContainer.html(); // Lưu giá gốc (giá khoảng)

    // Lắng nghe sự kiện WooCommerce khi tìm thấy biến thể
    $(document).on('found_variation', 'form.variations_form', function(event, variation) {
        if (variation && variation.price_html) {
            // Thay giá ở trên bằng giá của biến thể vừa tìm thấy
            $priceContainer.html(variation.price_html);
        }
    });

    // Lắng nghe sự kiện khi khách bấm nút "Xóa" hoặc bỏ chọn biến thể
    $(document).on('reset_data', 'form.variations_form', function() {
        // Trả lại giá khoảng ban đầu
        $priceContainer.html(originalPrice);
        $('.swatch-item').removeClass('active');
    });

    // Xử lý click swatch để trigger sự kiện của WooCommerce
    $(document).on('click', '.swatch-item', function() {
        var $this = $(this);
        var slug = $this.data('slug');
        var $wcSelect = $('form.cart').find('select#pa_mau');
        
        $this.addClass('active').siblings().removeClass('active');
        
        if ($wcSelect.length > 0) {
            $wcSelect.val(slug).trigger('change');
        }
    });
});

    // Khi khách click vào Swatch tự làm
    $(document).on('click', '.swatch-item', function() {
        var $this = $(this);
        var slug = $this.data('slug');
        $this.addClass('active').siblings().removeClass('active');
        
        // Kích hoạt thẻ select gốc của WC
        var $wcSelect = $('form.cart').find('select#pa_mau');
        if ($wcSelect.length > 0) {
            $wcSelect.val(slug).trigger('change');
        }
    });

    // Lắng nghe TẤT CẢ các hành vi thay đổi thuộc tính trong Form (Click Swatch, đổi Dropdown Kích thước)
    $(document).on('change click', 'form.variations_form select, .swatch-item', function() {
        // Chạy lặp lại liên tục ở các mốc mili-giây để bắt kịp tốc độ tính toán giá của WooCommerce
        setTimeout(forceSyncPrice, 50);
        setTimeout(forceSyncPrice, 150);
        setTimeout(forceSyncPrice, 300);
        setTimeout(forceSyncPrice, 500);
    });

    // Khi người dùng bấm nút "Xóa" (Clear selection)
    $(document).on('reset_data', 'form.variations_form', function() {
        $topPriceContainer.html(originalPriceHtml);
        $('.swatch-item').removeClass('active');
    });


    /* ==========================================================================
       5. XỬ LÝ NÚT TĂNG GIẢM SỐ LƯỢNG
       ========================================================================== */
    $(document).on('click', '.qty-plus', function(e) {
        e.preventDefault(); var $input = $(this).siblings('.qty'); var currentVal = parseInt($input.val(), 10); var maxVal = parseInt($input.attr('max'), 10);
        if (isNaN(currentVal)) currentVal = 0; if (isNaN(maxVal) || maxVal === 0 || currentVal < maxVal) { $input.val(currentVal + 1).trigger('change'); }
    });
    $(document).on('click', '.qty-minus', function(e) {
        e.preventDefault(); var $input = $(this).siblings('.qty'); var currentVal = parseInt($input.val(), 10); var minVal = parseInt($input.attr('min'), 10);
        if (isNaN(currentVal)) currentVal = 1; if (isNaN(minVal) || minVal === 0) minVal = 1; if (currentVal > minVal) { $input.val(currentVal - 1).trigger('change'); }
    });

    /* ==========================================================================
       6. NÚT MUA NGAY TRÊN SẢN PHẨM BIẾN THỂ
       ========================================================================== */
    $(document).on('click', '.custom-buy-now-btn', function(e) {
        e.preventDefault();
        var $form = $('form.cart');
        var $btn = $(this);
        var variationId = $form.find('input[name="variation_id"]').val();
        
        if ($form.hasClass('variations_form') && (!variationId || variationId == 0)) {
            alert('Vui lòng chọn đầy đủ Mẫu và Kích thước trước khi mua!');
            return;
        }

        $btn.text('ĐANG XỬ LÝ...').css('opacity', '0.7').prop('disabled', true);
        
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: $form.serialize() + '&add-to-cart=' + $form.find('input[name="add-to-cart"]').val(),
            success: function() { window.location.href = '<?php echo esc_url( wc_get_checkout_url() ); ?>'; },
            error: function() { $btn.text('MUA NGAY').css('opacity', '1').prop('disabled', false); alert('Có lỗi xảy ra, vui lòng thử lại!'); }
        });
    });
});
</script>

<?php endwhile; endif; ?>
<?php get_footer(); ?>