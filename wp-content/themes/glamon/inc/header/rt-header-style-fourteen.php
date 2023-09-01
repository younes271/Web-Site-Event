<?php
/**
 * Header Style Fourteen Template
 *
 * @package glamon
 */

?>

<!-- wraper_header -->
<header class="wraper_header style-fourteen">
	<!-- wraper_header_main -->
	<?php if ( true == glamon_global_var( 'header_fourteen_sticky', '', false ) ) { ?>
	    <div data-delay="<?php echo esc_attr( glamon_global_var( 'header_fourteen_sticky_delay', '', false ) ); ?>" class="wraper_header_main radiantthemes-sticky-style-<?php echo esc_attr( glamon_global_var( 'header_fourteen_sticky_style', '', false ) ); ?>">
	<?php } else { ?>
		<div class="wraper_header_main">
	<?php } ?>
		<div class="container">
			<!-- header_main -->
			<div class="row header_main">
			    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-left">
			        <!-- header_main_item -->
			        <div class="header_main_item">
			            <!-- header-slideout-menu -->
        				<div class="header-slideout-menu"><span class="ti-menu"></span></div>
        				<!-- header-slideout-menu -->
			        </div>
			        <!-- header_main_item -->
			    </div>
			    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-8 text-center">
			        <!-- header_main_item -->
			        <div class="header_main_item">
			            <?php if ( glamon_global_var( 'header_fourteen_logo', 'url', true ) ) { ?>
        					<!-- brand-logo -->
        					<div class="brand-logo">
        						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( glamon_global_var( 'header_fourteen_logo', 'url', true ) ); ?>" alt="<?php echo esc_attr( glamon_global_var( 'header_fourteen_logo', 'alt', true ) ); ?>"></a>
        					</div>
        					<!-- brand-logo -->
        				<?php } ?>
        				<?php if ( glamon_global_var( 'header_fourteen_sticky_logo', 'url', true ) ) { ?>
							<!-- brand-logo-sticky -->
							<div class="brand-logo-sticky radiantthemes-retina">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( glamon_global_var( 'header_fourteen_sticky_logo', 'url', true ) ); ?>" alt="<?php echo esc_attr( glamon_global_var( 'header_fourteen_sticky_logo', 'alt', true ) ); ?>"></a>
							</div>
							<!-- brand-logo-sticky -->
						<?php } ?>
			        </div>
			        <!-- header_main_item -->
			    </div>
			    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right visible-lg visible-md visible-sm hidden-xs">
			        <!-- header_main_item -->
			        <div class="header_main_item">
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
			        <!-- header_main_item -->
			    </div>
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
