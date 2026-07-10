<?php get_header(); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

<div class="video-container">
    <video autoplay muted loop playsinline>
        <source src="<?php the_field('video_gioi_thieu'); ?>" type="video/mp4">
        Trình duyệt của bạn không hỗ trợ thẻ video.
    </video>
</div>
<div class="home-endow-wrap">
    <div class="container">
        <?php
        $chinh_sach_group = get_field('chinh_sach');
        if( $chinh_sach_group ): 
        // Gán các biến từ group để code gọn hơn
        $icon1 = $chinh_sach_group['icon_1'];
        $icon2 = $chinh_sach_group['icon_2'];
        $icon3 = $chinh_sach_group['icon_3'];

        $mota1 = $chinh_sach_group['mo_ta_1'];
        $mota2 = $chinh_sach_group['mo_ta_2'];
        $mota3 = $chinh_sach_group['mo_ta_3'];

        $text1 = $chinh_sach_group['name-cs_1'];
        $text2 = $chinh_sach_group['name-cs_2'];
        $text3 = $chinh_sach_group['name-cs_3'];
        ?>
        <div class="home-endow">
            <div class="home-endow-item">
                <div class="home-endow-item-img">
                    <?php if($icon1): ?>
                    <img src="<?php echo esc_url($icon1['url']); ?>" alt="<?php echo esc_attr($icon1['alt']); ?>">
                    <?php endif; ?>
                </div>
                <div class="endow-item-text">
                    <b><?php echo $text1; ?></b>
                    <p><?php echo $mota1; ?></p>
                </div>
            </div>
            <div class="home-endow-item">
                <div class="home-endow-item-img">
                    <?php if($icon2): ?>
                    <img src="<?php echo esc_url($icon2['url']); ?>" alt="<?php echo esc_attr($icon2['alt']); ?>">
                    <?php endif; ?>
                </div>
                <div class="endow-item-text">
                    <b><?php echo $text2; ?></b>
                    <p><?php echo $mota2; ?></p>
                </div>
            </div>
            <div class="home-endow-item">
                <div class="home-endow-item-img">
                    <?php if($icon3): ?>
                    <img src="<?php echo esc_url($icon3['url']); ?>" alt="<?php echo esc_attr($icon3['alt']); ?>">
                    <?php endif; ?>
                </div>
                <div class="endow-item-text">
                    <b><?php echo $text3; ?></b>
                    <p><?php echo $mota3; ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<div class="home-sale">
    <div class="container">
        <div class="home-sale-top">
                <img  class="home-sale-banner" src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/FlashSale_Icon.webp">
                <a href="sale">Xem Thêm <i class="fa fa-angle-right"></i></a>
        </div>
        <div class="slider-prd">
            <div class="owl-carousel owl-theme">
             <?php 
                // Lấy danh sách ID của các sản phẩm đang giảm giá
                $onsale_ids = wc_get_product_ids_on_sale();

                $sale_args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 10,
                    'post__in'       => array_merge( array( 0 ), $onsale_ids ),
                    'orderby'        => 'date',
                    'order'          => 'DESC'
                );

                $sale_query = new WP_Query($sale_args);

                if ($sale_query->have_posts()) :
                    while ($sale_query->have_posts()) : $sale_query->the_post();
                        global $product;
                        // File này sẽ hiển thị layout của từng sản phẩm
                        include(locate_template('product-item-ui.php')); 
                    endwhile;
                    wp_reset_postdata();
                else:
                    echo '<p>Không có sản phẩm giảm giá nào.</p>';
                endif;
                ?>
            </div>
        </div>
        <!--  slider product full width -->
            <?php
            $category_group = get_field('Category');

            if ($category_group) :
                $sub_field_names = ['Category_1', 'Category_2', 'Category_3', 'Category_4', 'Category_5', 'Category_6'];
                foreach ($sub_field_names as $name) :
                    $cat_slug = isset($category_group[$name]) ? $category_group[$name] : '';
                    if (!empty($cat_slug)) :
                        $term = get_term_by('slug', trim($cat_slug), 'product_cat');
                        if ($term && !is_wp_error($term)) : 
                            $term_link = get_term_link($term);
                            ?>
                            <div class="home-category" >
                                <div class="home-category-link">
                                    <h2 class="icon-after"><?php echo $term->name; ?></h2> 
                                    <a class="see-more" href="<?php echo esc_url($term_link); ?>">Xem Thêm <i class="fa fa-angle-right"></i></a>
                                </div>
                                <div class="home-category-loop"> 
                                    <?php 
                                    $args = array(
                                        'post_type'      => 'product',
                                        'posts_per_page' => 10,
                                        'tax_query'      => array(
                                            array(
                                                'taxonomy' => 'product_cat',
                                                'field'    => 'slug',
                                                'terms'    => $cat_slug,
                                            ),
                                        ),
                                    );

                                    $query = new WP_Query($args);

                                    if ($query->have_posts()) :
                                        while ($query->have_posts()) : $query->the_post();
                                            global $product;
                                            include(locate_template('product-item-ui.php')); 
                                        endwhile;
                                        wp_reset_postdata();
                                    else:
                                        echo '<p>Không có sản phẩm nào.</p>';
                                    endif;
                                    ?>
                                </div>
                            </div>
                        <?php 
                        endif;
                    endif; 
                endforeach; 
            endif; 
            ?>
        <!--  slider product full width end-->
        <!--  blogs-->
        <div class="home-category-link">
            <h2 class="icon-after">Thông Tin</h2> 
            <a class="see-more" href="#">Xem Thêm <i class="fa fa-angle-right"></i></a>
        </div>
        <div class="main-home-blogs">
            <?php 
                $args = array(
                    'post_status' => 'publish',
                    'post_type' => 'post', 
                    'showposts' => 4, 
                    );
                ?>
            <?php $getposts = new WP_query($args); ?>
            <?php global $wp_query; $wp_query->in_the_loop = true; ?>
            <div class="owl-carousel owl-theme">
                <?php while ($getposts->have_posts()) : $getposts->the_post(); ?>
                <div class="item">
                    <a class="blogs-thumbnar" href="<?php the_permalink();?>">
                        <?php echo get_the_post_thumbnail( $post_id, 'medium', array( 'class' =>' transition-img') ); ?>
                    </a>
                    <div class="content-blogs">
                        <a class="title-blogs" href="<?php the_permalink();?>"><h3><?php the_title(); ?></h3></a>
                        <div class="excerpt-blogs">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>     
            </div> 
        </div>
        <!--  blogs-->
    </div>
</div>

<?php endwhile;?>
<?php endif; ?>
<?php get_footer(); ?>