<?php get_header(); ?>

<div class="wrap-checkout">
    <div class="container">
        <div class="cuttom-h2-wrap">
            <h1 class="cuttom-h2">Thanh Toán</h1>
            <div class="line-heading"></div>
        </div>
        
        <div class="woocommerce-checkout-wrapper">
            <?php echo do_shortcode('[woocommerce_checkout]'); ?>
        </div>
    </div>
</div>
<style>
	 .woocommerce ul.order_details::before{
	 	content: none;
	 }
	/* 1. Tổng thể khung trang thanh toán thành công */
.woocommerce-order {
    margin: 30px auto;
    padding: 25px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    font-family: 'Segoe UI', Roboto, sans-serif;
}

/* 2. Cải thiện phần thông báo nhận đơn hàng thành công */
.woocommerce-notice--success {
    font-size: 18px;
    font-weight: bold;
    color: #27ae60;
    padding: 15px;
    background-color: #ebf7ee;
    border-left: 5px solid #27ae60;
    border-radius: 4px;
    margin-bottom: 30px;
}

/* 3. Định dạng lại thanh thông tin chung (Mã đơn, Ngày, Email, Tổng cộng...) */
ul.woocommerce-order-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    list-style: none;
    padding: 0;
    margin: 0 0 40px 0;
    border-bottom: 1px solid #eee;
    padding-bottom: 20px;
}

ul.woocommerce-order-overview li {
    font-size: 13px;
    color: #777;
    text-transform: uppercase;
    border-right: 1px solid #eee;
    padding-right: 10px;
}

ul.woocommerce-order-overview li:last-child {
    border-right: none;
}

ul.woocommerce-order-overview li strong {
    display: block;
    font-size: 16px;
    color: #333;
    margin-top: 5px;
    text-transform: none;
}

/* Làm nổi bật số tiền tổng cộng */
ul.woocommerce-order-overview li.total strong {
    color: #e74c3c;
    font-weight: 700;
}

/* 4. Định dạng Bảng chi tiết đơn hàng */
.woocommerce-table--order-details {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    margin-bottom: 30px;
}

.woocommerce-table--order-details th, 
.woocommerce-table--order-details td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #f0f0f0;
}

.woocommerce-table--order-details th {
    background-color: #f9f9f9;
    color: #333;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 14px;
}

.woocommerce-table--order-details td a {
    color: #333;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}

.woocommerce-table--order-details td a:hover {
    color: #ca151b; /* Màu đỏ thương hiệu chủ đạo của bạn */
}

/* Định dạng các thuộc tính sản phẩm (Kích thước, mẫu...) bên dưới tên sản phẩm */
.wc-item-meta {
    font-size: 12px;
    color: #666;
    padding-left: 0;
    margin: 5px 0 0 0;
    list-style: none;
}

.wc-item-meta li {
    margin-bottom: 3px;
}

.wc-item-meta strong {
    color: #333;
}

/* 5. Định dạng phần Địa chỉ thanh toán / Nhận hàng */
.woocommerce-customer-details {
    margin-top: 40px;
}

.woocommerce-customer-details address {
    font-style: normal;
    color: #555;
    line-height: 1.6;
    padding: 20px;
    background-color: #fdfdfd;
    border: 1px solid #eef0f2;
    border-radius: 6px;
    margin-top: 15px;
}

/* Responsive cho thiết bị di động */
@media (max-width: 768px) {
    ul.woocommerce-order-overview {
        grid-template-columns: 1fr 1fr;
    }
    ul.woocommerce-order-overview li {
        border-right: none;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }
}
</style>
<?php get_footer(); ?>