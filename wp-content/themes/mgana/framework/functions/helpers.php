<?php
/**
 * This file includes helper functions used throughout the theme.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Return theme settings
 */

if ( ! function_exists( 'mgana_get_option' ) ) {

    function mgana_get_option( $key = '', $default = '' ) {
        $theme_options = get_option('mgana_options', array());

        if(empty($theme_options) || $key == ''){
            $value = $default;
        }
        else{
            $value = !empty($theme_options[$key]) ? $theme_options[$key] : $default;
        }

        return apply_filters( 'mgana/filter/get_option', $value, $key, $default, $theme_options);
    }

}

if ( ! function_exists( 'mgana_get_post_meta' ) ) {
    function mgana_get_post_meta( $object_id, $sub_key = '', $meta_key = '', $single = true ) {

        if (!is_numeric($object_id)) {
            return false;
        }

        if (empty($meta_key)) {
            $meta_key = '_mgana_post_options';
        }

        $object_value = get_post_meta($object_id, $meta_key, $single);

        if(!empty($sub_key)){
            if( $single ) {
                if(isset($object_value[$sub_key])){
                    return $object_value[$sub_key];
                }
                else{
                    return false;
                }
            }
            else{
                $tmp = array();
                if( ! empty( $object_value ) ) {
                    foreach( $object_value as $k => $v ){
                        $tmp[] = (isset($v[$sub_key])) ? $v[$sub_key] : '';
                    }
                }
                return $tmp;
            }
        }
        else{
            return $object_value;
        }
    }
}

if ( ! function_exists( 'mgana_get_term_meta' ) ) {
    function mgana_get_term_meta( $object_id, $sub_key = '', $meta_key = '', $single = true ) {

        if (!is_numeric($object_id)) {
            return false;
        }
        if (empty($meta_key)) {
            $meta_key = '_mgana_term_options';
        }

        $object_value = get_term_meta($object_id, $meta_key, $single);

        if(!empty($sub_key)){
            if( $single ) {
                if(isset($object_value[$sub_key])){
                    return $object_value[$sub_key];
                }
                else{
                    return false;
                }
            }
            else{
                $tmp = array();
                if(!empty($object_value)){
                    foreach( $object_value as $k => $v ){
                        $tmp[] = (isset($v[$sub_key])) ? $v[$sub_key] : '';
                    }
                }
                return $tmp;
            }
        }
        else{
            return $object_value;
        }
        
    }
}

if ( ! function_exists( 'mgana_get_theme_option_by_context') ) {

    function mgana_get_theme_option_by_context( $key = '', $default = '' ){
        if( $key == '' ){
            return $default;
        }

        $value = $value_default = mgana_get_option( $key, $default );

        if( is_home() ) {
            $_value = mgana_get_option("{$key}_blog");
            if(!empty($_value)){
                if(is_array($_value)){
                    if(mgana_array_filter_recursive($_value)){
                        $value = $_value;
                    }
                }
                else{
                    if($_value !== 'inherit'){
                        $value = $_value;
                    }
                }
            }
        }

        if( is_home() || is_front_page() ) {

            if( ($key == 'main_space' || $key == 'main_full_width') && ( is_home() && !is_front_page() ) ) {
                $_value = mgana_get_option("{$key}_archive_post");
                if(!empty($_value)){
                    if(is_array($_value)){
                        if(mgana_array_filter_recursive($_value)){
                            $value = $_value;
                        }
                    }
                    else{
                        if($_value !== 'inherit'){
                            $value = $_value;
                        }
                    }
                }
            }

            if ( $current_object_id = get_queried_object_id() ) {
                $_value = mgana_get_post_meta( $current_object_id, $key );
                if(!empty($_value)){
                    if(is_array($_value)){
                        if(mgana_array_filter_recursive($_value)){
                            $value = $_value;
                        }
                    }
                    else{
                        if($_value !== 'inherit'){
                            $value = $_value;
                        }
                    }
                }
            }
        }
        elseif ( is_singular() ) {

            $post_type = get_query_var('post_type') ? get_query_var('post_type') : ( is_singular('post') ? 'post' : 'page' );

            if(is_array($post_type)){
                $post_type = $post_type[0];
            }

            $post_type = str_replace('la_', '', $post_type);

            /*
             * get {$key} is layout from blog
             */

            if(is_singular('post') && $key == 'layout'){
                $_value = mgana_get_option('layout_blog');
                if(!empty($_value) && $_value !== 'inherit'){
                    $value = $_value;
                }
            }

            $_value = mgana_get_option("{$key}_single_{$post_type}", $value_default );
            
            if(!empty($_value)){
                if( is_array($_value) ) {
                    if(mgana_array_filter_recursive($_value)){
                        $value = $_value;
                    }
                }
                else{
                    if($_value !== 'inherit'){
                        $value = $_value;
                    }
                }
            }
            
            $_value = mgana_get_post_meta( get_queried_object_id(), $key );

            if(!empty($_value)){
                if( is_array($_value) ) {
                    if( mgana_array_filter_recursive($_value) ){
                        $value = $_value;
                    }
                }
                else{
                    if($_value !== 'inherit'){
                        $value = $_value;
                    }
                }
            }

            if(is_singular('elementor_library')){
                if( $key == 'layout' ) {
                    $value = 'col-1c';
                }
                if( $key == 'page_title_bar_layout'){
                    $value = 'hide';
                }
                if( $key == 'hide_header'){
                    $value = 'yes';
                }
                if( $key == 'hide_footer'){
                    $value = 'yes';
                }
            }
        }

        elseif( is_archive() ) {

            if( function_exists('is_shop') && is_shop() ){
                $_value = mgana_get_option("{$key}_archive_product", $value_default );
                if(!empty($_value)){
                    if(is_array($_value)){
                        if(mgana_array_filter_recursive($_value)){
                            $value = $_value;
                        }
                    }
                    else{
                        if($_value !== 'inherit'){
                            $value = $_value;
                        }
                    }
                }
                if( $shop_page_id = wc_get_page_id('shop') ){
                    $_value = mgana_get_post_meta( $shop_page_id, $key );
                    if(!empty($_value)){
                        if(is_array($_value)){
                            if(mgana_array_filter_recursive($_value)){
                                $value = $_value;
                            }
                        }
                        else{
                            if($_value !== 'inherit'){
                                $value = $_value;
                            }
                        }
                    }
                }
            }
            elseif( function_exists('is_product_taxonomy') && is_product_taxonomy() ){
                $_value = mgana_get_option("{$key}_archive_product", $value_default);
                if(!empty($_value)){
                    if(is_array($_value)){
                        if(mgana_array_filter_recursive($_value)){
                            $value = $_value;
                        }
                    }
                    else{
                        if($_value !== 'inherit'){
                            $value = $_value;
                        }
                    }
                }
                $_value = mgana_get_term_meta( get_queried_object_id(), $key);
                if(!empty($_value)){
                    if(is_array($_value)){
                        if(mgana_array_filter_recursive($_value)){
                            $value = $_value;
                        }
                    }
                    else{
                        if($_value !== 'inherit'){
                            $value = $_value;
                        }
                    }
                }
            }
            elseif( is_post_type_archive('la_portfolio') ) {
                $_value = mgana_get_option("{$key}_archive_portfolio", $value_default);
                if(!empty($_value)){
                    if(is_array($_value)){
                        if(mgana_array_filter_recursive($_value)){
                            $value = $_value;
                        }
                    }
                    else{
                        if($_value !== 'inherit'){
                            $value = $_value;
                        }
                    }
                }
            }
            elseif( is_tax() && is_tax(get_object_taxonomies( 'la_portfolio' ))){
                $_value = mgana_get_option("{$key}_archive_portfolio", $value_default);
                if(!empty($_value)){
                    if(is_array($_value)){
                        if(mgana_array_filter_recursive($_value)){
                            $value = $_value;
                        }
                    }
                    else{
                        if($_value !== 'inherit'){
                            $value = $_value;
                        }
                    }
                }
                $_value = mgana_get_term_meta( get_queried_object_id(), $key );
                if(!empty($_value)){
                    if(is_array($_value)){
                        if(mgana_array_filter_recursive($_value)){
                            $value = $_value;
                        }
                    }
                    else{
                        if($_value !== 'inherit'){
                            $value = $_value;
                        }
                    }
                }
            }
            else{
                if($key == 'layout'){
                    if( mgana_is_blog() ){
                        $_value = mgana_get_option("layout_blog");
                        if(!empty($_value) && $_value !== 'inherit'){
                            $value = $_value;
                        }
                    }
                }
                else{

                    $_value = mgana_get_option("{$key}_archive_post", $value_default);
                    if(!empty($_value)){
                        if(is_array($_value)){
                            if(mgana_array_filter_recursive($_value)){
                                $value = $_value;
                            }
                        }
                        else{
                            if($_value !== 'inherit'){
                                $value = $_value;
                            }
                        }
                    }
                }

                $_value = mgana_get_term_meta( get_queried_object_id(), $key );

                if(!empty($_value)){
                    if(is_array($_value)){
                        if(mgana_array_filter_recursive($_value)){
                            $value = $_value;
                        }
                    }
                    else{
                        if($_value !== 'inherit'){
                            $value = $_value;
                        }
                    }
                }
            }
        }

        else{
            /*
             * check if is dokan store page
             */
            if(function_exists('dokan_is_store_page') && dokan_is_store_page()){
                $_value = mgana_get_option("{$key}_archive_product", $value_default );
                if(!empty($_value)){
                    if(is_array($_value)){
                        if(mgana_array_filter_recursive($_value)){
                            $value = $_value;
                        }
                    }
                    else{
                        if($_value !== 'inherit'){
                            $value = $_value;
                        }
                    }
                }
                else{

                    $value = $value_default;
                }
            }
            else{
                /*
                * For search & 404 page
                */
                $value = $value_default;
            }
        }


        return apply_filters('mgana/filter/get_theme_option_by_context', $value, $key );

    }

}

/**
 * Return correct schema markup
 */

