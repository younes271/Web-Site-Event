<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */
if ( ! comments_open() && ! get_comments_number() ){ return; }
?>

<div class="uk-container uk-margin-medium">
	<?php echo dahz_framework_upscale_get_comments();?>
</div>