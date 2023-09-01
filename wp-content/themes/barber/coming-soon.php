<?php
/*
 Template Name: Coming soon
 */
 ?>

<?php get_header(); ?>
<div id="primary" class="site-content">
    <div id="content">
    	<div class="page-coming-soon has-overlay text-center">
	        <div class="container">
				<div class="row">  	
					<div class="coming-soon-container">			
						<div class="coming-soon">
							<?php if(isset($apr_settings['under-contr-title']) && $apr_settings['under-contr-title'] != ''):?>
								<div class="coming-title"><?php echo wp_kses($apr_settings['under-contr-title'], 
		                                array(
		                                'a' => array(
		                                    'href' => array('callto'=> array()),
		                                    'title' => array(),
		                                    'target' => array(),
		                                ),
		                                'i' => array(
		                                    'class' => array(),
		                                    'aria-hidden' => array(),
		                                ),
		                                'h2' => array(
		                                    'class' => array(),
		                                ),
		                                'h3' => array(
		                                    'class' => array(),
		                                ),
		                                ));
		                            ?>
                                	
                                </div>
							<?php endif;?>					

							<?php if($apr_settings['under-display-countdown'] == 1):?>
								<?php 
								if(!isset($apr_settings['under-end-date']) || $apr_settings['under-end-date'] == ""){
									$apr_settings['under-end-date'] ="12/28/2017";
								}
								?>
								<?php if(isset($apr_settings['under-end-date']) && $apr_settings['under-end-date'] != ''):?>
									<div class="coming-clock">
										<div id="getting-started"></div>
									</div>
								<?php endif;?>
							<?php endif;?>
							<div class="coming-subcribe">

								<?php if($apr_settings['under-mail'] == 1):?>
									<?php
										if( function_exists( 'mc4wp_show_form' ) ) {
										    mc4wp_show_form();
										}
									?>
								<?php endif;?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>