if ( ! function_exists( 'mgana_get_schema_markup' ) ) {

    function mgana_get_schema_markup( $location ) {

        // Return if disable
        if ( ! mgana_get_option( 'schema_markup', false ) ) {
            return null;
        }

        // Default
        $schema = $itemprop = $itemtype = '';

        // HTML
        if ( 'html' == $location ) {
            $schema = 'itemscope itemtype="//schema.org/WebPage"';
        }

        // Header
        elseif ( 'header' == $location ) {
            $schema = 'itemscope="itemscope" itemtype="//schema.org/WPHeader"';
        }

        // Logo
        elseif ( 'logo' == $location ) {
            $schema = 'itemscope itemtype="//schema.org/Brand"';
        }

        // Navigation
        elseif ( 'site_navigation' == $location ) {
            $schema = 'itemscope="itemscope" itemtype="//schema.org/SiteNavigationElement"';
        }

        // Main
        elseif ( 'main' == $location ) {
            $itemtype = '//schema.org/WebPageElement';
            $itemprop = 'mainContentOfPage';
            if ( is_singular( 'post' ) ) {
                $itemprop = '';
                $itemtype = '//schema.org/Blog';
            }
        }

        // Breadcrumb
        elseif ( 'breadcrumb' == $location ) {
            $schema = 'itemscope itemtype="//schema.org/BreadcrumbList"';
        }

        // Breadcrumb list
        elseif ( 'breadcrumb_list' == $location ) {
            $schema = 'itemprop="itemListElement" itemscope itemtype="//schema.org/ListItem"';
        }

        // Breadcrumb itemprop
        elseif ( 'breadcrumb_itemprop' == $location ) {
            $schema = 'itemprop="breadcrumb"';
        }

        // Sidebar
        elseif ( 'sidebar' == $location ) {
            $schema = 'itemscope="itemscope" itemtype="//schema.org/WPSideBar"';
        }

        // Footer widgets
        elseif ( 'footer' == $location ) {
            $schema = 'itemscope="itemscope" itemtype="//schema.org/WPFooter"';
        }

        // Headings
        elseif ( 'headline' == $location ) {
            $schema = 'itemprop="headline"';
        }

        // Posts
        elseif ( 'entry_content' == $location ) {
            $schema = 'itemprop="text"';
        }

        // Publish date
        elseif ( 'publish_date' == $location ) {
            $schema = 'itemprop="datePublished"';
        }

        // Author name
        elseif ( 'author_name' == $location ) {
            $schema = 'itemprop="name"';
        }

        // Author link
        elseif ( 'author_link' == $location ) {
            $schema = 'itemprop="author" itemscope="itemscope" itemtype="//schema.org/Person"';
        }

        // Item
        elseif ( 'item' == $location ) {
            $schema = 'itemprop="item"';
        }

        // Url
        elseif ( 'url' == $location ) {
            $schema = 'itemprop="url"';
        }

        // Position
        elseif ( 'position' == $location ) {
            $schema = 'itemprop="position"';
        }

        // Image
        elseif ( 'image' == $location ) {
            $schema = 'itemprop="image"';
        }

        return ' ' . apply_filters( 'mgana_schema_markup', $schema );

    }

}

if ( ! function_exists( 'mgana_schema_markup' ) ) {

    function mgana_schema_markup( $location ) {

        echo mgana_get_schema_markup( $location );

    }

}

if ( ! function_exists('mgana_social_sharing') ) {
    function mgana_social_sharing( $post_link = '', $post_title = '', $image = '', $post_excerpt = '', $echo = true){
        if(empty($post_link) || empty($post_title)){
            return;
        }
        if(!$echo){
            ob_start();
        }
        echo '<span class="social--sharing">';
        if(mgana_string_to_bool(mgana_get_option('sharing_facebook'))){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="facebook" title="%2$s"><i class="lastudioicon-b-facebook"></i></a>',
                esc_url( 'https://www.facebook.com/sharer.php?u=' . $post_link ),
                esc_attr_x('Share this post on Facebook', 'front-view', 'mgana')
            );
        }
        if(mgana_string_to_bool(mgana_get_option('sharing_twitter'))){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="twitter" title="%2$s"><i class="lastudioicon-b-twitter"></i></a>',
                esc_url( 'https://twitter.com/intent/tweet?text=' . $post_title . '&url=' . $post_link ),
                esc_attr_x('Share this post on Twitter', 'front-view', 'mgana')
            );
        }
        if(mgana_string_to_bool(mgana_get_option('sharing_reddit'))){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="reddit" title="%2$s"><i class="lastudioicon-b-reddit"></i></a>',
                esc_url( 'https://www.reddit.com/submit?url=' . $post_link . '&title=' . $post_title ),
                esc_attr_x('Share this post on Reddit', 'front-view', 'mgana')
            );
        }
        if(mgana_string_to_bool(mgana_get_option('sharing_linkedin'))){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="linkedin" title="%2$s"><i class="lastudioicon-b-linkedin"></i></a>',
                esc_url( 'https://www.linkedin.com/shareArticle?mini=true&url=' . $post_link . '&title=' . $post_title ),
                esc_attr_x('Share this post on Linked In', 'front-view', 'mgana')
            );
        }
        if(mgana_string_to_bool(mgana_get_option('sharing_tumblr'))){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="tumblr" title="%2$s"><i class="lastudioicon-b-tumblr"></i></a>',
                esc_url( 'https://www.tumblr.com/share/link?url=' . $post_link ) ,
                esc_attr_x('Share this post on Tumblr', 'front-view', 'mgana')
            );
        }
        if(mgana_string_to_bool(mgana_get_option('sharing_pinterest'))){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="pinterest" title="%2$s"><i class="lastudioicon-b-pinterest"></i></a>',
                esc_url( 'https://pinterest.com/pin/create/button/?url=' . $post_link . '&media=' . $image . '&description=' . $post_title) ,
                esc_attr_x('Share this post on Pinterest', 'front-view', 'mgana')
            );
        }
        if(mgana_string_to_bool(mgana_get_option('sharing_line'))){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="network-line" title="%2$s"><i class="lastudioicon-b-line"></i></a>',
                esc_url( 'https://social-plugins.line.me/lineit/share?url=' . $post_link ),
                esc_attr_x('LINE it!', 'front-view', 'mgana')
            );

        }
        if(mgana_string_to_bool(mgana_get_option('sharing_vk'))){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="vk" title="%2$s"><i class="lastudioicon-b-vkontakte"></i></a>',
                esc_url( 'https://vkontakte.ru/share.php?url=' . $post_link . '&title=' . $post_title ) ,
                esc_attr_x('Share this post on VK', 'front-view', 'mgana')
            );
        }
        if(mgana_string_to_bool(mgana_get_option('sharing_whatapps'))){
            printf('<a href="%1$s" rel="nofollow" class="whatsapp" data-action="share/whatsapp/share" title="%2$s"><i class="lastudioicon-b-whatsapp"></i></a>',
                'whatsapp://send?text=' . esc_attr( $post_title . ' ' . $post_link ),
                esc_attr_x('Share via Whatsapp', 'front-view', 'mgana')
            );
        }
        if(mgana_string_to_bool(mgana_get_option('sharing_telegram'))){
            printf('<a href="%1$s" rel="nofollow" class="telegram" title="%2$s"><i class="lastudioicon-b-telegram"></i></a>',
                esc_attr( add_query_arg(array( 'url' => $post_link, 'text' => $post_title ), 'https://telegram.me/share/url') ),
                esc_attr_x('Share via Telegram', 'front-view', 'mgana')
            );
        }
        if(mgana_string_to_bool(mgana_get_option('sharing_email'))){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="email" title="%2$s"><i class="lastudioicon-mail"></i></a>',
                esc_url( 'mailto:?subject=' . $post_title . '&body=' . $post_link ),
                esc_attr_x('Share this post via Email', 'front-view', 'mgana')
            );
        }
        echo '</span>';
        if(!$echo){
            return ob_get_clean();
        }
    }
}

/**
 * Return the pagination
 */

if ( ! function_exists( 'mgana_the_pagination' ) ) {

    function mgana_the_pagination($args = array(), $query = null) {
        if(null === $query) {
            $query = $GLOBALS['wp_query'];
        }
        if($query->max_num_pages < 2) {
            return;
        }
        $paged        = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
        $pagenum_link = html_entity_decode(get_pagenum_link());
        $wp_rewrite  = $GLOBALS['wp_rewrite'];
        $query_args   = array();
        $url_parts    = explode('?', $pagenum_link);
        if(isset($url_parts[1])) {
            wp_parse_str($url_parts[1], $query_args);
        }

        $pagenum_link = remove_query_arg(array_keys($query_args), $pagenum_link);
        $pagenum_link = trailingslashit($pagenum_link) . '%_%';

        $format  = $wp_rewrite->using_index_permalinks() && ! strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
        $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit('page/%#%', 'paged') : '?paged=%#%';

        $loadmore_html = '<div class="la-ajax-loading-outer"><div class="la-loader spinner3"><div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div><div class="cube1"></div><div class="cube2"></div><div class="cube3"></div><div class="cube4"></div></div></div>';
        $loadmore_html .= '<div class="post__loadmore_ajax pagination_ajax_loadmore"><a href="javascript:;"><span>'.esc_html__('Load More', 'mgana').'</span></a></div>';

        if(!isset($args['pagi_data'])){
            $args['pagi_data'] = array();
        }

        $extra_pagi_data = shortcode_atts(array(
            'class' => '',
            'attr'  => ''
        ), $args['pagi_data']);

        if($paged >= $query->max_num_pages){
            $extra_pagi_data['class'] .= ' nothingtoshow';
        }

        printf('<div class="la-pagination %3$s" %4$s>%1$s%2$s</div>',
            $loadmore_html,
            paginate_links(array_merge(array(
                'base'     => $pagenum_link,
                'format'   => $format,
                'total'    => $query->max_num_pages,
                'current'  => $paged,
                'mid_size' => 1,
                'add_args' => array_map('urlencode', $query_args),
                'prev_text'    => '<i class="lastudioicon-arrow-left"></i>',
                'next_text'    => '<i class="lastudioicon-arrow-right"></i>',
                'type'         => 'list'
            ), $args)),
            $extra_pagi_data['class'],
            $extra_pagi_data['attr']
        );
    }
}

