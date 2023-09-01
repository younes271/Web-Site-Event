<?php
/**
 * Template for Single Default
 *
 * @package glamon
 */

?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<!-- wraper_blog_main -->
		<section class="wraper_blog_main">
			<div class="container">
				<!-- row -->
				<div class="row">
                    <?php if ( 'nosidebar' === glamon_global_var( 'blog-layout', '', false ) ) { ?>
                    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php } else { ?>
                    	<?php if ( 'leftsidebar' === glamon_global_var( 'blog-layout', '', false ) ) { ?>
                    		<?php if ( 'three-grid' === glamon_global_var( 'blog-layout-sidebar-width', '', false ) ) { ?>
                    			<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 pull-right">
                    		<?php } elseif ( 'four-grid' === glamon_global_var( 'blog-layout-sidebar-width', '', false ) ) { ?>
                    			<div class="col-lg-8 col-md-7 col-sm-7 col-xs-12 pull-right">
                    		<?php } elseif ( 'five-grid' === glamon_global_var( 'blog-layout-sidebar-width', '', false ) ) { ?>
                    			<div class="col-lg-7 col-md-6 col-sm-6 col-xs-12 pull-right">
                    		<?php } ?>
                    	<?php } elseif ( 'rightsidebar' === glamon_global_var( 'blog-layout', '', false ) ) { ?>
                    		<?php if ( 'three-grid' === glamon_global_var( 'blog-layout-sidebar-width', '', false ) ) { ?>
                    			<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 pull-left">
                    		<?php } elseif ( 'four-grid' === glamon_global_var( 'blog-layout-sidebar-width', '', false ) ) { ?>
                    			<div class="col-lg-8 col-md-7 col-sm-7 col-xs-12 pull-left">
                    		<?php } elseif ( 'five-grid' === glamon_global_var( 'blog-layout-sidebar-width', '', false ) ) { ?>
                    			<div class="col-lg-7 col-md-6 col-sm-6 col-xs-12 pull-left">
                    		<?php } ?>
                    	<?php } else { ?>
                    		<?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
                    			<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
                    		<?php } else { ?>
                    			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    		<?php } ?>
                    	<?php } ?>
                    <?php } ?>
                    	<!-- blog_single -->
                    	<div class="blog_single">
                    		<?php
                    		while ( have_posts() ) :
                    			the_post();
                    			get_template_part( 'template-parts/content-single', get_post_format() );
                    			endwhile; // End of the loop.
                    		?>
                    		<?php if ( true == glamon_global_var( 'display_tags', '', false ) ) : ?>
                    			<?php
                    			$tags = get_the_tags( $post->ID );
                    			if ( ! empty( $tags ) ) {
                    				?>
                    			<!-- post-tags -->
                    			<div class="post-tags">
                    				<?php
                    				/* translators: used between list items, there is a space after the comma */
                    				$tags_list = get_the_tag_list( '', ' ' );
                    				if ( $tags_list ) {
                    					printf(
                    						wp_kses_post( '<strong class="tags-title">Tags:</strong> ' ) .
                    						/* translators: used between list items, there is a space after the comma */
                    						esc_html( '%1$s' ) .
                    						wp_kses_post( '' ),
                    						wp_kses_post( $tags_list )
                    					);
                    				}
                    				?>
                    			</div>
                    			<!-- post-tags -->
                    			<?php } ?>
                    		<?php endif; ?>
                    		<?php if ( true == glamon_global_var( 'display_navigation', '', false ) ) : ?>
                    		<!-- post-navigation -->
                    		<div class="navigation post-navigation">
                    			<div class="nav-links">
                    				<?php
                    				$prev_post = get_previous_post();
                    				if ( is_a( $prev_post, 'WP_Post' ) ) {
                    					?>
                    					<div class="nav-previous">
                    						<a rel="prev" href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" title="<?php echo esc_attr( get_the_title( $prev_post->ID ) ); ?>"><strong><?php echo get_the_title( $prev_post->ID ); ?></strong> <?php echo esc_html__( 'Older Post', 'glamon' ); ?></a>
                    					</div>
                    				<?php } ?>
                    				<?php
                    				$next_post = get_next_post();
                    				if ( is_a( $next_post, 'WP_Post' ) ) {
                    					?>
                    					<div class="nav-next">
                    						<a rel="next" href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" title="<?php echo esc_attr( get_the_title( $next_post->ID ) ); ?>"><strong><?php echo get_the_title( $next_post->ID ); ?></strong> <?php echo esc_html__( 'Newer Post', 'glamon' ); ?></a>
                    					</div>
                    				<?php } ?>
                    			</div>
                    		</div>
                    		<!-- post-navigation -->
                    		<?php endif; ?>
                    		<?php if ( true == glamon_global_var( 'display_author_information', '', false ) ) : ?>
                    			<?php if ( get_the_author_meta( 'description' ) ) : ?>
                    				<!-- author-bio -->
                    				<div class="author-bio">
                    					<div class="holder">
                    						<div class="pic">
                    							<?php echo get_avatar( get_the_author_meta( 'email' ), '150' ); ?>
                    						</div><!-- .pic -->
                    						<div class="data">
                    							<p class="designation">
                    								<?php echo esc_html__( 'Author', 'glamon' ); ?>
                    							</p>
                    							<p class="title"><?php the_author_link(); ?></p>
                    							<?php the_author_meta( 'description' ); ?>
                    						</div><!-- .data -->
                    					</div>
                    				</div>
                    				<!-- author-bio -->
                    			<?php endif; ?>
                    		<?php endif; ?>
                    		<!-- comments-area -->
                    		<?php if ( glamon_global_var( 'blog-layout', '', false ) ) : ?>
                    			<?php if ( glamon_global_var( 'blog_comment_display', '', false ) ) : ?>
                    				<?php if ( comments_open() || get_comments_number() ) : ?>
                    					<?php comments_template(); ?>
                    			<?php endif; ?>
                    		<?php endif; ?>
                    		<?php else : ?>
                    		<?php if ( comments_open() || get_comments_number() ) : ?>
                    				<?php comments_template(); ?>
                    			<?php endif; ?>
                    		<?php endif; ?>
                    		<!-- comments-area -->
                    	</div>
                    	<!-- blog_single -->
                    </div>
                    <?php if ( 'nosidebar' === glamon_global_var( 'blog-layout', '', false ) ) { ?>
                    <?php } else { ?>
                    	<?php if ( 'leftsidebar' === glamon_global_var( 'blog-layout', '', false ) ) { ?>
                    		<?php if ( 'three-grid' === glamon_global_var( 'blog-layout-sidebar-width', '', false ) ) { ?>
                    			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 pull-left">
                    		<?php } elseif ( 'four-grid' === glamon_global_var( 'blog-layout-sidebar-width', '', false ) ) { ?>
                    			<div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 pull-left">
                    		<?php } elseif ( 'five-grid' === glamon_global_var( 'blog-layout-sidebar-width', '', false ) ) { ?>
                    			<div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 pull-left">
                    		<?php } ?>
                    	<?php } elseif ( 'rightsidebar' === glamon_global_var( 'blog-layout', '', false ) ) { ?>
                    		<?php if ( 'three-grid' === glamon_global_var( 'blog-layout-sidebar-width', '', false ) ) { ?>
                    			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 pull-right">
                    		<?php } elseif ( 'four-grid' === glamon_global_var( 'blog-layout-sidebar-width', '', false ) ) { ?>
                    			<div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 pull-right">
                    		<?php } elseif ( 'five-grid' === glamon_global_var( 'blog-layout-sidebar-width', '', false ) ) { ?>
                    			<div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 pull-right">
                    		<?php } ?>
                    	<?php } else { ?>
                    		<?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
                    			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    		<?php } else { ?>
                    			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    		<?php } ?>
                    	<?php } ?>
                    		<?php get_sidebar(); ?>
                    	</div>
                    <?php } ?>
                </div>
				<!-- row -->
			</div>
		</section>
		<!-- wraper_blog_main -->
	</main><!-- #main -->
</div><!-- #primary -->