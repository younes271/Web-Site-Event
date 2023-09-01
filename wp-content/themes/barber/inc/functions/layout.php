<?php
//get search template
if(! function_exists('apr_get_search_ajax')){
    function apr_get_search_ajax(){
        global $apr_settings;
        $output = '';
        ob_start();
        ?>

            <form id="woosearch-search" action="<?php echo esc_url(home_url('/'));?>" >
                <div class="woosearch-input-box hidecat">
                    <input type="text" name="s" class="woosearch-search-input woocommerce-product-search product-search search-field" value="" placeholder="<?php echo esc_attr_x( 'Enter keyword & hit enter to search&hellip;', 'placeholder', 'barber' ); ?>" autocomplete="off" data-number="4" data-keypress="2">
                <div><div class="woosearch-results"></div></div>
                </div>
                <button type="submit" class="woosearch-submit submit btn-search">
                    <i class="pe-7s-search"></i>
                    <i class="fa fa-spin"></i>
                </button>
                <input type="hidden" name="post_type" value="product" />

            </form>

        <?php
        $output .= ob_get_clean();
        return $output;
    }
}
if ( ! function_exists( 'apr_get_search_form' ) ) {
    function apr_get_search_form() {
        global $apr_settings;
        $template = get_search_form(false);
        $header_type = apr_get_header_type();

        if(class_exists( 'WooCommerce' )) {
            if(isset($apr_settings['header_search_type']) && $apr_settings['header_search_type'] =='1'){
                $template = apr_get_search_ajax();
            }
        }
        $output = '';
        ob_start();
        ?>
        <?php if(isset($apr_settings['header_search_style']) && $apr_settings['header_search_style'] =='2'):?>
            <div class="search-holder">
                <span class="btn-search search_button" ><i class="<?php echo esc_html($apr_settings['header-search-icon']); ?>"></i></span>
                <div class="searchform_wrap">
                    <div class="search-title">
                        <a href="" class="close_search_form">
                            <span class="lnr lnr-cross"></span>
                        </a>
                        <p><?php echo esc_html__('Search','barber'); ?></p>
                    </div>
                    <div class="vc_child h_inherit relative">
                         <?php echo wp_kses($template,apr_allow_html()); ?>
                    </div>
                </div>
            </div>
        <?php else:?>
            <span class="btn-search"><i class="<?php echo esc_html($apr_settings['header-search-icon']); ?>"></i></span>
            <div class="top-search content-filter">
                <?php echo wp_kses($template,apr_allow_html()); ?>
            </div>
        <?php endif;?>
        <?php
        $output .= ob_get_clean();
        return $output;
    }
}