/**
 * Adds post classes
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mgana_blog_wrap_classes' ) ) {

    function mgana_blog_wrap_classes( $classes = NULL ) {

        // Return custom class if set
        if ( $classes ) {
            return $classes;
        }

        // Admin defaults
        $classes = array( 'entries');

        // Add filter for child theming
        $classes = apply_filters( 'mgana/filter/blog_wrap_classes', $classes );

        // Turn classes into space seperated string
        if ( is_array( $classes ) ) {
            $classes = implode( ' ', $classes );
        }

        // Echo classes
        echo esc_attr( $classes );

    }

}

/**
 * Display breadcrumbs
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mgana_has_breadcrumbs' ) ) {

    function mgana_has_breadcrumbs() {

        // Return true by default
        $return = true;

        // Apply filters and return
        return apply_filters( 'mgana/filter/display_breadcrumbs', $return );

    }

}

/**
 * Get excerpt
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mgana_excerpt' ) ) {

    function mgana_excerpt( $length = 30 ) {
        global $post;

        // Check for custom excerpt
        if ( has_excerpt( $post->ID ) ) {
            $output = $post->post_excerpt;
        }
        // No custom excerpt
        else {

            // Check for more tag and return content if it exists
            if ( strpos( $post->post_content, '<!--more-->' ) || strpos( $post->post_content, '<!--nextpage-->' ) ) {
                $output = apply_filters( 'the_content', get_the_content() );
            }

            // No more tag defined
            else {
                $output = wp_trim_words( strip_shortcodes( $post->post_content ), $length );
            }

        }
        return $output;

    }

}

/**
 * Sanitize HTML output
 * @since 1.0.0
 */

if( !function_exists('mgana_render_variable') ) {
    function mgana_render_variable( $variable ) {
        return $variable;
    }
}

if ( ! function_exists( 'mgana_array_filter_recursive' ) ) {

    function mgana_array_filter_recursive($array, $callback = null, $remove_empty_arrays = true) {
        if(!is_scalar($array)){
            foreach ($array as $key => & $value) { // mind the reference
                if (is_array($value)) {
                    $value = mgana_array_filter_recursive($value, $callback, $remove_empty_arrays);
                    if ($remove_empty_arrays && !(bool) $value) {
                        unset($array[$key]);
                    }
                }
                else {
                    if (!is_null($callback) && !call_user_func($callback, $value, $key)) {
                        unset($array[$key]);
                    }
                    elseif ($value == '' || $key == 'unit') {
                        unset($array[$key]);
                    }
                }
            }
            unset($value); // kill the reference
        }
        return $array;
    }

}

/**
 * @param $content
 * @param bool $autop
 * @return string
 */

if ( ! function_exists( 'mgana_transfer_text_to_format' ) ) {
    function mgana_transfer_text_to_format ( $content, $autop = false ) {
        if ( $autop ) {
            $content = preg_replace( '/<\/?p\>/', "\n", $content );
            $content = preg_replace( '/<p[^>]*><\\/p[^>]*>/', "", $content );
            $content = wpautop( $content . "\n" );
        }
        return do_shortcode( shortcode_unautop( $content ) );
    }
}

/**
 * Get Site Layout
 * @return name of layout
 */

if ( ! function_exists( 'mgana_get_site_layout' ) ) {

    function mgana_get_site_layout(){

        $layout = mgana_get_theme_option_by_context('layout', 'col-1c');

        if($layout != '' && !is_active_sidebar(apply_filters('mgana/filter/sidebar_primary_name', 'sidebar'))){
            $layout =  'col-1c';
        }

        return apply_filters('mgana/get_site_layout', $layout);

    }

}

/**
 * Get Header Layout
 * @return name of layout
 */

if ( ! function_exists( 'mgana_get_header_layout' ) ) {

    function mgana_get_header_layout(){

        if( 'default' == get_option('lastudio_header_layout', 'default') ) {
            return 'default';
        }
        return mgana_get_theme_option_by_context('header_layout', 1);

    }

}

if ( ! function_exists( 'mgana_get_page_header_layout' ) ) {

    function mgana_get_page_header_layout(){

        if(is_404()){
            return 'hide';
        }
        return mgana_get_theme_option_by_context('page_title_bar_layout', 'hide');

    }

}

if ( ! function_exists( 'mgana_get_footer_layout' ) ) {

    function mgana_get_footer_layout(){

        return mgana_get_theme_option_by_context('footer_layout', '');

    }

}

if ( !function_exists('mgana_header_classes' ) ) {

    function mgana_header_classes(){

        // Header style
        $header_layout = mgana_get_header_layout();

        // Setup classes array
        $classes = array();

        if ( ! function_exists( 'elementor_location_exits' ) || ! elementor_location_exits( 'header', true ) ) {

            $classes[] = 'lahb-wrap';

            if( 'default' == $header_layout ) {
                $classes[] = 'default-header';
            }

        }

        else{
            $classes[] = 'elm-header-builder';
        }

        // Set keys equal to vals
        $classes = array_combine( $classes, $classes );

        // Apply filters for child theming
        $classes = apply_filters( 'mgana_header_classes', $classes );

        // Turn classes into space seperated string
        $classes = implode( ' ', $classes );

        // return classes
        return $classes;

    }

}

if ( !function_exists('mgana_footer_classes' ) ) {

    function mgana_footer_classes(){

        // Setup classes array
        $classes = array();

        // Default class
        $classes[] = 'site-footer';

        $footer_layout = mgana_get_footer_layout();

        if(!empty($footer_layout) && $footer_layout != 'inherit') {
            $classes[] = 'la-footer-builder';
        }
        else{
            $classes[] = 'site-footer-default';
        }

        // Set keys equal to vals
        $classes = array_combine( $classes, $classes );

        // Apply filters for child theming
        $classes = apply_filters( 'mgana_footer_classes', $classes );

        // Turn classes into space seperated string
        $classes = implode( ' ', $classes );

        // return classes
        return $classes;

    }

}


/**
 * Comments and pingbacks
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mgana_comment' ) ) {

    function mgana_comment( $comment, $args, $depth ) {

        switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' :
                // Display trackbacks differently than normal comments.
                ?>

                <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

                <article id="comment-<?php comment_ID(); ?>" class="comment-container">
                    <p><?php esc_html_e( 'Pingback:', 'mgana' ); ?> <span><span<?php mgana_schema_markup( 'author_name' ); ?>><?php comment_author_link(); ?></span></span> <?php edit_comment_link( esc_html__( '(Edit)', 'mgana' ), '<span class="edit-link">', '</span>' ); ?></p>
                </article>

                <?php
                break;
            default :
                // Proceed with normal comments.
                global $post;
                ?>

            <li id="comment-<?php comment_ID(); ?>" class="comment-container">

                <article <?php comment_class( 'comment-body' ); ?>>

                    <?php echo get_avatar( $comment, apply_filters( 'mgana_comment_avatar_size', 150 ) ); ?>

                    <div class="comment-content-outer">

                        <div class="comment-author">
                            <h3 class="comment-link"><?php printf( esc_html__( '%s ', 'mgana' ), sprintf( '%s', get_comment_author_link() ) ); ?></h3>
                            <span class="comment-meta commentmetadata">
		                    	<span class="comment-date"><?php comment_date('j M Y'); ?></span>
		                    </span>
                        </div>

                        <div class="comment-entry">
                            <?php if ( '0' == $comment->comment_approved ) : ?>
                                <p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'mgana' ); ?></p>
                            <?php endif; ?>

                            <div class="comment-content">
                                <?php comment_text(); ?>
                            </div>

                        </div>
                        <span class="comment-meta commentmetadata">
                            <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                            <?php edit_comment_link(__('edit', 'mgana' )); ?>
                        </span>
                    </div>

                </article><!-- #comment-## -->

                <?php
                break;
        endswitch; // end comment_type check
    }

}

/**
 * Comment fields
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mgana_modify_comment_form_fields' ) ) {

    function mgana_modify_comment_form_fields( $fields ) {

        $commenter = wp_get_current_commenter();
        $req       = get_option( 'require_name_email' );

        $fields['author'] 	= '<div class="comment-form-author"><input type="text" name="author" id="author" value="'. esc_attr( $commenter['comment_author'] ) .'" placeholder="'. esc_attr__( 'Name (required)', 'mgana' ) .'" size="22" tabindex="101"'. ( $req ? ' aria-required="true"' : '' ) .' class="input-name" /></div>';

        $fields['email'] 	= '<div class="comment-form-email"><input type="text" name="email" id="email" value="'. esc_attr( $commenter['comment_author_email'] ) .'" placeholder="'. esc_attr__( 'Email', 'mgana' ) .'" size="22" tabindex="102"'. ( $req ? ' aria-required="true"' : '' ) .' class="input-email" /></div>';

        $fields['url'] 		= '<div class="comment-form-url"><input type="text" name="url" id="url" value="'. esc_attr( $commenter['comment_author_url'] ) .'" placeholder="'. esc_attr__( 'Website', 'mgana' ) .'" size="22" tabindex="103" class="input-website" /></div>';

        return $fields;

    }

    add_filter( 'comment_form_default_fields', 'mgana_modify_comment_form_fields' );

}

/**
 * String to boolean
 */
if(!function_exists('mgana_string_to_bool')){
    function mgana_string_to_bool( $string ){
        return is_bool( $string ) ? $string : ( 'yes' === $string || 'on' === $string || 1 === $string || 'true' === $string || '1' === $string );
    }
}
/**
 * Get list image sizes of WordPress
 *
 * @return array
 */

if(!function_exists('mgana_get_list_image_sizes')){

    function mgana_get_list_image_sizes() {

        global $_wp_additional_image_sizes;

        $sizes  = get_intermediate_image_sizes();
        $result = array();


        foreach ( $sizes as $size ) {
            if ( in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
                $result[ $size ] = ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) );
            }
            else {
                $result[ $size ] = sprintf(
                    '%1$s (%2$sx%3$s)',
                    ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) ),
                    $_wp_additional_image_sizes[ $size ]['width'],
                    $_wp_additional_image_sizes[ $size ]['height']
                );
            }
        }

        return array_merge( array( 'full' => esc_html__( 'Full', 'mgana' ), ), $result );
    }
}
/**
 * Get social HTML
 */

