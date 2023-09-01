<?php
if( !class_exists( 'Dahz_Framework_Megamenu_Admin' ) ){
	
	class Dahz_Framework_Megamenu_Admin {
		
		public $filter_term_id = '';

		public function __construct(){
			
			add_action( 'wp_update_nav_menu_item', array( $this, 'dahz_framework_custom_update' ), 15, 3 );
			
			add_action( 'wp_ajax_nopriv_dahz_framework_autocomplete', array( $this, 'dahz_framework_autocomplete' ) );
			
			add_action( 'wp_ajax_dahz_framework_autocomplete', array( $this, 'dahz_framework_autocomplete' ) );
			
			add_action( 'wp_update_nav_menu', array($this, 'dahz_framework_update_menu_transient'), 10 );
			
		}
		
		public function dahz_framework_update_menu_transient( $menu_id ){
			
			$overrides_menu = get_option( 'dahz_framework_primary_menu_overrides', array() );
			
			$overrides_menu[] = '';
			
			foreach( $overrides_menu as $menu ){
				delete_transient( "dahz_framework_primary_menu_{$menu}_lazy" );
				delete_transient( "dahz_framework_primary_menu_mobile_{$menu}" );
				delete_transient( "dahz_framework_primary_menu_vertical_{$menu}" );
				delete_transient( "dahz_framework_primary_menu_{$menu}" );
			}
		}
				
		public function dahz_framework_autocomplete(){
		
			$output = '';
			$sss;
			switch($_POST['source']){
				
				case "product":
					$output = json_encode(
						dahz_framework_get_list_autocomplete(
							$_POST['keyword'],
							'product',
							explode( ',', $_POST['selected'] )
						)
					);
					break;
				case "post":
					$output = json_encode(
						dahz_framework_get_list_autocomplete(
							$_POST['keyword'],
							'post',
							explode( ',', $_POST['selected'] )
						)
					);
					break;
				case "portfolio":
					$output = json_encode(
						dahz_framework_get_list_autocomplete(
							$_POST['keyword'],
							'portfolio',
							explode( ',', $_POST['selected'] )
						)
					);
					break;
				case "product_category":
					
					$term_list = dahz_framework_search_terms( $_POST['keyword'], 'product_cat', $_POST['selected'] );
					
					$output = json_encode( $term_list );
					
					break;
				case "post_category":
					$term_list = dahz_framework_search_terms( $_POST['keyword'], 'category', $_POST['selected'] );
					$output = json_encode( $term_list );
					break;
				case "brand":
					$term_list = dahz_framework_search_terms( $_POST['keyword'], 'brand', $_POST['selected'] );
					$output = json_encode( $term_list );
					break;
					
			}
			
			printf( "%s", $output );
			
			die();
		}
		
		function dahz_framework_custom_update( $menu_id, $menu_item_db_id, $args ){
			
			$mega_menu = array();

			if( isset( $_POST['is_mega_menu'][$menu_item_db_id] ) ){
				$mega_menu['is_mega_menu'] = $_POST['is_mega_menu'][$menu_item_db_id];
			} else {
				$mega_menu['is_mega_menu'] = false ;
			}
			if( isset( $_POST['dropdown_width'][$menu_item_db_id] ) ){
				$mega_menu['dropdown_width'] = $_POST['dropdown_width'][$menu_item_db_id];
			} 
			if( isset( $_POST['dropdown_alignment'][$menu_item_db_id] ) ){
				$mega_menu['dropdown_alignment'] = $_POST['dropdown_alignment'][$menu_item_db_id];
			} 
			if( isset( $_POST['submenu_background_image'][$menu_item_db_id] ) ){
				$mega_menu['submenu_background_image'] = $_POST['submenu_background_image'][$menu_item_db_id];
			}
			if( isset( $_POST['background_repeat'][$menu_item_db_id] ) ){
				$mega_menu['background_repeat']=$_POST['background_repeat'][$menu_item_db_id];
			}
			if( isset( $_POST['background_position'][$menu_item_db_id] ) ){
				$mega_menu['background_position']=$_POST['background_position'][$menu_item_db_id];
			}
			if( isset( $_POST['background_size'][$menu_item_db_id] ) ){
				$mega_menu['background_size']= $_POST['background_size'][$menu_item_db_id];
			}
			if( isset( $_POST['submenu_text_align'][$menu_item_db_id] ) ){
				$mega_menu['submenu_text_align']= $_POST['submenu_text_align'][$menu_item_db_id];
			}
			if( isset( $_POST['image_replace_link'][$menu_item_db_id] ) ){
				$mega_menu['image_replace_link']= $_POST['image_replace_link'][$menu_item_db_id];
			}
			
			if( isset( $_POST['is_display_as_header'][$menu_item_db_id] ) ){
				$mega_menu['is_display_as_header']= $_POST['is_display_as_header'][$menu_item_db_id];
			} else {
				$mega_menu['is_display_as_header']=false ;
			}
			if( isset( $_POST['is_carousel'][$menu_item_db_id] ) ){
				$mega_menu['is_carousel'] = $_POST['is_carousel'][$menu_item_db_id];
			} else {
				$mega_menu['is_carousel'] = false ;
			}
			if( isset( $_POST['is_hide_title'][$menu_item_db_id] ) ){
				$mega_menu['is_hide_title'] = $_POST['is_hide_title'][$menu_item_db_id];
			} else {
				$mega_menu['is_hide_title'] = false ;
			}
			if( isset( $_POST['column_width'][$menu_item_db_id] ) ){
				$mega_menu['column_width'] = $_POST['column_width'][$menu_item_db_id];
			}
			if( isset( $_POST['source_carousel'][$menu_item_db_id] ) ){
				$mega_menu['source_carousel']= $_POST['source_carousel'][$menu_item_db_id];
			}
			if( isset( $_POST['column_carousel'][$menu_item_db_id] ) ){
				$mega_menu['column_carousel']= $_POST['column_carousel'][$menu_item_db_id];
			}
			if( isset( $_POST['carousel_content'][$menu_item_db_id] ) ){
				$mega_menu['carousel_content'] =$_POST['carousel_content'][$menu_item_db_id];
				
			}

			update_post_meta( $menu_item_db_id, 'mega_menu', $mega_menu );
			
		}

	}
	
	new Dahz_Framework_Megamenu_Admin();
	
}






