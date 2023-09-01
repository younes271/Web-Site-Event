<?php
/**
 * Header Style Five Template
 *
 * @package glamon
 */

?>

<!-- wraper_header -->
<?php if ( true == glamon_global_var( 'header_five_floating', '', false ) ) { ?>
	<header class="wraper_header style-five floating-header">
<?php } else { ?>
	<header class="wraper_header style-five static-header">
<?php } ?>
	<!-- wraper_header_main -->
	<?php if ( true == glamon_global_var( 'header_five_sticky', '', false ) ) { ?>
	    <div data-delay="<?php echo esc_attr( glamon_global_var( 'header_five_sticky_delay', '', false ) ); ?>" class="wraper_header_main radiantthemes-sticky-style-<?php echo esc_attr( glamon_global_var( 'header_five_sticky_style', '', false ) ); ?>">
	<?php } else { ?>
		<div class="wraper_header_main">
	<?php } ?>
		<div class="container">
			<!-- header_main -->
			<div class="header_main">
				<?php if ( glamon_global_var( 'header_five_logo', 'url', true ) ) { ?>
					<!-- brand-logo -->
					<div class="brand-logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( glamon_global_var( 'header_five_logo', 'url', true ) ); ?>" alt="<?php echo esc_attr( glamon_global_var( 'header_five_logo', 'alt', true ) ); ?>"></a>
					</div>
					<!-- brand-logo -->
				<?php } ?>
			    <!-- header-flyout-menu -->
				<div class="header-flyout-menu">
				    <span class="header-flyout-menu-icon"></span>
				    <span class="header-flyout-menu-icon"></span>
				    <span class="header-flyout-menu-icon"></span>
				    <span class="header-flyout-menu-icon"></span>
				    <span class="header-flyout-menu-icon"></span>
				    <span class="header-flyout-menu-icon"></span>
				    <span class="header-flyout-menu-icon"></span>
				    <span class="header-flyout-menu-icon"></span>
				    <span class="header-flyout-menu-icon"></span>
				    <span class="header-flyout-menu-icon"></span>
				    <span class="header-flyout-menu-icon"></span>
				    <span class="header-flyout-menu-icon"></span>
				    <span class="header-flyout-menu-icon"></span>
				    <span class="header-flyout-menu-icon"></span>
				    <span class="header-flyout-menu-icon"></span>
				    <span class="header-flyout-menu-icon"></span>
				</div>
				<!-- header-flyout-menu -->
				<!-- header_main_action -->
				<div class="header_main_action">
					<ul>
						<?php if ( ( class_exists( 'WooCommerce' ) ) && ( true == glamon_global_var( 'header_five_cart_display', '', false ) ) ) : ?>
							<li class="header-cart-bar">
								<a class="header-cart-bar-icon" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
									<i class="fa fa-shopping-basket"></i>
									<span class="cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
								</a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
				<!-- header_main_action -->
				<div class="clearfix"></div>
			</div>
			<!-- header_main -->
		</div>
	</div>
	<!-- wraper_header_main -->
</header>
<!-- wraper_header -->

<!-- wraper_flyout_menu -->
<div class="wraper_flyout_menu">
	<div class="table">
		<div class="table-cell">
			<!-- flyout-menu -->
			<div class="flyout-menu">
				<!-- flyout-menu-close -->
				<div class="flyout-menu-close">
					<span class="flyout-menu-close-line"></span>
				    <span class="flyout-menu-close-line"></span>
				</div>
				<!-- flyout-menu-close -->
				<!-- flyout-menu-nav -->
				<nav class="flyout-menu-nav">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'flyout-menu',
							'fallback_cb'    => false,
						)
					);
					?>
				</nav>
				<!-- flyout-menu-nav -->
				<!-- flyout-header-social -->
				<div class="flyout-header-social">
				    <p class="title"><?php echo esc_html__( 'Follow Us On', 'glamon' ); ?></p>
					<?php
					if ( true == glamon_global_var( 'social-icon-target', '', false ) ) {
						$social_target = 'target="_blank"';
					} else {
						$social_target = '';
					}
					?>
					<!-- social -->
					<ul class="social">
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
					<!-- social -->
				</div>
				<!-- flyout-header-social -->
			</div>
			<!-- flyout-menu -->
		</div>
	</div>
</div>
<!-- wraper_flyout_menu -->