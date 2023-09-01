<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_filter('lastudio/theme/defer_scripts', '__return_empty_array', 100);

if(!function_exists('mgana_add_icon_to_fw_icon')){
    function mgana_add_icon_to_fw_icon( $icons ) {
        $la_icon_lists = [
            "lastudioicon-ic_mail_outline_24px",
            "lastudioicon-ic_compare_arrows_24px",
            "lastudioicon-ic_compare_24px",
            "lastudioicon-ic_share_24px",
            "lastudioicon-bath-tub-1",
            "lastudioicon-shopping-cart-1",
            "lastudioicon-contrast",
            "lastudioicon-heart-1",
            "lastudioicon-sort-tool",
            "lastudioicon-list-bullet-1",
            "lastudioicon-menu-8-1",
            "lastudioicon-menu-4-1",
            "lastudioicon-menu-3-1",
            "lastudioicon-menu-1",
            "lastudioicon-down-arrow",
            "lastudioicon-left-arrow",
            "lastudioicon-right-arrow",
            "lastudioicon-up-arrow",
            "lastudioicon-phone-1",
            "lastudioicon-pin-3-1",
            "lastudioicon-search-content",
            "lastudioicon-single-01-1",
            "lastudioicon-i-delete",
            "lastudioicon-zoom-1",
            "lastudioicon-b-meeting",
            "lastudioicon-bag-20",
            "lastudioicon-bath-tub-2",
            "lastudioicon-web-link",
            "lastudioicon-shopping-cart-2",
            "lastudioicon-cart-return",
            "lastudioicon-check",
            "lastudioicon-g-check",
            "lastudioicon-d-check",
            "lastudioicon-circle-10",
            "lastudioicon-circle-simple-left",
            "lastudioicon-circle-simple-right",
            "lastudioicon-compare",
            "lastudioicon-letter",
            "lastudioicon-mail",
            "lastudioicon-email",
            "lastudioicon-eye",
            "lastudioicon-heart-2",
            "lastudioicon-shopping-cart-3",
            "lastudioicon-list-bullet-2",
            "lastudioicon-marker-3",
            "lastudioicon-measure-17",
            "lastudioicon-menu-8-2",
            "lastudioicon-menu-7",
            "lastudioicon-menu-4-2",
            "lastudioicon-menu-3-2",
            "lastudioicon-menu-2",
            "lastudioicon-microsoft",
            "lastudioicon-phone-2",
            "lastudioicon-phone-call-1",
            "lastudioicon-pin-3-2",
            "lastudioicon-pin-check",
            "lastudioicon-e-remove",
            "lastudioicon-single-01-2",
            "lastudioicon-i-add",
            "lastudioicon-small-triangle-down",
            "lastudioicon-small-triangle-left",
            "lastudioicon-small-triangle-right",
            "lastudioicon-tag-check",
            "lastudioicon-tag",
            "lastudioicon-clock",
            "lastudioicon-time-clock",
            "lastudioicon-triangle-left",
            "lastudioicon-triangle-right",
            "lastudioicon-business-agent",
            "lastudioicon-zoom-2",
            "lastudioicon-zoom-88",
            "lastudioicon-search-zoom-in",
            "lastudioicon-search-zoom-out",
            "lastudioicon-small-triangle-up",
            "lastudioicon-phone-call-2",
            "lastudioicon-full-screen",
            "lastudioicon-car-parking",
            "lastudioicon-transparent",
            "lastudioicon-bedroom-1",
            "lastudioicon-bedroom-2",
            "lastudioicon-search-property",
            "lastudioicon-menu-5",
            "lastudioicon-circle-simple-right-2",
            "lastudioicon-detached-property",
            "lastudioicon-armchair",
            "lastudioicon-measure-big",
            "lastudioicon-b-meeting-2",
            "lastudioicon-bulb-63",
            "lastudioicon-new-construction",
            "lastudioicon-quite-happy",
            "lastudioicon-shape-star-1",
            "lastudioicon-shape-star-2",
            "lastudioicon-star-rate-1",
            "lastudioicon-star-rate-2",
            "lastudioicon-home-2",
            "lastudioicon-home-3",
            "lastudioicon-home",
            "lastudioicon-home-2-2",
            "lastudioicon-home-3-2",
            "lastudioicon-home-4",
            "lastudioicon-home-search",
            "lastudioicon-e-add",
            "lastudioicon-e-delete",
            "lastudioicon-i-delete-2",
            "lastudioicon-i-add-2",
            "lastudioicon-arrow-right",
            "lastudioicon-arrow-left",
            "lastudioicon-arrow-up",
            "lastudioicon-arrow-down",
            "lastudioicon-a-check",
            "lastudioicon-a-add",
            "lastudioicon-chart-bar-32",
            "lastudioicon-chart-bar-32-2",
            "lastudioicon-cart-simple-add",
            "lastudioicon-cart-add",
            "lastudioicon-cart-add-2",
            "lastudioicon-cart-speed-1",
            "lastudioicon-cart-speed-2",
            "lastudioicon-cart-refresh",
            "lastudioicon-ic_format_quote_24px",
            "lastudioicon-quote-1",
            "lastudioicon-quote-2",
            "lastudioicon-b-dribbble",
            "lastudioicon-b-twitter-squared",
            "lastudioicon-b-yahoo-1",
            "lastudioicon-b-skype-outline",
            "lastudioicon-b-twitter",
            "lastudioicon-b-facebook",
            "lastudioicon-b-github-circled",
            "lastudioicon-b-pinterest-circled",
            "lastudioicon-b-pinterest-squared",
            "lastudioicon-b-linkedin",
            "lastudioicon-b-github",
            "lastudioicon-b-youtube-squared",
            "lastudioicon-b-youtube",
            "lastudioicon-b-youtube-play",
            "lastudioicon-b-dropbox",
            "lastudioicon-b-instagram",
            "lastudioicon-b-tumblr",
            "lastudioicon-b-tumblr-squared",
            "lastudioicon-b-skype",
            "lastudioicon-b-foursquare",
            "lastudioicon-b-vimeo-squared",
            "lastudioicon-b-wordpress",
            "lastudioicon-b-yahoo",
            "lastudioicon-b-reddit",
            "lastudioicon-b-reddit-squared",
            "lastudioicon-b-spotify-1",
            "lastudioicon-b-soundcloud",
            "lastudioicon-b-vine",
            "lastudioicon-b-yelp",
            "lastudioicon-b-lastfm",
            "lastudioicon-b-lastfm-squared",
            "lastudioicon-b-pinterest",
            "lastudioicon-b-whatsapp",
            "lastudioicon-b-vimeo",
            "lastudioicon-b-reddit-alien",
            "lastudioicon-b-telegram",
            "lastudioicon-b-github-squared",
            "lastudioicon-b-flickr",
            "lastudioicon-b-flickr-circled",
            "lastudioicon-b-vimeo-circled",
            "lastudioicon-b-twitter-circled",
            "lastudioicon-b-linkedin-squared",
            "lastudioicon-b-spotify",
            "lastudioicon-b-instagram-1",
            "lastudioicon-b-evernote",
            "lastudioicon-b-soundcloud-1"
        ];
        $icons = array(
            array(
                'title' => esc_html__('LA-Studio Icons', 'mgana'),
                'icons' => $la_icon_lists
            )
        );
        return $icons;
    }
    add_filter('lasf_field_icon_add_icons', 'mgana_add_icon_to_fw_icon');
}

