<?php
/**
 * Header Style Nine Template
 *
 * @package glamon
 */

?>

<!-- wraper_header -->
<header class="wraper_header style-nine">
	<!-- wraper_header_main -->
	<?php if ( true == glamon_global_var( 'header_nine_sticky', '', false ) ) { ?>
	    <div data-delay="<?php echo esc_attr( glamon_global_var( 'header_nine_sticky_delay', '', false ) ); ?>" class="wraper_header_main radiantthemes-sticky-style-<?php echo esc_attr( glamon_global_var( 'header_nine_sticky_style', '', false ) ); ?>">
	<?php } else { ?>
		<div class="wraper_header_main">
	<?php } ?>
		<div class="container">
			<!-- header_main -->
			<div class="header_main">
				<?php if ( glamon_global_var( 'header_nine_logo', 'url', true ) ) { ?>
					<!-- brand-logo -->
					<div class="brand-logo radiantthemes-retina">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( glamon_global_var( 'header_nine_logo', 'url', true ) ); ?>" alt="<?php echo esc_attr( glamon_global_var( 'header_nine_logo', 'alt', true ) ); ?>"></a>
					</div>
					<!-- brand-logo -->
				<?php } ?>
				<!-- header-responsive-nav -->
				<div class="header-responsive-nav hidden-lg visible-md visible-sm visible-xs"><span class="ti-menu"></span></div>
				<!-- header-responsive-nav -->
				<!-- header_main_contact -->
				<ul class="header_main_contact visible-lg visible-md visible-sm hidden-xs">
				    <?php if ( true == glamon_global_var( 'header_nine_phonenumber_display', '', false ) ) : ?>
				        <li class="phone"><span class="ti-mobile"></span> <a href="tel:<?php echo wp_kses_post( glamon_global_var( 'header_nine_phonenumber_text', '', false ) ); ?>"><?php echo wp_kses_post( glamon_global_var( 'header_nine_phonenumber_text', '', false ) ); ?></a></li>
				    <?php endif; ?>
				    <?php if ( true == glamon_global_var( 'header_nine_email_display', '', false ) ) : ?>
				        <li class="email"><span class="ti-email"></span> <a href="mailto:<?php echo wp_kses_post( glamon_global_var( 'header_nine_email_text', '', false ) ); ?>"><?php echo wp_kses_post( glamon_global_var( 'header_nine_email_text', '', false ) ); ?></a></li>
				    <?php endif; ?>
			    </ul>
			    <!-- header_main_contact -->
				<!-- nav -->
				<nav class="nav visible-lg hidden-md hidden-sm hidden-xs">
					<?php if ( true == glamon_global_var( 'header_nine_menu_singlepagemode', '', false ) ) {
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
            <?php if ( true == glamon_global_var( 'header_nine_menu_singlepagemode', '', false ) ) {
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
