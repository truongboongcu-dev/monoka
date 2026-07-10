
/* ==========================================================================
       7. XỬ LÝ NÚT XEM THÊM / RÚT GỌN THÔNG TIN SẢN PHẨM
       ========================================================================== */
    var $wrapper = $('.main-content-wrapper');
    var $content = $wrapper.find('.main-content');
    var $btn = $('#toggle-content-btn');
    var maxHeight = 400; // Phải trùng với max-height trong CSS nhé

    // Kiểm tra nếu nội dung thực tế của sản phẩm ngắn hơn chiều cao giới hạn thì ẩn luôn nút và lớp mờ
    if ($content[0] && $content[0].scrollHeight <= maxHeight) {
        $wrapper.find('.content-overlay').hide();
        $wrapper.find('.readmore-btn-wp').hide();
    } else {
        $btn.on('click', function(e) {
            e.preventDefault();
            
            if ($wrapper.hasClass('is-expanded')) {
                // HÀNH ĐỘNG: THU GỌN LẠI
                $content.css('max-height', maxHeight + 'px');
                $wrapper.removeClass('is-expanded');
                $btn.html('Xem thêm <span class="arrow">▼</span>');
                
                // Tự động cuộn mượt màn hình lên đầu khung thông tin để người dùng không bị hụt hẫng
                $('html, body').animate({
                    scrollTop: $('.information-prd').offset().top - 80
                }, 400);
            } else {
                // HÀNH ĐỘNG: MỞ RỘNG RA
                // Lấy chiều cao thực tế của toàn bộ nội dung để hiệu ứng trượt chuẩn xác
                var totalHeight = $content[0].scrollHeight; 
                $content.css('max-height', totalHeight + 'px');
                $wrapper.addClass('is-expanded');
                $btn.html('Rút gọn <span class="arrow">▲</span>');
            }
        });
    }
// Xử lý click chọn mẫu có ảnh và đồng bộ với WooCommerce
$(document).on('click', '.custom-swatches-wrapper .swatch-item', function() {
    // Đổi class active
    $('.custom-swatches-wrapper .swatch-item').removeClass('active');
    $(this).addClass('active');
    
    // Lấy giá trị slug và gán vào ô select ẩn của WooCommerce
    var slug = $(this).data('slug');
    $('select#pa_mau').val(slug).trigger('change');
});

// Tự động kích hoạt nút đầu tiên khi trang tải xong (nếu muốn)
$('.custom-swatches-wrapper .swatch-item').first().trigger('click');

jQuery(document).ready(function($) {
    
    // 1. Ẩn dòng thuộc tính 'pa_mau' mặc định trong bảng variations của WooCommerce đi (vì đã có Swatches)
    $('select#pa_mau').closest('tr').hide();

    // 2. Xử lý click chọn mẫu từ Khối Swatches ngoại vi
    $(document).on('click', '.custom-swatches-wrapper .swatch-item', function() {
        $('.custom-swatches-wrapper .swatch-item').removeClass('active');
        $(this).addClass('active');
        
        var slug = $(this).data('slug');
        // Đẩy giá trị vào ô select pa_mau ẩn của WC và kích hoạt sự kiện thay đổi
        $('select#pa_mau').val(slug).trigger('change');
    });

    // Tự động click kích hoạt mẫu đầu tiên khi tải trang
    $('.custom-swatches-wrapper .swatch-item').first().trigger('click');

    /* ==========================================================================
       6. NÚT MUA NGAY (Xử lý đóng gói toàn bộ thuộc tính biến thể gửi qua AJAX)
       ========================================================================== */
    $(document).on('click', '.custom-buy-now-btn', function(e) {
        e.preventDefault();
        var $form = $(this).closest('form.cart');
        
        // Kiểm tra xem khách hàng đã chọn đủ các thuộc tính chưa (Đèn led, mẫu...)
        if ($form.find('.single_add_to_cart_button').hasClass('disabled')) {
            alert('Vui lòng chọn đầy đủ các tùy chọn sản phẩm trước khi mua!');
            return;
        }
        
        var $btn = $(this);
        $btn.text('ĐANG XỬ LÝ...').css('opacity', '0.8').prop('disabled', true);

        // Đóng gói toàn bộ form dữ liệu bao gồm: quantity, variation_id và tất cả attribute_pa_...
        var formData = $form.serialize();
        
        // Bổ sung tham số ID sản phẩm nếu chuỗi serialize chưa nhận diện add-to-cart
        if (formData.indexOf('add-to-cart') === -1) {
            var productId = $form.find('input[name="add-to-cart"]').val() || '<?php echo $product->get_id(); ?>';
            formData += '&add-to-cart=' + productId;
        }

        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: formData,
            success: function() {
                // Chuyển hướng thẳng đến trang Thanh toán Checkout chuẩn WooCommerce
                window.location.href = '<?php echo esc_url( wc_get_checkout_url() ); ?>';
            },
            error: function() {
                $btn.text('MUA NGAY').css('opacity', '1').prop('disabled', false);
                alert('Có lỗi xảy ra, vui lòng tải lại trang và thử lại!');
            }
        });
    });
});