<?php
$apr_settings = apr_check_theme_options();
$apr_header_class = '';
$apr_header_layout = isset($apr_settings['header_layout_style_2']) ? $apr_settings['header_layout_style_2'] :'';
	$apr_header_layout_class = '';
	if($apr_header_layout == '1'){
		$apr_header_layout_class = 'container-fluid';
	}
	else if($apr_header_layout == '3'){
		$apr_header_layout_class = 'container-fluid header-boxed';
	}else{
		$apr_header_layout_class = 'container';
	}
$has_logo_sticky = $logo_header_sticky = '';
if(isset($apr_settings['logo_sticky']) && $apr_settings['logo_sticky']!=''){
$logo_header_sticky = (apr_get_meta_value('logo_header_page') != '') ? apr_get_meta_value('logo_header_page') : $apr_settings['logo_sticky']['url'];
}

if($logo_header_sticky && $logo_header_sticky != ''){
	$has_logo_sticky = 'has-logo-sticky';
}
?>

<div class="header-wrapper <?php echo esc_attr($apr_header_class);?> <?php echo esc_attr($has_logo_sticky);?>">
	<div class="<?php echo esc_attr($apr_header_layout_class); ?>">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<?php if (is_front_page()) : ?>
					<h1 class="header-logo">
					<?php else : ?>
						<h2 class="header-logo">
						<?php endif; ?>
						<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
							<?php 
							if(isset($apr_settings['logo8']) && $apr_settings['logo8']!=''){
							$logo_header = (apr_get_meta_value('logo_header_page') != '') ? apr_get_meta_value('logo_header_page') : $apr_settings['logo8']['url'];
							}elseif(isset($apr_settings['logo']) && $apr_settings['logo']!=''){
								$logo_header = (apr_get_meta_value('logo_header_page') != '') ? apr_get_meta_value('logo_header_page') : $apr_settings['logo']['url'];
							}
							?>
						
							<?php

							if (($logo_header && $logo_header != '') && ($logo_header_sticky && $logo_header_sticky != '')):
								echo '<img class="logo" src="' . esc_url(str_replace(array('http:', 'https:'), '', $logo_header)) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
								echo '<img class="logo-sticky" src="' . esc_url(str_replace(array('http:', 'https:'), '', $logo_header_sticky)) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
							elseif ($logo_header && $logo_header != ''):
								echo '<img class="" width="50" height="50" src="' . esc_url(str_replace(array('http:', 'https:'), '', $logo_header)) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
							else:
								bloginfo('name');
							endif;
							?>
						</a>
						<?php if (is_front_page()) : ?>
					</h1>
				<?php else : ?>
					</h2>
				<?php endif; ?>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="header-container">
					<div class="open-menu-mobile hidden-lg hidden-md"><i class="lnr lnr-menu"></i></div>
					<div class="header-center">
						<div class="header-tops">
							<h2 class="logo-mobile hidden-lg hidden-md">
								<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
									<?php 
									if(isset($apr_settings['logo8']) && $apr_settings['logo8']!=''){
									$logo_header = (apr_get_meta_value('logo_header_page') != '') ? apr_get_meta_value('logo_header_page') : $apr_settings['logo8']['url'];
									}elseif(isset($apr_settings['logo']) && $apr_settings['logo']!=''){
										$logo_header = (apr_get_meta_value('logo_header_page') != '') ? apr_get_meta_value('logo_header_page') : $apr_settings['logo']['url'];
									}
									?>
								
									<?php
									if ($logo_header && $logo_header != ''):
										echo '<img class="" width="50" height="50" src="' . esc_url(str_replace(array('http:', 'https:'), '', $logo_header)) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
									else:
										bloginfo('name');
									endif;
									?>
								</a>
							</h2>
							<div class="close-menu-mobile hover-effect hidden-lg hidden-md"><i class="lnr lnr-cross"></i><i class="lnr lnr-cross fa-hover"></i></div>	
							<?php if(isset($apr_settings['header-social']) && $apr_settings['header-social']):?>
								<div class="header-social social-mobile hidden-lg hidden-md">
									<div class="social_icon hover-effect">
										<ul>
											<?php if(isset($apr_settings['social-header-twitter']) && $apr_settings['social-header-twitter'] !=''):?>
											 <li><a target="_blank" href="<?php echo esc_url($apr_settings['social-header-twitter']);?>" ><i class="fa fa-twitter"></i><i class="fa fa-twitter fa-hover"></i></a></li>
											<?php endif;?>
											<?php if(isset($apr_settings['social-header-instagram']) && $apr_settings['social-header-instagram'] !=''):?>
											 <li><a  target="_blank" href="<?php echo esc_url($apr_settings['social-header-instagram']);?>" ><i class="fa fa-instagram"></i><i class="fa fa-instagram fa-hover"></i></a></li>
											<?php endif;?>
											<?php if(isset($apr_settings['social-header-facebook']) && $apr_settings['social-header-facebook'] !=''):?>
											 <li><a  target="_blank" href="<?php echo esc_url($apr_settings['social-header-facebook']);?>" ><i class="fa fa-facebook"></i><i class="fa fa-facebook fa-hover"></i></a></li>
											<?php endif;?>
											<?php if(isset($apr_settings['social-header-google']) && $apr_settings['social-header-google'] !=''):?>
											 <li><a  target="_blank" href="<?php echo esc_url($apr_settings['social-header-google']);?>" ><i class="fa fa-google-plus"></i><i class="fa fa-google-plus fa-hover"></i></a></li>
											<?php endif;?>
											<?php if(isset($apr_settings['social-header-pinterest']) && $apr_settings['social-header-pinterest'] !=''):?>
											 <li><a  target="_blank" href="<?php echo esc_url($apr_settings['social-header-pinterest']);?>" ><i class="fa fa-pinterest"></i><i class="fa fa-pinterest fa-hover"></i></a></li>
											<?php endif;?>
										</ul>
									</div>
								</div>
							<?php endif;?>
						</div>
						<nav id="site-navigation" class="main-navigation">
							<?php
							$before_items_wrap = '';
							$after_item_wrap = '';
							if (has_nav_menu('primary')) {
								wp_nav_menu(array(
									'theme_location' => 'primary',
									'menu_class' => 'mega-menu',
									'items_wrap' => $before_items_wrap . '<ul id="%1$s" class="%2$s">%3$s</ul>' . $after_item_wrap,
									'walker' => new Apr_Primary_Walker_Nav_Menu()
										)
								);
							}
							?> 
							<?php if(isset($apr_settings['header-contact']) && $apr_settings['header-contact']):?>
								<?php if((isset($apr_settings['header-callto']) && $apr_settings['header-mailto']) || (isset($apr_settings['header-callto']) && $apr_settings['header-mailto'])):?>									
									<div class="header-contact contact-mobile hidden-lg hidden-md">
										<h5><?php echo esc_html__('Contact Us','barber');?></h5>
										<ul>
											<li>
												<a href="tel:<?php echo esc_html($apr_settings['header-callto']); ?>"><span class="lnr lnr-phone-handset"></span> <?php echo esc_html($apr_settings['header-callto']); ?></a>
											</li>
											<li>
												<a href="mailto:<?php echo esc_html($apr_settings['header-mailto']); ?>"><span class="lnr lnr-envelope"></span> <?php echo esc_html($apr_settings['header-mailto']); ?></a>
											</li>
										</ul>
									</div>
								<?php endif;?>	
							<?php endif;?>		
						</nav> 
					</div>  
					<div class="header-right">
						<?php if ($apr_settings['header-search']): ?>
							<div class="header_icon display-inline-b">	                 
								<?php 	  
										$apr_search_template = apr_get_search_form();
										echo '<div class="search-block-top">' .wp_kses($apr_search_template, apr_allow_html()) . '</div>';
								apr_show_language_dropdown(); 
								?>  
							</div>	
						<?php endif; ?>
						<?php	 
							if (isset($apr_settings['header-minicart']) && $apr_settings['header-minicart'] && class_exists('WooCommerce')) :
							$apr_minicart_template = apr_get_minicart_template();?>
							<div id="mini-scart" class="mini-cart display-inline-b"> <?php echo wp_kses($apr_minicart_template, apr_allow_html()); ?> </div>
						<?php endif; ?>
						
						<?php if (isset($apr_settings['header-myaccount']) && $apr_settings['header-myaccount']) :?>
							<div class="header_icon display-inline-b header-myaccount">
								<i class="<?php echo esc_html($apr_settings['header-myaccount-icon']); ?> btn_togglefilter"></i>
								<div class="header-profile content-filter">
									<?php
										$apr_myaccount_page_id = get_option('woocommerce_myaccount_page_id');
										$apr_logout_url = wp_logout_url(get_permalink($apr_myaccount_page_id));
										if (get_option('woocommerce_force_ssl_checkout') == 'yes') {
											$apr_logout_url = str_replace('http:', 'https:', $logout_url);
										}
									?>
									<ul>
										<li><a href="<?php echo esc_url(get_permalink($apr_myaccount_page_id)); ?>"><?php echo esc_html__('My Account', 'barber') ?></a></li>
										<?php if (!is_user_logged_in()): ?>
											<li><a href="<?php echo esc_url(get_permalink($apr_myaccount_page_id)); ?>"><?php echo esc_html__('Login / Register', 'barber') ?></a></li>
										<?php else: ?>
											<li><a href="<?php echo esc_url($apr_logout_url) ?>"><?php echo esc_html__('Logout', 'barber') ?></a></li>
										<?php endif; ?>
									</ul>
								</div>
							</div>	 
						<?php endif; ?> 
					</div>    
				</div> 
			</div> 
		</div>
	</div>
</div>
<!-- Menu -->
