<?php 

get_header(); 

$current_page_id = get_the_ID();
?>

<div class="container sale-page-container">
    <div class="breadcrumb-list">
        <a href="<?php echo home_url(); ?>" class="breadcrumb-item">Trang chủ</a>
        <span class="breadcrumb-item"><?php the_title(); ?></span>
    </div> 

    <h1><?php the_title(); ?></h1>

    <div class="sub-category-prd" style="margin: 20px 0;">
        <div class="owl-carousel owl-theme category-main-slider">
            <?php 
            $parent_cats = get_terms(array(
                'taxonomy' => 'product_cat',
                'parent' => 0,
                'hide_empty' => false,
            ));
            if (!empty($parent_cats)) :
                foreach ($parent_cats as $cat) :
                    $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                    $image_url = wp_get_attachment_url($thumbnail_id);
            ?>
                <div class="item">
                    <a class="sub-category-item" href="<?php echo get_term_link($cat); ?>">
                        <div class="category-img">
                            <img src="<?php echo $image_url ? $image_url : wc_placeholder_img_src(); ?>" alt="<?php echo $cat->name; ?>">
                        </div>
                        <div class="ctegory-name"><?php echo esc_html($cat->name); ?></div>
                    </a>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>

    <h3>🔥 SẢN PHẨM ĐANG HẠ GIÁ</h3>
    <div class="category-with-img-backgroud">
        <div class="category-with-img-main">
            <div class="category-with-img-image">
                <img src="<?php echo get_the_post_thumbnail_url($current_page_id, 'full'); ?>" alt="Sale Banner Left"> 
            </div>

            <div class="category-with-img-product">
                <div class="owl-carousel owl-theme product-sale-countdown-slider">
                    <?php 
                    $current_time = current_time('timestamp');
                    $sale_args = array(
                        'post_type'      => 'product',
                        'posts_per_page' => 10,
                        'meta_key'       => '_sale_price_dates_to',
                        'orderby'        => 'meta_value_num',
                        'order'          => 'ASC',
                        'meta_query'     => array(
                            'relation' => 'AND',
                            array('key' => '_sale_price_dates_to', 'value' => $current_time, 'compare' => '>', 'type' => 'NUMERIC'),
                            array('key' => '_sale_price', 'value' => 0, 'compare' => '>', 'type' => 'NUMERIC'),
                        ),
                    );
                    $sale_query = new WP_Query($sale_args);
                    if ($sale_query->have_posts()) :
                        while ($sale_query->have_posts()) : $sale_query->the_post();
                            global $product;
                            include(locate_template('product-item-ui.php')); 
                        endwhile;
                        wp_reset_postdata();
                    else:
                        echo '<p>Hiện không có ưu đãi giới hạn thời gian.</p>';
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="category-prd-baner" style="margin: 40px 0;">
        <div class="owl-carousel owl-theme sale-banner-gallery">
            <?php 
            $gallery = get_field('banner_sale', $current_page_id);
            if ($gallery) :
                foreach ($gallery as $image) :
            ?>
                <div class="item">
                    <img src="<?php echo esc_url($image['url']); ?>" alt="Banner">
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
    <div class="orderBy-wrap">
        <?php 
        // Thêm nút "Tất cả" để quay lại ban đầu nếu cần
        ?>
        <div class="orderBy-item orderBy" data-id="all" style="cursor:pointer;top: -4px;    position: relative;">
            <img class="orderBy-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo/Logo2.png" alt="logo">
            <div class="orderBy-text" >Tất cả</div>
        </div>

        <?php 
        if (!empty($parent_cats)) :
            foreach ($parent_cats as $cat) :
                $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                $image_url = wp_get_attachment_url($thumbnail_id);
        ?>
            <div class="orderBy-item" data-id="<?php echo $cat->term_id; ?>" style="cursor:pointer;">
                <img class="orderBy-img" src="<?php echo $image_url ? $image_url : wc_placeholder_img_src(); ?>" alt="<?php echo $cat->name; ?>">
                <div class="orderBy-text"><?php echo esc_html($cat->name); ?></div>
            </div>
        <?php endforeach; endif; ?>
    </div>
    

    <div class="product-loop-wrap" id="product-list">
        
			<?php 
			// 1. Cấu hình Query để lấy tất cả sản phẩm sắp xếp theo lượt bán (total_sales)
			$recommended_args = array(
			    'post_type'      => 'product',
			    'post_status'    => 'publish',
			    'meta_key'       => 'total_sales', // Key lưu trữ lượt bán của WooCommerce
			    'orderby'        => 'meta_value_num', // Sắp xếp theo giá trị số
			    'order'          => 'DESC',         // DESC: Mua nhiều nhất đứng đầu
			);

			$recommended_query = new WP_Query($recommended_args);

			// 2. Hiển thị kết quả
			if ($recommended_query->have_posts()) :
			    while ($recommended_query->have_posts()) : $recommended_query->the_post();
			        global $product;
			        // Gọi file template hiển thị sản phẩm của bạn
			        include(locate_template('product-item-ui.php')); 
			    endwhile;
			    wp_reset_postdata();
			else:
			    echo '<p>Hiện không có sản phẩm nào.</p>';
			endif;
			?>
        
        <div class="loading-overlay" style="display:none;">Đang tải...</div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {

    // 1. Hàm quét giỏ hàng và cập nhật UI cho sản phẩm
    function applyCartStateToProducts() {
        console.log("Đang đối chiếu sản phẩm với giỏ hàng...");
        
        // Duyệt qua từng sản phẩm đang hiển thị trong danh sách #product-list
        $('#product-list .slider-product-wrap').each(function() {
            var $productBox = $(this);
            var productId = $productBox.attr('data-product-id');

            // Tìm sản phẩm này trong mini-cart
            var $itemInCart = $('.box-product-mini-cart .mini-cart-prd-item[data-product-id="' + productId + '"]');

            if ($itemInCart.length > 0) {
                // Nếu tìm thấy trong giỏ hàng:
                var qtyInCart = $itemInCart.find('.mini-cart-quantity input').val();
                
                // Thêm class và cập nhật số lượng
                $productBox.find('.Volume').addClass('add-active');
                $productBox.find('input.qty').val(qtyInCart);
            } else {
                // Nếu không có: Reset về trạng thái ban đầu
                $productBox.find('.Volume').removeClass('add-active');
                $productBox.find('input.qty').val(0);
            }
        });
    }

    // 2. Xử lý sự kiện Click vào orderBy-item
    $(document).on('click', '.orderBy-item', function() {
        // UI: Active item được chọn
        $('.orderBy-item').removeClass('active');
        $(this).addClass('active');

        var catId = $(this).attr('data-id');
        var $container = $('#product-list');

        // Hiệu ứng chờ
        $container.css('opacity', '0.5');

        $.ajax({
            url: ajax_obj.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_products_by_cat',
                cat_id: catId
            },
            success: function(response) {
                // Bước quan trọng: Thay đổi toàn bộ nội dung sản phẩm
                $container.html(response);
                $container.css('opacity', '1');

                // GỌI LẠI HÀM ĐỐI CHIẾU NGAY TẠI ĐÂY
                // Mỗi lần AJAX thành công, nó sẽ chạy lại logic quét giỏ hàng
                applyCartStateToProducts();
            },
            error: function() {
                $container.css('opacity', '1');
                console.error("Lỗi khi lọc sản phẩm.");
            }
        });
    });

    // 3. Chạy lần đầu tiên khi trang vừa tải xong
    applyCartStateToProducts();
});
</script>

