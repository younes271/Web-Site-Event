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
<li class="uk-light uk-cover-container uk-width-3-4">
	<div class="uk-position-relative uk-width-1-1 uk-height-1-1 uk-background-muted">
		<?php if ( has_post_thumbnail() ) : ?>
		<?php echo get_the_post_thumbnail( get_the_ID(), 'full', array( 'data-uk-cover' => '' ) ); ?>
		<?php endif; ?>
		<div class="uk-overlay-primary uk-position-cover uk-transition-fade de-opacity-5"></div>
		<div class="uk-overlay uk-position-cover uk-flex uk-flex-center uk-flex-middle uk-text-center">
			<div class="uk-width-1-1 uk-width-1-2@m">
				<div class="entry-title">
					<?php dahz_framework_title( array( 'class' => "{$uppercase} {$heading_style}" ) );?>
				</div>
				<div class="entry-meta">
					<?php 
					dahz_framework_post_meta( 
						get_the_ID(),
						array( 
							'metas'			=> $metas,
							'items_wrap'	=> '<ul class="uk-subnav uk-subnav-divider uk-margin uk-flex-center" data-uk-margin>%1$s</ul>',
						)
					);
					?>
				</div>
			</div>
		</div>
	</div>
</li>