if(!function_exists('mgana_render_socials_for_header_builder')){
    function mgana_render_socials_for_header_builder(){
        $social_links = mgana_get_option('social_links');
        if(!empty($social_links)){
            echo '<div class="social-media-link style-default">';
            foreach($social_links as $item){
                if(!empty($item['link']) && !empty($item['icon'])){
                    $title = isset($item['title']) ? $item['title'] : '';
                    printf(
                        '<a href="%1$s" class="%2$s" title="%3$s" target="_blank" rel="nofollow"><i class="%4$s"></i></a>',
                        esc_url($item['link']),
                        esc_attr(sanitize_title($title)),
                        esc_attr($title),
                        esc_attr($item['icon'])
                    );
                }
            }
            echo '</div>';
        }
    }
    add_action('lastudio/header-builder/render-social', 'mgana_render_socials_for_header_builder');
}

if(!function_exists('mgana_setup_header_preset_data_for_builder')){
	function mgana_setup_header_preset_data_for_builder( $data = array() ){
		$value = mgana_get_header_layout();
		if (!empty($value) && $value != 'inherit') {
			if (!is_admin() && !isset($_GET['lastudio_header_builder'])) {
				$data = LAHB_Helper::get_data_frontend_component_with_preset($value, $data);
			}
		}
		return $data;
	}
}
add_filter('lastudio/header-builder/setup-data-preset', 'mgana_setup_header_preset_data_for_builder');