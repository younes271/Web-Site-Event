<?php get_header(); ?>

<?php 
	$apr_class = '';
	$apr_sidebar_left = apr_get_sidebar_left();
	$apr_sidebar_right = apr_get_sidebar_right();
	$apr_layout = apr_get_layout();	
	$apr_settings = apr_check_theme_options(); 
	if ($apr_sidebar_left && $apr_sidebar_right && is_active_sidebar($apr_sidebar_left) && is_active_sidebar($apr_sidebar_right)){
	 	$apr_class .= 'col-md-6 col-sm-12 col-xs-12 main-sidebar'; 
	}elseif($apr_sidebar_left && (!$apr_sidebar_right|| $apr_sidebar_right=="none") && is_active_sidebar($apr_sidebar_left)){
		$apr_class .= 'f-right col-lg-9 col-md-9 col-sm-12 col-xs-12 main-sidebar'; 
	}elseif((!$apr_sidebar_left || $apr_sidebar_left=="none") && $apr_sidebar_right && is_active_sidebar($apr_sidebar_right)){
		$apr_class .= 'col-lg-9 col-md-9 col-sm-12 col-xs-12 main-sidebar'; 
	}else {
		$apr_class .= 'content-primary'; 
		if($apr_layout == 'fullwidth'){
			$apr_class .= ' col-md-12';
		}
	}
?>
<?php get_sidebar('left'); ?> 
	<div class="<?php echo esc_attr($apr_class);?>">			
		<div id="primary" class="content-area">
             <?php if (have_posts()): ?>                        
                 <?php get_template_part( 'templates/content', 'blog-archive' ); ?>
             <?php else: ?> 
			    <article id="post-0" class="post no-results not-found">
			        <div class="container">
			            <h1 class="entry-title not-found-title"><?php echo esc_html__('Nothing Found', 'barber'); ?></h1>
			            <div class="row">
			                <div class="entry-content">
			                    <div class="col-md-6 col-sm-12 col-xs-12">
			                        <p><?php echo esc_html__('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'barber'); ?></p>
			                        <div class="widget widget_search">
			                        <?php get_search_form(); ?>
			                        </div>
			                    </div>
			                </div>
			            </div>
			        </div>
			    </article>
             <?php endif; ?>
		</div> <!-- End primary -->
	</div>
<?php get_sidebar('right'); ?> 
<?php get_footer(); ?>