if ( ! function_exists( 'apr_get_search_form_2' ) ) {
    function apr_get_search_form_2() {
        global $apr_settings;
        $template = get_search_form(false);
        $header_type = apr_get_header_type();

        if(class_exists( 'WooCommerce' )) {
            if(isset($apr_settings['header_search_type']) && $apr_settings['header_search_type'] =='1'){
                $template = apr_get_search_ajax();
            }
        }
        $output = '';
        ob_start();
        ?>
        <?php if(isset($apr_settings['header_search_style_2']) && $apr_settings['header_search_style_2'] =='2'):?>
            <div class="search-holder">
                <span class="btn-search search_button" ><i class="<?php echo esc_html($apr_settings['header-search-icon']); ?>"></i></span>
                <div class="searchform_wrap">
                    <div class="search-title">
                        <a href="" class="close_search_form">
                            <span class="lnr lnr-cross"></span>
                        </a>
                        <p><?php echo esc_html__('Search','barber'); ?></p>
                    </div>
                    <div class="vc_child h_inherit relative">
                         <?php echo wp_kses($template,apr_allow_html()); ?>
                    </div>
                </div>
            </div>
        <?php else:?>
            <span class="btn-search"><i class="<?php echo esc_html($apr_settings['header-search-icon']); ?>"></i></span>
            <div class="top-search content-filter">
                <?php echo wp_kses($template,apr_allow_html()); ?>
            </div>
        <?php endif;?>
        <?php
        $output .= ob_get_clean();
        return $output;
    }
}
//mini cart template
if ( class_exists( 'WooCommerce' ) ) {
    if ( ! function_exists ( 'apr_get_minicart_template' ) ) {
        function apr_get_minicart_template() {
			global $apr_settings;
            $cart_item_count = WC()->cart->cart_contents_count;
            $header_type = apr_get_header_type();
            $output = '';
            ob_start();
            ?>

                <a class="cart_label" href="#">
                    <i class="<?php echo esc_html($apr_settings['header-cart-icon']); ?>"></i>
                    <p class="cart_nu_count"><?php echo esc_html($cart_item_count);?></p>
                </a>
                <div class="cart-block content-filter">
                    <?php if($cart_item_count > 0): ?>
                    <div class="count-item">
                        <p><?php echo wp_sprintf( __( 'You have <span class="cart_nu_count2"> %s </span> item(s) in your cart','barber' ), esc_html($cart_item_count) );?></p>
                    </div>
                    <?php endif; ?>
                    <div class="widget_shopping_cart_content">
                    </div>
                </div>
            <?php
            $output .= ob_get_clean();
            return $output;
        }
    }
}
if ( ! function_exists ( 'apr_shop_settings' ) ) {
function apr_shop_settings(){
    global $apr_settings;
    if ( class_exists( 'WooCommerce' ) ) {
        $compare = false;
        if (class_exists('YITH_WOOCOMPARE')) {
            $compare = true;
        }
        $wishlist = false;
        if (class_exists('YITH_WCWL')) {
            $wishlist = true;
        }
        $myaccount_page_id = get_option('woocommerce_myaccount_page_id');
        $logout_url = wp_logout_url(get_permalink($myaccount_page_id));
        if (get_option('woocommerce_force_ssl_checkout') == 'yes') {
            $logout_url = str_replace('http:', 'https:', $logout_url);
        }
    $output = '';
    ob_start();
    ?>
    <div class="dib customlinks inline shop_settings">
        <a href="#" aria-expanded="false" aria-haspopup="true" data-toggle="dropdown">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </a>
        <div class="dib header-profile dropdown-menu">
            <ul>
                <li><a href="<?php echo esc_url(get_permalink($myaccount_page_id)); ?>"><?php echo esc_html__('My Account', 'barber') ?></a></li>
                <?php if ($wishlist && $apr_settings['product-wishlist']): ?>
                    <li><a class="update-wishlist" href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>"><?php echo esc_html__('Wishlist', 'barber') ?> <span>(<?php echo yith_wcwl_count_products(); ?>)</span></a></li>
                <?php endif; ?>
                <?php if (class_exists('YITH_WOOCOMPARE') && $apr_settings['product-compare']) { ?>
                    <li>
                        <?php apr_compare_toplink(); ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

 <?php
        $output .= ob_get_clean();
        return $output;
    }
}
}
// top link myaccout
if ( ! function_exists ( 'apr_myaccount_toplinks' ) ) {
function apr_myaccount_toplinks() {
    $wishlist = false;
    global $apr_settings;
    if(class_exists('YITH_WCWL')) {
        $wishlist = true;
    }
    $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
    $logout_url = wp_logout_url('my-account');
    $output = '';
    ob_start();
    ?>
    <ul>
        <li class="dib customlinks">
            <a class="current-open" href="javascript:void(0);">
                <i class="fa fa-gear"></i>
            </a>
            <div class="dib header-profile dropdown-menu content-filter">
                    <ul>
                        <li><a href="<?php echo get_permalink( $myaccount_page_id ); ?>"><?php echo esc_html__('My Account', 'barber') ?></a></li>
                        <?php if($wishlist && $apr_settings['product-wishlist']): ?>
                        <li><a class="update-wishlist" href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>"><?php echo esc_html__('Wishlist', 'barber') ?> <span>(<?php echo yith_wcwl_count_products(); ?>)</span></a></li>
                        <?php endif; ?>
                        <?php if (class_exists( 'YITH_WOOCOMPARE' ) && $apr_settings['product-compare'] ) :?>
                        <li>
                            <?php
                                apr_compare_toplink();
                            ?>
                        </li>
                        <?php endif;?>
                        <?php if ( !is_user_logged_in() ) :?>
                        <li><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php echo esc_html__('Login / Register','barber'); ?>"><?php echo esc_html__('Login / Register','barber'); ?></a></li>
                        <?php else :?>
                        <li><a href="<?php echo esc_url($logout_url); ?>"><?php echo esc_html__('Logout', 'barber') ?></a></li>
                        <?php endif; ?>
                    </ul>
            </div>
        </li>
    </ul>
   <?php
   $output .= ob_get_clean();
    return $output;
}
}
function apr_get_layout() {
    global $wp_query, $apr_settings, $apr_layout;
    $result = '';
    if (empty($apr_layout)) {
        $result = isset($apr_settings['layout']) ? $apr_settings['layout'] : 'fullwidth';
        if (is_404()) {
            $result = 'fullwidth';
        } else if (is_category()) {
            $result = $apr_settings['post-layout'];
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop()) {
                $shop_layout = get_post_meta(wc_get_page_id('shop'), 'layout', true);
                $result = !empty($shop_layout) && $shop_layout != 'default' ? $shop_layout : $apr_settings['shop-layout'];
            } else {
                if (is_post_type_archive('gallery')) {
                    $result = $apr_settings['gallery-layout'];
                }
                else if(is_post_type_archive('gallery')){
                    $result = $apr_settings['gallery-layout'];
                }
                else if(is_post_type_archive('pressmedia')){
                    $result = $apr_settings['pressmedia-layout'];
                }
                else if(is_post_type_archive('hb_room')){
                    $result = $apr_settings['room-layout'];
                }
                else {
                    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
                    if ($term) {
                        $tax_layout = get_metadata($term->taxonomy, $term->term_id, 'layout', true);
                        switch ($term->taxonomy) {
                            case 'product_cat':
                                if(!empty($tax_layout) && $tax_layout != 'default') {
                                    $result = $tax_layout;
                                } else {
                                    $result = $apr_settings['shop-layout'];
                                }
                                break;
                            case 'product_tag':
                                $result = $apr_settings['shop-layout'];
                                break;
                            case 'gallery_cat':
                                if(!empty($tax_layout) && $tax_layout != 'default') {
                                    $result = $tax_layout;
                                } else {
                                    $result = $apr_settings['gallery-layout'];
                                }
                                break;
                            case 'gallery_cat':
                                $result = $apr_settings['gallery-layout'];
                                break;
                            case 'pressmedia_cat':
                                $result = $apr_settings['pressmedia-layout'];
                                break;
                            case 'gallery':
                                $result = $apr_settings['post-layout'];
                                break;
                            default:
                                $result = $apr_settings['layout'];
                        }
                    }
                }
            }
        } else {
            if (is_singular()) {
                $single_layout = get_post_meta(get_the_id(), 'layout', true);
                if (!empty($single_layout) && $single_layout != 'default') {
                    $result = $single_layout;
                } else {
                    switch (get_post_type()) {
                        case 'gallery':
                            $result = $apr_settings['gallery-layout'];
                            break;
                        case 'hb_room':
                            $result = $apr_settings['single-room-layout'];
                            break;
                        case 'pressmedia':
                            $result = $apr_settings['pressmedia-layout'];
                            break;
                        case 'product':
                            $result = $apr_settings['single-product-layout'];
                            break;
                        case 'post':
                            $result = $apr_settings['post-layout'];
                            break;
                        default:
                            $result = $apr_settings['layout'];
                    }
                }
            } else {
				if ( is_home() && ! is_front_page() ) {
					$result = isset( $apr_settings['post-layout'] ) ? $apr_settings['post-layout'] : '';
				}
            }
        }
        $apr_layout = $result;
    }
    return $apr_layout;
}
//get global sidebar position
function apr_get_sidebar_position() {
    $result = '';
    global $wp_query, $apr_settings, $apr_sidebar_pos;
    if(empty($apr_sidebar_pos)){
        $result = isset($apr_settings['sidebar-position']) ? $apr_settings['sidebar-position'] : 'none';
        if (is_404()) {
            $result = 'none';
        } else if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $cat_sidebar = get_metadata('category', $cat->term_id, 'sidebar_position', true);
            if (!empty($cat_sidebar) && $cat_sidebar != 'default') {
                    $result = $cat_sidebar;
                }
            else{
                $result = $apr_settings['post-sidebar-position'];
            }
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop()) {
                $shop_sidebar_position = get_post_meta(wc_get_page_id('shop'), 'sidebar_position', true);
                $result = !empty($shop_sidebar_position) && $shop_sidebar_position != 'default' ? $shop_sidebar_position : $apr_settings['shop-sidebar-position'];
            } else {
                if (is_post_type_archive('gallery')) {
                    if(isset($apr_settings['gallery-sidebar-position'])){
                        $result = $apr_settings['gallery-sidebar-position'];
                    }else{
                        $result = $apr_settings['sidebar-position'];
                    }
                }else if(is_post_type_archive('gallery')){
                    if(isset($apr_settings['gallery-sidebar-position'])){
                        $result = $apr_settings['gallery-sidebar-position'];
                    }else{
                        $result = $apr_settings['sidebar-position'];
                    }
                }else {
                    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
                    if ($term) {
                        $tax_sidebar_pos = get_metadata($term->taxonomy, $term->term_id, 'sidebar_position', true);
                        switch ($term->taxonomy) {
                            case 'product_cat':
                                if(!empty($tax_sidebar_pos) && $tax_sidebar_pos != 'default') {
                                    $result = $tax_sidebar_pos;
                                } else {
                                    $result = $apr_settings['shop-sidebar-position'];
                                }
                                break;
                            case 'product_tag':
                                $result = $apr_settings['shop-sidebar-position'];
                                break;
                            case 'gallery_cat':
                                $result = $apr_settings['gallery-sidebar-position'];
                                break;
                            case 'gallery_tag':
                                $result = $apr_settings['gallery-sidebar-position'];
                                break;
                            case 'category':
                                if(!empty($tax_sidebar_pos) && $tax_sidebar_pos != 'default') {
                                    $result = $tax_sidebar_pos;
                                } else {
                                    $result = $apr_settings['post-sidebar-position'];
                                }
                                break;
                            case 'tag':
                                    $result = $apr_settings['post-sidebar-position'];
                                break;
                            default:
                                $result = $apr_settings['sidebar-position'];
                        }
                    }
                }
            }
        } else {
            if (is_singular()) {
                $single_sidebar_position = get_post_meta(get_the_id(), 'sidebar_position', true);
                if (!empty($single_sidebar_position) && $single_sidebar_position != 'default') {
                    $result = $single_sidebar_position;
                } else {
                    switch (get_post_type()) {
                        case 'gallery':
                            $result = $apr_settings['gallery-sidebar-position'];
                            break;
                        case 'product':
                            $result = $apr_settings['single-product-sidebar-position'];
                            break;
                        case 'gallery':
                            if(isset($apr_settings['gallery-sidebar-position'])){
                                $result = $apr_settings['gallery-sidebar-position'];
                            }else{
                                $result = $apr_settings['sidebar-position'];
                            }
                            break;
                        case 'pressmedia':
                            if(isset($apr_settings['press-sidebar-position'])){
                                $result = $apr_settings['press-sidebar-position'];
                            }else{
                                $result = $apr_settings['sidebar-position'];
                            }
                            break;
                        case 'post':
                            $result = $apr_settings['post-sidebar-position'];
                            break;
                        default:
                            $result = $apr_settings['sidebar-position'];
                    }
                }
            } else {
                if (is_home() && !is_front_page()) {
                    $result = $apr_settings['post-sidebar-position'];
                }
            }
        }
        $apr_sidebar_pos = $result;
    }
    return $apr_sidebar_pos;
}