if(!function_exists('mgana_get_member_social_tpl')){
    function mgana_get_member_social_tpl( $post_id ) {
        $output = '<div class="item--social member-social">';
        if(($facebook = mgana_get_post_meta($post_id, 'facebook')) && !empty($facebook)){
            $output .= sprintf('<a class="social-facebook facebook" href="%s"><i class="lastudioicon-b-facebook"></i></a>', esc_url($facebook));
        }
        if(($twitter = mgana_get_post_meta($post_id, 'twitter')) && !empty($twitter)){
            $output .= sprintf('<a class="social-twitter twitter" href="%s"><i class="lastudioicon-b-twitter"></i></a>', esc_url($twitter));
        }
        if(($pinterest = mgana_get_post_meta($post_id, 'pinterest')) && !empty($pinterest)){
            $output .= sprintf('<a class="social-pinterest pinterest" href="%s"><i class="lastudioicon-b-pinterest"></i></a>', esc_url($pinterest));
        }
        if(($linkedin = mgana_get_post_meta($post_id, 'linkedin')) && !empty($linkedin)){
            $output .= sprintf('<a class="social-linkedin linkedin" href="%s"><i class="lastudioicon-b-linkedin"></i></a>', esc_url($linkedin));
        }
        if(($dribbble = mgana_get_post_meta($post_id, 'dribbble')) && !empty($dribbble)){
            $output .= sprintf('<a class="social-dribbble dribbble" href="%s"><i class="lastudioicon-b-dribbble"></i></a>', esc_url($dribbble));
        }
        if(($youtube = mgana_get_post_meta($post_id, 'youtube')) && !empty($youtube)){
            $output .= sprintf('<a class="social-youtube youtube" href="%s"><i class="lastudioicon-b-youtube-play"></i></a>', esc_url($youtube));
        }
        if(($email = mgana_get_post_meta($post_id, 'email')) && !empty($email)){
            $output .= sprintf('<a class="social-email email" href="%s"><i class="lastudioicon-mail"></i></a>', esc_url('mailto:'.$email));
        }
        $output .= '</div>';

        return $output;
    }
}

if(!function_exists('mgana_entry_meta_item_category_list')){
    function mgana_entry_meta_item_category_list($before = '', $after = '', $separator = ', ', $parents = '', $post_id = false){
        add_filter('get_the_terms', 'mgana_exclude_demo_term_in_category');
        $categories_list = get_the_category_list('{{_}}', $parents, $post_id );
        mgana_deactive_filter('get_the_terms', 'mgana_exclude_demo_term_in_category');
        if ( $categories_list ) {
            printf(
                '%3$s<span class="screen-reader-text">%1$s </span><span>%2$s</span>%4$s',
                esc_html_x('Posted in', 'front-view', 'mgana'),
                str_replace('{{_}}', $separator, $categories_list),
                $before,
                $after
            );
        }
    }
}

if(!function_exists('mgana_exclude_demo_term_in_category')){
    function mgana_exclude_demo_term_in_category( $term ){
        return apply_filters('mgana/post_category_excluded', $term);
    }
}

if(!function_exists('mgana_deactive_filter')){
    function mgana_deactive_filter( $tag, $function_to_remove, $priority = 10) {
        return call_user_func('remove_filter', $tag, $function_to_remove, $priority );
    }
}

if(!function_exists('mgana_render_responsive_main_space_options')){
    function mgana_render_responsive_main_space_options( $default = array() ) {
        return wp_parse_args( $default, array(
            'type'  => 'tabbed',
            'class' => 'lasf-responsive-tabs',
            'tabs'  => array(
                array(
                    'title'  => esc_html_x('Mobile', 'admin-view', 'mgana'),
                    'icon'   => 'dashicons dashicons-smartphone',
                    'fields' => array(
                        array(
                            'id'    => 'mobile',
                            'type'  => 'spacing',
                            'left'  => false,
                            'right' => false,
                            'class' => 'lasf-field-fullwidth'
                        )
                    )
                ),

                array(
                    'title'  => esc_html_x('Mobile Landscape', 'admin-view', 'mgana'),
                    'icon'   => 'dashicons dashicons-smartphone fa-rotate-90',
                    'fields' => array(
                        array(
                            'id'    => 'mobile_landscape',
                            'type'  => 'spacing',
                            'left'  => false,
                            'right' => false,
                            'class' => 'lasf-field-fullwidth'
                        )
                    ),
                ),
                array(
                    'title'  => esc_html_x('Tablet', 'admin-view', 'mgana'),
                    'icon'   => 'dashicons dashicons-tablet fa-rotate-90',
                    'fields' => array(
                        array(
                            'id'    => 'tablet',
                            'type'  => 'spacing',
                            'left'  => false,
                            'right' => false,
                            'class' => 'lasf-field-fullwidth'
                        )
                    ),
                ),

                array(
                    'title'  => esc_html_x('Laptop', 'admin-view', 'mgana'),
                    'icon'   => 'dashicons dashicons-desktop',
                    'fields' => array(
                        array(
                            'id'    => 'laptop',
                            'type'  => 'spacing',
                            'left'  => false,
                            'right' => false,
                            'class' => 'lasf-field-fullwidth'
                        )
                    ),
                ),

                array(
                    'title'  => esc_html_x('Desktop', 'admin-view', 'mgana'),
                    'icon'   => 'fa fa-desktop',
                    'fields' => array(
                        array(
                            'id'    => 'desktop',
                            'type'  => 'spacing',
                            'left'  => false,
                            'right' => false,
                            'class' => 'lasf-field-fullwidth'
                        )
                    ),
                )
            )
        ) );
    }
}

if(!function_exists('mgana_render_responsive_font_size_options')){
    function mgana_render_responsive_font_size_options( $default = array() ) {
        return wp_parse_args( $default,  array(
            'type'              => 'tabbed',
            'class'             => 'lasf-responsive-tabs',
            'tabs'              => array(

                array(
                    'title'  => esc_html_x('Mobile', 'admin-view', 'mgana'),
                    'icon'   => 'dashicons dashicons-smartphone',
                    'fields' => array(
                        array(
                            'id'            => 'mobile',
                            'type'          => 'typography',
                            'class'         => 'lasf-field-fullwidth',
                            'font_family'   => false,
                            'font_weight'   => false,
                            'font_style'    => false,
                            'text_align'    => false,
                            'text_transform'=> false,
                            'color'         => false,
                            'preview'       => false
                        )
                    ),
                ),

                array(
                    'title'  => esc_html_x('Mobile Landscape', 'admin-view', 'mgana'),
                    'icon'   => 'dashicons dashicons-smartphone fa-rotate-90',
                    'fields' => array(
                        array(
                            'id'            => 'mobile_landscape',
                            'type'          => 'typography',
                            'class'         => 'lasf-field-fullwidth',
                            'font_family'   => false,
                            'font_weight'   => false,
                            'font_style'    => false,
                            'text_align'    => false,
                            'text_transform'=> false,
                            'color'         => false,
                            'preview'       => false
                        )
                    ),
                ),

                array(
                    'title'  => esc_html_x('Tablet', 'admin-view', 'mgana'),
                    'icon'   => 'dashicons dashicons-tablet fa-rotate-90',
                    'fields' => array(
                        array(
                            'id'            => 'tablet',
                            'type'          => 'typography',
                            'class'         => 'lasf-field-fullwidth',
                            'font_family'   => false,
                            'font_weight'   => false,
                            'font_style'    => false,
                            'text_align'    => false,
                            'text_transform'=> false,
                            'color'         => false,
                            'preview'       => false
                        )
                    ),
                ),

                array(
                    'title'  => esc_html_x('Laptop', 'admin-view', 'mgana'),
                    'icon'   => 'dashicons dashicons-desktop',
                    'fields' => array(
                        array(
                            'id'            => 'laptop',
                            'type'          => 'typography',
                            'class'         => 'lasf-field-fullwidth',
                            'font_family'   => false,
                            'font_weight'   => false,
                            'font_style'    => false,
                            'text_align'    => false,
                            'text_transform'=> false,
                            'color'         => false,
                            'preview'       => false
                        )
                    ),
                ),

                array(
                    'title'  => esc_html_x('Desktop', 'admin-view', 'mgana'),
                    'icon'   => 'fa fa-desktop',
                    'fields' => array(
                        array(
                            'id'            => 'desktop',
                            'type'          => 'typography',
                            'class'         => 'lasf-field-fullwidth',
                            'font_family'   => false,
                            'font_weight'   => false,
                            'font_style'    => false,
                            'text_align'    => false,
                            'text_transform'=> false,
                            'color'         => false,
                            'preview'       => false
                        )
                    ),
                )
            )
        ) );
    }
}

