<?php
$apr_settings = apr_check_theme_options();
?>

	<div class="footer-content text-center">
		<div class="container">	
			<div class="row  list-item-info">				
				<div class="col-md-3 col-sm-6 col-xs-12 text-center">
					<?php
			            if (is_active_sidebar('footer-3-widget1')) {
			            ?> 
			            	<?php dynamic_sidebar('footer-3-widget1'); ?>
						<?php
			            }
			        ?>
				</div>	
				<div class="col-md-3 col-sm-6 col-xs-12 text-center">
					<?php
			            if (is_active_sidebar('footer-3-widget2')) {
			            ?> 
			            	<?php dynamic_sidebar('footer-3-widget2'); ?>
						<?php
			            }
			        ?>
				</div>	
				<div class="col-md-3 col-sm-6 col-xs-12 text-center">
					<?php
			            if (is_active_sidebar('footer-3-widget3')) {
			            ?> 
			            	<?php dynamic_sidebar('footer-3-widget3'); ?>
						<?php
			            }
			        ?>
				</div>	
				<div class="col-md-3 col-sm-6 col-xs-12 text-center">
					<?php
			            if (is_active_sidebar('footer-3-widget4')) {
			            ?> 
			            	<?php dynamic_sidebar('footer-3-widget4'); ?>
						<?php
			            }
			        ?>
				</div>	
			</div>	
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 text-left">
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
				<div class="col-md-6 col-sm-6 col-xs-12 text-right">
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
		</div>
	</div>