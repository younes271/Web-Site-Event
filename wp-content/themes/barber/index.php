<?php get_header(); ?>

<?php 
	$apr_class = '';
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
                 <?php get_template_part('templates/content', 'blog-archive'); ?>
             <?php else: ?> 
                 <?php get_template_part('content', 'none'); ?>
             <?php endif; ?>
		</div> <!-- End primary -->
	</div>
<?php get_sidebar('right'); ?> 
<?php get_footer(); ?> 