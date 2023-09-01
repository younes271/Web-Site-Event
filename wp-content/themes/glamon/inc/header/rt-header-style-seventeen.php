<?php
/**
 * Header Style Seventeen Template
 *
 * @package glamon
 */

?>

<!-- wraper_header -->
<header class="wraper_header style-seventeen">
	<!-- wraper_header_main -->
	<?php if ( true == glamon_global_var( 'header_seventeen_sticky', '', false ) ) { ?>
	    <div data-delay="<?php echo esc_attr( glamon_global_var( 'header_seventeen_sticky_delay', '', false ) ); ?>" class="wraper_header_main radiantthemes-sticky-style-<?php echo esc_attr( glamon_global_var( 'header_seventeen_sticky_style', '', false ) ); ?>">
	<?php } else { ?>
		<div class="wraper_header_main">
	<?php } ?>
		<div class="container">
			<!-- header_main -->
			<div class="header_main">
				<?php if ( glamon_global_var( 'header_seventeen_logo', 'url', true ) ) { ?>
					<!-- brand-logo -->
					<div class="brand-logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( glamon_global_var( 'header_seventeen_logo', 'url', true ) ); ?>" alt="<?php echo esc_attr( glamon_global_var( 'header_seventeen_logo', 'alt', true ) ); ?>"></a>
					</div>
					<!-- brand-logo -->
				<?php } ?>
			    <!-- header-slideout-menu -->
				<div class="header-slideout-menu">
				    <span class="header-slideout-menu-line"></span>
				    <span class="header-slideout-menu-line"></span>
				    <span class="header-slideout-menu-line"></span>
				</div>
				<!-- header-slideout-menu -->
				<div class="clearfix"></div>
			</div>
			<!-- header_main -->
		</div>
	</div>
	<!-- wraper_header_main -->
</header>
<!-- wraper_header -->

<!-- wraper_slideout_menu -->
<div class="wraper_slideout_menu">
    <!-- slideout-menu-overlay -->
    <div class="slideout-menu-overlay">
        <!-- slideout-menu-close -->
    	<div class="slideout-menu-close"><span class="ti-close"></span></div>
    	<!-- slideout-menu-close -->
    	<!-- slideout-menu -->
    	<div class="slideout-menu">
    		<!-- slideout-menu-nav -->
    		<nav class="slideout-menu-nav">
				<?php
    			wp_nav_menu(
    				array(
    					'theme_location' => 'slideout-menu',
    					'fallback_cb'    => false,
    				)
    			); ?>
    		</nav>
    		<!-- slideout-menu-nav -->
    	</div>
    	<!-- slideout-menu -->
	</div>
	<!-- slideout-menu-overlay -->
</div>
<!-- wraper_slideout_menu -->
