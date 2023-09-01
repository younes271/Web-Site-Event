<?php

// JSON-LD for Wordpress Home Articles and Author Pages written by Pete Wailes and Richard Baxter
function dahz_framework_get_single_post_data() { global $post; return $post; } 

$ldSinglePost["@context"] = "http://schema.org/";

// this has all the data of the post/page etc 
$post_data = dahz_framework_get_single_post_data(); // stuff for any page, if it exists 
$category = get_the_category(); // stuff for specific pages 
$blog_title = get_bloginfo( 'name' );
if ( is_singular('post') ) { 
	// this gets the data for the user who wrote that particular item 
	$author_data = get_userdata($post_data->post_author); 
	$post_url = get_permalink(); 
	if ( has_post_thumbnail() ) {
		$post_thumb = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())); 
	} else {
		$post_thumb = esc_url( get_template_directory_uri() . '/assets/default-placeholder/img-land-lg-l.jpg' );
	}
	$postThumbmetasize = wp_get_attachment_metadata(get_post_thumbnail_id(get_the_ID()), 'true');
	$forPublisherLogo = dahz_framework_get_option( 'logo_and_site_identity_logo_default_normal', get_template_directory_uri() . '/assets/images/logo/default-logo.svg' );
	if ( has_post_thumbnail( get_the_ID() ) ) {
		$postThumbmetawidth = $postThumbmetasize['width'];
		$postThumbmetaheight = $postThumbmetasize['height'];
	} else {
		$postThumbmetawidth = '';
		$postThumbmetaheight = '';	
	}

	$ldSinglePost["@type"] = "NewsArticle";
	$ldSinglePost["mainEntityOfPage"] = array( "@type"=> "WebPage", "@id" => get_site_url() );
	$ldSinglePost["url"] = $post_url; 
	$ldSinglePost["author"] = array( "@type" => "Person", "name" => $author_data->display_name, ); 
	$ldSinglePost["headline"] = $post_data->post_title; 
	$ldSinglePost["datePublished"] = $post_data->post_date;
	$ldSinglePost["dateModified"] = $post_data->post_modified_gmt;
	$ldSinglePost["image"] = array( "@type" => "ImageObject", "url" => $post_thumb, "width" => $postThumbmetawidth, "height" => $postThumbmetaheight);
	if ( !class_exists('WooCommerce') || ( class_exists('WooCommerce') && !is_woocommerce() ) ) {
		$ldSinglePost["ArticleSection"] = $category[0]->cat_name; 
	}
	
	$ldSinglePost["Publisher"] = array( "@type" => "Organization", "name" => $blog_title, "logo" => array("@type" => "ImageObject", "url" => $forPublisherLogo, "width" => 600, "height" => 60 ) );
}