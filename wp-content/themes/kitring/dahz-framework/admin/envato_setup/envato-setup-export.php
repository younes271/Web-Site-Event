<?php

// This is the export file that writes json files
// Your build process should probably exclude this file from the final theme zip, but it doesn't really matter.

// Change line 100 where it has the hard coded: /../theme/images/stock/ path
// This is the path where media files are copied to during export.
// Change this to your theme folder images/stock/ path, whatever that may be.
// The importer will look for local 'images/stock/*.jpg' files during import.

// Also change the json export path near the bottom: theme/plugins/envato_setup/content/

$default_content = array();
$post_types      = array( 'attachment', 'wpcf7_contact_form', 'post', 'page' );
foreach ( get_post_types() as $post_type ) {
	if ( ! in_array( $post_type, $post_types ) ) { // which post types to ignore.
		$post_types[] = $post_type;
	}
}
$categories = get_categories( array( 'type' => '' ) );
$taxonomies = get_taxonomies();
//              print_r($categories);
foreach ( $post_types as $post_type ) {
	if ( in_array( $post_type, array( 'revision', 'event', 'event-recurring' ) ) ) {
		continue;
	} // post types to ignore.
	$args                = array( 'post_type' => $post_type, 'posts_per_page' => - 1 );
	$args['post_status'] = array( 'publish', 'private', 'inherit' );
	// if ( $post_type == 'attachment' ) {
		// continue;
	// }
	$post_datas = get_posts( $args );
	if ( ! isset( $default_content[ $post_type ] ) ) {
		$default_content[ $post_type ] = array();
	}
	$object = get_post_type_object( $post_type );
	if ( $object && ! empty( $object->labels->singular_name ) ) {
		$type_title = $object->labels->name;
	} else {
		$type_title = ucwords( $post_type ) . 's';
	}

	foreach ( $post_datas as $post_data ) {
		$meta = get_post_meta( $post_data->ID, '', true );
		if ( $post_data->ID == 65 ) {
//			print_r($meta); exit;
		}

		foreach ( $meta as $meta_key => $meta_val ) {
			// if (
				// // which keys to nuke all the time
				// in_array( $meta_key, array( '_location_id' ) )
				// ||
				// (
					// // which keys we want to keep all the time, using strpos:
					// strpos( $meta_key, 'elementor' ) === false &&
					// strpos( $meta_key, 'dtbaker' ) === false &&
					// strpos( $meta_key, 'vc_' ) === false &&
					// strpos( $meta_key, 'wpb_' ) === false &&
					// strpos( $meta_key, 'dtbwp_' ) === false &&
					// strpos( $meta_key, 'dahz_' ) === false &&
					// strpos( $meta_key, 'portfolio' ) === false &&
					// strpos( $meta_key, '_slider' ) === false &&
					// // which post types we keep all meta values for:
					// ! in_array( $post_type, array(
						// 'nav_menu_item',
						// 'location',
						// 'event',
						// 'product',
						// 'wpcf7_contact_form',
					// ) ) &&
					// // other meta keys we always want to keep:
					// ! in_array( $meta_key, array(
						// 'dtbwp_post_title_details',
						// 'dtbwp_page_style',
						// 'sliderlink',
						// 'slidercolor',
						// '_wp_attached_file',
						// '_thumbnail_id',
					// ) )
				// )
			// ) {
				// unset( $meta[ $meta_key ] );
			// } else {
				$meta[ $meta_key ] = maybe_unserialize( get_post_meta( $post_data->ID, $meta_key, true ) );
			//}
		}
		if ( $post_data->ID == 2 ) {
			//print_r($meta);
		}
		// copy stock images into the images/stock/ folder for theme import.
		if ( $post_type == 'attachment' ) {
			$file = get_attached_file( $post_data->ID );
			if ( is_file( $file ) ) {
				if ( filesize( $file ) > 1500000 ) {
					$image = wp_get_image_editor( $file );
					if ( ! is_wp_error( $image ) ) {
						list( $width, $height, $type, $attr ) = getimagesize( $file );
						$image->resize( min( $width, 1200 ), null, false );
						$image->save( $file );
					}
				}
				$post_data->guid = wp_get_attachment_url( $post_data->ID );
				if ( is_dir( get_template_directory() . '/dahz-framework/admin/envato_setup/content/images/' ) ) {
					copy( $file, get_template_directory() . '/dahz-framework/admin/envato_setup/content/images/' . basename( $file ) );
				}
			}
			// fix for incorrect GUID when renaming files with the rename plugin, causes import to bust.

		}
		$terms = array();
		foreach ( $taxonomies as $taxonomy ) {
			$terms[ $taxonomy ] = wp_get_post_terms( $post_data->ID, $taxonomy, array( 'fields' => 'all' ) );
			if($terms[$taxonomy]){
				foreach($terms[$taxonomy] as $tax_id => $tax){
					if(!empty($tax->term_id)) {
						$terms[ $taxonomy ][ $tax_id ] -> meta = get_term_meta( $tax->term_id );
						if(!empty($terms[ $taxonomy ][ $tax_id ] -> meta)){
							foreach($terms[ $taxonomy ][ $tax_id ] -> meta as $key=>$val){
								if(is_array($val) && count($val) == 1 && isset($val[0])){
									$terms[ $taxonomy ][ $tax_id ] -> meta[$key] = $val[0];
								}
							}
						}
					}
				}
			}
		}
		$default_content[ $post_type ][] = array(
			'type_title'     => $type_title,
			'post_id'        => $post_data->ID,
			'post_title'     => $post_data->post_title,
			'post_status'    => $post_data->post_status,
			'post_name'      => $post_data->post_name,
			'post_content'   => $post_data->post_content,
			'post_excerpt'   => $post_data->post_excerpt,
			'post_parent'    => $post_data->post_parent,
			'menu_order'     => $post_data->menu_order,
			'post_date'      => $post_data->post_date,
			'post_date_gmt'  => $post_data->post_date_gmt,
			'guid'           => $post_data->guid,
			'post_mime_type' => $post_data->post_mime_type,
			'meta'           => $meta,
			'terms'          => $terms,
			//                          'other' => $post_data,
		);
	}
}
// put certain content at very end.
$nav = isset( $default_content['nav_menu_item'] ) ? $default_content['nav_menu_item'] : array();
if ( $nav ) {
	unset( $default_content['nav_menu_item'] );
	$default_content['nav_menu_item'] = $nav;
}
//              print_r($default_content);
//              exit;
// find the ID of our menu names so we can import them into default menu locations and also the widget positions below.
$menus    = get_terms( 'nav_menu' );
$menu_ids = array();
foreach ( $menus as $menu ) {
	if ( $menu->name == 'Primary Menu' ) {
		$menu_ids['primary_menu'] = $menu->term_id;
	} else if ( $menu->name == 'Woocommerce Account' ) {
		$menu_ids['woocommerce_account'] = $menu->term_id;
	} else if ( $menu->name == 'Footer Menu' ) {
		$menu_ids['footer_menu'] = $menu->term_id;
	} else if ( $menu->name == 'Secondary Menu' ) {
		$menu_ids['secondary_menu'] = $menu->term_id;
	}
}
// used for me to export my widget settings.
$widget_positions = get_option( 'sidebars_widgets' );
$widget_options   = array();
$my_options       = array();
$dahz_options	  = array(
	'woocommerce_setting'	=> array(
		'shop_catalog_image_size'	=> get_option( 'shop_catalog_image_size' ),
		'shop_single_image_size'	=> get_option( 'shop_single_image_size' ),
		'shop_thumbnail_image_size'	=> get_option( 'shop_thumbnail_image_size' ),
	)
);
foreach ( $widget_positions as $sidebar_name => $widgets ) {
	if ( is_array( $widgets ) ) {
		foreach ( $widgets as $widget_name ) {
			$widget_name_strip                    = preg_replace( '#-\d+$#', '', $widget_name );
			$widget_options[ $widget_name_strip ] = get_option( 'widget_' . $widget_name_strip );
		}
	}
}
// choose which custom options to load into defaults
$all_options = wp_load_alloptions();
//print_r($all_options);exit;
foreach ( $all_options as $name => $value ) {
	if ( stristr( $name, 'elementor' ) ) {
		$my_options[ $name ] = maybe_unserialize( $value );
	}
	if ( stristr( $name, '_widget_area_manager' ) ) {
		$my_options[ $name ] = $value;
	}
	if ( stristr( $name, 'wam_' ) ) {
		$my_options[ $name ] = $value;
	}
	//if ( stristr( $name, 'dbem_' ) !== false ) { $my_options[ $name ] = $value; }
	//                  if ( stristr( $name, 'woo' ) !== false ) { $my_options[ $name ] = $value; }
	if ( stristr( $name, 'dtbaker_featured_images' ) !== false ) {
		$my_options[ $name ] = $value;
	}
	if ( $name === 'dahz_framework_term_swatches' ) {
		$dahz_options[ 'term_swatches' ] = maybe_unserialize( $value );
	}

	if ( stristr( $name, 'dahz_framework_taxonomy_' ) !== false ) {
		if( !isset( $dahz_options[ 'term_meta' ] ) ){
			$dahz_options[ 'term_meta' ] = array();
		}
		$dahz_options[ 'term_meta' ][ $name ] = maybe_unserialize( $value );
	}
	if ( 'theme_mods_diacara' === $name ) {
		$my_options[ $name ] = maybe_unserialize( $value );
		$my_options[ $name . '-child' ] = maybe_unserialize( $value );
		unset( $my_options[ $name ]['nav_menu_locations'] );
	}
}
$my_options['dbem_credits']                        = 0;
$my_options['woocommerce_cart_redirect_after_add'] = 'yes';
$my_options['woocommerce_enable_ajax_add_to_cart'] = 'no';
//$my_options['travel_settings']                   = array( 'api_key' => 'AIzaSyBsnYWO4SSibatp0SjsU9D2aZ6urI-_cJ8' );
//$my_options['tt-font-google-api-key']            = 'AIzaSyBsnYWO4SSibatp0SjsU9D2aZ6urI-_cJ8';
$my_options                                        = $this->filter_options( $my_options );

