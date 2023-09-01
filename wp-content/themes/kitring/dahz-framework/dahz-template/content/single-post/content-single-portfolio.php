<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */

?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="uk-grid-large" data-uk-grid>
		<div <?php dahz_framework_set_attributes( 
			array( 
				'class'	=> array( 'uk-width-expand@m', 'de-portfolio-single__content' ),
			),
			'portfolio_single_content'
		);?>>
			<div <?php dahz_framework_set_attributes( 
				array( 
					'class'	=> array(),
				),
				'portfolio_single_content_container'
			);?>>
				<!-- #The Content# -->
				<?php the_content();?>
			</div>
		</div>
		<div <?php dahz_framework_set_attributes( 
			array( 
				'class'	=> array( 'uk-width-1-1', 'de-portfolio-single__description' ),
			),
			'portfolio_single_description'
		);?>>
			<!-- #Portfolio Description# -->
			<div class="uk-container">
				<div <?php dahz_framework_set_attributes( 
					array( 
						'class'	=> array(),
					),
					'portfolio_single_description_container'
				);?>>
					<div class="" data-uk-grid="">
						<?php do_action( 'dahz_framework_single_portfolio_description' );?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- #post-<?php the_ID(); ?>#-->