//get global sidebar
function apr_get_sidebar() {
    $result = '';
    global $wp_query, $apr_settings, $apr_sidebar;
    if(empty($apr_sidebar)){
        $result = isset($apr_settings['sidebar']) ? $apr_settings['sidebar'] : 'none';
        if (is_404()) {
            $result = 'none';
        } else if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $cat_sidebar = get_metadata('category', $cat->term_id, 'sidebar', true);
            if (!empty($cat_sidebar) && $cat_sidebar != 'default') {
                    $result = $cat_sidebar;
                }
            else{
                $result = $apr_settings['post-sidebar'];
            }
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop()) {
                $shop_sidebar = get_post_meta(wc_get_page_id('shop'), 'sidebar', true);
                $result = !empty($shop_sidebar) && $shop_sidebar != 'default' ? $shop_sidebar : $apr_settings['shop-sidebar'];
            } else {
                if (is_post_type_archive('gallery')) {
                    if(isset($apr_settings['gallery-sidebar'])){
                        $result = $apr_settings['gallery-sidebar'];
                    }else{
                        $result = $apr_settings['sidebar'];
                    }
                } else if(is_post_type_archive('gallery')){
                    if(isset($apr_settings['gallery-sidebar'])){
                        $result = $apr_settings['gallery-sidebar'];
                    }else{
                        $result = $apr_settings['sidebar'];
                    }
                } else if(is_post_type_archive('pressmedia')){
                    if(isset($apr_settings['press-sidebar'])){
                        $result = $apr_settings['press-sidebar'];
                    }else{
                        $result = $apr_settings['sidebar'];
                    }
                } else {
                    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
                    if ($term) {
                        $tax_sidebar = get_metadata($term->taxonomy, $term->term_id, 'sidebar', true);
                        switch ($term->taxonomy) {
                            case 'product_cat':
                                if(!empty($tax_sidebar) && $tax_sidebar != 'default') {
                                    $result = $tax_sidebar;
                                } else {
                                    $result = $apr_settings['shop-sidebar'];
                                }
                                break;
                            case 'product_tag':
                                $result = $apr_settings['shop-sidebar'];
                                break;
                            case 'gallery_cat':
                                if(isset($apr_settings['gallery-sidebar'])){
                                    $result = $apr_settings['gallery-sidebar'];
                                }else{
                                    $result = $apr_settings['sidebar'];
                                }
                                break;
                            case 'gallery_cat':
                                if(isset($apr_settings['gallery-sidebar'])){
                                    $result = $apr_settings['gallery-sidebar'];
                                }else{
                                    $result = $apr_settings['sidebar'];
                                }
                                break;
                            case 'pressmedia_cat':
                                if(isset($apr_settings['press-sidebar'])){
                                    $result = $apr_settings['press-sidebar'];
                                }else{
                                    $result = $apr_settings['sidebar'];
                                }
                                break;
                            case 'gallery_tag':
                                if(isset($apr_settings['gallery-sidebar'])){
                                    $result = $apr_settings['gallery-sidebar'];
                                }else{
                                    $result = $apr_settings['sidebar'];
                                }
                                break;
                            case 'category':
                                if(!empty($tax_sidebar) && $tax_sidebar != 'default') {
                                    $result = $tax_sidebar;
                                } else {
                                    $result = $apr_settings['post-sidebar'];
                                }
                                break;
                            case 'tag':
                                $result = $apr_settings['post-sidebar'];
                                break;
                            default:
                                $result = $apr_settings['sidebar'];
                        }
                    }
                }
            }
        } else {
            if (is_singular()) {
                $single_sidebar = get_post_meta(get_the_id(), 'sidebar', true);
                if (!empty($single_sidebar) && $single_sidebar != 'default') {
                    $result = $single_sidebar;
                } else {
                    switch (get_post_type()) {
                        case 'gallery':
                            $result = $apr_settings['gallery-sidebar'];
                            break;
                        case 'product':
                            $result = $apr_settings['single-product-sidebar'];
                            break;
                        case 'gallery':
                            $result = $apr_settings['gallery-sidebar'];
                            break;
                        case 'pressmedia':
                            $result = $apr_settings['press-sidebar'];
                            break;
                        case 'post':
                            $result = $apr_settings['post-sidebar'];
                            break;
                        default:
                            $result = $apr_settings['sidebar'];
                    }
                }
            } else {
                if (is_home() && !is_front_page()) {
                    $result = $apr_settings['post-sidebar'];
                }
            }
        }
        $apr_sidebar = $result;
    }
    return $apr_sidebar;
}
function apr_get_sidebar_left() {
    $result = '';
    global $wp_query, $apr_settings, $apr_sidebar_left;

    if (empty($apr_sidebar_left)) {
        $result = isset($apr_settings['left-sidebar']) ? $apr_settings['left-sidebar'] : '';
        if (is_404()) {
            $result = '';
        } else if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $cat_sidebar = get_metadata('category', $cat->term_id, 'left-sidebar', true);
            if (!empty($cat_sidebar) && $cat_sidebar != 'default') {
                $result = $cat_sidebar;
            }else if($cat_sidebar =='none') {
                $result = "none";
            } else {
                $result = $apr_settings['left-post-sidebar'];
            }
        }else if (is_tag()){
            $result = $apr_settings['left-post-sidebar'];
        }
        else if (is_search()){
            $result = $apr_settings['left-post-sidebar'];
        }
        else if (is_archive()) {
            if (function_exists('is_shop') && is_shop()) {
                $shop_sidebar = get_post_meta(wc_get_page_id('shop'), 'left-sidebar', true);
                $result = !empty($shop_sidebar) && $shop_sidebar != 'default' ? $shop_sidebar : $apr_settings['left-shop-sidebar'];
            } else {
                if (is_post_type_archive('gallery')) {
                    if(isset($apr_settings['left-gallery-sidebar'])){
                        $result = $apr_settings['left-gallery-sidebar'];
                    }else{
                        $result = $apr_settings['left-sidebar'];
                    }
                }
                else if (is_post_type_archive('left-casestudy')) {
                    $result = $apr_settings['left-casestudy-sidebar'];
                } else {
                    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
                    if ($term) {
                        $tax_sidebar = get_metadata($term->taxonomy, $term->term_id, 'left-sidebar', true);
                        switch ($term->taxonomy) {
                            case 'product_cat':
                                if (!empty($tax_sidebar) && $tax_sidebar != 'default') {
                                    $result = $tax_sidebar;
                                }else if($tax_sidebar =='none') {
                                    $result = "none";
                                } else {
                                    $result = $apr_settings['left-shop-sidebar'];
                                }
                                break;
                            case 'gallery_cat':
                                if (!empty($tax_sidebar) && $tax_sidebar != 'default') {
                                    $result = $tax_sidebar;
                                } else if($tax_sidebar =='none') {
                                    $result = "none";
                                }else{
                                    $result = $apr_settings['left-gallery-sidebar'];
                                }
                                break;
                            case 'product_tag':
                                $result = $apr_settings['left-shop-sidebar'];
                                break;
                            case 'category':
                                if (!empty($tax_sidebar) && $tax_sidebar != 'default') {
                                    $result = $tax_sidebar;
                                } else {
                                    $result = $apr_settings['left-post-sidebar'];
                                }
                                break;
                            case 'tag':
                                $result = $apr_settings['left-post-sidebar'];
                                break;
                            default:
                                $result = $apr_settings['left-sidebar'];
                        }
                    }
                }
            }
        } else if(function_exists('is_plugin_active') && is_plugin_active( 'bbpress/bbpress.php' ) && is_bbpress()){
            $result = $apr_settings['left-bb-sidebar'];
        } else {
            if (is_singular()) {
                $single_sidebar = get_post_meta(get_the_id(), 'left-sidebar', true);
                if (!empty($single_sidebar) && $single_sidebar != 'default') {
                    $result = $single_sidebar;
                }else if($single_sidebar =='none') {
                    $result = "none";
                } else {
                    switch (get_post_type()) {
                        case 'post':
                            $result = $apr_settings['left-post-sidebar'];
                            break;
                        case 'gallery':
                            $result = $apr_settings['left-gallery-sidebar'];
                            break;
                        case 'product':
                            $result = $apr_settings['left-single-product-sidebar'];
                            break;
                        default:
                            $result = $apr_settings['left-sidebar'];
                    }
                }
            } else {
                if (is_home() && !is_front_page()) {
                    $result = $apr_settings['left-post-sidebar'];
                }
            }
        }
        $apr_sidebar_left = $result;
    }
    return $apr_sidebar_left;
}

