<?php 

function apr_scripts_styles() {

    wp_enqueue_style( 'apr-fonts', apr_fonts_url(), array(), null );

    global $apr_settings;
    if(isset($apr_settings['primary-color'])){
        $apr_main_color = apr_get_meta_value('main_color')!=''?apr_get_meta_value('main_color'):$apr_settings['primary-color'];
    }else{
        $apr_main_color = '#8262b5';
    }
    $apr_highlight_color = isset($apr_settings['highlight-color'])?$apr_settings['highlight-color']:'#000';
    $apr_cus_font = apr_get_meta_value('cus_font');

    $apr_custom_css ='';

    if (isset($apr_main_color) && $apr_main_color != '') :

        ?>

        <?php 

            $apr_custom_css .= "
                a:focus, a:hover,
                [class*='header-'] .open-menu-mobile:hover, 
                [class*='header-'] .searchform_wrap form button:hover, 
                [class*='header-'] .header-contact a:hover, 
                [class*='header-'] .mega-menu li.current_page_parent > a, 
                [class*='header-'] .mega-menu .sub-menu li.current-menu-item > a, 
                [class*='header-'] .widget_shopping_cart_content ul li a:hover,
                .mega-menu li .sub-menu li a:hover,
                .open-menu:hover,.social_icon li a,
                .header-sidebar h4,
                .header-myaccount i:hover,
                .close-menu, .close-menu-mobile,
                .mini-cart .cart_label:hover,
                .mega-menu > li.menu-item.current-menu-item > a, 
                .mega-menu > li.menu-item.current-menu-parent > a,
                .header-v10 .header-right .social_icon li a:hover,
                .search-block-top .btn-search:hover,
                .header-v3 .search-block-top .top-search .btn-search:hover, 
                .header-v8 .search-block-top .top-search .btn-search:hover, 
                .header-v9 .search-block-top .top-search .btn-search:hover,
                .header-v8 .header-right .social_icon li a:hover, .header-v9 .header-right .social_icon li a:hover,
                .main-color .uvc-main-heading >h2,
                .baber-heading .header_icon,
                .icon_box_content:hover .icon_box_title h3,
                .icon_box_title h4,
                .icon_box,
                .single-gallery .vertical_list .port_share a:hover,
                .custom-banner-1 .banner-type2 .banner-btn a:hover,
                .bg-overlay .button-group .btn-filter.is-checked, 
                .bg-overlay .button-group .btn-filter:hover,
                .button-group .btn-filter:before,
                .member-info .link-text a:hover,
                .box-pricing-tt h2,
                .caption_testimonial .title-testimonial h2,
                .type1.blog-info .author a,
                .grid_style_1 .blog-date a:hover,
                .button-group .btn-filter.is-checked, .button-group .btn-filter:hover,
                .post-name a:hover,
                .footer-newsletter .mc4wp-form label,
                .list-info-footer li i,
                .list-info-footer li a:hover,
                .footer-social li a:hover,
                .footer-content .widget_nav_menu ul li a:hover,
                .product-content .price .amount,
                .product-content .price .amount span,
                .btn.btn-default,
                .member-info .member-job,
                .caption_testimonial .tes_name h4,
                .title-portfolio .title-left::before,
                .title-portfolio .title-left h3,.icon_box_content.type_2:hover .icon_box_title h3,
                .pricing-content.style2 .price-center,
                .footer-newsletter.newletter-2 .mc4wp-form label,
                .footer-v2 .footer-content .widget_nav_menu ul li a:hover,
                .footer-newsletter.type1 .mc4wp-form .submit:hover [type='submit'],
                .footer-newsletter.newletter-2 .mc4wp-form label span,
                .footer-newsletter.type1 .mc4wp-form .submit:hover:before,
                .banner-type1 .banner-title h3,
                .pricing-list-3 li .price-list,
                .member-type2 .member-desc h2,
                .member-type2 .link-text a,
                .member-type2 .btn-next,
                .list-item-info .icon,
                .product-content h3 a:hover,
                .post-single.single-4 .blog-info .info-cat:hover, 
                .post-single.single-4 .blog-info .info-tag:hover, 
                .post-single.single-4 .blog-info .info-comment:hover, 
                .post-single.single-4 .blog-info .info-like:hover,
                .post-single.single-4 .blog-info .info-cat:hover a, 
                .post-single.single-4 .blog-info .info-tag:hover a, 
                .post-single.single-4 .blog-info .info-comment:hover a, 
                .post-single.single-4 .blog-info .info-like:hover a,
                .post-single.single-2 .blog-info .info-cat:hover, 
                .post-single.single-2 .blog-info .info-tag:hover, 
                .post-single.single-2 .blog-info .info-comment:hover, 
                .post-single.single-2 .blog-info .info-like:hover,
                .post-single.single-2 .blog-info .info-cat:hover a, 
                .post-single.single-2 .blog-info .info-tag:hover a, 
                .post-single.single-2 .blog-info .info-comment:hover a, 
                .post-single.single-2 .blog-info .info-like:hover a,
                .post-single.single-3 .blog-info .info-cat:hover, 
                .post-single.single-3 .blog-info .info-tag:hover, 
                .post-single.single-3 .blog-info .info-comment:hover, 
                .post-single.single-3 .blog-info .info-like:hover,
                .post-single.single-3 .blog-info .info-cat:hover a, 
                .post-single.single-3 .blog-info .info-tag:hover a, 
                .post-single.single-3 .blog-info .info-comment:hover a, 
                .post-single.single-3 .blog-info .info-like:hover a,
                .footer-v10 .widget_nav_menu li a:hover,
                .footer-v10 .footer-social li a:hover,
                .footer-v10 a.to-top:hover,
                .footer-v9 .footer-social li a:hover,
                .footer-v9 .footer-newsletter .submit:hover:before,
                .header-v4 .search-block-top .top-search .btn-search:hover,
                .list-item-info .info-mail a:hover, .list-item-info .info-number a:hover,
                .barber_container.title-abs .header_icon,
                .baber-1 .tp-bullet:hover, .baber-1 .tp-bullet.selected,
                .banner-type1.banner-type3 .banner-title h2,
                .icon_box_content.type_1.icon_box_3 .icon_box,
                .uavc-list-icon .uavc-list > li .ult-just-icon-wrapper .align-icon .aio-icon,
                .block-text h2,
                .block-text:hover .text-content h3,
                .list-item-box li:before,
                .footer-v6 .footer-social li a:hover,
                .list-item-box li:before,
                .box-text-sidebar h4,
                .widget_search form .btn-search:hover, 
                .widget_product_search form .btn-search:hover,
                .widget_archive li:hover a, .widget_categories li:hover a, 
                .widget_archive li.current-cat > a, .widget_categories li.current-cat > a,
                .widget_product_categories li.current-cat > a, 
                .widget_pages li.current-cat > a, .widget_meta li.current-cat > a,
                .widget_product_categories li:hover a, .widget_pages li:hover a, .widget_meta li:hover a,
                .widget_archive li a:before, .widget_categories li a:before, .widget_product_categories li a:before,
                .widget_pages li a:before, .widget_meta li a:before,
                .widget_archive li:hover span, .widget_categories li:hover span, .widget_product_categories li:hover span, 
                .widget_pages li:hover span, .widget_meta li:hover span,
                .widget_post_blog .blog-post-info .blog-time a,
                .viewmode-toggle a:hover, .viewmode-toggle a:focus, .viewmode-toggle a.active,
                .tagcloud a:hover,
                .breadcrumb li a:hover,
                .addthis_sharing_toolbox .f-social li a:hover,
                .list_s2 .blog-date .date a:hover,
                .blog-info .author a:hover, .blog-info .info-comment a:hover,
                .comment-body .comment-bottom .links-info a:hover,
                .page-numbers li .page-numbers:hover, .page-numbers li .page-numbers.current,
                .post-single.single-2 .blog-info .info-cat a:hover, 
                .post-single.single-2 .blog-info .info-tag a:hover, 
                .post-single.single-2 .blog-info .info-comment a:hover, 
                .post-single.single-2 .blog-info .info-like a:hover,
                .post-single.single-3 .blog-info .info-cat a:hover, 
                .post-single.single-3 .blog-info .info-tag a:hover, 
                .post-single.single-3 .blog-info .info-comment a:hover, 
                .post-single.single-3 .blog-info .info-like a:hover,
                .tt-instagram .uvc-sub-heading > a:hover,
                .info .price span, #yith-quick-view-content .price span,
                .shop_table .cart_item .product-remove a,.title-cart-sub,
                .showlogin, .showcoupon,
                .shop_table .cart_item .product-name a:hover,
                .wishlist_table .product-remove a,
                .woocommerce .wishlist_table .product-name a.yith-wcqv-button,
                .woocommerce-page .wishlist_table .product-price .amount,
                .shop_table .product-subtotal span, .shop_table .product-price span,
                .woocommerce-pagination .page-numbers > li .current, 
                .yith-woocompare-widget ul.products-list li .remove,
                .close_search_form:hover,.search-title p,
                .yith-woocompare-widget ul.products-list li .title:hover,
                .widget_post_blog .blog-post-info .post-name > a:hover,
                .woocommerce-message,
                .tt-instagram .uvc-sub-heading > a,
                .woocommerce-pagination .page-numbers > li a:hover,
                .header-profile ul a:hover,
                .member-type2 .btn-prev,
                .uvc-sub-heading > a,
                .info.info-cat:hover > i,
                .info.info-tag:hover > i,
                .blog-info a:hover,
                .list_s3 .blog-content .blog-post-info .blog-info a:hover,
                .blog-masonry .blog-content .blog-item .blog-info a:hover,
                .wpb_text_column .sln-alert.sln-alert--wait, .wpb_text_column .sln-alert.sln-alert--wait:after, .wpb_text_column .sln-alert, .wpb_text_column .sln-alert a:hover, .wpb_text_column #sln-salon .alert a:hover, .wpb_text_column .sln-steps-name:hover,
                .banner-type4 .banner-mid h2 a:hover,
                .wpb-js-composer .tab-custom.vc_tta-color-grey.vc_tta-style-classic .vc_tta-tab.vc_active>a,
                .wpb-js-composer .tab-custom.vc_tta.vc_tta-spacing-1 .vc_tta-tab a:hover{

                    color: {$apr_main_color};

                }

                .ult_tabs .ult_tabmenu.style3 > li.ult_tab_li.current a, 
                .ult_tabs .ult_tabmenu.style3 > li.ult_tab_li:hover a,
                .slick-next:hover, .slick-p,rev:hover,
                .main-color .uvc-main-heading > h2,
                .mega-menu li a:hover, .mega-menu li a:focus,
                .barber-2 .tp-bullet:hover, .barber-2 .tp-bullet.selected,
                .box_banner_4 .ult-content-box-container:hover .vc_custom_heading,
                .main-color, .slick-next:hover, .slick-prev:hover,
                .ult_tabs .ult_tabmenu.style3 > li.ult_tab_li.current a .ult_tab_icon, 
                .ult_tabs .ult_tabmenu.style3 > li.ult_tab_li:hover a .ult_tab_icon,
                .slick-arrow-top .slick-next:hover, .slick-arrow-top .slick-prev:hover{

                    color: {$apr_main_color} !important;

                }

                .main-bg_color, .main-bg_color.ult-content-box-container, 
                .main-bg_color > .vc_column-inner, 
                .main-bg_color > .upb_row_bg, 
                .main-bg_color.vc_row,
                .bg-overlay figure:before,
                .button-group .btn-filter:before,
                .button-group .btn-filter:after,
                .ult-carousel-wrapper .slick-dots li.slick-active,
                .product-content .product-action,
                .btn.btn-primary,
                .btn.btn-black:hover, .btn.btn-black:focus, .btn.btn-black:active,
                .blog-img.hover-mask:before,
                .footer-newsletter .mc4wp-form [type='submit'],
                .instagram-container li a:before,
                .barber-2 .tp-bullet:after,
                .mini-cart .cart_nu_count,
                .barber-2 .tp-bullet.selected:after,
                .scroll-to-top,
                .img-before::before,
                .rev_slider_wrapper .custom .tp-bullet:hover, 
                .rev_slider_wrapper .custom .tp-bullet.selected,
                .gallery-style2 .gallery-img:before,
                .grid_style_2 .blog-date,
                .blog-date,
                .footer-newsletter.newletter-2 .mc4wp-form [type='submit'],
                .contact-info,
                .btn-plus:before, .btn-plus:after,
                .vc_btn_primary .vc_general.vc_btn3-icon-right,
                .instagram-type1 .title-insta,
                .uavc-list-icon .uavc-list > li .uavc-list-icon:after,
                .instagram-type3 .instagram-img a::before,
                .ares .tp-bullet:hover, .ares .tp-bullet.selected,
                .box_banner_4 .ult-content-box-container:hover .banner_home4:after,
                .baber-1 .tp-bullet:hover:after, .baber-1 .tp-bullet.selected:after,
                .banner-type4 .banner-mid h2::before,
                .custom-progress.vc_progress_bar .vc_single_bar .vc_bar,
                .contact-8 .wpcf7,
                .widget_post_blog .blog-img:before,
                .list_s2 .post-name a:before,
                .arrows-custom .slick-arrow:hover,
                .blog-item .post_link i,
                .list-items.style1 li:before,
                .post-comments .comment-reply-title:before, 
                .post-comments .widget-title:before,
                .comment-body .comment-author:before,
                .comment-body .comment-author:after,
                .contact-form2 .btn-submit input[type='submit'],
                .box-scheduce .ult-content-box:before,
                .info .single_add_to_cart_button, .info .add_to_cart_button, 
                #yith-quick-view-content .single_add_to_cart_button,
                #yith-quick-view-content .add_to_cart_button,
                .product-tab .nav-tabs > li a:hover, .product-tab .nav-tabs > li a:focus,
                .product-tab .nav-tabs > li.active a,
                .widget_price_filter .ui-slider .ui-slider-handle,
                #barber_services .icon_box,
                .demos-buy-button,
                .widget_price_filter .price_slider_amount .button,
                .woocommerce-page .wishlist_table .product-add-to-cart .button,
                .single-product .products > h2.title_related:before,
                .title-cart:before,
                .woocommerce .login .form-row input.button,
                .side-breadcrumb.type-3.has-overlay:before,
                .ubtn-link.main-bg > button,
                .fancybox-nav span:hover,
                .service-page-2 .icon_box_content .icon_box,
                .countdown_home4:before,
                .page-coming-soon .mc4wp-form input[type='submit'],
                .has_overlay:before,
                #blog-loadmore:hover,
                .wpb_text_column .sln-radiobox input:checked + label:after, .wpb_text_column .sln-radiobox input:checked + label:hover:after,
                .wpb_text_column .sln-radiobox input + label:hover:after,
                .wpb-js-composer .tab-custom.vc_tta.vc_tta-spacing-1 .vc_tta-tab.vc_active a .vc_tta-title-text:before,
                .wpb-js-composer .tab-custom.vc_tta.vc_tta-spacing-1 .vc_tta-tab a .vc_tta-title-text:before,
                .wpb-js-composer .tab-custom.vc_tta.vc_tta-spacing-1 .vc_tta-tab.vc_active a .vc_tta-title-text:after,
                .wpb-js-composer .tab-custom.vc_tta.vc_tta-spacing-1 .vc_tta-tab a .vc_tta-title-text:after{

                  background: {$apr_main_color};

                }

                .ult_tabs .ult_tabmenu.style3 > li.ult_tab_li,
                .member-bg .style-2 .item-member-content:hover .member-info,
                .footer-top,
                .style-2 .item-member-content:hover .member-info,
                .btn.btn-default:hover, .btn.btn-default:focus, .btn.btn-default:active,
                .rev-btn.button-slide1,
                .wpb_text_column #sln-salon .sln-panel .sln-panel-heading .sln-btn--nobkg:hover,
                .wpb_text_column #sln-salon .sln-panel .sln-panel-heading .sln-btn--nobkg:active,
                .wpb_text_column #sln-salon .sln-panel .sln-panel-heading .sln-btn--nobkg{

                   background: {$apr_main_color} !important;

                }

                #btn_appointment,
                #loading, #loading-2, #loading-3, 
                .preloader-4, .preloader-5, #loading-6,
                #loading-7, #loading-9, .loader-8,.wpb_text_column #sln-salon .sln-btn--medium input, .wpb_text_column #sln-salon .sln-btn--medium button, .wpb_text_column #sln-salon .sln-btn--medium a, .wpb_text_column #sln-salon.sln-salon--m .sln-btn--big,
                .wpb_text_column #sln-salon .sln-box--formactions .sln-btn.sln-btn--borderonly:hover,
                #sln-salon .sln-btn--medium input,#sln-salon .sln-btn--medium button, #sln-salon .sln-btn--medium a,
                #sln-salon.sln-salon--m .sln-btn--big,#sln-salon .sln-btn--emphasis, #sln-salon .sln-bootstrap .sln-btn--emphasis                {

                    background-color:{$apr_main_color};

                }

                .close-menu, .close-menu-mobile,

                .social_icon li a,

                .mini-cart .cart-block,

                .mini-cart .count-item,

                .content-filter,

                .member-type2 .btn-next,

                #btn_appointment,

                .border-slide,.instagram-type2::before,

                .btn.btn-black:hover, .btn.btn-black:focus, .btn.btn-black:active,

                .uavc-list-icon .uavc-list > li .ult-just-icon-wrapper,

                .single-gallery .vertical_list .port_share a:hover,

                .page-numbers li .page-numbers:hover, .page-numbers li .page-numbers.current,

                .tagcloud a:hover,

                blockquote,

                .footer-v7 .list-item-info .icon:hover,

                .addthis_sharing_toolbox .f-social li a:hover,

                .contact-form2 .btn-submit input,

                .ult_tabmenu.style1 a.ult_a:hover,

                .ult_tabmenu.style1 .ult_tab_li.current > a,

                .viewmode-toggle a:hover, .viewmode-toggle a:focus, .viewmode-toggle a.active,

                .woocommerce .login .form-row input.button,

                .woosearch-results,

                .btn.btn-primary,

                .member-type2 .btn-prev,

                .list-item-info .icon:hover,

                .btn.btn-default,.wpb_text_column #sln-salon .sln-btn--medium input, .wpb_text_column #sln-salon .sln-btn--medium button, .wpb_text_column #sln-salon .sln-btn--medium a, .wpb_text_column #sln-salon.sln-salon--m .sln-btn--big,
                .wpb_text_column #sln-salon .sln-box--formactions .sln-btn.sln-btn--borderonly:hover,
                #sln-salon .sln-btn--medium input,#sln-salon .sln-btn--medium button, #sln-salon .sln-btn--medium a,
                #sln-salon.sln-salon--m .sln-btn--big,#sln-salon .sln-btn--emphasis, #sln-salon .sln-bootstrap .sln-btn--emphasis{

                  border-color:{$apr_main_color};

                }

                .shop_table tbody tr:first-child td{

                     border-top-color:{$apr_main_color};

                }
                #sln-salon #sln-salon-my-account .table thead td{
                    border-bottom: 2px solid {$apr_main_color} !important;
                }
                .custom-progress.vc_progress_bar .vc_single_bar .vc_bar:before{

                  border-color:transparent transparent transparent {$apr_main_color};

                }

                .custom-progress.vc_progress_bar .vc_progress_value::before {

                    border-color:{$apr_main_color} transparent transparent;

                }

                .baber-heading.style-heading-2 .header_icon:before{

                  background: -moz-linear-gradient(0deg, $apr_main_color 0%, rgba(255,255,255,0.1) 100%);

                  background: -webkit-gradient(linear, left top, right top, color-stop(0%, $apr_main_color), color-stop(100%, rgba(255,255,255,0.1)));

                  background: -webkit-linear-gradient(0deg, $apr_main_color 0%, rgba(255,255,255,0.1) 100%); 

                  background: -o-linear-gradient(0deg, $apr_main_color 0%, rgba(255,255,255,0.1) 100%); 

                  background: -ms-linear-gradient(0deg, $apr_main_color 0%, rgba(255,255,255,0.1) 100%); 

                  background: linear-gradient(90deg, $apr_main_color 0%, rgba(255,255,255,0.1) 100%); 

                  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$apr_main_color', endColorstr='rgba(255,255,255,0.1)',GradientType=1 );

                }

                .baber-heading.style-heading-2 .header_icon:after{

                  background: -moz-linear-gradient(0deg, $apr_main_color 0%, rgba(255,255,255,0.1) 100%);

                  background: -webkit-gradient(linear, left top, right top, color-stop(0%, $apr_main_color), color-stop(100%, rgba(255,255,255,0.1)));

                  background: -webkit-linear-gradient(0deg, $apr_main_color 0%, rgba(255,255,255,0.1) 100%); 

                  background: -o-linear-gradient(0deg, $apr_main_color 0%, rgba(255,255,255,0.1) 100%); 

                  background: -ms-linear-gradient(0deg, $apr_main_color 0%, rgba(255,255,255,0.1) 100%); 

                  background: linear-gradient(-90deg, $apr_main_color 0%, rgba(255,255,255,0.1) 100%); 

                  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$apr_main_color', endColorstr='rgba(255,255,255,0.1)',GradientType=1 ); 

                }

                @media (min-width: 992px){

                  .mega-menu > li > a:after,

                  .height-900:first-child::before,

                  .mega-menu > li > a:before {

                      background:{$apr_main_color};

                  }

                  .mega-menu > li:not(.megamenu) .sub-menu, .mega-menu > li > .sub-menu{

                    border-color :{$apr_main_color};

                  }

                }

                @media (min-width: 768px){

                    .header-profile ul a:before,

                  .uavc-list-icon .uavc-list > li .ult-just-icon-wrapper:hover,

                  .list-item-info .icon:hover,

                  .pricing-content.style2 .pricing-box:hover .btn.btn-black,

                  .icon_box_content:hover .icon_box,

                  .pricing-content.style1.active .pricing-box .price-box {

                      background: {$apr_main_color};

                  }

                  .pricing-content.style2 .pricing-box:hover .btn.btn-black{

                    border-color:{$apr_main_color};

                  }

                }

                .cart-block::-webkit-scrollbar-thumb{

                     background-color: {$apr_main_color} !important;

                }

            ";

        ?>        

    <?php endif;

    if (isset($apr_highlight_color) && $apr_highlight_color != '') :?>
        <?php 

            $apr_custom_css .= "

            .ubtn-link.main-bg:hover > button,
            .scroll-to-top:hover,
            .page-coming-soon .mc4wp-form input[type='submit']:hover{

                background: {$apr_highlight_color};

            }
            .uvc-sub-heading > a:hover{
                color: {$apr_highlight_color};
            }
            .btn.btn-primary:hover, .btn.btn-primary:focus, .btn.btn-primary:active,
            #btn_appointment:hover, #btn_appointment:active, #btn_appointment:focus,
            .wpb_text_column #sln-salon .sln-btn--medium input:hover, .wpb_text_column #sln-salon .sln-btn--medium button:hover, .wpb_text_column #sln-salon .sln-btn--medium a:hover, .wpb_text_column #sln-salon.sln-salon--m .sln-btn--big:hover,.wpb_text_column #sln-salon .sln-box--formactions .sln-btn.sln-btn--borderonly,
                 #sln-salon .sln-btn--medium input:hover,#sln-salon .sln-btn--medium button:hover, #sln-salon .sln-btn--medium a:hover,
                #sln-salon.sln-salon--m .sln-btn--big:hover,#sln-salon .sln-btn--emphasis:hover, #sln-salon .sln-bootstrap .sln-btn--emphasis:hover            {
                background-color:{$apr_highlight_color};
                border-color: {$apr_highlight_color};
            }            
            ";

        ?>            
    <?php endif;

    if (isset($apr_cus_font) && $apr_cus_font != 'default' && $apr_cus_font != '') :

        ?>

        <?php 

            $apr_custom_css .= "

            header,

            .megamenu.notsub_level-2 ul.sub-menu > li > a{

                font-family: '{$apr_cus_font}';

            }";

        ?>        

    <?php endif;  

    if(isset($apr_settings['breadcrumbs-overlay-color']) && $apr_settings['breadcrumbs-overlay-color'] !=''){
        $apr_custom_css .= "
            .side-breadcrumb.has-overlay::before{
                background-color: {$apr_settings['breadcrumbs-overlay-color']};
            }
        ";        
    } 
    if(isset($apr_settings['breadcrumbs_align']) && $apr_settings['breadcrumbs_align'] !=''){
        $apr_custom_css .= "
            .side-breadcrumb{
                text-align: {$apr_settings['breadcrumbs_align']};
            }
        ";        
    }        
    if(isset($apr_settings['breadcrumbs_padding']) && $apr_settings['breadcrumbs_padding'] !=''){
        $apr_custom_css .= "
            .side-breadcrumb{
                padding-left: {$apr_settings['breadcrumbs_padding']['padding-left']};
                padding-top: {$apr_settings['breadcrumbs_padding']['padding-top']};
                padding-right: {$apr_settings['breadcrumbs_padding']['padding-right']};
                padding-bottom: {$apr_settings['breadcrumbs_padding']['padding-bottom']};
            }
        ";        
    } 
    if(isset($apr_settings['title-breadcrumbs-font']) && $apr_settings['title-breadcrumbs-font'] !=''){
        $apr_custom_css .= "
            .side-breadcrumb .page-title h1{
                font-family: {$apr_settings['title-breadcrumbs-font']['font-family']};
                color: {$apr_settings['title-breadcrumbs-font']['color']};
                font-size: {$apr_settings['title-breadcrumbs-font']['font-size']};
                font-weight: {$apr_settings['title-breadcrumbs-font']['font-weight']};
            }
        ";        
    }   
    if(isset($apr_settings['link-breadcrumbs-font']) && $apr_settings['link-breadcrumbs-font'] !=''){ 
        if(isset($apr_settings['link-breadcrumbs-font']['color']) && $apr_settings['link-breadcrumbs-font']['color']!=''){
                $apr_custom_css .= "
                    .breadcrumb,
                    .breadcrumb li a,
                    .breadcrumb > li + li::before{
                        color: {$apr_settings['link-breadcrumbs-font']['color']};
                    }
                ";              
        }          
        if(isset($apr_settings['link-breadcrumbs-font']['font-weight']) && $apr_settings['link-breadcrumbs-font']['font-weight']!=''){
                $apr_custom_css .= "
                    .breadcrumb,
                    .breadcrumb li a,
                    .breadcrumb > li + li::before{
                        font-weight: {$apr_settings['link-breadcrumbs-font']['font-weight']};
                    }
                ";              
        }  
        if(isset($apr_settings['link-breadcrumbs-font']['font-size']) && $apr_settings['link-breadcrumbs-font']['font-size']!=''){
                $apr_custom_css .= "
                    .breadcrumb,
                    .breadcrumb li a,
                    .breadcrumb > li + li::before{
                        font-size: {$apr_settings['link-breadcrumbs-font']['font-size']};
                    }
                ";              
        }  
        if(isset($apr_settings['link-breadcrumbs-font']['font-family']) && $apr_settings['link-breadcrumbs-font']['font-family']!=''){
                $apr_custom_css .= "
                    .breadcrumb,
                    .breadcrumb li a,
                    .breadcrumb > li + li::before{
                        font-family: {$apr_settings['link-breadcrumbs-font']['font-family']};
                    }
                ";              
        }                  
    }      

    if(isset($apr_settings['header-bg']) && $apr_settings['header-bg'] !=''){

        $apr_custom_css .= "

            .header-v1, .header-v5, .header-v7, 

            .fixed-header .header-v1.is-sticky,

            .fixed-header .header-v5.is-sticky,

            .fixed-header .header-v7.is-sticky,

            .mega-menu li .sub-menu,

            .content-filter, .header-ver,

            .searchform_wrap{

                background-color: {$apr_settings['header-bg']};

            }

            @media (max-width: 991px){

                .fixed-header .header-bottom,

                .header-center{

                    background-color: {$apr_settings['header-bg']};

                }

            }

        ";         

    }
    if(isset($apr_settings['header-bg-image']) && $apr_settings['header-bg-image'] !=''){
        $apr_custom_css .= "
            @media (max-width: 991px){
                .fixed-header .header-bottom{
                    background-image: url('{$apr_settings['header-bg-image']['background-image']}');
                    background-repeat: {$apr_settings['header-bg-image']['background-repeat']};
                    background-size: {$apr_settings['header-bg-image']['background-size']};
                    background-attachment: {$apr_settings['header-bg-image']['background-attachment']};
                    background-position: {$apr_settings['header-bg-image']['background-position']};               
                }
            }
        ";          
    }
	if(isset($apr_settings['header-overlay-color']) && $apr_settings['header-overlay-color'] !=''){
        $apr_custom_css .= "
            .header-wrapper::before{
                background-color: {$apr_settings['header-overlay-color']};
            }
        ";        
    } 
	if(isset($apr_settings['header-opacity']) && $apr_settings['header-opacity'] !=''){
        $apr_custom_css .= "
            .header-wrapper::before{
                opacity: {$apr_settings['header-opacity']};
            }
        ";        
    }
    if(isset($apr_settings['header-bg-hover']) && $apr_settings['header-bg-hover'] !=''){

        $apr_custom_css .= "

            .mega-menu li .sub-menu li a:hover,

            .header-profile ul li:hover a{

                background-color: {$apr_settings['header-bg-hover']};

            }

        ";         

    }

    if(isset($apr_settings['header-menu-color']) && $apr_settings['header-menu-color'] !=''){

        $apr_custom_css .= "

            .header_icon,

            .languges-flags a,

            .search-block-top, 

            .mini-cart > a,

            .mega-menu > li > a,

            .mega-menu li .sub-menu li a,

            .slogan,.header-contact a, 

            .searchform_wrap input,

            .searchform_wrap form button,

            .widget_shopping_cart_content ul li.empty,

            .open-menu-mobile,

            .nav-sections .nav-tabs > li > a,

            .social-mobile h5, .contact-mobile h5,

            .social-sidebar .twitter-tweet .tweet-text,

            .widget_shopping_cart_content ul li a,

            .widget_shopping_cart_content .total,

            .mini-cart .product_list_widget .product-content .product-title,

            .mega-menu .product_list_widget .product-content .product-title,

            .header-profile ul a

            {

                color: {$apr_settings['header-menu-color']};

            }

        ";        

    } 



    if(isset($apr_settings['header-border-color']) && $apr_settings['header-border-color'] !=''){

        $apr_custom_css .= "

            .mega-menu li .sub-menu li a,

            .searchform_wrap .vc_child,

            .header-v1, .social-mobile,

            .main-navigation .mega-menu li .sub-menu li:last-child > a,

            .widget_shopping_cart_content ul li,

            .header-profile ul li,

            .contact-mobile {

              border-color: {$apr_settings['header-border-color']};

            }

            @media (max-width: 991px){

                .main-navigation .mega-menu > li.menu-item > a,

                .nav-sections ul.nav-tabs,

                .nav-tabs > li > a,

                .main-navigation .caret-submenu,

                .main-navigation .menu-block1,

                .main-navigation .menu-block2,

                .header-v7 .header-center,

                .header-bottom.header-v7 .header-center{

                    border-color: {$apr_settings['header-border-color']};

                }

            }

        ";

    } 

    if(isset($apr_settings['bg_header_sidebar']) && $apr_settings['bg_header_sidebar'] !=''){

        $apr_custom_css .= "
            .header-v2 .header-ver,

            .header-v3 .header-ver,

            .header-v4 .header-ver,

            .header-v8 .header-ver,

            .header-v9 .header-ver{
                background-color: {$apr_settings['bg_header_sidebar']};
            }
        "
        ;
    }

    if(isset($apr_settings['header2-bg']) && $apr_settings['header2-bg'] !=''){

        $apr_custom_css .= "

            .header-v2, .header-v3, .header-v4, 

            .header-v8, .header-v9,

            .fixed-header .header-v2.is-sticky,

            .fixed-header .header-v3.is-sticky,

            .fixed-header .header-v4.is-sticky,

            .fixed-header .header-v8.is-sticky,

            .fixed-header .header-v9.is-sticky,

            .header-v2 .mega-menu li .sub-menu,

            .header-v3 .mega-menu li .sub-menu,

            .header-v4 .mega-menu li .sub-menu,

            .header-v8 .mega-menu li .sub-menu,

            .header-v9 .mega-menu li .sub-menu,

            .header-v2 .content-filter,

            .header-v3 .content-filter,

            .header-v4 .content-filter,

            .header-v8 .content-filter,

            .header-v9 .content-filter,

            .header-v2 .searchform_wrap,

            .header-v3 .searchform_wrap,

            .header-v4 .searchform_wrap,

            .header-v8 .searchform_wrap,

            .header-v9 .searchform_wrap{

                background-color: {$apr_settings['header2-bg']};

            }

            @media (max-width: 991px){

                .fixed-header .header-v2.header-bottom,

                .fixed-header .header-v3.header-bottom,

                .fixed-header .header-v4.header-bottom,

                .fixed-header .header-v8.header-bottom,

                .fixed-header .header-v9.header-bottom,

                .header-v2 .header-center,

                .header-v3 .header-center,

                .header-v4 .header-center,

                .header-v8 .header-center,

                .header-v9 .header-center{

                    background-color: {$apr_settings['header2-bg']};

                }

            }

        ";         

    }

     if(isset($apr_settings['header10-menu-color']) && $apr_settings['header10-menu-color'] !=''){

        $apr_custom_css .= "

            .header-v10 .header-contact a,

            .header-v10 .contact-mobile h5,

            .header-v10 .mega-menu > li > a,

            .header-v10 .mega-menu li .sub-menu li a,

            .header-v10 .mega-menu .product_list_widget .product-content .product-title{

                color: {$apr_settings['header10-menu-color']};

            }

        ";         

    }

     if(isset($apr_settings['header10-icon-color']) && $apr_settings['header10-icon-color'] !=''){

        $apr_custom_css .= "

            .header-v10 .open-menu-mobile,

            .header-v10 .search-block-top,

            .header-v10 .mini-cart > a,

            .header-v10 .header-right .social_icon li a{

                color: {$apr_settings['header10-icon-color']};

            }

        ";         

    }

    if(isset($apr_settings['header10-bg']) && $apr_settings['header10-bg'] !=''){

        $apr_custom_css .= "

            .header-v10 .header-center,

            .header-v10 .mega-menu li .sub-menu,

            .header-v10 .header-top{

                background-color: {$apr_settings['header10-bg']};

            }

        ";         

    }

    if(isset($apr_settings['header2-bg-hover']) && $apr_settings['header2-bg-hover'] !=''){

        $apr_custom_css .= "

            .header-v2 .mega-menu li .sub-menu li a:hover,

            .header-v3 .mega-menu li .sub-menu li a:hover,

            .header-v4 .mega-menu li .sub-menu li a:hover,

            .header-v8 .mega-menu li .sub-menu li a:hover,

            .header-v9 .mega-menu li .sub-menu li a:hover,

            .header-v2 .header-profile ul li:hover a,

            .header-v3 .header-profile ul li:hover a,

            .header-v4 .header-profile ul li:hover a,

            .header-v8 .header-profile ul li:hover a,

            .header-v9 .header-profile ul li:hover a{

                background-color: {$apr_settings['header2-bg-hover']};

            }

        ";         

    }

    if(isset($apr_settings['header2-menu-color']) && $apr_settings['header2-menu-color'] !=''){

        $apr_custom_css .= "

            .header-v2 .header_icon,

            .header-v2 .languges-flags a,

            .header-v2 .search-block-top, 

            .header-v2 .mini-cart > a,

            .header-v2 .mega-menu > li > a,

            .header-v2 .mega-menu > li > a,

            .header-v2 .mega-menu li .sub-menu li a,

            .header-v2 .slogan,

            .header-v2 .header-contact a, 

            .header-v2 .searchform_wrap form button,

            .header-v2 .widget_shopping_cart_content ul li.empty,

            .header-v2 .searchform_wrap input,

            .header-v2 .open-menu-mobile,

            .header-v2 .nav-sections .nav-tabs > li > a,

            .header-v2 .social-mobile h5,

            .header-v2 .contact-mobile h5,

            .header-v2 .social-sidebar .twitter-tweet .tweet-text,

            .header-v2 .widget_shopping_cart_content ul li a,

            .header-v2 .widget_shopping_cart_content .total,

            .header-v2 .header-profile ul a,

            .header-v2 .product_list_widget .product-content .product-title,

            .header-v3 .header_icon,

            .header-v3 .languges-flags a,

            .header-v3 .search-block-top, 

            .header-v3 .mini-cart > a,

            .header-v3 .mega-menu > li > a,

            .header-v3 .mega-menu li .sub-menu li a,

            .header-v3 .slogan,

            .header-v3 .header-contact a, 

            .header-v3 .searchform_wrap input,

            .header-v3 .searchform_wrap form button,

            .header-v3 .widget_shopping_cart_content ul li.empty,

            .header-v3 .open-menu-mobile,

            .header-v3 .nav-sections .nav-tabs > li > a,

            .header-v3 .social-mobile h5,

            .header-v3 .contact-mobile h5,

            .header-v3 .social-sidebar .twitter-tweet .tweet-text,

            .header-v3 .widget_shopping_cart_content ul li a,

            .header-v3 .widget_shopping_cart_content .total,

            .header-v3 .header-profile ul a,

            .header-v3 .product_list_widget .product-content .product-title,

            .header-v4 .header_icon,

            .header-v4 .languges-flags a,

            .header-v4 .search-block-top, 

            .header-v4 .mini-cart > a,

            .header-v4 .mega-menu > li > a,

            .header-v4 .mega-menu li .sub-menu li a,

            .header-v4 .slogan, 

            .header-v4 .header-contact a,

            .header-v4 .searchform_wrap input,

            .header-v4 .searchform_wrap form button,

            .header-v4 .widget_shopping_cart_content ul li.empty,

            .header-v4 .open-menu-mobile,

            .header-v4 .nav-sections .nav-tabs > li > a,

            .header-v4 .social-mobile h5, 

            .header-v4 .contact-mobile h5,

            .header-v4 .social-sidebar .twitter-tweet .tweet-text,

            .header-v4 .widget_shopping_cart_content ul li a,

            .header-v4 .widget_shopping_cart_content .total,

            .header-v4 .header-profile ul a,

            .header-v4 .product_list_widget .product-content .product-title,

            .header-v8 .header_icon,

            .header-v8 .languges-flags a,

            .header-v8 .search-block-top, 

            .header-v8 .mini-cart > a,

            .header-v8 .mega-menu > li > a,

            .header-v8 .mega-menu li .sub-menu li a,

            .header-v8 .slogan, 

            .header-v8 .header-contact a,

            .header-v8 .searchform_wrap input,

            .header-v8 .searchform_wrap form button,

            .header-v8 .widget_shopping_cart_content ul li.empty,

            .header-v8 .open-menu-mobile,

            .header-v8 .nav-sections .nav-tabs > li > a,

            .header-v8 .social-mobile h5, 

            .header-v8 .contact-mobile h5,

            .header-v8 .social-sidebar .twitter-tweet .tweet-text,

            .header-v8 .widget_shopping_cart_content ul li a,

            .header-v8 .widget_shopping_cart_content .total,

            .header-v8 .header-profile ul a,

            .header-v8 .product_list_widget .product-content .product-title,

            .header-v9 .header_icon,

            .header-v9 .languges-flags a,

            .header-v9 .search-block-top, 

            .header-v9 .mini-cart > a,

            .header-v9 .mega-menu > li > a,

            .header-v9 .mega-menu li .sub-menu li a,

            .header-v9 .slogan, 

            .header-v9 .header-contact a,

            .header-v9 .searchform_wrap input,

            .header-v9 .searchform_wrap form button,

            .header-v9 .widget_shopping_cart_content ul li.empty,

            .header-v9 .open-menu-mobile,

            .header-v9 .nav-sections .nav-tabs > li > a,

            .header-v9 .social-mobile h5, 

            .header-v9 .contact-mobile h5,

            .header-v9 .social-sidebar .twitter-tweet .tweet-text,

            .header-v9 .widget_shopping_cart_content ul li a,

            .header-v9 .widget_shopping_cart_content .total,

            .header-v9 .header-profile ul a,

            .header-v9 .product_list_widget .product-content .product-title{

                color: {$apr_settings['header2-menu-color']};

            }

        ";        

    } 



    if(isset($apr_settings['header2-border-color']) && $apr_settings['header2-border-color'] !=''){

        $apr_custom_css .= "

            .header-v2 .mega-menu li .sub-menu li a,

            .header-v3 .mega-menu li .sub-menu li a,

            .header-v4 .mega-menu li .sub-menu li a,

            .header-v8 .mega-menu li .sub-menu li a,

            .header-v9 .mega-menu li .sub-menu li a,

            .header-v10 .mega-menu li .sub-menu li a,

            .header-v2 .searchform_wrap .vc_child,

            .header-v3 .searchform_wrap .vc_child,

            .header-v4 .searchform_wrap .vc_child,

            .header-v8 .searchform_wrap .vc_child,

            .header-v9 .searchform_wrap .vc_child,

            .header-v10 .searchform_wrap .vc_child,

            .header-v2 .social-mobile,

            .header-v3 .social-mobile,

            .header-v4 .social-mobile,

            .header-v8 .social-mobile,

            .header-v9 .social-mobile,

            .header-v10 .social-mobile,

            .header-v2 .contact-mobile,

            .header-v3 .contact-mobile,

            .header-v4 .contact-mobile,

            .header-v8 .contact-mobile,

            .header-v9 .contact-mobile,

            .header-v10 .contact-mobile,

            .header-v2 .widget_shopping_cart_content ul li,

            .header-v3 .widget_shopping_cart_content ul li,

            .header-v4 .widget_shopping_cart_content ul li,

            .header-v8 .widget_shopping_cart_content ul li,

            .header-v9 .widget_shopping_cart_content ul li,

            .header-v10 .widget_shopping_cart_content ul li,

            .header-v2 .header-profile ul li,

            .header-v3 .header-profile ul li,

            .header-v4 .header-profile ul li,

            .header-v8 .header-profile ul li,

            .header-v9 .header-profile ul li,

            .header-v10 .header-profile ul li{

              border-color: {$apr_settings['header2-border-color']};

            }

            @media (max-width: 991px){

                .header-v2 .main-navigation .mega-menu > li.menu-item > a,

                .header-v3 .main-navigation .mega-menu > li.menu-item > a,

                .header-v4 .main-navigation .mega-menu > li.menu-item > a,

                .header-v8 .main-navigation .mega-menu > li.menu-item > a,

                .header-v9 .main-navigation .mega-menu > li.menu-item > a,

                .header-v10 .main-navigation .mega-menu > li.menu-item > a,

                .header-v2 .nav-sections ul.nav-tabs, 

                .header-v3 .nav-sections ul.nav-tabs,

                .header-v4 .nav-sections ul.nav-tabs,

                .header-v8 .nav-sections ul.nav-tabs,

                .header-v9 .nav-sections ul.nav-tabs,

                .header-v10 .nav-sections ul.nav-tabs,

                .header-v3 .header-tops,

                .header-v2 .main-navigation .mega-menu li .sub-menu li:last-child > a,

                .header-v3 .main-navigation .mega-menu li .sub-menu li:last-child > a,

                .header-v4 .main-navigation .mega-menu li .sub-menu li:last-child > a,

                .header-v8 .main-navigation .mega-menu li .sub-menu li:last-child > a,

                .header-v9 .main-navigation .mega-menu li .sub-menu li:last-child > a,

                .header-v10 .main-navigation .mega-menu li .sub-menu li:last-child > a,

                .header-v2 .main-navigation .caret-submenu,

                .header-v3 .main-navigation .caret-submenu,

                .header-v4 .main-navigation .caret-submenu,

                .header-v8 .main-navigation .caret-submenu,

                .header-v9 .main-navigation .caret-submenu,

                .header-v10 .main-navigation .caret-submenu,

                .header-v2 .main-navigation .menu-block1,

                .header-v3 .main-navigation .menu-block1,

                .header-v4 .main-navigation .menu-block1,

                .header-v8 .main-navigation .menu-block1,

                .header-v9 .main-navigation .menu-block1,  

                .header-v10 .main-navigation .menu-block1,

                .header-v2 .main-navigation .menu-block2,

                .header-v3 .main-navigation .menu-block2,

                .header-v4 .main-navigation .menu-block2,

                .header-v8 .main-navigation .menu-block2,

                .header-v9 .main-navigation .menu-block2,

                .header-v10 .main-navigation .menu-block2{

                    border-color: {$apr_settings['header2-border-color']};

                }

                .header-v2 .nav-sections .nav-tabs > li > a,

                .header-v3 .nav-sections .nav-tabs > li > a,

                .header-v4 .nav-sections .nav-tabs > li > a,

                .header-v8 .nav-sections .nav-tabs > li > a,

                .header-v9 .nav-sections .nav-tabs > li > a{

                    border-color: {$apr_settings['header2-border-color']} !important;

                }

            }

        ";

    } 

    // if(isset($apr_settings['footer-bg']) && $apr_settings['footer-bg'] !=''){

    //     $apr_custom_css .= "

    //         .footer-v2,.footer-v3,.footer-v4{

    //             background: {$apr_settings['footer-bg']};

    //         }

    //     ";        

    // }

    //  if(isset($apr_settings['footer5-bg']) && $apr_settings['footer5-bg'] !=''){

    //     $apr_custom_css .= "

    //         .footer-v5{

    //             background: {$apr_settings['footer5-bg']};

    //         }

    //     ";        

    // }

     if(isset($apr_settings['footer8-bg']) && $apr_settings['footer8-bg'] !=''){

        $apr_custom_css .= "

            .footer-v8{

                background: {$apr_settings['footer8-bg']};

            }

        ";        

    }

    if(isset($apr_settings['footer-color']) && $apr_settings['footer-color'] !=''){

        $apr_custom_css .= "

            .footer-v4 .footer_info,

            .footer-v1 a ,.footer-v1 .footer_info,.list-info-footer li,

            .list-info-footer li a,.list-items-time li,

            .footer-content .widget_nav_menu ul li a{

                color: {$apr_settings['footer-color']};

            }

        ";        

    }

    if(isset($apr_settings['footer-t-color']) && $apr_settings['footer-t-color'] !=''){

        $apr_custom_css .= "

            .footer-title{

                color: {$apr_settings['footer-t-color']};

            }

        ";        

    }

    if(isset($apr_settings['footer-copyright-color']) && $apr_settings['footer-copyright-color'] !=''){

        $apr_custom_css .= "

            .footer-v3 .footer-copyright p,

            .footer-copyright p{

                color: {$apr_settings['footer-copyright-color']};

            }

        ";        

    }

    if(isset($apr_settings['footer-social-color']) && $apr_settings['footer-social-color'] !=''){

        $apr_custom_css .= "

            .footer-social li a{

                color: {$apr_settings['footer-social-color']};

            }

        ";        

    }

    if(isset($apr_settings['footer-desc-color']) && $apr_settings['footer-desc-color'] !=''){

        $apr_custom_css .= "

            .footer-v3 .footer_info p,

            .footer_info{

                color: {$apr_settings['footer-desc-color']};

            }

        ";        

    }

    if(isset($apr_settings['footer3-color']) && $apr_settings['footer3-color'] !=''){

        $apr_custom_css .= "

            .footer .location,

            .footer-v8 .footer-content .widget_nav_menu ul li a,

            .footer-v8 .textwidget,

            .footer-v8 .widget_archive li a,

            .footer-v8 .location li a,

            .list-item-info .info-address,

            .list-item-info .info-time .list-items-time li span,

            .list-item-info .info-mail a, .list-item-info .info-number a,

            .footer-v7 p, .footer-v7 a

            .footer-v3 p, .footer-v3 a{

                color: {$apr_settings['footer3-color']};

            }

        ";        

    }

    if(isset($apr_settings['footer6-color']) && $apr_settings['footer6-color'] !=''){

        $apr_custom_css .= "

            .footer-v6 .footer-social li a,

            .footer-v6 .footer-copyright p,

            .footer-v6 p, .footer-v6 a{

                color: {$apr_settings['footer6-color']};

            }

        ";        

    }

    if(isset($apr_settings['footer8-t-color']) && $apr_settings['footer8-t-color'] !=''){

        $apr_custom_css .= "

            .footer-v8 .footer-title{

                color: {$apr_settings['footer8-t-color']};

            }

        ";        

    }

    // Preload Options

    if(isset($apr_settings['preloader-bg']) && $apr_settings['preloader-bg'] !=''){

        $apr_custom_css .= "

            #loading, #loading-2, #loading-3, 

            .preloader-4, .preloader-5, #loading-6,

            #loading-7, #loading-9, .loader-8{

                background-color: {$apr_settings['preloader-bg']};

            }

        ";         

    }

    if(isset($apr_settings['preloader-color']) && $apr_settings['preloader-color'] !=''){

        $apr_custom_css .= "

            .object, .object-2, .loader:before,

            .busy-loader .w-ball-wrapper .w-ball,

            #object-7,.pacman > div:nth-child(3),

            .pacman > div:nth-child(4),

            .pacman > div:nth-child(5),

            .pacman > div:nth-child(6),

            .object-9 {

                background-color: {$apr_settings['preloader-color']};

            }

            .object-3{

                border-top-color: {$apr_settings['preloader-color']};

                border-left-color: {$apr_settings['preloader-color']};

            }

            .pacman > div:first-of-type,

            .pacman > div:nth-child(2){

                border-top-color: {$apr_settings['preloader-color']};

                border-left-color: {$apr_settings['preloader-color']};

                border-bottom-color: {$apr_settings['preloader-color']};

            }

            .object-6{

                border-color: {$apr_settings['preloader-color']};

            }

        ";         

    }

    //Metabox options

    $apr_body_bg = (apr_get_meta_value('body_bg') != '') ? apr_get_meta_value('body_bg') : '';   

    $apr_f_text_color = (apr_get_meta_value('footer_text_color') != '') ? apr_get_meta_value('footer_text_color') : '';

    $apr_f_link_color = (apr_get_meta_value('footer_link_color') != '') ? apr_get_meta_value('footer_link_color') : '';    

    $apr_footer_bg = (apr_get_meta_value('footer_bg') != '') ? apr_get_meta_value('footer_bg') : ''; 

    $apr_newletter_bg = (apr_get_meta_value('newletter_bg') != '') ? apr_get_meta_value('newletter_bg') : ''; 

    $apr_newletter_title_bg = (apr_get_meta_value('newletter_title_bg') != '') ? apr_get_meta_value('newletter_title_bg') : ''; 

    //$apr_header_menu_hcolor =    (apr_get_meta_value('header_menu_hcolor') != '') ? apr_get_meta_value('header_menu_hcolor') : ''; 

    if(isset($apr_f_text_color) ){

        $apr_custom_css .= "

            .footer{

                color: {$apr_f_text_color} !important;

            }

        ";          

    }   

    if(isset($apr_f_link_color) ){

        $apr_custom_css .= "

            footer .footer-v4 a,footer .footer-v3 a,footer .footer-v5 a,footer .footer-v2 a,footer a{

                color: {$apr_f_link_color} !important;

            }

        ";          

    }      

    if(isset($apr_body_bg) ){

        $apr_custom_css .= "

            body{

                background: {$apr_body_bg} !important;

            }

        ";        

    }   



    if(isset($apr_settings['menu_spacing']) && $apr_settings['menu_spacing'] !=''){

        $apr_custom_css .= "

            @media (min-width: 768px){

                .mega-menu > li > a{

                    padding-left: {$apr_settings['menu_spacing']['margin-left']} !important;

                    padding-top: {$apr_settings['menu_spacing']['margin-top']} !important;

                    padding-right: {$apr_settings['menu_spacing']['margin-right']} !important;

                    padding-bottom: {$apr_settings['menu_spacing']['margin-bottom']} !important;

                }

            }

        ";        

    }    

    if(isset($apr_settings['logo_width']) && $apr_settings['logo_width'] !=''){

        $apr_custom_css .= "

            .header-logo img{

                width: {$apr_settings['logo_width']['width']} !important;

            }

        ";         

    }   

    if(isset($apr_settings['404-bg-image']) && $apr_settings['404-bg-image'] !='' && $apr_settings['404-bg-image']['url']){

        $apr_custom_css .= "

            .page-404{

                background: url({$apr_settings['404-bg-image']['url']});   

                background-size: cover;

                background-position: center center;

            }

            #bkDiv{

                background-image:url({$apr_settings['404-bg-image']['url']});   

            }

            .title404{

                background: url({$apr_settings['404-bg-image']['url']});  

                -webkit-text-fill-color: transparent;

                -webkit-background-clip: text; 

                background-size: contain;

                line-height: 100%;              

            }

        ";         

    }

    if(isset($apr_settings['under-bg-image']) && $apr_settings['under-bg-image'] !='' && $apr_settings['under-bg-image']['url']){

        $apr_custom_css .= "

            .page-coming-soon{

                background: url({$apr_settings['under-bg-image']['url']});   

                background-size: cover;

                background-position: center center;

            }

        ";         

    }    

    if(isset($apr_settings['coming-overlay-color']) && $apr_settings['coming-overlay-color'] !=''){

        $apr_custom_css .= "

            .page-coming-soon.has-overlay:before{

                background: {$apr_settings['coming-overlay-color']} !important;

                opacity: 0.6;

            }

        ";        

    }  

    if(isset($apr_settings['404-color']) && $apr_settings['404-color'] !=''){

        $apr_custom_css .= "

            .page-404-container{

                color: {$apr_settings['404-color']} !important;

            }

        ";        

    }   

    if(isset($apr_settings['header6-bg']) && $apr_settings['header6-bg'] !=''){

        $apr_custom_css .= "

            .header-v6.site-header{

                background: {$apr_settings['header6-bg']} !important;

            }

        ";         

    }  

    if(isset($apr_settings['header6-stickybg']) && $apr_settings['header6-stickybg'] !=''){

        $apr_custom_css .= "

            .header-v6.site-header.is-sticky{

                background: {$apr_settings['header6-stickybg']} !important;

            }

        ";         

    } 

    if(isset($apr_settings['header6-menu-color']) && $apr_settings['header6-menu-color'] !=''){

        $apr_custom_css .= "

            .header-v6 .header-right,.header-v6 .mega-menu > li > a,.header-v6 .social_icon li a,

            .header-v6 .mini-cart .cart_label{

                color: {$apr_settings['header6-menu-color']} !important;

            }

        ";         

    }   

    if(isset($apr_newletter_bg) ){

        $apr_custom_css .= "

            .footer .footer-top{

                background-color: {$apr_newletter_bg} !important;

            }

            .footer-newsletter.type1 .mc4wp-form .submit input:hover,

            .footer-newsletter.type1 .mc4wp-form .submit:hover input,

            .footer-newsletter.type1 .mc4wp-form .submit:hover::before{

                color: {$apr_newletter_bg} !important;

            }

        ";          

    }   

    if(isset($apr_newletter_title_bg) ){

        $apr_custom_css .= "

            .footer-newsletter.type1 .mc4wp-form .submit input{

                background-color: {$apr_newletter_title_bg} !important;

            }

            .footer-newsletter.type1 .mc4wp-form label span{

                color: {$apr_newletter_title_bg} !important;

            }

        ";          

    }         

    //Load font icon css

    

    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css?ver=' . APR_VERSION); 

    wp_enqueue_style('apr-font-common', get_template_directory_uri() . '/css/icomoon.css?ver=' . APR_VERSION); 

    wp_enqueue_style('dashicons', get_template_directory_uri() . '/css/dashicons.css?ver=' . APR_VERSION);    

    wp_enqueue_style('pe-icon-7-stroke', get_template_directory_uri() . '/css/pe-icon/pe-icon-7-stroke.css?ver=' . APR_VERSION);

    wp_enqueue_style('linearicons-free', get_template_directory_uri() . '/css/linearicons/linearicons.css?ver=' . APR_VERSION);        

    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/plugin/bootstrap.min.css?ver=' . APR_VERSION);

    wp_enqueue_style('fancybox', get_template_directory_uri() . '/css/plugin/jquery.fancybox.css?ver=' . APR_VERSION);

    wp_enqueue_style('slick', get_template_directory_uri() . '/css/plugin/slick.css?ver=' . APR_VERSION);    

    

    wp_enqueue_style('apr-animate', get_template_directory_uri() . '/css/animate.min.css?ver=' . APR_VERSION);

    if (is_rtl()) {

        //Load theme RTL css

        wp_enqueue_style('apr-theme-rtl', get_template_directory_uri() . '/css/theme_rtl.css?ver=' . APR_VERSION);

    }

    else{

        //Load theme css

        wp_enqueue_style('apr-theme', get_template_directory_uri() . '/css/theme.css?ver=' . APR_VERSION);

    }

    // Load skin stylesheet

    // wp_enqueue_style('apr-skin-theme', get_template_directory_uri() . '/css/config/skin.css?ver=' . APR_VERSION);

    wp_add_inline_style( 'apr-theme', $apr_custom_css );

    // custom styles

    wp_deregister_style( 'apr-style' );

    wp_register_style( 'apr-style', get_template_directory_uri() . '/style.css' );

    wp_enqueue_style( 'apr-style' );

    

    if (is_rtl()) {

        wp_deregister_style( 'apr-style-rtl' );

        wp_register_style( 'apr-style-rtl', get_template_directory_uri() . '/style_rtl.css' );

        wp_enqueue_style( 'apr-style-rtl' );

    }



}

add_action('wp_enqueue_scripts', 'apr_scripts_styles');