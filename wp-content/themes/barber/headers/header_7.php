<?php
$apr_settings = apr_check_theme_options();
$apr_header_class = '';
$apr_header_layout = isset($apr_settings['header_layout_style_3']) ? $apr_settings['header_layout_style_3'] :'';
if(apr_get_meta_value('header_layout_style') !='' && apr_get_meta_value('header_layout_style') !='default'){
	$apr_header_layout =  apr_get_meta_value('header_layout_style');
}
	$apr_header_layout_class = '';
	if($apr_header_layout == '1'){
		$apr_header_layout_class = 'container-fluid';
	}
	else if($apr_header_layout == '3'){
		$apr_header_layout_class = 'container-fluid header-boxed';
	}else{
		$apr_header_layout_class = 'container';
	}
?>

<div class="header-wrapper <?php echo esc_attr($apr_header_class);?>">
	<div class="<?php echo esc_attr($apr_header_layout_class); ?>">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 hidden-lg hidden-md">
				<div class="header-logo">
					<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
						<?php 
						if(isset($apr_settings['logo7']) && $apr_settings['logo7']!=''){
						$logo_header = (apr_get_meta_value('logo_header_page') != '') ? apr_get_meta_value('logo_header_page') : $apr_settings['logo7']['url'];
						}elseif(isset($apr_settings['logo']) && $apr_settings['logo']!=''){
							$logo_header = (apr_get_meta_value('logo_header_page') != '') ? apr_get_meta_value('logo_header_page') : $apr_settings['logo']['url'];
						}
						?>
						<?php
						if ($logo_header && $logo_header != ''):
							echo '<img class="" src="' . esc_url(str_replace(array('http:', 'https:'),'', 
								$logo_header)) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
						else:
							bloginfo('name');
						endif;
						?>
					</a>
				</div>
			</div>
			<div class="kad-header-logo hidden-xs hidden-sm">
				<?php if (is_front_page()) : ?>
					<h1 class="header-logo">
					<?php else : ?>
						<h2 class="header-logo">
						<?php endif; ?>
						<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
							<?php 
							if(isset($apr_settings['logo7']) && $apr_settings['logo7']!=''){
							$logo_header = (apr_get_meta_value('logo_header_page') != '') ? apr_get_meta_value('logo_header_page') : $apr_settings['logo7']['url'];
							}elseif(isset($apr_settings['logo']) && $apr_settings['logo']!=''){
								$logo_header = (apr_get_meta_value('logo_header_page') != '') ? apr_get_meta_value('logo_header_page') : $apr_settings['logo']['url'];
							}
							?>
							<?php
							if ($logo_header && $logo_header != ''):
								echo '<img class="" src="' . esc_url(str_replace(array('http:', 'https:'),'', 
									$logo_header)) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
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
			<div class="col-md-12 col-sm-12 col-xs-12 kad-header-menu">
				<div class="header-container">
					<div class="open-menu-mobile hidden-lg hidden-md"><i class="lnr lnr-menu"></i></div>
					<div class="header-center">
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
						</nav> 
					</div>  
					<div class="header-right">
						<div class="header_icon display-inline-b">	                 
							<?php 	                
							if ($apr_settings['header-search']) {
									$apr_search_template = apr_get_search_form();
									echo '<div class="search-block-top">' .wp_kses($apr_search_template, apr_allow_html()) . '</div>';
								}  
							apr_show_language_dropdown(); 
							?>  
						</div>	
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
						<?php if (isset($apr_settings['header-info']) && $apr_settings['header-info']) :?>
							<div class="header_icon display-inline-b header-info">
								<div class="open-menu"><i class="<?php echo esc_html($apr_settings['header-info-icon']); ?>"></i></div>
								<div class="header-ver">
									<div class="header-sidebar">
										<div class="close-menu hover-effect">
											<i class="lnr lnr-cross"></i>
											<i class="lnr lnr-cross fa-hover"></i>
										</div>
										<h2 class="logo-sidebar">
											<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
												<?php 
												if(isset($apr_settings['logo7']) && $apr_settings['logo7']!=''){
												$logo_header = (apr_get_meta_value('logo_header_page') != '') ? apr_get_meta_value('logo_header_page') : $apr_settings['logo7']['url'];
												}elseif(isset($apr_settings['logo']) && $apr_settings['logo']!=''){
													$logo_header = (apr_get_meta_value('logo_header_page') != '') ? apr_get_meta_value('logo_header_page') : $apr_settings['logo']['url'];
												}
												?>
												<?php
												if ($logo_header && $logo_header != ''):
													echo '<img class="" src="' . esc_url(str_replace(array('http:', 'https:'),'', 
														$logo_header)) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
												else:
													bloginfo('name');
												endif;
												?>
											</a>
										</h2>
										<?php if(isset($apr_settings['header-slogan']) && $apr_settings['header-slogan']):?>
											<div class="header-slogan">
												<div class="slogan">
												<?php echo force_balance_tags(wp_kses($apr_settings['header-slogan'],array(
													'p' => array(),
					                                'br' => array(),
					                                'a' => array(
					                                	'href'=>array(), 
														'target' =>array()
					                                ),
					                                'ul' => array(),
					                                'li' => array(),
					                                'h4' => array()
													))); ?>
														
												</div>
											</div>
										<?php endif;?>
										<div class="social-sidebar">
											<?php apr_side_tabbed(); ?>
										</div>
										<?php if(isset($apr_settings['header-social']) && $apr_settings['header-social']):?>
											<div class="header-social">
												<h4><?php echo esc_html__('LET&rsquo;S GET SOCIAL','barber');?></h4>
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
										<?php if(isset($apr_settings['header-contact']) && $apr_settings['header-contact']):?>
											<?php if((isset($apr_settings['header-callto']) && $apr_settings['header-mailto']) || (isset($apr_settings['header-callto']) && $apr_settings['header-mailto'])):?>
												<div class="header-contact">
													<h4><?php echo esc_html__('Contact Us','barber');?></h4>
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
									</div>
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
