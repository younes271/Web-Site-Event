<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */

get_header();

dahz_framework_get_template_part( 'global/global-wrapper', 'open' );

	if ( have_posts() ) :

		/* Start the Loop */		
		?>
		<div <?php dahz_framework_set_attributes( 
			array(
				'class' 		=> array( 'uk-child-width-1-1' ),
				'data-uk-grid'	=> '',
				'data-uk-filter'=> 'target: div > .de-content__portfolio;',
			),
			'portfolio_container'
		);?>>
			<?php do_action('dahz_framework_before_loop_portfolio'); ?>
			<div>
				<div <?php dahz_framework_set_attributes( 
					array(
						'class' 		=> array( 'uk-child-width-1-1@s' ),
						'data-uk-grid'	=> ''
					),
					'content_portfolio'
				);?>>
					<?php					
					while ( have_posts() ) : the_post();
					
						do_action( 'dahz_framework_loop_portfolio' );
					
						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						dahz_framework_get_template_part( 'content/archive/content', 'archive-portfolio' );

					endwhile;
					?>
				</div>
			</div>
			<?php do_action('dahz_framework_after_loop_portfolio'); ?>
		</div>
		<?php
		
	else :

		dahz_framework_get_template_part( 'content/archive/content', 'none' );

	endif;
	
dahz_framework_get_template_part( 'global/global-wrapper', 'close' );

get_footer();