if(!function_exists('mgana_render_responsive_column_options')){
    function mgana_render_responsive_column_options( $default = array() ){
        return wp_parse_args( $default, array(
            'class'         => 'lasf-responsive-tabs lasf-responsive-column-tabs',
            'type'          => 'tabbed',
            'tabs'          => array(

                array(
                    'title'  => esc_html_x('Mobile', 'admin-view', 'mgana'),
                    'icon'   => 'dashicons dashicons-smartphone',
                    'fields' => array(
                        array(
                            'id'          => 'mobile',
                            'type'        => 'select',
                            'class'       => 'lasf-field-fullwidth',
                            'options'     => array(
                                '1'  => 1,
                                '2'  => 2,
                                '3'  => 3,
                                '4'  => 4,
                                '5'  => 5,
                                '6'  => 6,
                            ),
                            'default'     => 1
                        )
                    ),
                ),

                array(
                    'title'  => esc_html_x('Mobile Landscape', 'admin-view', 'mgana'),
                    'icon'   => 'dashicons dashicons-smartphone fa-rotate-90',
                    'fields' => array(
                        array(
                            'id'          => 'mobile_landscape',
                            'type'        => 'select',
                            'class'       => 'lasf-field-fullwidth',
                            'options'     => array(
                                '1'  => 1,
                                '2'  => 2,
                                '3'  => 3,
                                '4'  => 4,
                                '5'  => 5,
                                '6'  => 6,
                            ),
                            'default'     => 1
                        )
                    ),
                ),

                array(
                    'title'  => esc_html_x('Tablet', 'admin-view', 'mgana'),
                    'icon'   => 'dashicons dashicons-tablet fa-rotate-90',
                    'fields' => array(
                        array(
                            'id'          => 'tablet',
                            'type'        => 'select',
                            'class'       => 'lasf-field-fullwidth',
                            'options'     => array(
                                '1'  => 1,
                                '2'  => 2,
                                '3'  => 3,
                                '4'  => 4,
                                '5'  => 5,
                                '6'  => 6,
                            ),
                            'default'     => 1
                        )
                    ),
                ),

                array(
                    'title'  => esc_html_x('Laptop', 'admin-view', 'mgana'),
                    'icon'   => 'dashicons dashicons-desktop',
                    'fields' => array(
                        array(
                            'id'          => 'laptop',
                            'type'        => 'select',
                            'class'       => 'lasf-field-fullwidth',
                            'options'     => array(
                                '1'  => 1,
                                '2'  => 2,
                                '3'  => 3,
                                '4'  => 4,
                                '5'  => 5,
                                '6'  => 6,
                            ),
                            'default'     => 1
                        )
                    ),
                ),

                array(
                    'title'  => esc_html_x('Desktop', 'admin-view', 'mgana'),
                    'icon'   => 'fa fa-desktop',
                    'fields' => array(
                        array(
                            'id'          => 'desktop',
                            'type'        => 'select',
                            'class'       => 'lasf-field-fullwidth',
                            'options'     => array(
                                '1'  => 1,
                                '2'  => 2,
                                '3'  => 3,
                                '4'  => 4,
                                '5'  => 5,
                                '6'  => 6,
                            ),
                            'default'     => 1
                        ),
                    ),
                )
            )
        ) );
    }
}

if(!function_exists('mgana_render_responsive_item_space_options')){
    function mgana_render_responsive_item_space_options( $default = array(), $css_output = array() ) {

        $mobile = isset($css_output['mobile']) ? $css_output['mobile'] : array();
        $mobile_landscape = isset($css_output['mobile_landscape']) ? $css_output['mobile_landscape'] : array();
        $tablet = isset($css_output['tablet']) ? $css_output['tablet'] : array();
        $laptop = isset($css_output['laptop']) ? $css_output['laptop'] : array();
        $desktop = isset($css_output['desktop']) ? $css_output['desktop'] : array();

        return wp_parse_args( $default, array(
            'type'          => 'tabbed',
            'class'         => 'lasf-responsive-tabs',
            'tabs'          => array(

                array(
                    'title'  => esc_html_x('Mobile', 'admin-view', 'mgana'),
                    'icon'   => 'dashicons dashicons-smartphone',
                    'fields' => array(
                        array(
                            'id'    => 'mobile',
                            'type'  => 'spacing',
                            'class' => 'lasf-field-fullwidth',
                            'units' => array('px'),
                            'selectors' => $mobile
                        )
                    ),
                ),

                array(
                    'title'  => esc_html_x('Mobile Landscape', 'admin-view', 'mgana'),
                    'icon'   => 'dashicons dashicons-smartphone fa-rotate-90',
                    'fields' => array(
                        array(
                            'id'    => 'mobile_landscape',
                            'type'  => 'spacing',
                            'class' => 'lasf-field-fullwidth',
                            'units' => array('px'),
                            'selectors' => $mobile_landscape
                        )
                    ),
                ),

                array(
                    'title'  => esc_html_x('Tablet', 'admin-view', 'mgana'),
                    'icon'   => 'dashicons dashicons-tablet fa-rotate-90',
                    'fields' => array(
                        array(
                            'id'    => 'tablet',
                            'type'  => 'spacing',
                            'class' => 'lasf-field-fullwidth',
                            'units' => array('px'),
                            'selectors' => $tablet
                        )
                    ),
                ),

                array(
                    'title'  => esc_html_x('Laptop', 'admin-view', 'mgana'),
                    'icon'   => 'dashicons dashicons-desktop',
                    'fields' => array(
                        array(
                            'id'    => 'laptop',
                            'type'  => 'spacing',
                            'class' => 'lasf-field-fullwidth',
                            'units' => array('px'),
                            'selectors' => $laptop
                        )
                    ),
                ),
                array(
                    'title'  => esc_html_x('Desktop', 'admin-view', 'mgana'),
                    'icon'   => 'fa fa-desktop',
                    'fields' => array(
                        array(
                            'id'    => 'desktop',
                            'type'  => 'spacing',
                            'class' => 'lasf-field-fullwidth',
                            'units' => array('px'),
                            'selectors' => $desktop
                        )
                    ),
                ),
            ),
        ) );
    }
}

if(!function_exists('mgana_options_section_page_title_bar_auto_detect')){
    function mgana_options_section_page_title_bar_auto_detect( $key = 'default', $inherit = false ) {

        $base_options = array();

        $subtitle_for_default   = esc_html_x('For page header bar', 'admin-view', 'mgana');

        $key_allows = array(
            'default' => array(
                'key' => '',
                'subtitle' => $subtitle_for_default,
            ),
            'woocommerce' => array(
                'key' => 'woo_',
                'subtitle' => '['. esc_html_x('WooCommerce', 'admin-view', 'mgana') .'] ' . $subtitle_for_default,
                'override_subtitle' => esc_html_x('Turn on to override all setting page header bar of WooCommerce Settings ( Shop page / Product Category / Product Tags and Search page )', 'admin-view', 'mgana'),
                'override_info' => esc_html_x('This option will not work with these pages were overwritten', 'admin-view', 'mgana'),
            ),
            'single_product' => array(
                'key' => 'single_product_',
                'subtitle' => '['. esc_html_x('Single Product', 'admin-view', 'mgana') .'] ' . $subtitle_for_default,
                'override_subtitle' => esc_html_x('Turn on to override all setting page header bar of Single Product', 'admin-view', 'mgana'),
                'override_info' => esc_html_x('This option will not work with these pages were overwritten', 'admin-view', 'mgana'),
            ),
            'single_post' => array(
                'key' => 'single_post_',
                'subtitle' => '['. esc_html_x('Single Post', 'admin-view', 'mgana') .'] ' . $subtitle_for_default,
                'override_subtitle' => esc_html_x('Turn on to override all setting page header bar of Post pages', 'admin-view', 'mgana'),
                'override_info' => esc_html_x('This option will not work with these pages were overwritten', 'admin-view', 'mgana'),
            ),
            'blog_post' => array(
                'key' => 'blog_post_',
                'subtitle' => '['. esc_html_x('Blog Post', 'admin-view', 'mgana') .'] ' . $subtitle_for_default,
                'override_subtitle' => esc_html_x('Turn on to override all setting page header bar of Blog/Tag/Category pages', 'admin-view', 'mgana'),
                'override_info' => esc_html_x('This option will not work with these pages were overwritten', 'admin-view', 'mgana'),
            ),
            'archive_portfolio' => array(
                'key' => 'archive_portfolio_',
                'subtitle' => '['. esc_html_x('Archive Portfolio', 'admin-view', 'mgana') .'] ' . $subtitle_for_default,
                'override_subtitle' => esc_html_x('Turn on to override all setting page header bar of Archive Portfolio', 'admin-view', 'mgana'),
                'override_info' => esc_html_x('This option will not work with these pages were overwritten', 'admin-view', 'mgana'),
            ),
            'single_portfolio' => array(
                'key' => 'single_portfolio_',
                'subtitle' => '['. esc_html_x('Single Portfolio', 'admin-view', 'mgana') .'] ' . $subtitle_for_default,
                'override_subtitle' => esc_html_x('Turn on to override all setting page header bar of Single Portfolio', 'admin-view', 'mgana'),
                'override_info' => esc_html_x('This option will not work with these pages were overwritten', 'admin-view', 'mgana'),
            )
        );

        if(!array_key_exists($key, $key_allows)){
            return $base_options;
        }

        $subtitle = $key_allows[$key]['subtitle'];

        $dependency = array();
        $dependency_root = array();

        if($key != 'default'){
            $dependency_root = array(
                $key_allows[$key]['key'] . 'override_page_title_bar', '==', 'on'
            );
            $dependency = array($key_allows[$key]['key'] . 'override_page_title_bar|'.$key_allows[$key]['key'].'page_title_bar_layout', '==|!=', 'on|hide');
        }

        $layout_options = array( 'hide' => esc_html_x('Do not display', 'admin-view', 'mgana') ) + Mgana_Options::get_config_page_title_bar_opts(false);

        if($inherit){
            $layout_options = array(
                    'inherit' => esc_html_x('Inherit', 'admin-view', 'mgana'),
                    'hide' => esc_html_x('Do not display', 'admin-view', 'mgana'),
                ) + Mgana_Options::get_config_page_title_bar_opts(false);
            $subtitle = '';
            $dependency = array('page_title_bar_layout|page_title_bar_style', '!=|==' , 'hide|yes');

        }

        $base_options = array(
            array(
                'id'            => $key_allows[$key]['key'] . 'page_title_bar_layout',
                'type'          => 'select',
                'title'         => esc_html_x('Select Layout', 'admin-view', 'mgana'),
                'options'       => $layout_options,
                'subtitle'      => $subtitle,
                'dependency'    => $dependency_root
            ),

            array(
                'id'                    => $key_allows[$key]['key'] . 'page_title_bar_border',
                'type'                  => 'border',
                'title'                 => esc_html_x('Page Header Border', 'admin-view', 'mgana'),
                'subtitle'              => $subtitle,
                'dependency'            => $dependency
            ),

            array(
                'id'                    => $key_allows[$key]['key'] . 'page_title_bar_background',
                'type'                  => 'background',
                'title'                 => esc_html_x('Page Header Background', 'admin-view', 'mgana'),
                'background_color'      => true,
                'background_image'      => true,
                'background-position'   => true,
                'background_repeat'     => true,
                'background_attachment' => true,
                'background_size'       => true,
                'background_origin'     => true,
                'background_clip'       => true,
                'background_blend_mode' => true,
                'background_gradient'   => true,
                'subtitle'              => $subtitle,
                'dependency'            => $dependency
            ),

            mgana_render_responsive_main_space_options(array(
                'id'                    => $key_allows[$key]['key'] . 'page_title_bar_space',
                'title'                 => esc_html_x('Page Header Spacing', 'admin-view', 'mgana'),
                'subtitle'              => $subtitle,
                'dependency'            => $dependency,
            )),

            array(
                'id'                => $key_allows[$key]['key'] . 'page_title_bar_heading_fonts',
                'type'              => 'typography',
                'title'             => esc_html_x('Heading Fonts', 'admin-view', 'mgana'),
                'text_align'        => false,
                'color'             => false,
                'extra_styles'      => true,
                'responsive'        => true,
                'subtitle'          => $subtitle,
                'dependency'        => $dependency
            ),

            array(
                'id'                => $key_allows[$key]['key'] . 'page_title_bar_breadcrumb_fonts',
                'type'              => 'typography',
                'title'             => esc_html_x('Breadcrumb Fonts', 'admin-view', 'mgana'),
                'text_align'        => false,
                'color'             => false,
                'extra_styles'      => true,
                'responsive'        => true,
                'subtitle'          => $subtitle,
                'dependency'        => $dependency
            ),

            array(
                'id'            => $key_allows[$key]['key'] . 'page_title_bar_heading_color',
                'default'       => Mgana_Options::get_color_default('heading_color'),
                'type'          => 'color',
                'title'         => esc_html_x('Heading Color', 'admin-view', 'mgana'),
                'subtitle'      => $subtitle,
                'dependency'    => $dependency
            ),

            array(
                'id'            => $key_allows[$key]['key'] . 'page_title_bar_text_color',
                'default'       => Mgana_Options::get_color_default('text_color'),
                'type'          => 'color',
                'title'         => esc_html_x('Text Color', 'admin-view', 'mgana'),
                'subtitle'      => $subtitle,
                'dependency'    => $dependency
            ),

            array(
                'id'            => $key_allows[$key]['key'] . 'page_title_bar_link_color',
                'default'       => Mgana_Options::get_color_default('text_color'),
                'type'          => 'color',
                'title'         => esc_html_x('Link Color', 'admin-view', 'mgana'),
                'subtitle'      => $subtitle,
                'dependency'    => $dependency
            ),

            array(
                'id'            => $key_allows[$key]['key'] . 'page_title_bar_link_hover_color',
                'default'       => Mgana_Options::get_color_default('text_color'),
                'type'          => 'color',
                'title'         => esc_html_x('Link Hover Color', 'admin-view', 'mgana'),
                'subtitle'      => $subtitle,
                'dependency'    => $dependency
            ),
        );

        if($key != 'default'){
            array_unshift($base_options, array(
                'id'            => $key_allows[$key]['key'] . 'override_page_title_bar',
                'type'          => 'button_set',
                'default'       => 'off',
                'title'         => esc_html_x('Enable Override', 'admin-view', 'mgana'),
                'subtitle'      => $key_allows[$key]['override_subtitle'],
                'desc'          => $key_allows[$key]['override_info'],
                'options'       => Mgana_Options::get_config_radio_onoff(false)
            ));
        }

        if($key == 'default' && !$inherit){
            array_unshift($base_options, array(
                'id'            => $key_allows[$key]['key'] . 'page_title_bar_heading_tag',
                'type'          => 'select',
                'default'       => 'h1',
                'title'         => esc_html_x('Heading Tag', 'admin-view', 'mgana'),
                'options'       => array(
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p'
                )
            ));
        }

        return $base_options;

    }
}

