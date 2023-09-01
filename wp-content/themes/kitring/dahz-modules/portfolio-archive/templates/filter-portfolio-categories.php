<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage kitring
 * @since 1.0
 * @version 1.0
 */

?>
<div class="uk-flex-first">
	<ul <?php dahz_framework_set_attributes( 
		array( 
			'class' => array( 'uk-subnav uk-subnav-pill uk-flex-left' ),
		),
		'loop_portfolio_filter'
	);?>>
		
		<li class="uk-active" data-uk-filter-control>
			<a href="#"><?php _e( 'All', 'kitring' )?></a>
		</li>
		<?php foreach( $categories as $category ): ?>
		
			<li data-uk-filter-control=".portfolio_categories-<?php echo esc_attr( $category->slug );?>">
				<a href="#"><?php echo esc_html( $category->name );?></a>
			</li>
			
		<?php endforeach; ?>
	</ul>
</div>