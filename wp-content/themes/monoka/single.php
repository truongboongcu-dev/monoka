<?php get_header(); ?>
<div class="container">
<i itemscope itemtype="https://schema.org/BreadcrumbList" class="breadcrumbs">
    <div itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <a itemprop="item" href="<?php bloginfo('url'); ?>">
            <div itemprop="name">Home</div>
        </a>
        <meta itemprop="position" content="1" />
    </div> / 
    <div itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <?php
        $categories = get_the_category();
        if (!empty($categories)) {
            // Chỉ lấy danh mục đầu tiên
            $category = $categories[0];
            echo '<a itemscope itemtype="https://schema.org/WebPage"
                   itemprop="item" itemid="' . esc_url(get_category_link($category->term_id)) . '"
                   href="' . esc_url(get_category_link($category->term_id)) . '">
                   <div itemprop="name">' . esc_html($category->name) . '</div></a>';
        }
        ?>
        <meta itemprop="position" content="2" />
    </div> / 
    <b itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <a style="color: #ff7f79;" itemprop="item" href="<?php the_permalink(); ?>">
            <div itemprop="name"><?php the_title(); ?></div>
        </a>
        <meta itemprop="position" content="3" />
    </b>
</i>
	<div class="wrap-content" itemtype="https://schema.org/NewsArticle">
        <meta itemprop="image" content="<?php the_post_thumbnail_url();?>" />
        <meta itemprop="datePublished" content="<?php echo get_the_date('c'); ?>" />
        <meta itemprop="dateModified" content="<?php echo get_the_modified_date('c'); ?>" />
		<div class="col-7">
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<?php the_post_thumbnail();?> 
			<h1 itemprop="headline"><?php the_title(); ?></h1>
			<div class="main-content-blogs"><?php the_content(); ?></div>
            <span itemprop="author" itemscope itemtype="https://schema.org/Person">
              <div>Tác Giả: <a itemprop="url" href="https://cuoihoingoclinh.com/">
                <span itemprop="name">Cưới Hỏi Ngọc Linh</span>
              </a></div>
		<?php endwhile;?>
		<?php endif; ?>
		</div>
		<div class="col-3">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>