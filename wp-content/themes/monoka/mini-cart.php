<?php
if ( ! WC()->cart ) return;

$cart_items = WC()->cart->get_cart();

// Khởi tạo biến tính tổng
$total_savings = 0;
$suppliers = [];

foreach ( $cart_items as $cart_item_key => $item ) {
    $product = $item['data'];
    $id      = $product->get_id();
    $qty     = $item['quantity'];

    // --- TÍNH TOÁN TIẾT KIỆM ---
    $regular_price = (float)$product->get_regular_price();
    $active_price  = (float)$product->get_price();
    
    // Nếu có giá giảm, tính tiền tiết kiệm = (giá gốc - giá bán) * số lượng
    if ( $regular_price > $active_price ) {
        $total_savings += ($regular_price - $active_price) * $qty;
    }
    // ---------------------------

    // Lấy supplier
    $terms = wp_get_post_terms($id, 'supplier');
    $supplier_name = $terms ? $terms[0]->name : 'Nhà cung cấp khác';
    $supplier_link = $terms ? get_term_link($terms[0]->term_id, 'supplier') : '#';

    // Gom lại
    $suppliers[$supplier_name]['link'] = $supplier_link;
    $suppliers[$supplier_name]['items'][] = [
        'key'   => $cart_item_key,
        'id'    => $id,
        'name'  => $product->get_name(),
        'qty'   => $qty,
        'price' => $active_price,
        'img'   => wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' )
    ];
}

// Tổng cộng cuối cùng khách phải trả
$total_payable = WC()->cart->get_total(); 
?>

<div class="haed-mini-cart-wrap">
    <div class="haed-mini-cart">
        <div style="    display: flex;">
            <img class="down-arrow-2" src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/down-arrow-2.png"> 
            <i class="fa fa-cart-plus"></i>
        </div>
        <div class="haed-provisional">
            <b><?php echo $total_payable; ?></b>
            
            <?php if ( $total_savings > 0 ) : ?>
                <div class="decrease">
                    Tiết kiệm 
                    <div class="decrease-kc"><?php echo wc_price($total_savings); ?></div>
                </div>
            <?php endif; ?>
        </div>
        <a href="/cart">Giỏ Hàng</a>
    </div>

    <div class="wrap-product-mini-cart">
        <div class="box-product-mini-cart">
            <?php foreach ($suppliers as $sup_name => $sup) : ?>
                <div class="product-mini-cart-car">
                    <p class="mini-cart-car-name">
                        <a href="<?php echo esc_url($sup['link']); ?>">
                            <?php echo esc_html($sup_name); ?>
                        </a>
                    </p>
                    <?php foreach ($sup['items'] as $prd) : 
                        $product = wc_get_product($prd['id']);
                        $price = $product->get_price();
                        $regular = $product->get_regular_price();
                        $sale = $product->get_sale_price();
                    ?>
                        <div class="mini-cart-prd-item" data-product-id="<?php echo $prd['id']; ?>" data-key="<?php echo $prd['key']; ?>">
                            <button class="close remove-item">
                                <img src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/close.png">
                            </button>
                            <img class="mini-cart-prd-img" src="<?php echo $prd['img']; ?>">
                            <div class="mini-cart-prd-name"><?php echo $prd['name']; ?></div>
                            <div class="mini-cart-prd-quantity">
                                <div class="mini-cart-prd-price">
                                    <?php if ($sale) : ?>
                                        <div class="mini-cart-prd-ins"><?php echo wc_price($regular); ?></div>
                                        <div class="mini-cart-prd-del sale-cart"><?php echo wc_price($sale); ?></div>
                                    <?php else : ?>
                                        <div class="mini-cart-prd-ins"><?php echo wc_price($price); ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="mini-cart-quantity">
                                    <div class="mini-cart-minus">-</div>
                                    <input type="number" value="<?php echo $prd['qty']; ?>" min="1">
                                    <div class="mini-cart-add">
                                        <img src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/add.png">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="mini-cart-pay-wrap">
            <a class="shipping-policy-cart" href="#">Chính sách vận chuyển</a>
            <a class="pay-cart-btn" href="/cart">Đến Quầy Thanh Toán</a>
        </div>
    </div>
</div>