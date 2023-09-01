<?php

if ( !function_exists( 'dahz_framework_custom_password_protected' )) {
	/**
	 * custom password protected post
	 *
	 * @author Dahz - KW
	 * @since 1.0.0
	 * @param - $id
	 * @return - string
	 */
	 function dahz_framework_custom_password_protected( $color = '' ) {

		global $post;
		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
		$form_render = '<form class="protected-post-form" action="' . get_option('siteurl') . '/wp-pass.php" method="post"><p>
		' . esc_html__( 'This content is password protected. To view it please enter your password below:', 'kitring' ) . '
		</p><p><label class="pass-label" for="' . $label . '">' . esc_html__( 'Password:', 'kitring' ) . ' <input name="post_password" id="' . $label . '" type="password" size="20" /></label>
		</p><input type="submit" name="Submit" class="uk-button uk-button-default button" value="' . esc_attr__( 'Submit', 'kitring' ) . '" /></form>
		';
		return $form_render;
	}
	add_filter( 'the_password_form', 'dahz_framework_custom_password_protected' );
}


if ( !function_exists( 'dahz_framework_reconstruct_page_link_content' ) ) {

	function dahz_framework_reconstruct_page_link_content( $link, $i ){

		global $page, $more;
		
		if ( $i == $page && $more ) {
			
			return '<li class="active">' . '<a href="javascript:void(0)">' . $link . '</a>' . '</li>';
			
		}

		return '<li>' . $link . '</li>';

	}

	add_filter( 'wp_link_pages_link', 'dahz_framework_reconstruct_page_link_content', 10, 2 );

}

if ( !function_exists( 'dahz_framework_upscale_get_comments' ) ) {

	function dahz_framework_upscale_get_comments() {

		if ( is_singular( 'product' ) ) return;

		$is_show_comment_counts = 1;

		$comments = '';
		
		if ( comments_open() || get_comments_number() ) {

			$comments = dahz_framework_get_template_html(
				"comments.php",
				array(),
				'dahz-modules/upscale/templates/'
			);

		}

		return $comments;

	}

}

if ( !function_exists( 'dahz_framework_hex_to_rgba' ) ) {

	function dahz_framework_hex_to_rgba( $color, $opacity = false ) {

		$default = 'rgb(0,0,0)';

		if ( stripos( $color, 'rgba' ) !== false ) {return $color;}

		//Return default if no color provided
		if ( empty( $color ) ) {return $default;}

		//Sanitize $color if "#" is provided
		if ( $color[0] == '#' ) { $color = substr( $color, 1 );}

		//Check if color has 6 or 3 characters and get values
		if ( strlen( $color ) == 6 ) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}
		//Convert hexadec to rgb
		$rgb =  array_map( 'hexdec', $hex );
		//Check if opacity is set(rgba or rgb)
		if ($opacity) {
			if ( abs( $opacity ) > 1 ) {$opacity = 1.0;}
			$output = 'rgba(' . implode( "," ,$rgb ).','.$opacity.')';
		} else {
			$output = 'rgb(' . implode( ",", $rgb ) . ')';
		}

		//Return rgb(a) color string
		return $output;
	}

}


/**
 * render header search modal
 *
 * @author Dahz - KW: BANER
 * @since 1.0.0
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_baner_header_search_modal' ) ) {

	function dahz_baner_header_search_modal( $output ) {
		$main_accent_color_regular = dahz_framework_get_option(
			"color_general_heading_text_color",
			'#000000'
		);

		$body_bg_color = dahz_framework_get_option( 'general_layout_body_bg_color', '#ffffff' );

		$output = sprintf(
			'
			<div id="header-search-modal" class="de-header-search uk-modal-full" style="background-color: %3$s;" data-uk-modal>
				<div class="uk-modal-dialog uk-modal-body uk-height-1-1" style="background-color: transparent;">
					<div class="uk-container uk-margin-top">
						<a class="uk-modal-close uk-modal-close-full uk-close-large" data-uk-close style="color: %4$s;"></a>
						<div class="uk-grid uk-grid-large uk-child-width-1-1 uk-margin-large-top" data-uk-grid>
							<div class="uk-position-relative">
								<form role="search" method="get" action="%2$s">
									<h2><span class="uk-hidden">Search</span><input type="text" name="s" title="search" value="" placeholder="%1$s"></h2>
									<input type="hidden" name="post_type" value="post">
									<input type="hidden" name="post_type" value="page">
									<input class="uk-hidden" type="submit" name="submit" value="Search" aria-label="submit">
								</form>
								<div class="uk-position-center-right uk-invisible" data-uk-spinner></div>
							</div>
							<div>
								<ul class="de-header-search__result uk-grid uk-child-width-1-2@m" data-uk-grid></ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			',
			esc_attr__( 'Start typing here...', 'kitring' ), # 1
			esc_url( home_url() ), # 2
			dahz_framework_hex2rgba( $body_bg_color, .95 ), # 3
			$main_accent_color_regular # 4
		);

		return $output;
	}

}

add_filter( 'dahz_framework_header_render_search_modal', 'dahz_baner_header_search_modal', 10, 1 );

/**
 * enqueue header autocomplete
 *
 * @author Dahz - KW: BANER
 * @since 1.0.0
 * @param -
 * @return -
 */
