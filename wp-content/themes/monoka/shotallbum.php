<?php
// Kiểm tra xem biến $slug có được truyền vào không
if (!isset($slug) || empty($slug)) {
    echo 'Không có slug được truyền vào shortcode.';
    return;
}

// Tạo truy vấn để tìm bài viết dựa trên $slug và post_type là album
$args = array(
    'name'        => $slug,
    'post_type'   => 'album',
    'post_status' => 'publish',
    'numberposts' => 1
);

$album_post = get_posts($args);

// Kiểm tra xem bài viết có tồn tại không
if (!empty($album_post)) {
    // Thiết lập bài viết hiện tại để lấy trường ACF
    setup_postdata($album_post[0]);

    // Lấy hình ảnh từ trường ACF có tên 'album'
    $images = get_field('album', $album_post[0]->ID);
    
    if ($images): ?>
        <div class="main-album" id="main-album-<?php echo esc_attr($slug); ?>">
            <?php foreach ($images as $image): ?>
                <div class="item-main-album">
                    <img class="transition-img" src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                </div>
            <?php endforeach; ?>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
        <script>
            Fancybox.bind('[data-fancybox]', {
                Thumbs: {
                    autoStart: true,
                    axis: "y",
                }
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var album = document.getElementById('main-album-<?php echo esc_js($slug); ?>');
                var images = album.getElementsByTagName('img');

                Array.prototype.forEach.call(images, function(img) {
                    var src = img.getAttribute('src');
                    var link = document.createElement('a');
                    link.setAttribute('data-fancybox', 'gallery-<?php echo esc_js($slug); ?>');
                    link.setAttribute('href', src);

                    img.parentNode.insertBefore(link, img);
                    link.appendChild(img);
                });
            });
        </script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    <?php endif;

    // Đặt lại bài viết gốc sau khi sử dụng `setup_postdata`
    wp_reset_postdata();
} else {
    echo 'Không tìm thấy bài viết.';
}
?>
