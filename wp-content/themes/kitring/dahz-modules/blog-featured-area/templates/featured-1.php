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
<li class="uk-light uk-cover-container uk-width-1-1">
	<div class="uk-flex uk-flex-middle uk-height-1-1 uk-background-muted">
		<?php if ( has_post_thumbnail() ) : ?>
		<?php echo get_the_post_thumbnail( get_the_ID(), 'full', array( 'data-uk-cover' => '' ) ); ?>
		<?php endif; ?>
		<div class="uk-overlay-primary uk-position-cover uk-transition-fade de-opacity-5"></div>
		<div class="uk-position-relative uk-position-z-index uk-width-1-1">
			<div class="uk-container">
				<div class="uk-grid" data-uk-grid>
					<div class="uk-width-1-1 uk-width-1-2@m">
						<div class="entry-meta">
							<?php 
							dahz_framework_post_meta( 
								array( 
									'metas'	=> $metas 
								)
							);
							?>
						</div>
						<div class="entry-title">
							<?php dahz_framework_title( array( 'class' => "{$uppercase} {$heading_style}" ) );?>
						</div>
						<div class="uk-visible@m de-archive__featured-content uk-margin-medium">
							<?php dahz_framework_excerpt();?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>