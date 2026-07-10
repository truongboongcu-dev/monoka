<?php
/* Template Name: Theo Dõi Đơn Hàng */
get_header(); 

if ( class_exists( 'WooCommerce' ) ) :
?>

<div class="container">
<div class="custom-order-tracking">
    <div class="user-order-history">
        <?php if ( is_user_logged_in() ) : ?>
            <?php 
                $current_user = wp_get_current_user();
                $view_order_id = isset( $_GET['view_order_id'] ) ? intval( $_GET['view_order_id'] ) : 0;
                $allowed_cancel_statuses = array('pending', 'on-hold', 'processing'); 
            ?>
            
            <div class="order-card">
                <div id="user-TT" class="user-TT">
                    <div class="user-TT-item">
                        <div class="user-TT-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="#f17f0f" d="M320 312C386.3 312 440 258.3 440 192C440 125.7 386.3 72 320 72C253.7 72 200 125.7 200 192C200 258.3 253.7 312 320 312zM290.3 368C191.8 368 112 447.8 112 546.3C112 562.7 125.3 576 141.7 576L498.3 576C514.7 576 528 562.7 528 546.3C528 447.8 448.2 368 349.7 368L290.3 368z"></path></svg>
                        </div>
                        <div class="user-TT-text"><?php echo esc_html( $current_user->user_login ); ?></div>
                        <div class="user-TT-edit redirect-edit" style="cursor:pointer;" title="Sửa trong cài đặt tài khoản">
                            <img class="user-TT-edit-img" src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/edit.png">
                        </div>
                    </div>
                    
                    <div class="user-TT-item">
                        <div class="user-TT-icon">
                            <img class="user-TT-img" src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/t-phone-call.png">
                        </div>
                        <div class="user-TT-text"><?php echo esc_html( get_user_meta( $current_user->ID, 'user_tel', true ) ?: 'Chưa cập nhật' ); ?></div>
                        <div class="user-TT-edit inline-edit" data-field="user_tel" style="cursor:pointer;">
                            <img class="user-TT-edit-img" src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/edit.png">
                        </div>
                    </div>
                    
                    <div class="user-TT-item">
                        <div class="user-TT-icon">
                            <img class="user-TT-img" src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/ico-file-format-variant.png">
                        </div>
                        <div class="user-TT-text"><?php echo esc_html( get_user_meta( $current_user->ID, 'user_ico', true ) ?: 'Chưa cập nhật' ); ?></div>
                        <div class="user-TT-edit inline-edit" data-field="user_ico" style="cursor:pointer;">
                            <img class="user-TT-edit-img" src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/edit.png">
                        </div>
                    </div>
                    
                    <div class="user-TT-item">
                        <div class="user-TT-icon">
                            <img class="user-TT-img" src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/d.png">
                        </div>
                        <div class="user-TT-text"><?php echo esc_html( get_user_meta( $current_user->ID, 'user_dic', true ) ?: 'Chưa cập nhật' ); ?></div>
                        <div class="user-TT-edit inline-edit" data-field="user_dic" style="cursor:pointer;">
                            <img class="user-TT-edit-img" src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/edit.png">
                        </div>
                    </div>
                    
                    <div class="user-TT-item">
                        <div class="user-TT-icon">
                            <img class="user-TT-img" src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/dmail.png">
                        </div>
                        <div class="user-TT-text"><?php echo esc_html( $current_user->user_email ); ?></div>
                        <div class="user-TT-edit redirect-edit" style="cursor:pointer;" title="Sửa trong cài đặt tài khoản">
                            <img class="user-TT-edit-img" src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/edit.png">
                        </div>
                    </div>
                    
                    <div class="user-TT-item">
                        <div class="user-TT-icon">
                            <img class="user-TT-img" src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/location.png">
                        </div>
                        <div class="user-TT-text"><?php echo esc_html( get_user_meta( $current_user->ID, 'user_address', true ) ?: 'Chưa cập nhật' ); ?></div>
                        <div class="user-TT-edit inline-edit" data-field="user_address" style="cursor:pointer;">
                            <img class="user-TT-edit-img" src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/edit.png">
                        </div>
                    </div>
                    
                    <div class="user-TT-item">
                        <div class="user-TT-icon">
                            <img class="user-TT-img" src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/t-lock.png">
                        </div>
                        <div class="user-TT-text">* * * * * *</div>
                        <div class="user-TT-edit redirect-edit" style="cursor:pointer;" title="Đổi mật khẩu">
                            <img class="user-TT-edit-img" src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/edit.png">
                        </div>
                    </div>
                </div>
                <div class="line-heading"></div>
                <script>
                jQuery(document).ready(function($) {
                    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
                    var security_nonce = "<?php echo wp_create_nonce('litesite-inline-update'); ?>";

                    // 1. Xử lý sửa nhanh bằng AJAX
                    $('.inline-edit').on('click', function() {
                        var $editBtn = $(this);
                        var field = $editBtn.data('field');
                        var $textDiv = $editBtn.siblings('.user-TT-text');
                        
                        // Lấy giá trị hiện tại
                        var currentValue = $textDiv.text().trim();
                        if (currentValue === 'Chưa cập nhật') currentValue = '';

                        // Nếu đang mở ô input rồi thì không làm gì
                        if ($textDiv.find('input').length > 0) return;

                        // Giao diện ô nhập và nút Lưu
                        var inputHtml = '<input type="text" value="' + currentValue + '" class="inline-input" style="width: calc(100% - 60px); padding: 4px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">';
                        var saveBtnHtml = '<button class="inline-save" style="background: #f17f0f; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-left: 5px; font-size: 13px;">Lưu</button>';
                        
                        $textDiv.html(inputHtml + saveBtnHtml);
                        $editBtn.hide(); // Ẩn icon cái bút đi

                        // Khi bấm Lưu
                        $textDiv.find('.inline-save').on('click', function() {
                            var newValue = $textDiv.find('.inline-input').val().trim();
                            var $btn = $(this);
                            $btn.text('...'); // Hiệu ứng đang tải

                            $.ajax({
                                url: ajaxurl,
                                type: 'POST',
                                data: {
                                    action: 'update_user_inline_meta',
                                    field: field,
                                    value: newValue,
                                    security: security_nonce
                                },
                                success: function(response) {
                                    if (response.success) {
                                        // Trả lại text mới
                                        $textDiv.html(newValue !== '' ? newValue : 'Chưa cập nhật');
                                        $editBtn.show();
                                    } else {
                                        alert(response.data.message || 'Có lỗi xảy ra.');
                                        $textDiv.html(currentValue !== '' ? currentValue : 'Chưa cập nhật');
                                        $editBtn.show();
                                    }
                                },
                                error: function() {
                                    alert('Lỗi kết nối. Vui lòng thử lại.');
                                    $textDiv.html(currentValue !== '' ? currentValue : 'Chưa cập nhật');
                                    $editBtn.show();
                                }
                            });
                        });
                    });

                    // 2. Chuyển hướng cho các trường cốt lõi (Tên đăng nhập, Email, Mật khẩu)
                    $('.redirect-edit').on('click', function() {
                        window.location.href = "<?php echo esc_url( wc_customer_edit_account_url() ); ?>";
                    });
                });
                </script>
                <?php 
                // ==================================================
                // TRƯỜNG HỢP 1: XEM CHI TIẾT ĐƠN HÀNG (DETAIL VIEW)
                // ==================================================
                if ( $view_order_id > 0 ) : 
                    
                    $order = wc_get_order( $view_order_id );

                    if ( $order && $order->get_user_id() === get_current_user_id() ) :
                        $order_status = $order->get_status();
                        $status_class = 'st-' . $order_status;
                        
                        // LẤY NGÀY GIAO HÀNG
                        $delivery_date = $order->get_meta('_delivery_date');
                        
                        // [FIX] Xử lý format ngày tháng năm (d/m/Y)
                        if ( ! empty($delivery_date) ) {
                            // Chuyển đổi chuỗi ngày thành timestamp rồi format lại
                            $delivery_display = date_i18n( 'd-m-Y', strtotime( $delivery_date ) );
                        } else {
                            $delivery_display = '';
                        }
                ?>
                        <a href="<?php echo remove_query_arg('view_order_id'); ?>" class="btn-custom btn-back">
                            &larr; Quay lại danh sách
                        </a>

                        <div class="order-header-info">
                            <div class="oh-left">
                                <h2>Đơn hàng #<?php echo $order->get_order_number(); ?></h2>
                                <div class="oh-meta">
                                    Ngày đặt: <?php echo wc_format_datetime( $order->get_date_created() ); ?> &bull; 
                                    Thanh toán: <?php echo $order->get_payment_method_title(); ?>
                                    
                                    <?php if ( ! empty($delivery_display) ) : ?>
                                        <br>
                                        <span class="delivery-date-highlight">
                                            <i class="fa fa-calendar-check-o"></i> Giao dự kiến: <?php echo esc_html($delivery_display); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="oh-right">
                                <span class="status-badge <?php echo $status_class; ?>">
                                    <?php echo wc_get_order_status_name( $order_status ); ?>
                                </span>
                                
                                <?php 
                                if ( in_array($order_status, $allowed_cancel_statuses) && $order->get_cancel_order_url() ) : 
                                    $cancel_url = $order->get_cancel_order_url( add_query_arg( 'view_order_id', $order->get_id(), get_permalink() ) );
                                ?>
                                    <a href="<?php echo esc_url( $cancel_url ); ?>" 
                                       class="btn-custom btn-cancel" 
                                       style="margin-top: 10px;"
                                       onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này? Hành động này không thể hoàn tác.');">
                                        Hủy đơn hàng
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="detail-table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th style="text-align: center;">SL</th>
                                        <th style="text-align: right;">Tạm tính</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ( $order->get_items() as $item_id => $item ) : 
                                        $product = $item->get_product();
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="product-info">
                                                <div class="product-thumb">
                                                    <?php 
                                                    if ( $product ) {
                                                        echo $product->get_image( 'thumbnail' );
                                                    } else {
                                                        echo '<img src="' . wc_placeholder_img_src() . '" alt="Product Image">';
                                                    }
                                                    ?>
                                                </div>
                                                <div>
                                                    <a href="<?php echo $product ? get_permalink( $product->get_id() ) : '#'; ?>" class="product-name">
                                                        <?php echo $item->get_name(); ?>
                                                    </a>
                                                    <?php 
                                                    if ( $meta_data = $item->get_formatted_meta_data( '' ) ) {
                                                        foreach ( $meta_data as $meta_id => $meta ) {
                                                            echo '<div class="product-meta">' . wp_kses_post( $meta->display_key ) . ': ' . wp_kses_post( wp_strip_all_tags( $meta->display_value ) ) . '</div>';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align: center; font-weight: bold;">x<?php echo $item->get_quantity(); ?></td>
                                        <td style="text-align: right; color: #555;">
                                            <?php echo $order->get_formatted_line_subtotal( $item ); ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="order-footer-grid">
                            <div class="address-box info-box">
                                <h3>Thông tin nhận hàng</h3>
                                <div class="address-details">
                                    <p><strong>Người nhận:</strong> <?php echo $order->get_formatted_shipping_full_name(); ?></p>
                                    <p><strong>Điện thoại:</strong> <?php echo $order->get_billing_phone(); ?></p>
                                    <p><strong>Địa chỉ:</strong> <?php echo $order->get_shipping_address_1(); ?></p>
                                    <p>
                                        <?php 
                                            $address_parts = array_filter([
                                                $order->get_shipping_city(),
                                                $order->get_shipping_state(),
                                                $order->get_shipping_country() == 'VN' ? 'Việt Nam' : $order->get_shipping_country()
                                            ]);
                                            echo implode(', ', $address_parts);
                                        ?>
                                    </p>
                                    <?php if ( $order->get_customer_note() ) : ?>
                                        <p style="margin-top: 10px; font-style: italic; color: #888;">"<?php echo $order->get_customer_note(); ?> "</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="totals-box">
                                <?php foreach ( $order->get_order_item_totals() as $key => $total ) : ?>
                                    <div class="total-row <?php echo $key === 'order_total' ? 'final' : ''; ?>">
                                        <span><?php echo $total['label']; ?></span>
                                        <span><?php echo $total['value']; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    <?php else : ?>
                        <div class="woocommerce-error">Không tìm thấy đơn hàng. <a href="<?php echo remove_query_arg('view_order_id'); ?>">Quay lại</a></div>
                    <?php endif; ?>

                <?php 
                // ==================================================
                // TRƯỜNG HỢP 2: DANH SÁCH ĐƠN HÀNG (LIST VIEW)
                // ==================================================
                else : 
                ?>
                    <div style="margin: 20px 0px;">
                        <h1 style="margin: 0; color: #f17f0f; font-size: 24px;">Lịch sử đơn hàng</h1>
                        <p style="color: #666;">Quản lý các đơn hàng bạn đã mua</p>
                    </div>

                    <?php
                    $customer_orders = wc_get_orders( array(
                        'customer_id' => get_current_user_id(),
                        'limit' => -1, 'orderby' => 'date', 'order' => 'DESC',
                    ) );
                    
                    if ( ! empty( $customer_orders ) ) :
                    ?>
                        <div style="overflow-x: auto;">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th>Trạng thái</th>
                                        <th>Tổng tiền</th>
                                        <th style="text-align: right;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ( $customer_orders as $order ) : 
                                        $status_class = 'st-' . $order->get_status();
                                        $view_url = add_query_arg( 'view_order_id', $order->get_id(), get_permalink() );
                                        $order_status = $order->get_status();
                                        
                                        // Lấy ngày giao hàng cho danh sách
                                        $delivery_date_raw = $order->get_meta('_delivery_date');
                                        $delivery_display_list = '';
                                        if ( ! empty($delivery_date_raw) ) {
                                            $delivery_display_list = date_i18n( 'd-m-Y', strtotime( $delivery_date_raw ) );
                                        }
                                    ?>
                                    <tr>
                                        <td><a href="<?php echo $view_url; ?>" class="order-id-link">#<?php echo $order->get_order_number(); ?></a></td>
                                        <td>
                                            <?php echo wc_format_datetime( $order->get_date_created() ); ?>
                                            
                                            <?php if ( ! empty($delivery_display_list) ) : ?>
                                                <span class="delivery-date-small">
                                                    <i class="fa fa-truck"></i> Dự kiến: <?php echo esc_html($delivery_display_list); ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="status-badge <?php echo $status_class; ?>"><?php echo wc_get_order_status_name( $order->get_status() ); ?></span></td>
                                        <td>
                                            <div style="font-weight: bold;"><?php echo $order->get_formatted_order_total(); ?></div>
                                            <div style="font-size: 11px; color:#999;"><?php echo $order->get_item_count(); ?> món</div>
                                        </td>
                                        <td style="text-align: right; white-space: nowrap;">
                                            <?php 
                                            if ( in_array($order_status, $allowed_cancel_statuses) && $order->get_cancel_order_url() ) : 
                                                $cancel_url = $order->get_cancel_order_url( get_permalink() );
                                            ?>
                                                <a href="<?php echo esc_url( $cancel_url ); ?>" 
                                                   class="btn-custom btn-cancel"
                                                   onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                                                    Hủy
                                                </a>
                                            <?php endif; ?>

                                            <a href="<?php echo $view_url; ?>" class="btn-custom btn-view">Xem</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p>Bạn chưa có đơn hàng nào.</p>
                    <?php endif; ?>

                <?php endif; ?> 
            </div>

        <?php else : ?>
            <div class="order-card" style="text-align: center;">
                <p>Vui lòng <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">đăng nhập</a> để xem đơn hàng.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
</div>
<?php 
else: echo 'Vui lòng cài WooCommerce'; endif;
get_footer(); 
?>