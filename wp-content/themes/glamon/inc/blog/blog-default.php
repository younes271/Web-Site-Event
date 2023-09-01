<?php
/**
 * Template for Blog Default
 *
 * @package glamon
 */

?>
<!-- wraper_blog_main -->
<div class="wraper_blog_main style-default">
	<div class="container">
		<!-- row -->
		<div class="row">
		    <?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
                <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
            <?php } else { ?>
			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		    <?php } ?>
				<!-- blog_main -->
				<div class="blog_main">
					<?php
					if ( have_posts() ) :
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/*
							* Include the Post-Format-specific template for the content.
							* If you want to override this in a child theme, then include a file
							* called content-___.php (where ___ is the Post Format name) and that will be used instead.
							*/
							get_template_part( 'template-parts/content-default', get_post_format() );
						endwhile;
					else :
						get_template_part( 'template-parts/content', 'none' );
					endif;
					?>
					<?php glamon_pagination(); ?>
				</div>
				<!-- blog_main -->
			</div>
            <?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 right-sidebar">
    				<?php get_sidebar(); ?>
    			</div>
            <?php } ?>
		</div>
		<!-- row -->
	</div>
</div>
<!-- wraper_blog_main -->
