<?php
$apr_settings = apr_check_theme_options();
?>

<?php if (isset($apr_settings['footer-copyright']) && $apr_settings['footer-copyright']) : ?>
	<div class="footer-top">
		<?php
            if (is_active_sidebar('footer2-menu')) {
            ?> 
            	<?php dynamic_sidebar('footer2-menu'); ?>
			<?php
            }
        ?>
	</div>
	<div class="footer-content">
		<div class="container">	
			<div class="row">	
				<div class="col-md-4 col-sm-4 col-xs-12 text-center">
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
				<div class="col-md-4 col-sm-4 col-xs-12 text-center">
					<h2 class="footer-logo">
		                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
		                	<?php 
		                		$logo_footer10 = (apr_get_meta_value('logo_footer_page') != '') ? apr_get_meta_value('logo_footer_page') : $apr_settings['logo_footer10']['url'];
		                	?>                
		                    <?php
		                    if (isset($logo_footer10) && $logo_footer10 != ''):
		                        echo '<img class="" src="' . esc_url(str_replace(array('http:', 'https:'), '', $logo_footer10)) . '" alt="' . esc_attr(get_bloginfo('name', 'display')) . '" />';
		                    else:
		                        bloginfo('name');
		                    endif;
		                    ?>
		                </a>
		            </h2>
				</div>	
				<div class="col-md-4 col-sm-4 col-xs-12 text-center">
		            <div class="to-top">
						<a class="to-top" href="javascript:void(0)"><?php echo esc_html__('Up to top', 'barber'); ?> <i class="fa fa-long-arrow-up"></i></a>
					</div>
				</div>	
			</div>	
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 text-center">
				<div class="footer-bottom">
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
<?php endif;?>