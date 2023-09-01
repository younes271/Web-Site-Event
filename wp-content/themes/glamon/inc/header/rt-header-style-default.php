<?php
/**
 * Template for Default Header
 *
 * @package glamon
 */

?>

<!-- wraper_header -->
<header class="wraper_header style-default">
	<!-- wraper_header_main -->
	<div class="wraper_header_main">
		<div class="container">
			<!-- header_main -->
			<div class="header_main">
				<!-- brand-logo -->
				<div class="brand-logo">
				    <div class="table">
				        <div class="table-cell">
        					<?php if ( has_custom_logo() ) { ?>
        						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php the_custom_logo(); ?></a>
        					<?php } else { ?>
        					    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><p class="site-title"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></p></a>
        					<?php } ?>
					    </div>
					</div>
				</div>
				<!-- brand-logo -->
				<!-- header-responsive-nav -->
				<div class="header-responsive-nav hidden-lg hidden-md visible-sm visible-xs">
					<i class="fa fa-bars"></i>
				</div>
				<!-- header-responsive-nav -->
				<!-- nav -->
				<nav class="nav visible-lg visible-md hidden-sm hidden-xs">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'top',
							'fallback_cb'    => false,
						)
					);
					?>
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
			wp_nav_menu(
				array(
					'theme_location' => 'top',
					'fallback_cb'    => false,
				)
			);
			?>
		</nav>
		<!-- mobile-menu-nav -->
	</div>
	<!-- mobile-menu-main -->
</div>
<!-- mobile-menu -->
