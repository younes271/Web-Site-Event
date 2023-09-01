<?php
/**
 * Default post entry layout
 *
 * @package Mgana WordPress theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$preset = mgana_get_option('blog_design', '');
$blog_excerpt_length = mgana_get_option('blog_excerpt_length', 30);
$blog_thumbnail_size = mgana_get_option('blog_thumbnail_size', 'full');

$title_tag = 'h2';

$classes = array('lastudio-posts__item', 'loop__item', 'grid-item');

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
    <div class="lastudio-posts__inner-box"><?php

        mgana_single_post_thumbnail($blog_thumbnail_size);

        echo '<div class="lastudio-posts__inner-content">';

        get_template_part('partials/entry/meta', 'single2');

        echo sprintf(
            '<header class="entry-header"><%1$s class="entry-title"><a href="%2$s" rel="bookmark">%3$s</a></%1$s></header>',
            esc_attr($title_tag),
            esc_url(get_the_permalink()),
            get_the_title()
        );

        get_template_part('partials/entry/meta');

        if($blog_excerpt_length > 0){
            the_excerpt();
        }

        echo sprintf(
            '<div class="lastudio-more-wrap"><a href="%2$s" class="elementor-button lastudio-more" title="%3$s" rel="bookmark"><span class="btn__text">%1$s</span><i class="lastudio-more-icon "></i></a></div>',
            esc_html__('Read More', 'mgana'),
            esc_url(get_the_permalink()),
            esc_html(get_the_title())
        );

        echo '</div>';

        ?></div>
</article><!-- #post-## -->