if(!function_exists('mgana_get_responsive_columns')){
    function mgana_get_responsive_columns( $key = '', $default = array()){
        $value = mgana_get_option($key, $default);
        $columns = wp_parse_args( $value, array(
            'mobile' => 1,
            'mobile_landscape' => 1,
            'tablet' => 1,
            'laptop' => 1,
            'desktop' => 1
        ) );
        return array(
            'xs' => intval($columns['mobile']),
            'sm' => intval($columns['mobile_landscape']),
            'md' => intval($columns['mobile_landscape']),
            'lg' => intval($columns['tablet']),
            'xl' => intval($columns['laptop']),
            'xxl' => intval($columns['desktop'])
        );

    }
}

if(!function_exists('mgana_get_responsive_column_classes')){
    function mgana_get_responsive_column_classes( $key = '', $default = array()){
        $value = mgana_get_option($key, $default);
        $columns = wp_parse_args( $value, array(
            'mobile' => '',
            'mobile_landscape' => '',
            'tablet' => '',
            'laptop' => '',
            'desktop' => ''
        ) );

        $replaces = array(
            'mobile' => 'xmobile-block-grid',
            'mobile_landscape' => 'mobile-block-grid',
            'tablet' => 'tablet-block-grid',
            'laptop' => 'laptop-block-grid',
            'desktop' => 'block-grid'
        );

        $classes = array();

        foreach ( $columns as $device => $cols ) {
            if ( ! empty( $cols ) ) {
                $classes[] = sprintf( '%1$s-%2$s', $replaces[$device], $cols );
            }
        }
        return implode( ' ' , $classes );
    }
}

if(!function_exists('mgana_minify_css')){
    function mgana_minify_css( $css = '' ){
        return $css;
    }
}

if(!function_exists('mgana_render_border_style_from_setting')){
    function mgana_render_border_style_from_setting( $value, $element = '' ){
        $output    = '';
        $unit      = ( ! empty( $value['unit'] ) ) ? $value['unit'] : 'px';

        // properties
        $top     = ( isset( $value['top'] )    && $value['top']    !== '' ) ? $value['top']    : '';
        $right   = ( isset( $value['right'] )  && $value['right']  !== '' ) ? $value['right']  : '';
        $bottom  = ( isset( $value['bottom'] ) && $value['bottom'] !== '' ) ? $value['bottom'] : '';
        $left    = ( isset( $value['left'] )   && $value['left']   !== '' ) ? $value['left']   : '';
        $style   = ( isset( $value['style'] )  && $value['style']  !== '' ) ? $value['style']  : '';
        $color   = ( isset( $value['color'] )  && $value['color']  !== '' ) ? $value['color']  : '';

        if( $top !== '' || $right !== '' || $bottom !== '' || $left !== '' || $color !== '' ) {

            $output .= ( $top    !== '' ) ? 'border-top-width:'. $top . $unit .';'       : '';
            $output .= ( $right  !== '' ) ? 'border-right-width:'. $right . $unit .';'   : '';
            $output .= ( $bottom !== '' ) ? 'border-bottom-width:'. $bottom . $unit .';' : '';
            $output .= ( $left   !== '' ) ? 'border-left-width:'. $left . $unit .';'     : '';
            $output .= ( $color  !== '' ) ? 'border-color:'. $color .';'                 : '';
            $output .= ( $style  !== '' ) ? 'border-style:'. $style .';'                 : '';

        }

        if( $output && $element) {
            $output = $element .'{'. $output .'}';
        }

        return $output;
    }
}

if(!function_exists('mgana_render_background_style_from_setting')){
    function mgana_render_background_style_from_setting( $value, $element = '' ){
        $output = '';
        // Background image and gradient
        $background_color        = ( ! empty( $value['background-color']              ) ) ? $value['background-color']              : '';
        $background_gd_color     = ( ! empty( $value['background-gradient-color']     ) ) ? $value['background-gradient-color']     : '';
        $background_gd_direction = ( ! empty( $value['background-gradient-direction'] ) ) ? $value['background-gradient-direction'] : '';
        $background_image        = ( ! empty( $value['background-image']['url']       ) ) ? $value['background-image']['url']       : '';

        if( $background_color && $background_gd_color ) {
            $gd_direction   = ( $background_gd_direction ) ? $background_gd_direction .',' : '';
            $bg_image[] = 'linear-gradient('. $gd_direction . $background_color .','. $background_gd_color .')';
        }

        if( $background_image ) {
            $bg_image[] = 'url("'. esc_url($background_image) .'")';
        }

        if( ! empty( $bg_image ) ) {
            $output .= 'background-image:'. implode( ',', $bg_image ) .';';
        }

        // Common background properties
        $properties = array( 'color', 'position', 'repeat', 'attachment', 'size', 'origin', 'clip', 'blend-mode' );

        foreach( $properties as $property ) {
            $property = 'background-'. $property;
            if( ! empty( $value[$property] ) ) {
                $output .= $property .':'. $value[$property] .';';
            }
        }

        if( $output && $element) {
            $output = $element .'{'. $output .'}';
        }

        return $output;
    }
}

if(!function_exists('mgana_render_typography_style_from_setting')){
    function mgana_render_typography_style_from_setting( $value,  $element = '', $screen = 'mobile' ){

        $output    = '';

        if($screen == 'mobile') {
            $font_family = (!empty($value['font-family'])) ? $value['font-family'] : '';
            $backup_family = (!empty($value['backup-font-family'])) ? ', ' . $value['backup-font-family'] : '';
            if ($font_family) {
                $output .= 'font-family:"' . $font_family . '"' . $backup_family . ';';
            }
            // Common font properties
            $properties = array(
                'color',
                'font-weight',
                'font-style',
                'font-variant',
                'text-align',
                'text-transform',
                'text-decoration',
            );
            foreach ($properties as $property) {
                if (isset($value[$property]) && $value[$property] !== '') {
                    $output .= $property . ':' . $value[$property] . ';';
                }
            }
        }

        $properties = array(
            'font-size',
            'line-height',
            'letter-spacing',
            'word-spacing',
        );

        $unit = ( ! empty( $value['unit'] ) ) ? $value['unit'] : '';

        if( isset($value['responsive']) && mgana_string_to_bool($value['responsive']) ){
            foreach( $properties as $property ) {
                if( isset( $value[$property][$screen] ) && $value[$property][$screen] !== '' ) {
                    $output .= $property .':'. $value[$property][$screen] . $unit .';';
                }
            }
        }
        else{
            foreach( $properties as $property ) {
                if( isset( $value[$property] ) && $value[$property] !== '' ) {
                    $output .= $property .':'. $value[$property] . $unit .';';
                }
            }
        }

        $custom_style = '';

        if($screen == 'mobile'){
            $custom_style = ( ! empty( $value['custom-style'] ) ) ? $value['custom-style'] : '';
        }

        if( $output && $element ) {
            $output = $element .'{'. $output . $custom_style .'}';
        }


        return $output;
    }
}


