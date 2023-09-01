<?php
/**
 * The Header column template file
 
 * @params
	$enable_contact
	$icon_ratio
	$enable_opening_hours
	$enable_address
	$phone
	$email
	$opening_hours_line_1
	$opening_hours_line_2
	$address_line_1
	$address_line_2
	$link_map
	
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kitring
 */
?>
<?php
$link_attributes = array(
	'class'			=> array(
		'uk-flex uk-flex-middle'
	),
	'aria-label'	=> __( 'Newsletter', 'kitring' ),
	'href'			=> "#header-newsletter-modal",
	'title'			=> __( 'Newsletter', 'kitring' ),
	'data-uk-toggle'=> array( 'target: #header-newsletter-modal' )
);
?>
<a <?php dahz_framework_set_attributes(
	$link_attributes,
	'header_newsletter_link'
);?>>
	<?php echo apply_filters( 'dahz_framework_newsletter_link_content', $link_content );?>
</a>
