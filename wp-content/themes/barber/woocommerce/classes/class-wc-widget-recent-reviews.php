<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Recent Reviews Widget.
 *
 * @author   WooThemes
 * @category Widgets
 * @package  WooCommerce/Widgets
 * @version  2.3.0
 * @extends  WC_Widget
 */
class WC_Widget_Recent_Reviews_Custom extends WC_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget_recent_reviews';
		$this->widget_description = esc_html__( 'Display a list of your most recent reviews on your site.', 'barber' );
		$this->widget_id          = 'woocommerce_recent_reviews';
		$this->widget_name        = esc_html__( 'WooCommerce Recent Reviews', 'barber' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => esc_html__( 'Recent Reviews', 'barber' ),
				'label' => esc_html__( 'Title', 'barber' )
			),
			'number' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 10,
				'label' => esc_html__( 'Number of reviews to show', 'barber' )
			)
		);

		parent::__construct();
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	 public function widget( $args, $instance ) {
		global $comments, $comment;

		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		ob_start();

		$number   = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
		$comments = get_comments( array( 'number' => $number, 'status' => 'approve', 'post_status' => 'publish', 'post_type' => 'product' ) );

		if ( $comments ) {
			$this->widget_start( $args, $instance );

			echo '<ul class="product_list_widget">';

			foreach ( (array) $comments as $comment ) {

				$_product = wc_get_product( $comment->comment_post_ID );

				$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

				$rating_html = $_product->get_rating_html( $rating );

				echo '<li><div class="product-img"><a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">';

				echo $_product->get_image() . '</a></div>';
				
				echo'<div class="product-content">';
				
				echo '<div class="product-title"><a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">';

				echo $_product->get_title() . '</a></div>';
				
				echo $rating_html;

				printf( '<span class="reviewer">' . _x( 'by %1$s', 'by comment author', 'barber' ) . '</span>', get_comment_author() ) . '</div>';

				echo '</li>';
			}

			echo '</ul>';

			$this->widget_end( $args );
		}

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}
