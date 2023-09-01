<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */

?>
<div class="widget widget_categories">
	<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'kitring' ); ?></h2>
	<ul>
	<?php
		wp_list_categories( array(
			'orderby'    => 'count',
			'order'      => 'DESC',
			'show_count' => 1,
			'title_li'   => '',
			'number'     => 10,
		) );
	?>
	</ul>
</div><!-- .widget -->