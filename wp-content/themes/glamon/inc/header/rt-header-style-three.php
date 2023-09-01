<?php
/**
 * Header Style Three Template
 *
 * @package glamon
 */

?>

<!-- wraper_header -->
<header class="wraper_header style-three">
	<!-- wraper_header_responsive -->
	<div class="wraper_header_responsive hidden-lg hidden-md visible-sm visible-xs">
		<!-- responsive-sidemenu-open -->
		<div class="responsive-sidemenu-open"><span class="ti-menu"></span></div>
		<!-- responsive-sidemenu-open -->
		<!-- responsive-sidemenu-close -->
		<div class="responsive-sidemenu-close"><span class="ti-close"></span></div>
		<!-- responsive-sidemenu-close -->
	</div>
	<!-- wraper_header_responsive -->
	<!-- sidemenu-holder -->
	<div class="sidemenu-holder visible-lg visible-md hidden-sm hidden-xs">
		<!-- wraper_header_main -->
		<div class="wraper_header_main">
			<!-- header_main -->
			<div class="header_main">
				<?php if ( glamon_global_var( 'header_three_logo', 'url', true ) ) { ?>
					<!-- brand-logo -->
					<div class="brand-logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( glamon_global_var( 'header_three_logo', 'url', true ) ); ?>" alt="<?php echo esc_attr( glamon_global_var( 'header_three_logo', 'alt', true ) ); ?>"></a>
					</div>
					<!-- brand-logo -->
				<?php } ?>
				<!-- nav -->
				<nav class="nav">
					<?php
					if ( true == glamon_global_var( 'header_three_menu_singlepagemode', '', false ) ) {
    					wp_nav_menu(
    						array(
    							'theme_location' => 'side-panel-menu',
    							'fallback_cb'    => false,
    							'items_wrap'     => '<ul id="%1$s" class="%2$s single-page-mode">%3$s</ul>',
    						)
    					);
        			} else {
        			    wp_nav_menu(
                            array(
                                'theme_location' => 'side-panel-menu',
    							'fallback_cb'    => false,
                            )
                        );
        		    } ?>
				</nav>
				<!-- nav -->
				<?php if ( ! empty( glamon_global_var( 'header_three_copyright_text', '', false ) ) ) : ?>
					<!-- header-copyright -->
					<div class="header-copyright">
						<p><?php echo wp_kses_post( glamon_global_var( 'header_three_copyright_text', '', false ) ); ?></p>
					</div>
					<!-- header-copyright -->
				<?php endif; ?>
				<!-- header-social -->
				<div class="header-social">
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
				<!-- header-social -->
			</div>
			<!-- header_main -->
		</div>
		<!-- wraper_header_main -->
	</div>
	<!-- sidemenu-holder -->
</header>
<!-- wraper_header -->
