
<footer>
	<div class="container">
		<div class="wrapr-footer">
			<div class="footer-item">
				<p style="	font-size: 16px;">CÔNG TY TNHH TƯ VẤN VÀ THIẾT KẾ NAM ANH <br>
				- MÃ SỐ THUẾ: 0109927071
				</p>
				<p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Pro v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2026 Fonticons, Inc.--><path fill="#fff" d="M0 188.6C0 84.4 86 0 192 0S384 84.4 384 188.6c0 119.3-120.2 262.3-170.4 316.8-11.8 12.8-31.5 12.8-43.3 0-50.2-54.5-170.4-197.5-170.4-316.8zM192 256a64 64 0 1 0 0-128 64 64 0 1 0 0 128z"/></svg>  Showroom: Số 54/274 Nguyễn Lân, Trường Chinh, Hà Nội</p>
				<p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Pro v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2026 Fonticons, Inc.--><path fill="#fff"  d="M16 64C16 28.7 44.7 0 80 0L304 0c35.3 0 64 28.7 64 64l0 384c0 35.3-28.7 64-64 64L80 512c-35.3 0-64-28.7-64-64L16 64zm64 0l0 304 224 0 0-304-224 0zM192 472c17.7 0 32-14.3 32-32s-14.3-32-32-32-32 14.3-32 32 14.3 32 32 32z"/></svg>  Điện thoại: <a href="tel:0986301131">0986.301131</a></p>
				<p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path fill="#fff"  d="M48 64c-26.5 0-48 21.5-48 48 0 15.1 7.1 29.3 19.2 38.4l208 156c17.1 12.8 40.5 12.8 57.6 0l208-156c12.1-9.1 19.2-23.3 19.2-38.4 0-26.5-21.5-48-48-48L48 64zM0 196L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-188-198.4 148.8c-34.1 25.6-81.1 25.6-115.2 0L0 196z"/></svg>  
				Email: <a href="mailto:contact@tuongxinh.com.vn"> contact@tuongxinh.com.vn</a></p>
				<p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path fill="#fff"  d="M256 0a256 256 0 1 1 0 512 256 256 0 1 1 0-512zM232 120l0 136c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2 280 120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>  Giờ mở cửa: 08:15 - 21:00h hàng ngày</p>
			</div>
			<div class="footer-item">
				<h3>HƯỚNG DẪN KHÁCH HÀNG</h3>
				<?php wp_nav_menu( 
					array( 
			      'theme_location' => 'footer-menu1', 
			      'container' => 'false', 
			      'menu_id' => 'footer-menu1', 
			      'menu_class' => 'footer-menu1'
					) 
				); ?>
			</div>
			<div class="footer-item">
				<h3>CHÍNH SÁCH & ƯU ĐÃI</h3>
				<?php wp_nav_menu( 
					array( 
			      'theme_location' => 'footer-menu2', 
			      'container' => 'false', 
			      'menu_id' => 'footer-menu2', 
			      'menu_class' => 'footer-menu2'
					) 
				); ?>
				<img src="<?php bloginfo("stylesheet_directory"); ?>/assets/img/icon/footer_trustbadge.png" alt="footer_trustbadge" class="footer_trustbadge">
			</div>
			<div class="footer-item">
				<h3>ĐĂNG KÝ TƯ VẤN</h3>
				<div class="footer-input">
					<input type="text" placeholder="    Nhập số điện thoại" id="InputDK">
					<input type="submit"value="Gửi" id="BTNDK">
				</div>
				
			</div>
		</div>
	</div>
</footer>
<div class="end-footer">© Monaka.2026</div>
</body>
<?php wp_footer();?>
</html>
