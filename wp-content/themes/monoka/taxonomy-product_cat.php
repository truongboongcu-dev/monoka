<?php get_header(); ?>
<?php
$queried_object = get_queried_object();
$taxonomy_id    = $queried_object->taxonomy . '_' . $queried_object->term_id;

$banner_url = get_field('banner_car_product', $taxonomy_id);

$default_banner = get_stylesheet_directory_uri() . '/assets/img/banner/logo.png';

echo '<div class="category-custom-banner" style="margin-bottom: 20px; width: 100%;">';

if ( ! empty( $banner_url ) ) {
    
    $clean_url = strtok(strtolower($banner_url), '?');
    $extension = pathinfo($clean_url, PATHINFO_EXTENSION);

    // Mảng định nghĩa các đuôi file ảnh và video phổ biến
    $image_extensions = array('jpg', 'jpeg', 'png', 'gif', 'webp', 'svg');
    $video_extensions = array('mp4', 'webm', 'ogv', 'mov');

    if ( in_array( $extension, $image_extensions ) ) {
        ?>
        <img src="<?php echo esc_url( $banner_url ); ?>" alt="<?php echo esc_attr( $queried_object->name ); ?>" style="max-width: 100%; height: auto; display: block; width: 100%;">
        <?php

    } elseif ( in_array( $extension, $video_extensions ) ) {
        ?>
        <video autoplay muted loop playsinline style="max-width: 100%; width: 100%; height: auto; display: block;">
            <source src="<?php echo esc_url( $banner_url ); ?>" type="video/<?php echo esc_attr( $extension ); ?>">
            Trình duyệt của bạn không hỗ trợ thẻ video.
        </video>
        <?php

    } elseif ( strpos($banner_url, 'youtube.com') !== false || strpos($banner_url, 'youtu.be') !== false ) {
        $video_id = '';
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $banner_url, $match)) {
            $video_id = $match[1];
        }
        
        if ( ! empty( $video_id ) ) {
            ?>
            <div class="video-responsive" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                <iframe src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe>
            </div>
            <?php
        } else {
            ?>
            <img src="<?php echo esc_url( $default_banner ); ?>" alt="<?php echo esc_attr( $queried_object->name ); ?>" style="max-width: 100%; height: auto; display: block; margin: 0 auto;">
            <?php
        }

    } else {
        ?>
        <img src="<?php echo esc_url( $default_banner ); ?>" alt="<?php echo esc_attr( $queried_object->name ); ?>" style="max-width: 100%; height: auto; display: block; margin: 0 auto;">
        <?php
    }

} else {
    ?>
    <img src="<?php echo esc_url( $default_banner ); ?>" alt="<?php echo esc_attr( $queried_object->name ); ?>" style="max-width: 100%; height: auto; display: block; margin: 0 auto;">
    <?php
}

echo '</div>';
?>
<?php
$current_term_id = $queried_object->term_id;
$current_taxonomy = $queried_object->taxonomy;

$sub_categories = get_terms( array(
    'taxonomy'   => $current_taxonomy,
    'child_of'   => $current_term_id,
    'parent'     => $current_term_id,
    'hide_empty' => false,
) );

if ( empty( $sub_categories ) || is_wp_error( $sub_categories ) ) {
    $categories_to_show = get_terms( array(
        'taxonomy'   => $current_taxonomy,
        'parent'     => 0, 
        'hide_empty' => false,
    ) );
} else {
    $categories_to_show = $sub_categories;
}

if ( ! empty( $categories_to_show ) && ! is_wp_error( $categories_to_show ) ) : 
?>