function apr_get_sidebar_right() {
    $result = '';
    global $wp_query, $apr_settings, $apr_sidebar_right;

    if (empty($apr_sidebar_right)) {
        $result = isset($apr_settings['right-sidebar']) ? $apr_settings['right-sidebar'] : 'none';
        if (is_404()) {
            $result = 'none';
        }else if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $cat_sidebar = get_metadata('category', $cat->term_id, 'right-sidebar', true);
            if (!empty($cat_sidebar) && $cat_sidebar != 'default') {
                $result = $cat_sidebar;
            }else if($cat_sidebar =='none') {
                $result = "none";
            } else {
                $result = $apr_settings['right-post-sidebar'];
            }
        }else if (is_tag()){
            $result = $apr_settings['right-post-sidebar'];
        }
        else if (is_search()){
            $result = $apr_settings['right-post-sidebar'];
        }
        else if (is_archive()) {
            if (function_exists('is_shop') && is_shop()) {
                $shop_sidebar = get_post_meta(wc_get_page_id('shop'), 'right-sidebar', true);
                $result = !empty($shop_sidebar) && $shop_sidebar != 'default' ? $shop_sidebar : $apr_settings['right-shop-sidebar'];
            } else {
                if (is_post_type_archive('gallery')) {
                    if(isset($apr_settings['right-gallery-sidebar'])){
                        $result = $apr_settings['right-gallery-sidebar'];
                    }else{
                        $result = $apr_settings['right-sidebar'];
                    }
                }
                else if (is_post_type_archive('right-casestudy')) {
                    $result = $apr_settings['right-casestudy-sidebar'];
                } else {
                    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
                    if ($term) {
                        $tax_sidebar = get_metadata($term->taxonomy, $term->term_id, 'right-sidebar', true);
                        switch ($term->taxonomy) {
                            case 'product_cat':
                                if (!empty($tax_sidebar) && $tax_sidebar != 'default') {
                                    $result = $tax_sidebar;
                                }else if($tax_sidebar =='none') {
                                    $result = "none";
                                } else {
                                    $result = $apr_settings['right-shop-sidebar'];
                                }
                                break;
                            case 'gallery_cat':
                                if (!empty($tax_sidebar) && $tax_sidebar != 'default') {
                                    $result = $tax_sidebar;
                                }else if($tax_sidebar =='none') {
                                    $result = "none";
                                } else {
                                    $result = $apr_settings['right-gallery-sidebar'];
                                }
                                break;
                            case 'product_tag':
                                $result = $apr_settings['right-shop-sidebar'];
                                break;
                            case 'category':
                                if (!empty($tax_sidebar) && $tax_sidebar != 'default') {
                                    $result = $tax_sidebar;
                                }else if($tax_sidebar =='none') {
                                    $result = "none";
                                } else {
                                    $result = $apr_settings['right-post-sidebar'];
                                }
                                break;
                            case 'tag':
                                $result = $apr_settings['right-post-sidebar'];
                                break;
                            default:
                                $result = $apr_settings['right-sidebar'];
                        }
                    }
                }
            }
        } else if(function_exists('is_plugin_active') && is_plugin_active( 'bbpress/bbpress.php' ) && is_bbpress()){
            $result = $apr_settings['right-bb-sidebar'];
        } else {
            if (is_singular()) {
                $single_sidebar = get_post_meta(get_the_id(), 'right-sidebar', true);
                if (!empty($single_sidebar) && $single_sidebar != 'default') {
                    $result = $single_sidebar;
                }else if($single_sidebar =='none') {
                    $result = "none";
                } else {
                    switch (get_post_type()) {
                        case 'post':
                            $result = $apr_settings['right-post-sidebar'];
                            break;
                        case 'gallery':
                            $result = $apr_settings['right-gallery-sidebar'];
                            break;
                        case 'product':
                            $result = $apr_settings['right-single-product-sidebar'];
                            break;
                        default:
                            $result = $apr_settings['right-sidebar'];
                    }
                }
            } else {
                if (is_home() && !is_front_page()) {
                    $result = $apr_settings['right-post-sidebar'];
                }
            }
        }
        $apr_sidebar_right = $result;
    }
    return $apr_sidebar_right;
}
function apr_get_header_type() {
    $result = '';
    global $apr_settings, $wp_query, $header_type;
    if (empty($header_type)) {
        $result = isset($apr_settings['header-type']) ? $apr_settings['header-type'] : 1;
        if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $cat_layout = get_metadata('category', $cat->term_id, 'header', true);
            if (!empty($cat_layout) && $cat_layout != 'default') {
                    $result = $cat_layout;
                }
            else{
                $result = $apr_settings['header-type'];
            }
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop()) {
                $shop_layout = get_post_meta(wc_get_page_id('shop'), 'header', true);
                if(!empty($shop_layout) && $shop_layout != 'default') {
                    $result = $shop_layout;
                }
            }
        } else if(is_404()){
            if(isset($apr_settings['404_header'])){
                $result = $apr_settings['404_header'];
            }else{
                $result = $apr_settings['header-type'];
            }
        } else if(is_page_template( 'coming-soon.php' )){
            if(isset($apr_settings['coming_header'])){
                $result = $apr_settings['coming_header'];
            }else{
                $result = $apr_settings['header-type'];
            }
        }else {
            if (is_singular()) {
                $single_layout = get_post_meta(get_the_id(), 'header', true);
                if (!empty($single_layout) && $single_layout != 'default') {
                    $result = $single_layout;
                }
            } else {
                if (!is_home() && is_front_page()) {
                    $result = $apr_settings['header-type'];
                } else if (is_home() && !is_front_page()) {
                    $posts_page_id = get_option( 'page_for_posts' );
                    $posts_page_layout = get_post_meta($posts_page_id, 'header', true);
                    if (!empty($posts_page_layout) && $posts_page_layout != 'default') {
                        $result = $posts_page_layout;
                    }
                }
            }
        }
        $header_type = $result;
    }
    return $header_type;
}