/**
 * Store current post ID
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'mgana_post_id' ) ) {

    function mgana_post_id() {

        // Default value
        $id = '';

        // If singular get_the_ID
        if ( is_singular() ) {
            $id = get_the_ID();
        }

        // Get ID of WooCommerce product archive
        elseif ( function_exists('is_shop') && is_shop() ) {
            $shop_id = wc_get_page_id( 'shop' );
            if ( isset( $shop_id ) ) {
                $id = $shop_id;
            }
        }

        // Posts page
        elseif ( is_home() && $page_for_posts = get_option( 'page_for_posts' ) ) {
            $id = $page_for_posts;
        }

        // Apply filters
        $id = apply_filters( 'mgana/filter/current_post_id', $id );

        // Sanitize
        $id = $id ? $id : '';

        // Return ID
        return $id;

    }

}

/**
 * Return the title
 *
 * @since 1.0.0
 */
if(!function_exists('mgana_title')){
    function mgana_title(){
        // Default title is null
        $title = NULL;

        // Get post ID
        $post_id = mgana_post_id();

        // Homepage - display blog description if not a static page
        if ( is_front_page() && ! is_singular( 'page' ) ) {

            if ( get_bloginfo( 'description' ) ) {
                $title = get_bloginfo( 'description' );
            } else {
                return esc_html__( 'Recent Posts', 'mgana' );
            }

            // Homepage posts page
        } elseif ( is_home() && ! is_singular( 'page' ) ) {

            $title = get_the_title( get_option( 'page_for_posts', true ) );

        }

        // Search needs to go before archives
        elseif ( is_search() ) {
            global $wp_query;
            $title = '<span id="search-results-count">'. $wp_query->found_posts .'</span> '. esc_html__( 'Search Results Found', 'mgana' );
        }

        // Archives
        elseif ( is_archive() ) {

            // Author
            if ( is_author() ) {
                $title = get_the_archive_title();
            }

            // Post Type archive title
            elseif ( is_post_type_archive() ) {
                $title = post_type_archive_title( '', false );
                if(function_exists('is_shop') && is_shop()){
                    $shop_id = wc_get_page_id( 'shop' );
                    $title = get_the_title( $shop_id );
                }
            }

            // Daily archive title
            elseif ( is_day() ) {
                $title = sprintf( esc_html__( 'Daily Archives: %s', 'mgana' ), get_the_date() );
            }

            // Monthly archive title
            elseif ( is_month() ) {
                $title = sprintf( esc_html__( 'Monthly Archives: %s', 'mgana' ), get_the_date( esc_html_x( 'F Y', 'Page title monthly archives date format', 'mgana' ) ) );
            }

            // Yearly archive title
            elseif ( is_year() ) {
                $title = sprintf( esc_html__( 'Yearly Archives: %s', 'mgana' ), get_the_date( esc_html_x( 'Y', 'Page title yearly archives date format', 'mgana' ) ) );
            }

            // Categories/Tags/Other
            else {

                // Get term title
                $title = single_term_title( '', false );

                // Fix for plugins that are archives but use pages
                if ( ! $title ) {
                    global $post;
                    $title = get_the_title( $post_id );
                }

            }

        } // End is archive check

        // 404 Page
        elseif ( is_404() ) {

            $title = esc_html__( '404: Page Not Found', 'mgana' );

        }

        // Anything else with a post_id defined
        elseif ( $post_id ) {

            // Single Pages
            if ( is_singular( 'page' ) || is_singular( 'attachment' ) ) {
                $title = get_the_title( $post_id );
            }

            // Single blog posts
            elseif ( is_singular( 'post' ) ) {

                if ( 'post-title' == mgana_get_option( 'blog_post_page_title', 'blog' ) ) {
                    $title = get_the_title();
                } else {
                    $title = esc_html__( 'Blog', 'mgana' );
                }

            }

            // Other posts
            else {

                $title = get_the_title( $post_id );

            }

        }
        // Last check if title is empty
        $title = $title ? $title : get_the_title();

        // Apply filters and return title
        return apply_filters( 'mgana/filter/current_title', $title );
    }
}

/**
 * Render single post format content
 */

if(!function_exists('mgana_single_post_thumbnail')){
    function mgana_single_post_thumbnail( $thumbnail_size = 'full' ) {
        if ( post_password_required() || is_attachment() ) {
            return;
        }
        $flag_format_content = false;

        $image_schema_markup = mgana_get_schema_markup('image');

        switch(get_post_format()){
            case 'link':
                $link = mgana_get_post_meta( get_the_ID(), 'format_link' );
                if(!empty($link)){
                    printf(
                        '<div class="post-thumbnail format-link la-lazyload-image" data-background-image="%2$s"><div class="blog_item--thumbnail"><div class="format-content">%1$s</div><a class="post-link-overlay" href="%1$s"></a></div></div>',
                        esc_url($link),
                        has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), $thumbnail_size) : ''
                    );
                    $flag_format_content = true;
                }
                break;
            case 'quote':
                $quote_content = mgana_get_post_meta(get_the_ID(), 'format_quote_content');
                $quote_author = mgana_get_post_meta(get_the_ID(), 'format_quote_author');
                $quote_background = mgana_get_post_meta(get_the_ID(), 'format_quote_background');
                $quote_color = mgana_get_post_meta(get_the_ID(), 'format_quote_color');
                if(has_post_thumbnail() && !empty($quote_content)) {
                    echo '<div class="post-thumbnail single_post_quote_wrap"><div class="blog_item--thumbnail">';
                    the_post_thumbnail($thumbnail_size);
                    $quote_content = '<p class="quote-content">' . $quote_content . '</p>';
                    if ( !empty( $quote_author ) ) {
                        $quote_content .= '<span class="quote-author">' . $quote_author . '</span>';
                    }
                    $styles = array();
                    $styles[] = 'background-color:' . $quote_background;
                    $styles[] = 'color:' . $quote_color;
                    echo sprintf( '<div class="quote-wrapper" style="%2$s"><div class="format-content">%1$s</div></div>', $quote_content, esc_attr( implode( ';', $styles ) ) );
                    $flag_format_content = true;
                    echo '</div></div>';
                }

                break;

            case 'gallery':
                $ids = mgana_get_post_meta(get_the_ID(), 'format_gallery');
                $ids = explode(',', $ids);
                $ids = array_map('trim', $ids);
                $ids = array_map('absint', $ids);
                $__tmp = '';
                if(has_post_thumbnail()){
                    $__tmp .= sprintf('<div><div class="sinmer">%1$s</div></div>',
                        str_replace('<img', '<img' . $image_schema_markup, get_the_post_thumbnail(get_the_ID(), $thumbnail_size))
                    );
                }
                if(!empty( $ids )){
                    foreach($ids as $image_id){
                        if(wp_attachment_is_image($image_id)){
                            $__tmp .= sprintf('<div><div class="sinmer">%1$s</div></div>',
                                wp_get_attachment_image( $image_id, $thumbnail_size )
                            );
                        }
                    }
                }

                if(!empty($__tmp)){
                    printf(
                        '<div class="post-thumbnail"><div class="loop__item__thumbnail blog_item--thumbnail format-gallery"><div data-la_component="AutoCarousel" class="js-el la-slick-slider" data-slider_config="%1$s">%2$s</div></div></div>',
                        esc_attr(json_encode(array(
                            'slidesToShow' => 1,
                            'slidesToScroll' => 1,
                            'dots' => false,
                            'arrows' => true,
                            'speed' => 300,
                            'autoplay' => false,
                            'infinite' => false,
                            'prevArrow'=> '<button type="button" class="slick-prev"><i class="lastudioicon-left-arrow"></i></button>',
                            'nextArrow'=> '<button type="button" class="slick-next"><i class="lastudioicon-right-arrow"></i></button>'
                        ))),
                        $__tmp
                    );
                    $flag_format_content = true;
                }
                break;

            case 'audio':
            case 'video':
                $embed_source = mgana_get_post_meta(get_the_ID(), 'format_embed');
                $embed_aspect_ration = mgana_get_post_meta(get_the_ID(), 'format_embed_aspect_ration');
                if(!empty($embed_source)){
                    $flag_format_content = true;
                    printf(
                        '<div class="post-thumbnail"><div class="blog_item--thumbnail format-embed"><div class="la-media-wrapper la-media-aspect-%2$s">%1$s</div></div></div>',
                        do_shortcode($embed_source),
                        esc_attr($embed_aspect_ration ? $embed_aspect_ration : 'origin')

                    );
                }
                break;
        }

        if(!$flag_format_content && has_post_thumbnail()){ ?>
            <div class="post-thumbnail">
                <a<?php
                if( 'video' == get_post_format() && ( $popup_video_link = mgana_get_post_meta(get_the_ID(), 'format_video_url') ) && !empty($popup_video_link) ){
                    printf(' href="%s" class="la-popup"', $popup_video_link );
                }
                else{
                    ?> class="post-thumbnail__link" href="<?php the_permalink();?>"<?php
                }
                ?>>
                    <figure class="blog_item--thumbnail figure__object_fit">
                        <?php echo str_replace('<img', '<img' . $image_schema_markup, get_the_post_thumbnail(get_the_ID(), $thumbnail_size, array('class' => 'post-thumbnail__img'))); ?>
                    </figure>
                    <span class="pf-icon pf-icon-<?php echo get_post_format() ? get_post_format() : 'standard' ?>"></span>
                    <span class="post-date"><?php echo sprintf('<span>%s</span><span>%s</span>', get_the_date('d'), get_the_date('M')) ?></span>
                </a>
            </div>
            <?php
        }

    }
}


