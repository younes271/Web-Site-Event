<?php
/**
 * Header Style Sixteen Template
 *
 * @package glamon
 */

?>

<!-- wraper_header -->
<header class="wraper_header style-sixteen">
	<!-- wraper_header_main -->
	<?php if ( true == glamon_global_var( 'header_sixteen_sticky', '', false ) ) { ?>
	    <div data-delay="<?php echo esc_attr( glamon_global_var( 'header_sixteen_sticky_delay', '', false ) ); ?>" class="wraper_header_main radiantthemes-sticky-style-<?php echo esc_attr( glamon_global_var( 'header_sixteen_sticky_style', '', false ) ); ?>">
	<?php } else { ?>
		<div class="wraper_header_main">
	<?php } ?>
		<div class="container">
			<!-- header_main -->
			<div class="row header_main">
				<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6 text-left">
					<!-- header_main_item -->
					<div class="header_main_item">
						<!-- brand-logo -->
						<div class="brand-logo radiantthemes-retina">
						    <?php if ( glamon_global_var( 'header_sixteen_logo', 'url', true ) ) { ?>
        						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( glamon_global_var( 'header_sixteen_logo', 'url', true ) ); ?>" alt="<?php echo esc_attr( glamon_global_var( 'header_sixteen_logo', 'alt', true ) ); ?>"></a>
        					<?php } else { ?>
        					    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><p class="site-title"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></p></a>
        					<?php } ?>
						</div>
						<!-- brand-logo -->
					</div>
					<!-- header_main_item -->
				</div>
				<?php if ( true == glamon_global_var( 'header_sixteen_actionarea_display', '', false ) ) { ?>
				    <div class="col-lg-8 col-md-6 col-sm-0 col-xs-0 text-center visible-lg visible-md hidden-sm hidden-xs">
			    <?php } else { ?>
			        <div class="col-lg-10 col-md-9 col-sm-0 col-xs-0 text-right visible-lg visible-md hidden-sm hidden-xs">
			    <?php } ?>
					<!-- header_main_item -->
					<div class="header_main_item">
						<!-- nav -->
					    <nav class="nav">
							<?php
							if ( true == glamon_global_var( 'header_sixteen_menu_singlepagemode', '', false ) ) {
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
					</div>
					<!-- header_main_item -->
				</div>
				<?php if ( true == glamon_global_var( 'header_sixteen_actionarea_display', '', false ) ) { ?>
    				<div class="col-lg-2 col-md-3 col-sm-6 col-xs-6 text-right">
    					<!-- header_main_item -->
    					<div class="header_main_item">
    						<!-- header-main-action -->
    						<div class="header-main-action">
    							<ul>
    								<?php if ( ( class_exists( 'WooCommerce' ) ) && ( true == glamon_global_var( 'header_sixteen_cart_display', '', false ) ) ) : ?>
    									<li class="header-cart-bar">
    										<a class="header-cart-bar-icon" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
    											<span class="ti-bag"></span>
    											<span class="cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
    										</a>
    									</li>
    								<?php endif; ?>
    								<?php if ( true == glamon_global_var( 'header_sixteen_search_display', '', false ) ) : ?>
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
    						<!-- header-main-action -->
    						<?php if ( true == glamon_global_var( 'header_sixteen_hamburger_display', '', false ) ) : ?>
    							<?php if ( true == glamon_global_var( 'header_sixteen_hamburger_mobile', '', false ) ) { ?>
    								<!-- header-hamburger-menu -->
    								<div class="header-hamburger-menu"><span class="ti-align-right"></span></div>
    								<!-- header-hamburger-menu -->
    							<?php } else { ?>
    								<!-- header-hamburger-menu -->
    								<div class="header-hamburger-menu hidden-sm hidden-xs"><span class="ti-align-right"></span></div>
    								<!-- header-hamburger-menu -->
    							<?php } ?>
    						<?php endif; ?>
    						<!-- header-responsive-nav -->
    						<div class="header-responsive-nav hidden-lg hidden-md"><span class="ti-menu"></span></div>
    						<!-- header-responsive-nav -->
    					</div>
    					<!-- header_main_item -->
    				</div>
				<?php } ?>
			</div>
			<!-- header_main -->
		</div>
	</div>
	<!-- wraper_header_main -->
</header>
<!-- wraper_header -->

<?php //if ( true == glamon_global_var( 'header_sixteen_mobile_menu_display', '', false ) ) :
	?>
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
				if ( true == glamon_global_var( 'header_sixteen_menu_singlepagemode', '', false ) ) {
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
<?php //endif;
?>