function apr_get_banner_top(){
    global $post, $apr_settings;
    $static_block = "";
	if(isset($apr_settings['select-slider']) && $apr_settings['select-slider'] != ''){
        $static_block = $apr_settings['select-slider'];
    }
	if($static_block != ''){
        $block = get_post($static_block);
        $post_content = $block->post_content;
        $hide_static = apr_get_meta_value('hide_static', true);
        if($hide_static){
			?>
				<div class="top-slider">
					<?php echo apply_filters('the_content', get_post_field('post_content', $static_block)); ?>
				</div>
			<?php
        }
    }
}
function apr_get_header_mobile_position() {
    $result = '';
    global $apr_settings, $wp_query, $header_position;
    if (empty($header_position)) {
        $result = isset($apr_settings['header_postion']) ? $apr_settings['header_postion'] : 1;
        if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $cat_layout = get_metadata('category', $cat->term_id, 'header-position', true);
            if (!empty($cat_layout) && $cat_layout != 'default') {
                    $result = $cat_layout;
                }
            else{
                $result = $apr_settings['header_postion'];
            }
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop()) {
                $shop_layout = get_post_meta(wc_get_page_id('shop'), 'header-position', true);
                if(!empty($shop_layout) && $shop_layout != 'default') {
                    $result = $shop_layout;
                }
            }
        } else {
            if (is_singular()) {
                $single_layout = get_post_meta(get_the_id(), 'header-position', true);
                if (!empty($single_layout) && $single_layout != 'default') {
                    $result = $single_layout;
                }
            } else {
                if (!is_home() && is_front_page()) {
                    $result = $apr_settings['header_postion'];
                } else if (is_home() && !is_front_page()) {
                    $posts_page_id = get_option( 'page_for_posts' );
                    $posts_page_layout = get_post_meta($posts_page_id, 'header-position', true);
                    if (!empty($posts_page_layout) && $posts_page_layout != 'default') {
                        $result = $posts_page_layout;
                    }
                }
            }
        }
        $header_position = $result;
    }
    return $header_position;
}

