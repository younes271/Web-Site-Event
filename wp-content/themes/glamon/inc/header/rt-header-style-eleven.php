<?php
/**
 * Header Style Eleven Template
 *
 * @package glamon
 */

?>

<!-- wraper_header -->
<header class="wraper_header style-eleven">
	<!-- wraper_header_top -->
    <div class="wraper_header_top">
		<div class="container">
		    <div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				    <!-- header_top -->
        			<div class="header_top">
        			    <div class="row">
            				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-left visible-lg visible-md visible-sm visible-xs">
            					<!-- header_top_item -->
            					<div class="header_top_item">
            						<?php if ( ! empty( glamon_global_var( 'header_eleven_header_top_note', '', false ) ) ) : ?>
            							<!-- header-top-note -->
            							<p class="header-top-note"><?php echo wp_kses_post( glamon_global_var( 'header_eleven_header_top_note', '', false ) ); ?></p>
            							<!-- header-top-note -->
            						<?php endif; ?>
            					</div>
            					<!-- header_top_item -->
            				</div>
            				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right visible-lg visible-md visible-sm hidden-xs">
            					<!-- header_top_item -->
            					<div class="header_top_item">
            					    <!-- header-top-calltoaction -->
            						<div class="header-top-calltoaction">
            						    <?php if ( true == glamon_global_var( 'header_eleven_button_one_display', '', false ) ) : ?>
            						        <a class="btn button-one" href="<?php echo wp_kses_post( glamon_global_var( 'header_eleven_button_one_link', '', false ) ); ?>">
            						            <span class="placeholder"><?php echo wp_kses_post( glamon_global_var( 'header_eleven_button_one_text', '', false ) ); ?></span>
        						            </a>
            						    <?php endif; ?>
            						    <?php if ( true == glamon_global_var( 'header_eleven_button_two_display', '', false ) ) : ?>
            						        <a class="btn button-two" href="<?php echo wp_kses_post( glamon_global_var( 'header_eleven_button_two_link', '', false ) ); ?>">
            						            <span class="placeholder"><?php echo wp_kses_post( glamon_global_var( 'header_eleven_button_two_text', '', false ) ); ?></span>
        						            </a>
            						    <?php endif; ?>
            					    </div>
            					    <!-- header-top-calltoaction -->
            					</div>
            					<!-- header_top_item -->
            				</div>
        				</div>
        			</div>
        			<!-- header_top -->
			    </div>
		    </div>
		</div>
	</div>
	<!-- wraper_header_top -->
	<!-- wraper_header_main -->
    <div class="wraper_header_main">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<!-- header_main -->
					<div class="header_main">
						<?php if ( glamon_global_var( 'header_eleven_logo', 'url', true ) ) { ?>
							<!-- brand-logo -->
							<div class="brand-logo radiantthemes-retina">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( glamon_global_var( 'header_eleven_logo', 'url', true ) ); ?>" alt="<?php echo esc_attr( glamon_global_var( 'header_eleven_logo', 'alt', true ) ); ?>"></a>
							</div>
							<!-- brand-logo -->
						<?php } ?>
						<!-- header-responsive-nav -->
        				<div class="header-responsive-nav hidden-lg hidden-md visible-sm visible-xs"><span class="ti-menu"></span></div>
        				<!-- header-responsive-nav -->
						<!-- header-contact -->
						<ul class="header-contact visible-lg visible-md visible-sm hidden-xs">
						    <?php if ( ! empty( glamon_global_var( 'header_eleven_header_top_address', '', false ) ) ) : ?>
						        <li class="address"><span class="ti-map-alt"></span> <?php echo wp_kses_post( glamon_global_var( 'header_eleven_header_top_address', '', false ) ); ?></li>
						    <?php endif; ?>
						    <?php if ( ! empty( glamon_global_var( 'header_eleven_header_top_phone', '', false ) ) ) : ?>
						        <li class="phone"><span class="ti-mobile"></span> <?php echo wp_kses_post( glamon_global_var( 'header_eleven_header_top_phone', '', false ) ); ?></li>
						    <?php endif; ?>
						     <?php if ( ! empty( glamon_global_var( 'header_eleven_header_top_email', '', false ) ) ) : ?>
						        <li class="email"><span class="ti-email"></span> <?php echo wp_kses_post( glamon_global_var( 'header_eleven_header_top_email', '', false ) ); ?></li>
						    <?php endif; ?>
					    </ul>
					    <!-- header-contact -->
						<div class="clearfix"></div>
					</div>
					<!-- header_main -->
				</div>
			</div>
			<!-- header_main -->
		</div>
	</div>
	<!-- wraper_header_main -->
	<!-- wraper_header_nav -->
	<?php if ( true == glamon_global_var( 'header_eleven_sticky', '', false ) ) { ?>
	    <div data-delay="<?php echo esc_attr( glamon_global_var( 'header_eleven_sticky_delay', '', false ) ); ?>" class="wraper_header_nav visible-lg visible-md hidden-sm hidden-xs radiantthemes-sticky-style-<?php echo esc_attr( glamon_global_var( 'header_eleven_sticky_style', '', false ) ); ?>">
	<?php } else { ?>
		<div class="wraper_header_nav visible-lg visible-md hidden-sm hidden-xs">
	<?php } ?>
		<div class="container">
			<!-- header_nav -->
			<div class="header_nav">
				<!-- nav -->
				<nav class="nav">
					<?php
					if ( true == glamon_global_var( 'header_eleven_menu_singlepagemode', '', false ) ) {
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
			<!-- header_nav -->
		</div>
	</div>
	<!-- wraper_header_nav -->
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
			if ( true == glamon_global_var( 'header_eleven_menu_singlepagemode', '', false ) ) {
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