<script>
jQuery(document).ready(function($) {
    // Lấy slug trang hiện tại từ URL hoặc từ biến PHP (đã khai báo ở đầu file)
    var currentSlug = '<?php echo get_post_field( 'post_name', get_the_ID() ); ?>';

    function applyCartStateToProducts() {
        $('#product-list .slider-product-wrap').each(function() {
            var $productBox = $(this);
            var productId = $productBox.attr('data-product-id');
            var $itemInCart = $('.box-product-mini-cart .mini-cart-prd-item[data-product-id="' + productId + '"]');

            if ($itemInCart.length > 0) {
                var qtyInCart = $itemInCart.find('.mini-cart-quantity input').val();
                $productBox.find('.Volume').addClass('add-active');
                $productBox.find('input.qty').val(qtyInCart);
            } else {
                $productBox.find('.Volume').removeClass('add-active');
                $productBox.find('input.qty').val(0);
            }
        });
    }

    $(document).on('click', '.orderBy-item', function() {
        var $this = $(this);
        var catId = $this.attr('data-id');
        var $container = $('#product-list');

        $('.orderBy-item').removeClass('active');
        $this.addClass('active');
        $container.css('opacity', '0.5');

        $.ajax({
            url: ajax_obj.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_products_by_cat',
                cat_id: catId,
                page_slug: currentSlug // Gửi về PHP để phân loại Featured hay Sale
            },
            success: function(response) {
                $container.html(response).css('opacity', '1');
                applyCartStateToProducts(); // Đồng bộ giỏ hàng ngay lập tức
            }
        });
    });

    applyCartStateToProducts();
});
</script>

<?php get_footer(); ?>