<div class="container">
	<div class="ban-tim">Bạn cần tìm</div>
	<div class="category-slider">
	    <div class="owl-carousel owl-theme">
	        <?php 
	        foreach ( $categories_to_show as $cat_item ) : 
	            $cat_link = get_term_link( $cat_item );
	            $cat_name = $cat_item->name;
	            $thumbnail_id = get_term_meta( $cat_item->term_id, 'thumbnail_id', true );
	            if ( $thumbnail_id ) {
	                $cat_img_url = wp_get_attachment_url( $thumbnail_id );
	            } else {
	                $cat_img_url = wc_placeholder_img_src();
	            }
	        ?>
	        <div class="item">
	            <a class="item-category" href="<?php echo esc_url( $cat_link ); ?>">
	                <img src="<?php echo esc_url( $cat_img_url ); ?>" alt="<?php echo esc_attr( $cat_name ); ?>">
	                <div class="ctegory-text"><?php echo esc_html( $cat_name ); ?></div>
	            </a>
	        </div>
	        <?php endforeach; ?>
	    </div>
	</div>
	<?php endif; ?>

	<div class="filter-archive-wrap">
		<div class="filter-left-breadcrumb">
            <?php 
            // Gọi đường dẫn Breadcrumb mặc định của WooCommerce (Trang chủ / Danh mục gốc / Danh mục hiện tại)
            woocommerce_breadcrumb( array(
                'delimiter'   => ' &nbsp;/&nbsp; ',
                'wrap_before' => '<nav class="woocommerce-breadcrumb">',
                'wrap_after'  => '</nav>',
                'before'      => '',
                'after'       => '',
            ) ); 
            ?>
        </div>
        
        <div class="filter-right-ordering">
            <div class="filter-result-count">
                <?php 
                // Gọi chuỗi text hiển thị số lượng kết quả (Ví dụ: "Hiển thị 1–20 của 2294 kết quả")
                woocommerce_result_count(); 
                ?>
            </div>
            <div class="filter-catalog-orderby">
                <?php 
                // Gọi form Dropdown sắp xếp sản phẩm (Mặc định, Mới nhất, Giá tăng/giảm...)
                woocommerce_catalog_ordering(); 
                ?>
            </div>
        </div>
	</div>
	<div class="product-loop-wrap" id="product-list">
		<?php 
            // 1. Nhận diện số trang và cấu hình tham số sắp xếp (orderby) từ URL của WooCommerce
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
            
            // Xử lý logic bốc bộ lọc sắp xếp từ Dropdown truyền vào WP_Query
            $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : 'date';
            $order_value   = 'DESC';

            if ( $orderby_value === 'price' ) {
                $orderby = 'meta_value_num';
                $meta_key = '_price';
                $order_value = 'ASC';
            } elseif ( $orderby_value === 'price-desc' ) {
                $orderby = 'meta_value_num';
                $meta_key = '_price';
                $order_value = 'DESC';
            } elseif ( $orderby_value === 'popularity' ) {
                $orderby = 'meta_value_num';
                $meta_key = 'total_sales';
                $order_value = 'DESC';
            } elseif ( $orderby_value === 'rating' ) {
                $orderby = 'meta_value_num';
                $meta_key = '_wc_average_rating';
                $order_value = 'DESC';
            } else {
                $orderby = 'date';
                $meta_key = '';
            }

            // 2. Thiết lập cấu hình Query sản phẩm đúng danh mục và bộ lọc sắp xếp hiện tại
            $prd_args = array(
                'post_type'      => 'product',
                'posts_per_page' => 20, 
                'paged'          => $paged,
                'orderby'        => $orderby,
                'order'          => $order_value,
                'tax_query'      => array(
                    array(
                        'taxonomy'         => $current_taxonomy, 
                        'field'            => 'term_id',
                        'terms'            => $current_term_id,  
                        'include_children' => true,              
                    ),
                ),
            );

            if ( ! empty( $meta_key ) ) {
                $prd_args['meta_key'] = $meta_key;
            }

            $prd_query = new WP_Query($prd_args);

            if ($prd_query->have_posts()) :
                while ($prd_query->have_posts()) : $prd_query->the_post();
                    global $product;
                    $product = wc_get_product( get_the_ID() ); 
                    
                    include(locate_template('product-item-ui.php')); 
                endwhile;
            else:
                echo '<p>Không có sản phẩm nào trong danh mục này.</p>';
            endif;
        ?>
    </div>

    <div class="nav">
        <?php 
        $big = 999999999; 
        
        echo paginate_links( array(
            'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format'    => '?paged=%#%',
            'current'   => max( 1, $paged ),
            'total'     => $prd_query->max_num_pages, 
            'type'      => 'list',                    
            'prev_text' => '<i class="fa fa-angle-left"></i>',
            'next_text' => '<i class="fa fa-angle-right"></i>',
        ) );

        wp_reset_postdata();
        ?>
    </div>

    <div class="cmt-slider">
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
</div>

<?php get_footer(); ?>