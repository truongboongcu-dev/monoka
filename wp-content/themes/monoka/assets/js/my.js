$(document).ready(function() {
    $('.cmt-slider .owl-carousel').owlCarousel({
        loop:true,
        nav:false,
        dots:false,
        autoplay:true,
        margin:18,
        autoplayHoverPause:true,
        responsive:{
        0:{
            items:2
        },
        300:{
            items:2
        },       
        700:{
            items:3
        },
        1000:{
            items:4
        },
        1200:{
            items:4
        },
        1450:{
            items:5
        },
    },
    })
});

jQuery(document).ready(function($) {


// 1. Mở log khi click vào nút .log
$('.log').on('click', function(e) {
    e.preventDefault();

    $('.log-box').css('display', 'flex');

    // Thu hồi (remove) toàn bộ log-active
    $('.log-active').removeClass('log-active');

    // Thêm lại cho dang-nhap
    $('.dang-nhap').addClass('log-active');
});



$('.register').on('click', function(e) {
    e.preventDefault();

    $('.log-box').css('display', 'flex');

    // Thu hồi (remove) toàn bộ log-active
    $('.log-active').removeClass('log-active');

    // Thêm lại cho dang-nhap
    $('.dang-ky').addClass('log-active');
});


    // 2. Đóng log khi click vào vùng ngoài (log-box)
    $('.log-box').on('click', function(e) {
        // e.target: là phần tử chính xác mà con trỏ chuột bấm vào
        // this: là phần tử .log-box mà chúng ta đang gắn sự kiện
        
        // Nếu người dùng click TRỰC TIẾP vào .log-box (vùng đen/mờ bên ngoài)
        if ($(e.target).is('.log-box')) {
            $(this).css('display', 'none'); 
            // Hoặc dùng: $(this).hide();
        }
    });

});