<?php
/**
 * Header Style Ten Template
 *
 * @package glamon
 */

?>

<!-- wraper_header -->
<header class="wraper_header style-ten">
	<!-- wraper_header_top -->
    <div class="wraper_header_top">
		<div class="container">
			<!-- header_top -->
			<div class="row header_top">
				<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 text-left visible-lg visible-md visible-sm hidden-xs">
					<!-- header_top_item -->
					<div class="header_top_item">
						<!-- header-contact -->
						<ul class="header-contact">
						    <?php if ( ! empty( glamon_global_var( 'header_ten_header_top_address', '', false ) ) ) : ?>
						        <li class="address"><span class="ti-location-pin"></span> <?php echo wp_kses_post( glamon_global_var( 'header_ten_header_top_address', '', false ) ); ?></li>
						    <?php endif; ?>
						    <?php if ( ! empty( glamon_global_var( 'header_ten_header_top_email', '', false ) ) ) : ?>
						        <li class="email"><span class="ti-email"></span> <?php echo wp_kses_post( glamon_global_var( 'header_ten_header_top_email', '', false ) ); ?></li>
						    <?php endif; ?>
						    <?php if ( ! empty( glamon_global_var( 'header_ten_header_top_phone', '', false ) ) ) : ?>
						        <li class="phone"><span class="ti-mobile"></span> <?php echo wp_kses_post( glamon_global_var( 'header_ten_header_top_phone', '', false ) ); ?></li>
						    <?php endif; ?>
					    </ul>
					    <!-- header-contact -->
					</div>
					<!-- header_top_item -->
				</div>
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 text-right visible-lg visible-md visible-sm visible-xs">
					<!-- header_top_item -->
					<div class="header_top_item">
					    <?php
    					if ( true == glamon_global_var( 'social-icon-target', '', false ) ) {
    						$social_target = 'target="_blank"';
    					} else {
    						$social_target = '';
    					}
    					?>
						<!-- header-social -->
						<ul class="header-social">
							<?php if ( ! empty( glamon_global_var( 'social-icon-googleplus', '', false ) ) ) : ?>
								<li class="google-plus"><a href="<?php echo esc_url( glamon_global_var( 'social-icon-googleplus', '', false ) ); ?>" rel="publisher" <?php echo esc_attr( $social_target ); ?>><i class="fa fa-google-plus"></i></a></li>
							<?php endif; ?>
							<?php if ( ! empty( glamon_global_var( 'social-icon-facebook', '', false ) ) ) : ?>
								<li class="facebook"><a href="<?php echo esc_url( glamon_global_var( 'social-icon-facebook', '', false ) ); ?>" <?php echo esc_attr( $social_target ); ?>><i class="fa fa-facebook"></i></a></li>
							<?php endif; ?>
							<?php if ( ! empty( glamon_global_var( 'social-icon-twitter', '', false ) ) ) : ?>
								<li class="twitter"><a href="<?php echo esc_url( glamon_global_var( 'social-icon-twitter', '', false ) ); ?>" <?php echo esc_attr( $social_target ); ?>><i class="fa fa-twitter"></i></a></li>
							<?php endif; ?>
							<?php if ( ! empty( glamon_global_var( 'social-icon-vimeo', '', false ) ) ) : ?>
								<li class="vimeo"><a href="<?php echo esc_url( glamon_global_var( 'social-icon-vimeo', '', false ) ); ?>" <?php echo esc_attr( $social_target ); ?>><i class="fa fa-vimeo"></i></a></li>
							<?php endif; ?>
							<?php if ( ! empty( glamon_global_var( 'social-icon-youtube', '', false ) ) ) : ?>
								<li class="youtube"><a href="<?php echo esc_url( glamon_global_var( 'social-icon-youtube', '', false ) ); ?>" <?php echo esc_attr( $social_target ); ?>><i class="fa fa-youtube-play"></i></a></li>
							<?php endif; ?>
							<?php if ( ! empty( glamon_global_var( 'social-icon-flickr', '', false ) ) ) : ?>
								<li class="flickr"><a href="<?php echo esc_url( glamon_global_var( 'social-icon-flickr', '', false ) ); ?>" <?php echo esc_attr( $social_target ); ?>><i class="fa fa-flickr"></i></a></li>
							<?php endif; ?>
							<?php if ( ! empty( glamon_global_var( 'social-icon-linkedin', '', false ) ) ) : ?>
								<li class="linkedin"><a href="<?php echo esc_url( glamon_global_var( 'social-icon-linkedin', '', false ) ); ?>" <?php echo esc_attr( $social_target ); ?>><i class="fa fa-linkedin"></i></a></li>
							<?php endif; ?>
							<?php if ( ! empty( glamon_global_var( 'social-icon-pinterest', '', false ) ) ) : ?>
								<li class="pinterest"><a href="<?php echo esc_url( glamon_global_var( 'social-icon-pinterest', '', false ) ); ?>" <?php echo esc_attr( $social_target ); ?>><i class="fa fa-pinterest-p"></i></a></li>
							<?php endif; ?>
							<?php if ( ! empty( glamon_global_var( 'social-icon-xing', '', false ) ) ) : ?>
								<li class="xing"><a href="<?php echo esc_url( glamon_global_var( 'social-icon-xing', '', false ) ); ?>" <?php echo esc_attr( $social_target ); ?>><i class="fa fa-xing"></i></a></li>
							<?php endif; ?>
							<?php if ( ! empty( glamon_global_var( 'social-icon-viadeo', '', false ) ) ) : ?>
								<li class="viadeo"><a href="<?php echo esc_url( glamon_global_var( 'social-icon-viadeo', '', false ) ); ?>" <?php echo esc_attr( $social_target ); ?>><i class="fa fa-viadeo"></i></a></li>
							<?php endif; ?>
							<?php if ( ! empty( glamon_global_var( 'social-icon-vkontakte', '', false ) ) ) : ?>
								<li class="vkontakte"><a href="<?php echo esc_url( glamon_global_var( 'social-icon-vkontakte', '', false ) ); ?>" <?php echo esc_attr( $social_target ); ?>><i class="fa fa-vk"></i></a></li>
							<?php endif; ?>
							<?php if ( ! empty( glamon_global_var( 'social-icon-tripadvisor', '', false ) ) ) : ?>
								<li class="tripadvisor"><a href="<?php echo esc_url( glamon_global_var( 'social-icon-tripadvisor', '', false ) ); ?>" <?php echo esc_attr( $social_target ); ?>><i class="fa fa-tripadvisor"></i></a></li>
							<?php endif; ?>
							<?php if ( ! empty( glamon_global_var( 'social-icon-tumblr', '', false ) ) ) : ?>
								<li class="tumblr"><a href="<?php echo esc_url( glamon_global_var( 'social-icon-tumblr', '', false ) ); ?>" <?php echo esc_attr( $social_target ); ?>><i class="fa fa-tumblr"></i></a></li>
							<?php endif; ?>
							<?php if ( ! empty( glamon_global_var( 'social-icon-behance', '', false ) ) ) : ?>
								<li class="behance"><a href="<?php echo esc_url( glamon_global_var( 'social-icon-behance', '', false ) ); ?>" <?php echo esc_attr( $social_target ); ?>><i class="fa fa-behance"></i></a></li>
							<?php endif; ?>
							<?php if ( ! empty( glamon_global_var( 'social-icon-instagram', '', false ) ) ) : ?>
								<li class="instagram"><a href="<?php echo esc_url( glamon_global_var( 'social-icon-instagram', '', false ) ); ?>" <?php echo esc_attr( $social_target ); ?>><i class="fa fa-instagram"></i></a></li>
							<?php endif; ?>
							<?php if ( ! empty( glamon_global_var( 'social-icon-dribbble', '', false ) ) ) : ?>
								<li class="dribbble"><a href="<?php echo esc_url( glamon_global_var( 'social-icon-dribbble', '', false ) ); ?>" <?php echo esc_attr( $social_target ); ?>><i class="fa fa-dribbble"></i></a></li>
							<?php endif; ?>
							<?php if ( ! empty( glamon_global_var( 'social-icon-skype', '', false ) ) ) : ?>
								<li class="skype"><a href="<?php echo esc_url( glamon_global_var( 'social-icon-skype', '', false ) ); ?>" <?php echo esc_attr( $social_target ); ?>><i class="fa fa-skype"></i></a></li>
							<?php endif; ?>
						</ul>
						<!-- header-social -->
					</div>
					<!-- header_top_item -->
				</div>
			</div>
			<!-- header_top -->
		</div>
	</div>
	<!-- wraper_header_top -->
	<!-- wraper_header_main -->
	<?php if ( true == glamon_global_var( 'header_ten_sticky', '', false ) ) { ?>
	    <div data-delay="<?php echo esc_attr( glamon_global_var( 'header_ten_sticky_delay', '', false ) ); ?>" class="wraper_header_main radiantthemes-sticky-style-<?php echo esc_attr( glamon_global_var( 'header_ten_sticky_style', '', false ) ); ?>">
	<?php } else { ?>
		<div class="wraper_header_main">
	<?php } ?>
		<div class="container">
			<!-- header_main -->
			<div class="header_main">
				<?php if ( glamon_global_var( 'header_ten_logo', 'url', true ) ) { ?>
					<!-- brand-logo -->
					<div class="brand-logo radiantthemes-retina">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( glamon_global_var( 'header_ten_logo', 'url', true ) ); ?>" alt="<?php echo esc_attr( glamon_global_var( 'header_ten_logo', 'alt', true ) ); ?>"></a>
					</div>
					<!-- brand-logo -->
				<?php } ?>
				<?php if ( true == glamon_global_var( 'header_ten_mobile_menu_enable', '', false ) ) : ?>
					<!-- header-responsive-nav -->
					<div class="header-responsive-nav hidden-lg hidden-md visible-sm visible-xs"><span class="ti-menu"></span></div>
					<!-- header-responsive-nav -->
				<?php endif; ?>
				<!-- header_main_calltoaction -->
				<div class="header_main_calltoaction visible-lg visible-md visible-sm hidden-xs">
				    <?php if ( true == glamon_global_var( 'header_ten_button_one_display', '', false ) ) : ?>
				        <a class="btn button-one" href="<?php echo wp_kses_post( glamon_global_var( 'header_ten_button_one_link', '', false ) ); ?>"><?php echo wp_kses_post( glamon_global_var( 'header_ten_button_one_text', '', false ) ); ?></a>
				    <?php endif; ?>
			    </div>
			    <!-- header_main_calltoaction -->
			    <!-- header_main_action -->
				<div class="header_main_action">
					<ul>
						<?php if ( true == glamon_global_var( 'header_ten_search_display', '', false ) ) : ?>
                            <li class="header-slideout-searchbar">
                                <div class="header-slideout-searchbar-holder">
                                    <!-- header-slideout-searchbar-icon -->
                                    <div class="header-slideout-searchbar-icon"><span class="ti-search"></span></div>
                                    <!-- header-slideout-searchbar-icon -->
                                    <!-- header-slideout-searchbar-box -->
                                    <form class="header-slideout-searchbar-box" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                        <div class="form-row">
        						            <input type="search" placeholder="<?php echo esc_attr__( 'Search...', 'glamon' ); ?>" value="" name="s" required>
        						            <button type="submit"><span class="ti-search"></span></button>
        						        </div>
            						</form>
            						<!-- header-slideout-searchbar-box -->
        						</div>
                            </li>
						<?php endif; ?>
					</ul>
				</div>
				<!-- header_main_action -->
				<!-- nav -->
				<nav class="nav visible-lg hidden-md hidden-sm hidden-xs">
					<?php
					if ( true == glamon_global_var( 'header_ten_menu_singlepagemode', '', false ) ) {
        				wp_nav_menu(
                            array(
                                'theme_location'    => 'top',
                                'fallback_cb'       => false,
                                'items_wrap'        => '<ul id="%1$s" class="%2$s single-page-mode">%3$s</ul>',
                            )
                        );
        			} else {
        			    wp_nav_menu(
                            array(
                                'theme_location' => 'top',
                                'fallback_cb'    => false,
                            )
                        );
					} ?>
				</nav>
				<!-- nav -->
				<div class="clearfix"></div>
			</div>
			<!-- header_main -->
		</div>
	</div>
	<!-- wraper_header_main -->
</header>
<!-- wraper_header -->

<!-- mobile-menu -->
<div class="mobile-menu hidden">
	<!-- mobile-menu-main -->
	<div class="mobile-menu-main">
		<!-- mobile-menu-close -->
		<div class="mobile-menu-close">
			<i class="fa fa-times"></i>
		</div>
		<!-- mobile-menu-close -->
		<!-- mobile-menu-nav -->
		<nav class="mobile-menu-nav">
			<?php 
			if ( true == glamon_global_var( 'header_ten_menu_singlepagemode', '', false ) ) {
				wp_nav_menu(
                    array(
                        'theme_location'    => 'top',
                        'fallback_cb'       => false,
                        'items_wrap'        => '<ul id="%1$s" class="%2$s single-page-mode">%3$s</ul>',
                    )
                );
			} else {
			    wp_nav_menu(
                    array(
                        'theme_location' => 'top',
                        'fallback_cb'    => false,
                    )
                );
		    } ?>
		</nav>
		<!-- mobile-menu-nav -->
	</div>
	<!-- mobile-menu-main -->
</div>
<!-- mobile-menu -->
