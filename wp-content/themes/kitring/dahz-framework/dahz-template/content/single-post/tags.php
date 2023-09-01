<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */

?>
<ul class="uk-width-1-1 uk-child-width-auto uk-grid-small uk-margin-medium uk-margin-remove-bottom" data-uk-grid>
	<?php echo apply_filters( 'dahz_framework_post_tags', $tag_list );?>
</ul>