if ( !function_exists( 'dahz_baner_header_search_autocomplete' ) ) {

	function dahz_baner_header_search_autocomplete( $output ) {

		wp_register_script( 'dahz-framework-header-search-autocomplete', DAHZ_FRAMEWORK_THEME_URI . '/dahz-modules/header-search/assets/js/dahz-framework-header-search-autocomplete.min.js', array( 'dahz-framework-script', 'dahz-framework-header-search' ), null, true );

	}

}

add_action( 'wp_enqueue_scripts', 'dahz_baner_header_search_autocomplete', 10 );

/**
 * render header search list
 *
 * @author Dahz - KW: DIACARA
 * @since 1.0.0
 * @param - $list_output, $thumbnail, $post_link, $title, $categories
 * @return - $list_output
 */
if ( !function_exists( 'dahz_pabu_header_search_list' ) ) {

	function dahz_pabu_header_search_list( $list_output, $thumbnail, $post_link, $title, $categories ) {

		$list_output = sprintf(
			'
			<li class="entry-item">
				<div class="uk-margin-small-bottom uk-grid" data-uk-grid>
					<div class="uk-width-auto">
						<a href="%2$s">
							<div class="de-ratio de-ratio-1-1" style="background-color: #eee;width: 100px;">
								%1$s
							</div>
						</a>
					</div>
					<div class="uk-width-expand uk-flex uk-flex-middle">
						<div>
							<h6 class="entry-title"><a class="uk-link" href="%2$s">%3$s</a></h6>
							<div class="entry-info">
								%5$s %6$s %7$s <span class="entry-categories">%8$s</span>
							</div>
						</div>
					</div>
				</div>
			</li>
			',
			$thumbnail, # 1
			$post_link, # 2
			$title, # 3
			$categories, # 4
			get_post_type() == 'post' ? __( 'By', 'kitring' ) : '', # 5
			get_post_type() == 'post' ? Dahz_Framework_Blog_Archive::dahz_framework_blog_archive_get_post_author('') : '', # 6
			!empty( dahz_framework_get_post_meta_categories() ) ? __( 'In', 'kitring' ) : '', # 7
			dahz_framework_get_post_meta_categories() # 8
		);

		return $list_output;
	}

}

add_filter( 'dahz_framework_header_search_list', 'dahz_pabu_header_search_list', 10, 5 );

/**
 * change search not found text
 *
 * @author Dahz - KW: DIACARA
 * @since 1.0.0
 * @param - $options
 * @return - $options
 */
if ( !function_exists( 'dahz_pabu_search_notfound' ) ) {

	function dahz_pabu_search_notfound( $options ) {

		$options = array_merge(
			$options,
			array(
				'language' => array(
					'emptyMessage' => __( '<h4>OH NO! No result were found</h4>', 'kitring' )
				)
			)
		);

		return $options;
	}

}

add_filter( 'dahz_framework_localize', 'dahz_pabu_search_notfound', 10, 1 );

/**
 * convert hex color into rgba
 *
 * @author Dahz - KW: DIACARA
 * @since 1.0.0
 * @param - $color, $opacity
 * @return - $output
 */
if ( !function_exists( 'dahz_framework_hex2rgba' ) ) {
	
	function dahz_framework_hex2rgba($color, $opacity = false) {
		$default = 'rgb(0,0,0)';
		//Return default if no color provided
		if (empty($color))
				return $default;
		//Sanitize $color if "#" is provided
		if ($color[0] == '#' ) {
			$color = substr( $color, 1 );
		}
		//Check if color has 6 or 3 characters and get values
		if (strlen($color) == 6) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}
		//Convert hexadec to rgb
		$rgb = array_map('hexdec', $hex);
		//Check if opacity is set(rgba or rgb)
		if ($opacity) {
			if (abs($opacity) > 1)
				$opacity = 1.0;
			$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
		} else {
			$output = 'rgb('.implode(",",$rgb).')';
		}
		//Return rgb(a) color string
		return $output;
	}
}

/** add icon to post single <blockquote>
 *
 * @author Dahz - KW
 * @since 1.0.1
 * @param - $content
 * @return - $content
 */
if ( !function_exists( 'dahz_framework_filter_blockqoute' ) ) {
	function dahz_framework_filter_blockqoute( $content ) {
		$content = str_replace( '</blockquote>', '</blockquote><hr class="uk-margin-medium" />', $content );
		$content = str_replace( '<blockquote>', '<hr class="uk-margin-medium" /><blockquote>', $content );

		return $content;
	}
	add_filter( 'the_content', 'dahz_framework_filter_blockqoute' );
	add_filter( 'comment_text', 'dahz_framework_filter_blockqoute' );
}

