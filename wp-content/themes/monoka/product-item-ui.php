<div class="item">  
   <?php 
   // SỬA QUAN TRỌNG: Loại bỏ câu lệnh IF kiểm tra dữ dội, ép buộc tải lại đúng sản phẩm của vòng lặp hiện tại
   global $product;
   $product = wc_get_product( get_the_ID() );
   
   // Kiểm tra nếu đối tượng sản phẩm tồn tại thì mới hiển thị giao diện
   if ( $product ) : 
   ?>
   <div class="slider-product-wrap" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
      
      <div class="slider-product-thumbnar" style="position: relative;">
         
         <!-- Lấy % giảm giá dựa trên biến thể có GIÁ THẤP NHẤT -->
         <?php 
         if ( $product->is_on_sale() ) : 
            $percentage = 0;

            if ( $product->is_type( 'variable' ) ) {
                // Lấy danh sách tất cả giá của các biến thể
                $prices = $product->get_variation_prices();
                
                if ( ! empty( $prices['sale_price'] ) ) {
                    // Tìm ID của biến thể có giá sale thấp nhất
                    asort( $prices['sale_price'] ); // Sắp xếp giá sale tăng dần
                    $min_sale_variant_id = key( $prices['sale_price'] ); // Lấy key (ID) của phần tử đầu tiên
                    
                    // Lấy giá gốc và giá sale của chính biến thể thấp nhất đó
                    $regular_price = (float) $prices['regular_price'][ $min_sale_variant_id ];
                    $sale_price    = (float) $prices['sale_price'][ $min_sale_variant_id ];

                    if ( $regular_price > 0 && $sale_price < $regular_price ) {
                        $percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
                    }
                }
            } else {
                // Đối với sản phẩm đơn giản (Simple Product) không có biến thể
                $regular_price = (float) $product->get_regular_price();
                $sale_price    = (float) $product->get_sale_price();
                if ( $regular_price > 0 ) {
                    $percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
                }
            }

            // Hiển thị tag % giảm giá nếu tính toán hợp lệ (> 0)
            if ( $percentage > 0 ) {
                echo '<span class="onsale-badge">-' . $percentage . '%</span>';
            }
         endif; 
         ?>

         <!-- SỬA TẠI ĐÂY: Thay the_permalink() và has_post_thumbnail() bằng hàm thuần của đối tượng $product để lấy ảnh chuẩn xác -->
         <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="link-prd">
         <?php 
         if ( $product->get_image_id() ) {
             // Hàm lấy ảnh đại diện chuẩn theo kích thước 'medium' của đúng sản phẩm này
             echo $product->get_image('medium'); 
         } else {
             echo '<img class="effect-shine" src="' . esc_url( wc_placeholder_img_src() ) . '" alt="No image">';
         } 
         ?>
         </a>

         <!-- Nút thêm vào giỏ hàng -->
         <div class="add-to-cart-btn-wrap">
            <?php 
            echo woocommerce_template_loop_add_to_cart([
                'quantity' => 1,
                'class'    => implode( ' ', array_filter( array(
                    'button',
                    'product_type_' . $product->get_type(),
                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                    $product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                ) ) ),
            ]);
            ?>
         </div>
      </div>

      <!-- SỬA TẠI ĐÂY: Lấy tên sản phẩm và link chuẩn từ đối tượng $product thay vì dùng vòng lặp WP gốc -->
      <a class="product-name" href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
      
      <!-- Hiển thị giá -->
      <div class="price">
          <?php echo $product->get_price_html(); ?>
      </div>

   </div>
   <?php endif; ?>
</div>