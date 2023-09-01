<?php $apr_settings = apr_check_theme_options(); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) :?>
        <?php if (!empty($apr_settings['favicon'])): ?>
            <link rel="shortcut icon" href="<?php echo esc_url(str_replace(array('http:', 'https:'), '', $apr_settings['favicon']['url'])); ?>" type="image/x-icon" />
        <?php endif; ?>
    <?php endif;?>    
    <?php wp_head(); ?>
</head>
<?php
$apr_sidebar_left = apr_get_sidebar_left();
$apr_sidebar_right = apr_get_sidebar_right();
$apr_layout = apr_get_layout();
$header_type = apr_get_header_type();
$header_position = apr_get_header_mobile_position();
$apr_remove_space_br = apr_get_meta_value('remove_space_br', true);
$apr_remove_space = apr_get_meta_value('remove_space', true);
$apr_header_fixed = get_post_meta(get_the_ID(), 'header_fixed', true);
$header_class = '';
$header_position_class = '';
$apr_coming_soon_class = '';
if($apr_header_fixed || (isset($apr_settings['header-fixed']) && $apr_settings['header-fixed']) && !is_404()){
    $header_class .= ' fixed-header';
}
if($header_position == '2'){
    $header_position_class .= ' header-bottom';
}else{
	$header_position_class .= ' header-top';
}
if (is_404() || is_page_template( 'coming-soon.php' )) {
    $apr_layout =  'wide';
}
if($header_type=='6'){
    $header_class .= ' right_openmenu ';
}
if(is_page_template( 'coming-soon.php' ) && isset($apr_settings['coming_footer_display']) && !$apr_settings['coming_footer_display']){
    $apr_coming_soon_class =' hide_footer ';
}
if(is_page_template( 'coming-soon.php' ) && isset($apr_settings['coming_header_display']) && !$apr_settings['coming_header_display']){
    $apr_coming_soon_class .=' hide_header ';
}

$layout_class = '';
if($apr_layout == 'wide'){
	$layout_class = ' wide';
}elseif($apr_layout == 'fullwidth'){
	$layout_class = ' full-width';
}else{
	$layout_class = '';
}
$layout_class2 = '';
if($apr_layout == 'boxed'){
    $layout_class2 = ' boxed';
}

?>
<body <?php body_class(); ?>>
    <?php echo apr_pre_loader();?>
	<div id="page" class="hfeed site <?php if(!$apr_remove_space){echo 'remove_space';}?> 
                                     <?php if(!$apr_remove_space_br){echo 'remove_space_br';}?> 
                                     <?php echo esc_attr($header_class);?>
                                     <?php echo esc_attr($apr_coming_soon_class);?>
                                     <?php echo esc_attr($layout_class2); ?>">
        <?php if (apr_get_meta_value('show_header', true)) : ?>
			<?php if($header_type == '9'): ?>
				<?php apr_get_banner_top(); ?>
			<?php endif; ?>
            <header id="masthead" class="site-header<?php echo esc_attr($header_position_class); ?> header-v<?php echo esc_attr($header_type); ?>">
                <?php get_template_part('headers/header_' . $header_type); ?>
            </header>
        <?php endif; ?>
        <?php get_template_part('breadcrumb'); ?>
        <?php apr_get_page_slider();?>
        <div id="main" class="wrapper <?php echo esc_attr($layout_class); ?>">
        <?php apr_get_post_banner_block();?>                  
        <?php if($apr_layout == 'fullwidth') :?>
            <div class="container">
				 <div class="row">    
			<?php else: ?>
			<div class="container-fluid">
			<?php endif;?> 
            

                    
        
       