if (!function_exists('mgana_wpml_object_id')) {
    function mgana_wpml_object_id( $element_id, $element_type = 'post', $return_original_if_missing = false, $ulanguage_code = null ) {
        if ( function_exists( 'wpml_object_id_filter' ) ) {
            return wpml_object_id_filter( $element_id, $element_type, $return_original_if_missing, $ulanguage_code );
        }
        elseif ( function_exists( 'icl_object_id' ) ) {
            return icl_object_id( $element_id, $element_type, $return_original_if_missing, $ulanguage_code );
        }
        else {
            return $element_id;
        }
    }
}

if(!function_exists('mgana_is_blog')){
    function mgana_is_blog(){
        return (is_home() || is_tag() || is_category() || is_date() || is_year() || is_month() || is_author()) ? true : false;
    }
}

if(!function_exists('mgana_get_wishlist_url')){
    function mgana_get_wishlist_url(){
        $wishlist_page_id = mgana_get_option('wishlist_page', 0);
        return (!empty($wishlist_page_id) ? get_the_permalink($wishlist_page_id) : esc_url(home_url('/')));
    }
}

if(!function_exists('mgana_get_compare_url')){
    function mgana_get_compare_url(){
        $compare_page_id = mgana_get_option('compare_page', 0);
        return (!empty($compare_page_id) ? get_the_permalink($compare_page_id) : esc_url(home_url('/')));
    }
}

if(!function_exists('mgana_render_access_component')){
    function mgana_render_access_component( $type, $component = array(), $parent_name = '', $css_class = '' ){
        $exist_flag     = false;

        $el_class       = !empty($component['el_class']) ? ' ' . $component['el_class'] : '';
        $icon_html      = '<i class="'.(!empty($component['icon']) ? $component['icon'] : 'lastudioicon-star-rate-2').'"></i>';
        $child_html     = '';
        $target_html    = '';
        $component_css_class    = '';
        $tpl        = '<div class="%1$s%2$s">%3$s%4$s</div>';
        if(!empty($component['text'])){
            $current_user_name = esc_html__('Guest', 'mgana');
            if(is_user_logged_in()){
                $current_user = wp_get_current_user();
                $current_user_name = $current_user->display_name;
            }
            $component['text'] = str_replace('{{user_name}}', $current_user_name, $component['text']);
        }

        if(!empty($component['link'])){
            $logout_link = wp_logout_url();
            $login_link = wp_login_url();
            if(function_exists('WC')){
                $logout_link = wc_get_account_endpoint_url('customer-logout');
                $login_link = wc_get_account_endpoint_url('dashboard');
            }
            $component['link'] = str_replace(
                array(
                    '{{logout_url}}',
                    '{{login_url}}'
                ),
                array(
                    $logout_link,
                    $login_link,
                ),
                $component['link']
            );

            $component['link'] = apply_filters('mgana/filter/component/link', $component['link'], $type);
        }

        switch($type){

            case 'dropdown_menu':
                $exist_flag = true;
                $component_css_class = $parent_name . ' ' . $parent_name . '--dropdown-menu la_compt_iem la_com_action--dropdownmenu ' . $css_class;

                if(empty($component['icon']) && !empty($component['text'])){
                    $icon_html = '';
                }
                if(!empty($component['text'])){
                    $component_css_class .= ' la_com_action--dropdownmenu-text';
                    $icon_html .= '<span class="component-target-text">';
                    $icon_html .= $component['text'];
                    $icon_html .= '</span>';
                }

                $target_html = '<a rel="nofollow" class="component-target" href="javascript:;">'.$icon_html.'</a>';
                if(isset($component['menu_id']) && ($menu_id = $component['menu_id']) && is_nav_menu($menu_id)){
                    $child_html = wp_nav_menu(array(
                        'container' => false,
                        'depth' => 1,
                        'echo' => false,
                        'menu' => $menu_id,
                        'fallback_cb' => false
                    ));
                }

                break;

            case 'text':
                $component_css_class = $parent_name . ' ' . $parent_name . '--text la_compt_iem la_com_action--text ' . $css_class;
                $target_url = isset($component['link']) ? $component['link'] : 'javascript:;';

                if(!empty($component['text'])){
                    $exist_flag = true;
                    $target_html .= '<a class="component-target" href="'.$target_url.'">';
                    if(!empty($component['icon'])){
                        $target_html .= $icon_html;
                    }
                    $target_html .= '<span class="component-target-text">';
                    $target_html .= apply_filters('mgana/filter/component/text', $component['text']);
                    $target_html .= '</span>';
                    $target_html .= '</a>';
                }
                else{
                    if(!empty($component['icon'])){
                        $exist_flag = true;
                        $target_html .= '<a class="component-target" href="'.$target_url.'">'. $icon_html .'</a>';
                    }
                }
                break;

            case 'search_1':
                $exist_flag = true;
                $component_css_class = $parent_name . ' ' . $parent_name . '--searchbox la_compt_iem la_com_action--searchbox searchbox__01 ' . $css_class;
                $icon_html = '<i class="lastudioicon-zoom-2"></i>';
                $target_html = '<a class="component-target" href="javascript:;">'.$icon_html.'</a>';
                break;

            case 'cart':
                $exist_flag = true;
                $component_css_class = $parent_name . ' ' . $parent_name . '--cart la_compt_iem la_com_action--cart ' . $css_class;
                $target_url = isset($component['link']) ? $component['link'] : '#';
                if(function_exists('wc_get_cart_url') && ($target_url == '#' || $target_url == '')){
                    $target_url = wc_get_cart_url();
                }
                $cart_count = '0';
                $cart_total_price = '';
                if(function_exists('WC')){
                    $cart_count = WC()->cart->get_cart_contents_count();
                    $cart_total_price = WC()->cart->get_cart_total();
                }

                $icon_html = '<i class="'.(!empty($component['icon']) ? $component['icon'] : 'lastudioicon-shopping-cart-3').'"></i>';

                if(!empty($component['text'])){
                    $icon_html .= '<span class="component-target-text">'. apply_filters('mgana/filter/component/text', $component['text']) .'</span>';
                    $component_css_class .= ' has-compt-text';
                }
                $icon_html .= '<span class="component-target-badget la-cart-count">'.$cart_count.'</span><span class="la-cart-total-price">'.$cart_total_price.'</span>';
                $target_html = '<a rel="nofollow" class="component-target" href="'.$target_url.'">'.$icon_html.'</a>';
                break;

            case 'wishlist':
                $total_count = 0;
                $exist_flag = true;
                $component_css_class = $parent_name . ' ' . $parent_name . '--wishlist la_compt_iem la_com_action--wishlist ' . $css_class;
                $target_url = isset($component['link']) ? $component['link'] : '#';
                if($target_url == '#'){
                    $target_url = mgana_get_wishlist_url();
                }
                if(class_exists('Mgana_WooCommerce_Wishlist', false)){
                    $total_count = Mgana_WooCommerce_Wishlist::get_count();
                }
                if(function_exists('yith_wcwl_object_id') && ($target_url == '#' || empty($target_url))){
                    $wishlist_page_id = yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) );
                    $target_url = get_the_permalink($wishlist_page_id);
                }
                $icon_html = '<i class="'.(!empty($component['icon']) ? $component['icon'] : 'lastudioicon-heart-2').'"></i><span class="component-target-badget la-wishlist-count">'.$total_count.'</span>';
                $target_html = '<a rel="nofollow" class="component-target" href="'.$target_url.'">'.$icon_html.'</a>';
                break;

            case 'compare':
                $total_count = 0;
                $exist_flag = true;
                $component_css_class = $parent_name . ' ' . $parent_name . '--compare la_compt_iem la_com_action--compare ' . $css_class;
                $target_url = isset($component['link']) ? $component['link'] : '#';
                if($target_url == '#'){
                    $target_url = mgana_get_compare_url();
                }
                if(class_exists('Mgana_WooCommerce_Compare', false)){
                    $total_count = Mgana_WooCommerce_Compare::get_count();
                }
                $icon_html = '<i class="'.(!empty($component['icon']) ? $component['icon'] : 'lastudioicon-chart-bar-32-2').'"></i><span class="component-target-badget la-compare-count">'.$total_count.'</span>';
                $target_html = '<a rel="nofollow" class="component-target" href="'.$target_url.'">'.$icon_html.'</a>';
                break;

        }

        if($exist_flag){
            return sprintf( $tpl
                , esc_attr( $component_css_class )
                , esc_attr( $el_class )
                , $target_html
                , $child_html
            );
        }
        else{
            return '';
        }
    }
}

if(!function_exists('mgana_get_custom_breakpoints')){
    function mgana_get_custom_breakpoints(){
        if(function_exists('la_get_custom_breakpoints')){
            return la_get_custom_breakpoints();
        }
        else{
	        $custom_breakpoints = get_option('la_custom_breakpoints');
	        $sm = !empty($custom_breakpoints['sm']) ? absint($custom_breakpoints['sm']) : 576;
	        $md = !empty($custom_breakpoints['md']) ? absint($custom_breakpoints['md']) : 800;
	        $lg = !empty($custom_breakpoints['lg']) ? absint($custom_breakpoints['lg']) : 1280;
	        $xl = !empty($custom_breakpoints['xl']) ? absint($custom_breakpoints['xl']) : 1700;

	        if( $sm <= 380 || $sm >= 800 ){
		        $sm = 576;
	        }
	        if( $md <= 800 || $md >= 1280 ){
		        $md = 800;
	        }
	        if( $lg <= 1280 || $lg >= 1700 ){
		        $lg = 1280;
	        }
	        if($lg > $xl){
		        $xl = $lg + 2;
	        }
	        if($xl > 2000){
		        $xl = 1700;
	        }
	        return [
		        'xs' => 0,
		        'sm' => $sm,
		        'md' => $md,
		        'lg' => $lg,
		        'xl' => $xl,
		        'xxl' => 2000
	        ];
        }
    }
}