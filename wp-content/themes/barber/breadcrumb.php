<?php
$apr_settings = apr_check_theme_options();
$header_type = apr_get_header_type();
$breadcrumbs = apr_get_meta_value('breadcrumbs', true);
$breadcrumbs_layout = get_post_meta(get_the_ID(), 'breadcrumbs_style', true);
$breadcrumbs_style =  isset($apr_settings['breadcrumbs_style']) ? $apr_settings['breadcrumbs_style'] : '';
$breadcrumbs_layout = ($breadcrumbs_layout == 'default' || !$breadcrumbs_layout) ? $breadcrumbs_style : $breadcrumbs_layout;
$page_title = apr_get_meta_value('page_title', true);

if (( is_front_page() && is_home()) || is_front_page() || is_page_template( 'coming-soon.php' )) {
    $breadcrumbs = false;
    $page_title = false;
}
$apr_breadcrumb_class='';
if(isset($apr_settings['breadcrumbs-bg']) && $apr_settings['breadcrumbs-bg']['background-image'] !=''){
	$apr_breadcrumb_class = 'use_bg_image';
}
?>
<?php if($breadcrumbs_layout == 'type-3'):?>
	<?php if ($breadcrumbs || $page_title) : ?>
	<div class="side-breadcrumb type-3 has-overlay <?php echo esc_attr($apr_breadcrumb_class);?>"> 
		<div class="container">
	        <div class="row">
	        	<div class="col-md-12 col-sm-12 col-xs-12 breadcrumb-container <?php if(get_the_title() == ''){echo 'breadcrumb_no_title';}?>">
				    <?php if($page_title && (get_the_title() != '' || is_404())) :?>
				        <div class="page-title"><h1><?php apr_page_title(); ?></h1></div>
				    <?php endif;?>
				    <?php if ($breadcrumbs) : ?>
				        <?php apr_breadcrumbs(); ?>
				    <?php endif;?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
<?php elseif($breadcrumbs_layout == 'type-2'):?>
	<?php if ($breadcrumbs || $page_title) : ?>
	<div class="side-breadcrumb type-2"> 
		<div class="container">
	        <div class="row">
	        	<div class="col-md-12 col-sm-12 col-xs-12 breadcrumb-container <?php if(get_the_title() == ''){echo 'breadcrumb_no_title';}?>">
				    <?php if ($breadcrumbs) : ?>
				        <?php apr_breadcrumbs(); ?>
				    <?php endif;?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
<?php else: ?>
	<?php if ($breadcrumbs || $page_title) : ?>
	<div class="side-breadcrumb type-1 has-overlay <?php echo esc_attr($apr_breadcrumb_class);?>"> 
		<div class="container">
	        <div class="row">
	        	<div class="col-md-12 col-sm-12 col-xs-12 breadcrumb-container <?php if(get_the_title() == ''){echo 'breadcrumb_no_title';}?>">
				    <?php if($page_title && (get_the_title() != '' || is_404())) :?>
				        <div class="page-title"><h1><?php apr_page_title(); ?></h1></div>
				    <?php endif;?>
				    <?php if ($breadcrumbs) : ?>
				        <?php apr_breadcrumbs(); ?>
				    <?php endif;?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
<?php endif; ?>