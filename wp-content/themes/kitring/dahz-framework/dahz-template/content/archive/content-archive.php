<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kitring
 * @since 1.0
 * @version 1.0
 */
?>
<article id="post-<?php the_ID();?>" <?php post_class( 'uk-article uk-margin-medium' );?>>
	<div class="de-archive__wrapper uk-margin-medium uk-position-relative">
		<div class="entry-sticky">
			<?php dahz_framework_sticky_post();?>
		</div>
		<div class="entry-meta">
			<?php dahz_framework_post_meta();?>
		</div>
		<div class="entry-title">
			<?php dahz_framework_title();?>
		</div>
	</div>
	<?php dahz_framework_featured_image();?>
	<div class="de-archive__featured-content uk-margin-medium">
		<?php dahz_framework_excerpt( 
			array(
				'button_type'	=> apply_filters( 'dahz_framework_blog_readmore_button_type', 'uk-button-default' ),
				'button_size'	=> apply_filters( 'dahz_framework_blog_readmore_button_size', '' ),
			)
		);?>
	</div>
</article>
<hr class="uk-margin-medium">