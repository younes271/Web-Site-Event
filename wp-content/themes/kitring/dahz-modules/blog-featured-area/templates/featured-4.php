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
<li class="uk-light uk-cover-container uk-width-1-1 uk-width-1-3@m">
	<div class="uk-position-relative uk-height-1-1 uk-background-muted">
		<?php if ( has_post_thumbnail() ) : ?>
		<?php echo get_the_post_thumbnail( get_the_ID(), 'full', array( 'data-uk-cover' => '' ) ); ?>
		<?php endif; ?>
		<div class="uk-overlay uk-position-bottom uk-flex uk-flex-bottom uk-width-1-1 uk-padding-large de-featured-area__overlay" style="min-height: 50%">
			<div>
				<div class="entry-title">
					<?php dahz_framework_title( array( 'class' => "{$uppercase} {$heading_style}" ) );?>
				</div>
				<div class="entry-meta">
					<?php 
					dahz_framework_post_meta( 
						array( 
							'metas'	=> $metas 
						)
					);
					?>
				</div>
			</div>
		</div>
	</div>
</li>