function apr_get_footer_type() {
    $result = '';
    global $apr_settings, $wp_query, $footer_type;
    if(empty($footer_type)){
        $result = isset($apr_settings['footer-type']) ? $apr_settings['footer-type'] : 1;
        if (is_category()) {
            $cat = $wp_query->get_queried_object();
            $cat_layout = get_metadata('category', $cat->term_id, 'footer', true);
            if (!empty($cat_layout) && $cat_layout != 'default') {
                    $result = $cat_layout;
                }
            else{
                $result = $apr_settings['footer-type'];
            }
        } else if (is_archive()) {
            if (function_exists('is_shop') && is_shop()) {
                $shop_layout = get_post_meta(wc_get_page_id('shop'), 'footer', true);
                if(!empty($shop_layout) && $shop_layout != 'default') {
                    $result = $shop_layout;
                }
            }
        } else if(is_404()){
            if(isset($apr_settings['404_footer'])){
                $result = $apr_settings['404_footer'];
            }else{
                $result = $apr_settings['footer-type'];
            }
        } else if(is_page_template( 'coming-soon.php' )){
            if(isset($apr_settings['coming_footer']) && $apr_settings['coming_footer']!=''){
                $result = $apr_settings['coming_footer'];
            }else{
                $result = $apr_settings['footer-type'];
            }
        }else {
            if (is_singular()) {
                $single_layout = get_post_meta(get_the_id(), 'footer', true);
                if (!empty($single_layout) && $single_layout != 'default') {
                    $result = $single_layout;
                }
            } else {
                if (!is_home() && is_front_page()) {
                    $result = $apr_settings['footer-type'];
                } else if (is_home() && !is_front_page()) {
                    $posts_page_id = get_option( 'page_for_posts' );
                    $posts_page_layout = get_post_meta($posts_page_id, 'footer', true);
                    if (!empty($posts_page_layout) && $posts_page_layout != 'default') {
                        $result = $posts_page_layout;
                    }
                }
            }
        }
        $footer_type = $result;
    }
    return $footer_type;
}

