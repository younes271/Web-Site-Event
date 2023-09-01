<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */
 
 if( empty( get_previous_post_link() ) && empty( get_next_post_link() ) ){ return; }
?>

<div class="uk-container uk-margin-medium">
	<hr class="uk-margin-medium">
	<div class="uk-child-width-1-2@m" data-uk-grid>
		<div class="nav-previous uk-text-center uk-text-left@m">
			<?php
			previous_post_link(
				'%link',
				'
				<p class="uk-text-small">' . __( 'Previous', 'kitring' ) . '</p>
				<h4 class="uk-margin-remove">%title</h4>
				'				
			);
 			?>
		</div>
		<div class="nav-next uk-text-center uk-text-right@m">
			<?php
			next_post_link(
				'%link',
				'
				<p class="uk-text-small">' . __( 'Next', 'kitring' ) . '</p>
				<h4 class="uk-margin-remove">%title</h4>
				'	
			);
 			?>
		</div>
	</div>
</div>