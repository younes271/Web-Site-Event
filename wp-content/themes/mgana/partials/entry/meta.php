<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
echo '<div class="post-meta">';
echo sprintf(
    '<span class="posted-by post-meta__item"%4$s><span>%1$s</span><a href="%2$s" class="posted-by__author" rel="author"%5$s>%3$s</a></span>',
    esc_html__( 'by ', 'mgana' ),
    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
    esc_html( get_the_author() ),
    mgana_get_schema_markup('author_name'),
    mgana_get_schema_markup('author_link')
);
echo sprintf(
    '<span class="post__date post-meta__item"%3$s><time datetime="%1$s" title="%1$s">%2$s</time></span>',
    esc_attr( get_the_date( 'c' ) ),
    esc_html( get_the_date() ),
    mgana_get_schema_markup('publish_date')
);
if(comments_open()){
    echo '<span class="post__comments post-meta__item"><i class="lastudioicon-b-meeting"></i>';
    comments_popup_link(__('0 comment', 'mgana'),__('1 comment', 'mgana'),false, 'post__comments-link');
    echo '</span>';
}
echo '</div>';