<?php get_header(); ?>
<div class="container">
	<i itemscope itemtype="https://schema.org/BreadcrumbList" class="breadcrumbs">
		<div itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" >
			<a itemprop="item" href="<?php bloginfo("url") ?>"><div itemprop="name" >Home</div></a>
			<meta itemprop="position" content="1" />
		</div> / 
		<div itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" >
			<?php
			$categories = get_the_category();
			if ( ! empty( $categories ) ) {
			    foreach( $categories as $category ) {
			        echo '<a  itemscope itemtype="https://schema.org/WebPage"
           itemprop="item"'.'itemid="'.esc_url( get_category_link( $category->term_id ) ) . '"'.'href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . '<div itemprop="name" class="color-theme">'.esc_html( $category->name ) . '</div></a> ';
			    }
			}
			?>
			<meta itemprop="position" content="2" /> 
		</div>
	</i>
	<div class="wrap-content">
		<div class="col-7">
		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<?php the_post_thumbnail();?> 
			<h1><?php the_title(); ?></h1>
			<div class="main-content-blogs"><?php the_content(); ?></div>
		<?php endwhile;?>
		<?php endif; ?>
		</div>
		<div class="col-3">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>