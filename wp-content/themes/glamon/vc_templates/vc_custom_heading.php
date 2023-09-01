<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $source
 * @var $text
 * @var $link
 * @var $google_fonts
 * @var $font_container
 * @var $el_class
 * @var $el_id
 * @var $css
 * @var $css_animation
 * @var $font_container_data - returned from $this->getAttributes
 * @var $google_fonts_data - returned from $this->getAttributes
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Custom_heading
 */

$custom_heading_select_font = $custom_heading_custom_font = $custom_heading_font_weight = $custom_heading_font_style =  $custom_heading_style = $custom_heading_slide_out_color = $source = $text = $link = $google_fonts = $font_container = $el_id = $el_class = $css = $css_animation = $font_container_data = $google_fonts_data = array();

// This is needed to extract $font_container_data and $google_fonts_data
extract( $this->getAttributes( $atts ) );

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if ( 'cfont' === $custom_heading_select_font ) {
	$custom_font_styles = 'font-family: ' . $custom_heading_custom_font . ';font-weight: ' . $custom_heading_font_weight . ';font-style: ' . $custom_heading_font_style . ';';
} else {
	$custom_font_styles = '';
}

/**
 * @var $css_class
 */
if ( 'gfont' === $custom_heading_select_font ) {
	extract( $this->getStyles( $el_class, $css, $google_fonts_data, $font_container_data, $atts ) );
} else {
	extract( $this->getStyles( $el_class, $css, '', $font_container_data, $atts ) );
}

$settings = get_option( 'wpb_js_google_fonts_subsets' );
if ( is_array( $settings ) && ! empty( $settings ) ) {
	$subsets = '&subset=' . implode( ',', $settings );
} else {
	$subsets = '';
}

if ( 'gfont' === $custom_heading_select_font && isset( $google_fonts_data['values']['font_family'] ) ) {
	wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] ), 'https://fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets );
}

if ( ! empty( $styles ) ) {
	$style = 'style="' . esc_attr( implode( ';', $styles ) ) . ';' . $custom_font_styles . '"';
} else {
	$style = '';
}

if ( 'post_title' === $source ) {
	$text = get_the_title( get_the_ID() );
}

if ( ! empty( $link ) ) {
	$link = vc_build_link( $link );
	$text = '<a href="' . esc_attr( $link['url'] ) . '"' . ( $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '"' : '' ) . ( $link['rel'] ? ' rel="' . esc_attr( $link['rel'] ) . '"' : '' ) . ( $link['title'] ? ' title="' . esc_attr( $link['title'] ) . '"' : '' ) . '>' . $text . '</a>';
}
$wrapper_attributes = array();

if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

if ( ! empty( $this->getCSSAnimation( $css_animation ) ) ) {
	$radiantthemes_custom_heading_animate_class = 'class="' . $this->getCSSAnimation( $css_animation ) . '"';
} else {
	$radiantthemes_custom_heading_animate_class = '';
}

$output = '';

$output .= '<!-- radiantthemes-custom-heading -->';
if ( ( 'one' === $custom_heading_style ) || ( 'two' === $custom_heading_style ) ) {
	$output .= '<div ' . implode( ' ', $wrapper_attributes ) . ' class="radiantthemes-custom-heading element-' . $custom_heading_style . ' ' . esc_attr( $css_class ) . '">';
		$output         .= '<div class="radiantthemes-custom-heading-text">';
			$output     .= '<' . $font_container_data['values']['tag'] . ' ' . $style . ' ' . $radiantthemes_custom_heading_animate_class . ' >';
				$output .= $text;
			$output     .= '</' . $font_container_data['values']['tag'] . '>';
		$output         .= '</div>';
	$output .= '</div>';
} elseif ( 'three' === $custom_heading_style ) {
	$output .= '<div ' . implode( ' ', $wrapper_attributes ) . ' class="radiantthemes-custom-heading element-' . $custom_heading_style . ' wow ' . esc_attr( $css_class ) . '">';
	$output         .= '<div class="radiantthemes-custom-heading-text">';
		$output     .= '<' . $font_container_data['values']['tag'] . ' ' . $style . ' ' . $radiantthemes_custom_heading_animate_class . ' >';
			$output .= $text;
		$output     .= '</' . $font_container_data['values']['tag'] . '>';
	$output         .= '</div>';
	$output         .= '<div class="radiantthemes-custom-heading-overlay" style="background-color:' . $custom_heading_slide_out_color . '"></div>';
	$output .= '</div>';
}
$output .= '<!-- radiantthemes-custom-heading -->';

echo wp_kses_post( $output );
