<?php get_header(); ?>
<div class="container">
	<div class="cuttom-h2-wrap">
	    <h1 class=" cuttom-h2 font-text"><?php single_cat_title(); ?></h1> 
	    <div class="line-heading"></div>
	</div>
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
   		<div class="col-7 box-item-post">		
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
			<div class="item-content">
				<a href="<?php the_permalink();?>" class="content-thumbnair">
					<?php the_post_thumbnail('full', array('class' => 'transition-img')); ?>
				</a>
				<div class="item-content-buttom">
					<a href="<?php the_permalink();?>" class="content-title"><?php the_title(); ?></a>
	                <div class="blogs-info">
	                        <div class="time-blogs">
	                            <i class="fa fa-calendar"></i><?php the_date('d/m/Y'); ?>
	                        </div>
	                        <div class="views-blogs">
	                            <i class="fa fa-eye"></i><?php echo getPostViews(get_the_ID()); ?>
	                        </div>
	                    </div>
	                <div class="excerpt-blogs">
	                    <?php the_excerpt(); ?>
	                </div>
                </div>
			</div>
			<?php endwhile;?>
			<?php endif; ?>
		</div>
		<div class="col-3">
			<?php get_sidebar(); ?>
		</div>
   	</div>
	<?php if(paginate_links()!='') {?>
		<div class="quatrang">
			<?php
			global $wp_query;
			$big = 999999999;
			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'prev_text'    => __('«'),
				'next_text'    => __('»'),
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages
				) );
		    ?>
		</div>
	<?php } ?>
</div>
<?php get_footer(); ?>