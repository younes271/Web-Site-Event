<?php
$apr_settings = apr_check_theme_options();
?>

<?php if (isset($apr_settings['footer-copyright']) && $apr_settings['footer-copyright']) : ?>
	<div class="footer-content has-overlay text-center">
		<div class="container">	
			<h2 class="footer-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                	<?php 
                		$logo_footer = (apr_get_meta_value('logo_footer_page') != '') ? apr_get_meta_value('logo_footer_page') : $apr_settings['logo_footer']['url'];
                	?>                
                    <?php
                    if (isset($logo_footer) && $logo_footer != ''):
                        echo '<img class="" src="' . esc_url(str_replace(array('http:', 'https:'), '', $logo_footer)) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
                    else:
                        bloginfo('name');
                    endif;
                    ?>
                </a>
            </h2>
            <?php
            if (is_active_sidebar('footer-newsletter')) {
            ?>
            <div class="footer-newsletter">				 
	            	<?php dynamic_sidebar('footer-newsletter'); ?>
			</div>
			<?php
            }
            ?>
			<div class="row text-left">
				<div class="col-md-4 col-sm-6 col-xs-12">
					<?php if (isset($apr_settings['footer-info_title']) && $apr_settings['footer-info_title']) : ?>
						<h4 class="footer-title"><?php echo esc_html($apr_settings['footer-info_title']);?></h4>
					<?php endif;?>
					<?php if (isset($apr_settings['footer-info']) && $apr_settings['footer-info']) : ?>
						
						<div class="footer_info">
							<p><?php echo force_balance_tags(wp_kses($apr_settings['footer-info'],array('i'=>array('class' =>array()),
								'a'=>array(
									'href'=>array(), 
									'target' =>array()
									))
								)); ?></p>	
						</div>
					<?php endif;?>
					<ul class="list-info-footer">
						<li>
							<?php echo force_balance_tags(wp_kses($apr_settings['footer-address'],array('i'=>array('class' =>array()),
							'a'=>array(
								'href'=>array(), 
								'target' =>array()
								))
							)); ?>
						</li>
						<li class="info-mail">
							<?php if (!empty($apr_settings['footer-email'])): ?>
								<?php echo force_balance_tags(wp_kses($apr_settings['footer-email'],array('i'=>array('class' =>array()),
									'a'=>array(
									'href'=>array(), 
									'target' =>array()
									))
								)); ?>								
							<?php endif;?>	
						</li>
						<li>
							<?php if (!empty($apr_settings['footer-phone'])): ?>
								<?php echo force_balance_tags(wp_kses($apr_settings['footer-phone'],array('i'=>array('class' =>array()),
									'a'=>array(
									'href'=>array(), 
									'target' =>array()
									))
								)); ?>								
							<?php endif;?>	
						</li>
						<li>
							<?php if (!empty($apr_settings['footer-fax'])): ?>
								<?php echo force_balance_tags(wp_kses($apr_settings['footer-fax'],array('i'=>array('class' =>array()),
									'a'=>array(
									'href'=>array(), 
									'target' =>array()
									))
								)); ?>								
							<?php endif;?>	
						</li>
					</ul>
					<div class="dib footer-social ">
	                    <ul>
	                    	<?php if (!empty($apr_settings['social-facebook'])): ?>
	                            <li><a href="<?php echo esc_url($apr_settings['social-facebook']) ?>" data-toggle="tooltip" title="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
	                        <?php endif; ?>
	                        <?php if (!empty($apr_settings['social-twitter'])): ?>
	                            <li><a href="<?php echo esc_url($apr_settings['social-twitter']) ?>" data-toggle="tooltip" title="twitter"><i class="fa fa-twitter"></i></a></li>
	                        <?php endif; ?>
	                        <?php if (!empty($apr_settings['social-google'])): ?>
	                            <li><a href="<?php echo esc_url($apr_settings['social-google']) ?>" data-toggle="tooltip" title="google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
	                        <?php endif; ?>
	                        <?php if (!empty($apr_settings['social-instagram'])): ?>
	                            <li><a href="<?php echo esc_url($apr_settings['social-instagram']) ?>" data-toggle="tooltip" title="instagram"><i class="fa fa-instagram"></i></a></li>
	                        <?php endif; ?>
	                        <?php if (!empty($apr_settings['social-pinterest'])): ?>
	                            <li><a href="<?php echo esc_url($apr_settings['social-pinterest']) ?>" data-toggle="tooltip" title="pinterest plus"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
	                        <?php endif; ?>
	                        <?php if (!empty($apr_settings['social-linkedin'])): ?>
	                            <li><a href="<?php echo esc_url($apr_settings['social-linkedin']) ?>" data-toggle="tooltip" title="linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
	                        <?php endif; ?>
	                        <?php if (!empty($apr_settings['social-behance'])): ?>
	                            <li><a href="<?php echo esc_url($apr_settings['social-behance']) ?>" data-toggle="tooltip" title="behance"><i class="fa fa-behance" aria-hidden="true"></i></a></li>
	                        <?php endif; ?>
	                        <?php if (!empty($apr_settings['social-dribbble'])): ?>
	                            <li><a href="<?php echo esc_url($apr_settings['social-dribbble']) ?>" data-toggle="tooltip" title="dribbble"><i class="fa fa-dribbble"></i></a></li>
	                        <?php endif; ?>	
	                    </ul>
		            </div>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<?php
		            if (is_active_sidebar('footer-1-widget1')) {
		            ?> 
		            	<?php dynamic_sidebar('footer-1-widget1'); ?>
					<?php
		            }
		            ?>
				</div>
				<div class="col-md-2 col-sm-6 col-xs-12">
					<?php
		            if (is_active_sidebar('footer-menu')) {
		            ?> 
		            	<?php dynamic_sidebar('footer-menu'); ?>
					<?php
		            }
		            ?>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-12">
					<?php
		            if (is_active_sidebar('footer-1-widget2')) {
		            ?> 
		            	<?php dynamic_sidebar('footer-1-widget2'); ?>
					<?php
		            }
		            ?>
				</div>
			</div>					
			<?php if (isset($apr_settings['footer-copyright']) && $apr_settings['footer-copyright'] != ''): ?>
			<div class="footer-copyright">	
				<p><?php echo force_balance_tags(wp_kses($apr_settings['footer-copyright'],array('i'=>array('class' =>array()),
				'a'=>array(
					'href'=>array(), 
					'target' =>array()
					))
				)); ?></p>
			</div>	
			<?php endif;?>
		</div>
	</div>
<?php endif;?>