$dir = get_template_directory() . '/dahz-framework/admin/envato_setup/content/';

if ( is_dir( $dir ) ) {

	// which style are we writing to?
    // $stylefolder = basename(get_theme_mod('dtbwp_site_style',$this->get_default_theme_style()));
    // if($stylefolder){
	    // $dir .= $stylefolder .'/';
    // }

	file_put_contents( $dir . 'default.json' , json_encode( $default_content ) );
	file_put_contents( $dir . 'widget_positions.json' , json_encode( $widget_positions ) );
	file_put_contents( $dir . 'widget_options.json' , json_encode( $widget_options ) );
	file_put_contents( $dir . 'menu.json' , json_encode( $menu_ids ) );
	file_put_contents( $dir . 'options.json' , json_encode( $my_options ) );
	file_put_contents( $dir . 'dahz-options.json' , json_encode( $dahz_options ) );
}
/*
	dahz_framework_term_swatches, 
	"dahz_framework_taxonomy_{$taxonomy}"
	"dahz_framework_init_setup_{$template_stylesheet}"
*/
?>
	<h1>Export Done:</h1>
	<p>Export content has been placed into /theme/plugins/envato_setup/content/*.json files</p>
	<p>Stock images have been copied into /theme/images/stock/ for faster theme install.</p>
