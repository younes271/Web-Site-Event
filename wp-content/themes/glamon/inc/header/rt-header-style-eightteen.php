<?php
/**
 * Header Style Eightteen Template
 *
 * @package glamon
 */

?>

<!-- wraper_header -->
<header class="wraper_header style-eightteen">
	<!-- wraper_header_main -->
	<div class="wraper_header_main">
		<div class="container">
			<!-- header_main -->
			<div class="header_main">
				<?php if ( glamon_global_var( 'header_eightteen_logo', 'url', true ) ) { ?>
					<!-- brand-logo -->
					<div class="brand-logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( glamon_global_var( 'header_eightteen_logo', 'url', true ) ); ?>" alt="<?php echo esc_attr( glamon_global_var( 'header_eightteen_logo', 'alt', true ) ); ?>"></a>
					</div>
					<!-- brand-logo -->
				<?php } ?>
			    <!-- header-aniopen-menu -->
				<div class="header-aniopen-menu visible-lg visible-md hidden-sm hidden-xs">
				    <span class="header-aniopen-menu-line"></span>
				    <span class="header-aniopen-menu-line"></span>
				    <span class="header-aniopen-menu-line"></span>
				</div>
				<!-- header-aniopen-menu -->
				<?php if ( true == glamon_global_var( 'header_eightteen_mobile_menu_display', '', false ) ) : ?>
					<!-- header-responsive-nav -->
					<div class="header-responsive-nav hidden-lg hidden-md visible-sm visible-xs">
						<span class="header-responsive-nav-line"></span>
					    <span class="header-responsive-nav-line"></span>
					    <span class="header-responsive-nav-line"></span>
					</div>
					<!-- header-responsive-nav -->
				<?php endif; ?>
				<!-- nav -->
			    <nav class="nav visible-lg visible-md hidden-sm hidden-xs">
					<?php
					if ( true == glamon_global_var( 'header_eightteen_menu_singlepagemode', '', false ) ) {
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

<?php if ( true == glamon_global_var( 'header_eightteen_mobile_menu_display', '', false ) ) : ?>
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
				if ( true == glamon_global_var( 'header_eightteen_menu_singlepagemode', '', false ) ) {
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
<?php endif; ?>
