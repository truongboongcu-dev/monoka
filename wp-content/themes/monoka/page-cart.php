<?php get_header(); ?>
<div class="container">
    <div class="cuttom-h2-wrap">
        <h1 class="cuttom-h2">Giỏ hàng của bạn</h1>
        <div class="line-heading"></div>
    </div>

    <?php do_action( 'woocommerce_before_cart' ); ?>

    <div class="wrap-cart">
        <div class="product-info-cart">
            <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                <?php do_action( 'woocommerce_before_cart_table' ); ?>

                <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tạm tính</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                            $product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

                            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) {
                                ?>
                                <tr class="woocommerce-cart-form__cart-item">
                                    <td class="product-remove">
                                        <?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove">&times;</a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) )), $cart_item_key ); ?>
                                        <?php echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ); ?>
                                        <span class="product-name"><?php echo wp_kses_post( $product_name ); ?></span>
                                    </td>
                                    <td class="product-price"><?php echo WC()->cart->get_product_price( $_product ); ?></td>
                                    <td class="product-quantity">
                                        <?php echo woocommerce_quantity_input( array( 'input_name' => "cart[{$cart_item_key}][qty]", 'input_value' => $cart_item['quantity'] ), $_product, false ); ?>
                                    </td>
                                    <td class="product-subtotal"><?php echo WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ); ?></td>
                                </tr>
                            <?php }
                        } ?>
                    </tbody>
                </table>

                <div class="actions-wrapper">
                    <div class="coupon">
                        <input type="text" name="coupon_code" id="coupon_code" placeholder="Mã giảm giá" />
                        <button type="submit" class="button" name="apply_coupon">Áp dụng</button>
                        <button class="update_cart" type="submit" class="button" name="update_cart">Cập nhật giỏ hàng</button>
                    </div>
                    
                    <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                </div>
            </form>
        </div>

        <div class="cart-collaterals">
            <?php do_action( 'woocommerce_cart_collaterals' ); ?>
            <a class="home" href="<?php bloginfo('url'); ?>">Xem thêm sản phẩm</a>
        </div>
    </div>
</div>
<?php get_footer(); ?>