//get search template
if ( ! function_exists ( 'apr_breadcrumbs' ) ) {
function apr_breadcrumbs() {
    global $post, $wp_query, $author, $apr_settings;

    $prepend = '';
    $before = '<li>';
    $after = '</li>';
    $home = esc_html__('Home', 'barber');
	$icon_home = '';
	if(isset($apr_settings['breadcrumbs-icon']) && $apr_settings['breadcrumbs-icon']!=''){
        $icon_home = $apr_settings['breadcrumbs-icon'];
    }
    $shop_page_id = false;
    $shop_page = false;
    $front_page_shop = false;
    if ( defined( 'WOOCOMMERCE_VERSION' ) ) {
        $permalinks   = get_option( 'woocommerce_permalinks' );
        $shop_page_id = wc_get_page_id( 'shop' );
        $shop_page    = get_post( $shop_page_id );
        $front_page_shop = get_option( 'page_on_front' ) == wc_get_page_id( 'shop' );
    }

    // If permalinks contain the shop page in the URI prepend the breadcrumb with shop
    if ( $shop_page_id && $shop_page && strstr( $permalinks['product_base'], '/' . $shop_page->post_name ) && get_option( 'page_on_front' ) != $shop_page_id ) {
        $prepend = $before . '<a href="' . get_permalink( $shop_page ) . '">' . $shop_page->post_title . '</a> ' . $after;
    }

    if ( ( ! is_home() && ! is_front_page() && ! ( is_post_type_archive() && $front_page_shop ) ) || is_paged() ) {
        echo '<ul class="breadcrumb">';

        if ( ! empty( $home ) ) {
            echo wp_kses($before,array('li'=>array())) . '<a class="home" href="' . apply_filters( 'woocommerce_breadcrumb_home_url', home_url('/') ) . '"><i class="' . $icon_home . '"></i> ' . $home . '</a>' . $after;
        }

        if ( is_home() ) {

            echo wp_kses($before,array('li'=>array())) . single_post_title('', false) . $after;

        } else if ( is_category()) {

            if ( get_option( 'show_on_front' ) == 'page' ) {
                echo wp_kses($before,array('li'=>array())) . '<a href="' . get_permalink( get_option('page_for_posts' ) ) . '">' . get_the_title( get_option('page_for_posts', true) ) . '</a>' . $after;
            }

            $cat_obj = $wp_query->get_queried_object();
            $this_category = get_category( $cat_obj->term_id );

            echo wp_kses($before,array('li'=>array())) . single_cat_title( '', false ) . $after;

        } elseif ( is_search() ) {

            echo wp_kses($before,array('li'=>array())) . esc_html__( 'Search results for &ldquo;', 'barber' ) . get_search_query() . '&rdquo;' . $after;

        } elseif ( is_tax('product_cat') || is_tax('portfolio_cat')) {
            echo wp_kses($prepend, apr_allow_html());
            if ( is_tax('portfolio_cat') ) {
                $post_type = get_post_type_object( 'portfolio' );
                echo wp_kses($before,array('li'=>array())) . '<a href="' . get_post_type_archive_link( 'portfolio' ) . '">' . $post_type->labels->singular_name . '</a>' . $after;
            }
            $current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

            $ancestors = array_reverse( get_ancestors( $current_term->term_id, get_query_var( 'taxonomy' ) ) );

            foreach ( $ancestors as $ancestor ) {
                $ancestor = get_term( $ancestor, get_query_var( 'taxonomy' ) );

                echo wp_kses($before,array('li'=>array())) . '<a href="' . get_term_link( $ancestor->slug, get_query_var( 'taxonomy' ) ) . '">' . esc_html( $ancestor->name ) . '</a>' . $after;
            }

            echo wp_kses($before,array('li'=>array())) . esc_html( $current_term->name ) . $after;

        } elseif ( is_tax('product_tag') ) {

            $queried_object = $wp_query->get_queried_object();
            echo wp_kses($prepend, apr_allow_html()). wp_kses($before,array('li'=>array())) . ' ' . esc_html__( 'Products tagged &ldquo;', 'barber' ) . $queried_object->name . '&rdquo;' . $after;

        } elseif ( is_tax('gallery_cat') ){
            if(is_tax('gallery_cat')){
                if(isset($apr_settings['gallery_cat_slug'])){
                    $gallery_cat_slug = $apr_settings['gallery_cat_slug'];
                }
                else {$gallery_cat_slug = "gallery_cat"; }
                echo wp_kses($prepend, apr_allow_html());

                $current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

                $ancestors = array_reverse( get_ancestors( $current_term->term_id, get_query_var( 'taxonomy' ) ) );

                foreach ( $ancestors as $ancestor ) {
                    $ancestor = get_term( $ancestor, get_query_var( 'taxonomy' ) );

                    echo wp_kses($before,array('li'=>array())) . '<a href="' . get_term_link( $ancestor->slug, get_query_var( 'taxonomy' ) ) . '">' . esc_html( $ancestor->name ) . '</a>' . $after;
                }

                echo wp_kses($before,array('li'=>array())) . esc_html( $current_term->name ) . $after;
            }else{
                $queried_object = $wp_query->get_queried_object();
                    echo wp_kses($prepend, apr_allow_html()) . wp_kses($before,array('li'=>array())) . ' ' . esc_html__( 'Recipes tagged &ldquo;', 'barber' ) . $queried_object->name . '&rdquo;' . $after;
            }
        }  elseif ( is_day() ) {

            echo wp_kses($before,array('li'=>array())) . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $delimiter . $after;
            echo wp_kses($before,array('li'=>array())) . '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a>' . $after;
            echo wp_kses($before,array('li'=>array())) . get_the_time('d') . $after;

        } elseif ( is_month() ) {

            echo wp_kses($before,array('li'=>array())) . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $after;
            echo wp_kses($before,array('li'=>array())) . get_the_time('F') . $after;

        } elseif ( is_year() ) {

            echo wp_kses($before,array('li'=>array())) . get_the_time('Y') . $after;

        } elseif ( is_post_type_archive('product') && get_option('page_on_front') !== $shop_page_id ) {

            $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';

            if ( ! $_name ) {
                $product_post_type = get_post_type_object( 'product' );
                $_name = $product_post_type->labels->singular_name;
            }

            if ( is_search() ) {

                echo wp_kses($before,array('li'=>array())) . '<a href="' . get_post_type_archive_link('product') . '">' . $_name . '</a>' . esc_html__( 'Search results for &ldquo;', 'barber' ) . get_search_query() . '&rdquo;' . $after;

            } elseif ( is_paged() ) {

                echo wp_kses($before,array('li'=>array())) . '<a href="' . get_post_type_archive_link('product') . '">' . $_name . '</a>' . $after;

            } else {

                echo wp_kses($before,array('li'=>array())) . $_name . $after;

            }

        }else if(is_post_type_archive('gallery')){
            if(isset($apr_settings['gallery_slug']) && $apr_settings['gallery_slug'] !=""){
                $post_type = get_post_type_object( get_post_type() );
                $slug = $post_type->rewrite;
                echo wp_kses($before,array('li'=>array())) .force_balance_tags($apr_settings['gallery_slug']). $after;
            }else{
                $post_type = get_post_type_object( 'gallery' );
                echo wp_kses($before,array('li'=>array())) . '<a href="' . get_post_type_archive_link('gallery') . '">' .  esc_html($post_type->labels->name) . '</a>' . $after;
            }

        }  elseif ( is_single() && ! is_attachment() ) {

            if ( 'product' == get_post_type() ) {

                echo wp_kses($prepend, apr_allow_html());

                if ( $terms = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ) {
                    $main_term = $terms[0];
                    $ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
                    $ancestors = array_reverse( $ancestors );

                    foreach ( $ancestors as $ancestor ) {
                        $ancestor = get_term( $ancestor, 'product_cat' );

                        if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                            echo wp_kses($before,array('li'=>array())) . '<a href="' . get_term_link( $ancestor ) . '">' . $ancestor->name . '</a>' . $after;
                        }
                    }

                    echo wp_kses($before,array('li'=>array())) . '<a href="' . get_term_link( $main_term ) . '">' . $main_term->name . '</a>' . $after;

                }

                echo wp_kses($before,array('li'=>array())) . get_the_title() . $after;

            }elseif ( 'gallery' == get_post_type() ) {
                $post_type = get_post_type_object( get_post_type() );
                $slug = $post_type->rewrite;
                if(isset($apr_settings['gallery_slug']) && $apr_settings['gallery_slug'] !=""){
                    echo wp_kses($before,array('li'=>array())) . '<a href="' . get_post_type_archive_link( get_post_type() ) . '">' . force_balance_tags($apr_settings['gallery_slug']). '</a>' . $after;
                    echo wp_kses($before,array('li'=>array())) . get_the_title() . $after;
                }else{
                    echo wp_kses($before,array('li'=>array())) . '<a href="' . get_post_type_archive_link( get_post_type() ) . '">' . esc_html($post_type->labels->name). '</a>' . $after;
                    echo wp_kses($before,array('li'=>array())) . get_the_title() . $after;
                }
            }  elseif ( 'post' != get_post_type() ) {
                $post_type = get_post_type_object( get_post_type() );
                $slug = $post_type->rewrite;
                echo wp_kses($before,array('li'=>array())) . '<a href="' . get_post_type_archive_link( get_post_type() ) . '">' . $post_type->labels->singular_name . '</a>' . $after;
                echo wp_kses($before,array('li'=>array())) . get_the_title() . $after;

            }else {

                if ( 'post' == get_post_type() && get_option( 'show_on_front' ) == 'page' ) {
                    echo wp_kses($before,array('li'=>array())) . '<a href="' . get_permalink( get_option('page_for_posts' ) ) . '">' . get_the_title( get_option('page_for_posts', true) ) . '</a>' . $after;
                }

                $cat = current( get_the_category() );
                if ( ( $parents = get_category_parents( $cat, TRUE, $after . $before ) ) && ! is_wp_error( $parents ) ) {
                    echo wp_kses($before,array('li'=>array())) . substr( $parents, 0, strlen($parents) - strlen($after . $before) ) . $after;
                }
                echo wp_kses($before,array('li'=>array())) . get_the_title() . $after;

            }

        } elseif ( is_404() ) {

            echo wp_kses($before,array('li'=>array())) . esc_html__( 'Error 404', 'barber' ) . $after;

        } elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' ) {

            $post_type = get_post_type_object( get_post_type() );

            if ( $post_type ) {
                echo wp_kses($before,array('li'=>array())) . $post_type->labels->singular_name . $after;
            }

        } elseif ( is_attachment() ) {

            $parent = get_post( $post->post_parent );
            $cat = get_the_category( $parent->ID );
            $cat = $cat[0];
            if ( ( $parents = get_category_parents( $cat, TRUE, $after . $before ) ) && ! is_wp_error( $parents ) ) {
                echo wp_kses($before,array('li'=>array())) . substr( $parents, 0, strlen($parents) - strlen($after . $before) ) . $after;
            }
            echo wp_kses($before,array('li'=>array())) . '<a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a>'. $after;
            echo wp_kses($before,array('li'=>array())). get_the_title() . $after;

        } elseif ( is_page() && !$post->post_parent ) {

            echo wp_kses($before,array('li'=>array())) . get_the_title() . $after;

        } elseif ( is_page() && $post->post_parent ) {

            $parent_id  = $post->post_parent;
            $breadcrumbs = array();

            while ( $parent_id ) {
                $page = get_post( $parent_id );
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title( $page->ID ) . '</a>';
                $parent_id  = $page->post_parent;
            }

            $breadcrumbs = array_reverse( $breadcrumbs );

            foreach ( $breadcrumbs as $crumb ) {
                echo $before . $crumb . $after;
            }

            echo wp_kses($before,array('li'=>array())) . get_the_title() . $after;

        } elseif ( is_search() ) {

            echo wp_kses($before,array('li'=>array())) . esc_html__( 'Search results for &ldquo;', 'barber' ) . get_search_query() . '&rdquo;' . $after;

        } elseif ( is_tag() ) {

            echo wp_kses($before,array('li'=>array())) . esc_html__( 'Posts tagged &ldquo;', 'barber' ) . single_tag_title('', false) . '&rdquo;' . $after;

        } elseif ( is_author() ) {

            $userdata = get_userdata($author);
            echo wp_kses($before,array('li'=>array())) . esc_html__( 'Author:', 'barber' ) . ' ' . $userdata->display_name . $after;

        }

        if ( get_query_var( 'paged' ) ) {
            echo wp_kses($before,array('li'=>array())) . '&nbsp;(' . esc_html__( 'Page', 'barber' ) . ' ' . get_query_var( 'paged' ) . ')' . $after;
        }

        echo '</ul>';
    } else {
        if ( is_home() && !is_front_page() ) {
            echo '<ul class="breadcrumb">';

            if ( ! empty( $home ) ) {
                echo wp_kses($before,array('li'=>array())) . '<a class="home" href="' . apply_filters( 'woocommerce_breadcrumb_home_url', home_url('/') ) . '"><i class="' . $icon_home . '"></i> ' . $home . '</a>' . $after;

                echo wp_kses($before,array('li'=>array())) . force_balance_tags($apr_settings['blog-title']) . $after;
            }

            echo '</ul>';
        }
    }
}
}
if ( ! function_exists ( 'apr_page_title' ) ) {
function apr_page_title() {

    global $apr_settings, $post, $wp_query, $author;

    $home = esc_html__('Home', 'barber');

    $shop_page_id = false;
    $front_page_shop = false;
    if ( defined( 'WOOCOMMERCE_VERSION' ) ) {
        $shop_page_id = wc_get_page_id( 'shop' );
        $front_page_shop = get_option( 'page_on_front' ) == wc_get_page_id( 'shop' );
    }

    if ( ( ! is_home() && ! is_front_page() && ! ( is_post_type_archive() && $front_page_shop ) ) || is_paged() ) {

        if ( is_home() ) {

        } else if ( is_category() ) {

            echo single_cat_title( '', false );

        } elseif ( is_search() ) {

            echo esc_html__( 'Search results for &ldquo;', 'barber' ) . get_search_query() . '&rdquo;';

        } elseif ( is_tax('product_cat') || is_tax('portfolio_cat')) {

            $current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

            echo esc_html( $current_term->name );

        } elseif ( is_tax('gallery_cat') ) {

            $queried_object = $wp_query->get_queried_object();
            echo  $queried_object->name ;

        } elseif ( is_tax('product_tag') ) {

            $queried_object = $wp_query->get_queried_object();
            echo esc_html__( 'Products tagged &ldquo;', 'barber' ) . $queried_object->name . '&rdquo;';

        } elseif(is_tax('kbe_tags')){
             echo esc_html__( 'Knowledge tagged &ldquo;', 'barber' ) . get_queried_object()->name . '&rdquo;';
        } elseif(is_tax('kbe_taxonomy')){
             echo esc_html( get_queried_object()->name );
        } elseif ( is_day() ) {

            printf( esc_html__( 'Daily Archives: %s', 'barber' ), get_the_date() );

        } elseif ( is_month() ) {

            printf( esc_html__( 'Monthly Archives: %s', 'barber' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'barber' ) ) );

        } elseif ( is_year() ) {

            printf( esc_html__( 'Yearly Archives: %s', 'barber' ), get_the_date( _x( 'Y', 'yearly archives date format', 'barber' ) ) );

        } elseif ( is_post_type_archive('product') && get_option('page_on_front') !== $shop_page_id ) {

            $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';

            if ( ! $_name ) {
                $product_post_type = get_post_type_object( 'product' );
                $_name = $product_post_type->labels->singular_name;
            }

            if ( is_search() ) {
                echo esc_html__( 'Search results for &ldquo;', 'barber' ) . get_search_query() . '&rdquo;';
            } elseif ( is_paged() ) {

            } else {

                echo $_name;

            }

        } elseif ( is_post_type_archive('hb_room') ) {

            $post_type = get_post_type_object( 'hb_room' );
            echo esc_html__( 'All Rooms', 'barber' );

        } else if(is_post_type_archive('gallery')){
            if(isset($apr_settings['gallery_slug']) && $apr_settings['gallery_slug'] !=""){
                echo force_balance_tags($apr_settings['gallery_slug']);
            }else{
                $post_type = get_post_type_object( 'gallery' );
                echo $post_type->labels->name;
            }

        }else if(is_post_type_archive('pressmedia')){
            if(isset($apr_settings['press-media-title']) && $apr_settings['press-media-title'] !=""){
                echo force_balance_tags($apr_settings['press-media-title']);
            }else{
                echo esc_html__( 'Press Media', 'barber' );
            }

        }
        else if ( is_post_type_archive() ) {
            sprintf( esc_html__( 'Archives: %s', 'barber' ), post_type_archive_title( '', false ) );
        } elseif ( is_single() && ! is_attachment() ) {

            if ( 'gallery' == get_post_type() ) {

                echo get_the_title();

            } else {

                echo get_the_title();

            }

        } elseif ( is_404() ) {

            echo esc_html__( 'Error 404', 'barber' );

        } elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' ) {

            $post_type = get_post_type_object( get_post_type() );

            if ( $post_type ) {
                echo $post_type->labels->singular_name;
            }

        } elseif ( is_attachment() ) {

            echo get_the_title();

        } elseif ( is_page() && !$post->post_parent ) {

            echo get_the_title();

        } elseif ( is_page() && $post->post_parent ) {

            echo get_the_title();

        } elseif ( is_search() ) {

            echo esc_html__( 'Search results for &ldquo;', 'barber' ) . get_search_query() . '&rdquo;';

        } elseif ( is_tag() ) {

            echo esc_html__( 'Posts tagged &ldquo;', 'barber' ) . single_tag_title('', false) . '&rdquo;';

        } elseif ( is_author() ) {

            $userdata = get_userdata($author);
            echo esc_html__( 'Author:', 'barber' ) . ' ' . $userdata->display_name;

        }

        if ( get_query_var( 'paged' ) ) {
            echo ' (' . esc_html__( 'Page', 'barber' ) . ' ' . get_query_var( 'paged' ) . ')';
        }
    } else {
        if ( is_home() && !is_front_page() ) {
            if ( ! empty( $home ) ) {
                echo force_balance_tags($apr_settings['blog-title']);
            }
        }
    }
}
}
?>
