<?php

if( !class_exists( 'Dahz_Framework_Comment_Template' ) ){

	Class Dahz_Framework_Comment_Template{

		static $path = '';

		public function __construct() {

			add_action( 'dahz_framework_module_comment-template_init', array( $this, 'dahz_framework_comment_template_init' ) );

			add_filter( 'comment_form_submit_button', array( $this, 'dahz_framework_blog_single_comment_button' ), 10 );

		}


		/**
		 * register blog & archive panel on customizer
		 *
		 * @author Dahz
		 * @since 1.0.0
		 * @param - $path
		 * @return -
		 */
		public function dahz_framework_comment_template_init( $path ) {

			self::$path = $path;

		}

		/**
		 * filter comment button
		 *
		 * @param -
		 * @return -
		 */
		public function dahz_framework_blog_single_comment_button() {
			return '<button type="submit" id="submit" class="uk-button uk-button-default">'. esc_html__( 'SUBMIT', 'kitring' ) .'</button>';
		}

	}

	new Dahz_Framework_Comment_Template();

}
