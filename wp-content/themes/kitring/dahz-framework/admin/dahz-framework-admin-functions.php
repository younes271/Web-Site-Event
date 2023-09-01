<?php 
if( !function_exists( 'dahz_framework_register_metabox' ) ){
	
	function dahz_framework_register_metabox( $id, $metabox_options ){
		
		global $dahz_framework;
		
		if( !is_object( $dahz_framework->metabox ) && !is_array( $metabox_options ) && empty( $metabox_options ) ) return;
		
		$dahz_framework->metabox->metaboxes[$id] = $metabox_options;
		
	}
	
}

if( !function_exists( 'dahz_framework_register_taxonomy_metabox' ) ){
	
	function dahz_framework_register_taxonomy_metabox( $taxonomy ){
		
		global $dahz_framework;
		
		if( !is_object( $dahz_framework->metabox ) && !is_array( $metabox_options ) && empty( $metabox_options ) ) return;

		$dahz_framework->metabox->taxonomy_metaboxes[$taxonomy] = $taxonomy;
		
	}
	
}

if( !function_exists( 'dahz_framework_get_query' ) ){

	function dahz_framework_get_query($atts = array()){
		
		$orderby = isset($atts['orderby']) && !empty($atts['orderby']) ? $atts['orderby'] : 'date';
		
		$order = isset($atts['order']) && !empty($atts['order']) ? $atts['order'] : 'DESC';
		
		$post_per_page = isset($atts['post_per_page']) && !empty($atts['post_per_page']) ? $atts['post_per_page'] : -1;
		
		$filter = isset($atts['filter']) && !empty($atts['filter']) ? $atts['filter'] : '';
		
		$taxonomy = isset($atts['taxonomy']) && !empty($atts['taxonomy']) ? $atts['taxonomy'] : false;
		
		$post__in = !empty($atts['post__in']) ? is_array($atts['post__in']) ? $atts['post__in'] : array() : array();
		
		$terms = !empty($atts['terms']) ? is_array($atts['terms']) ? $atts['terms'] : array() : array();
		
		$relation = !empty($atts['relation']) ? $atts['relation'] : 'or';
		
		$isSKU = !empty($atts['isSKU']) ? $atts['isSKU'] : false;
		
		$args = array();
		
		$args['orderby'] = $orderby;
		
		$args['order'] = $order;
		
		isset($atts['keyword']) && !empty($atts['keyword']) ? $args['s'] = $atts['keyword'] : false;
		
		$keyword = !empty($atts['keyword'])? $atts['keyword'] : "";
		
		if(!empty($filter)){
			
			$args['meta_query'] = array('relation' => $relation );
			
			switch($filter){
				
				case 'sale_products':
					$args['meta_query'] = WC()->query->get_meta_query();
					$args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
					break;
				case 'new_product':
					$args['meta_query'][] = array(
						'key' 		=> 'de_product_New',
						'value' 	=> 'on',
						'compare' 	=> '='
					);
					break;
				case 'featured_product':
					$args['meta_query'][] = array(
						'key' 		=> '_featured',
						'value' 	=> 'yes',
						'compare' 	=> '='
					);
					break;
				case 'top_rated':
					$args['meta_query'][] = array(
						'key' 		=> '_wc_average_rating',
						'value' 	=> 0,
						'compare' 	=> '>='
					);
					$args['meta_key'] = '_wc_average_rating';
					$args['orderby'] = 'meta_value_num';
					break;
				case 'best_sellers':
					$args['meta_key'] = 'total_sales';
					$args['orderby'] = 'meta_value_num';
					$args['meta_query'][] = array(
						 'key' 		=> '_visibility',
						 'value' 	=> array( 'catalog', 'visible' ),
						 'compare' 	=> 'IN'
					 );
					break;
				case 'latest_product':
					$args['meta_query'] = WC()->query->get_meta_query();
					break;
					
			}
			
		}
		
		if($taxonomy){
			if(!empty($terms[0])){
				$args['tax_query'] = array();
				$args['tax_query'][] = array(
					'taxonomy'	=> $taxonomy,
					'field'		=> 'term_id',
					'terms'		=> $terms,
					'operator' 	=> 'IN'
				);
				
			}
		}
		
		if(!empty($post__in)){
			if(is_array($post__in)){
				$args['post__in'] = $post__in;
			} else {
				$args['post'] = $post__in;
			}
		}
		if($isSKU){
			if(isset($args['s'])){
				unset($args['s']);
			}
			$args['meta_query'][] = array(
				'key' 		=> '_sku',
				'value' 	=> "{$keyword}",
				'compare' 	=> 'LIKE'
			);
		}
		$args['post_type'] = !empty($atts['post_type']) ? $atts['post_type'] : 'post';
		$args['post_status'] = 'publish';
		$args['ignore_sticky_posts'] = 1;
		$args['posts_per_page'] = $post_per_page;
		$query = new WP_Query( $args );
		return $query;
	}
	
}

if( !function_exists( 'dahz_framework_get_list_autocomplete' ) ){
	
	function dahz_framework_get_list_autocomplete( $keyword = '', $post_type = '', $selected = array() ) {
		
		$full_product_list = array();
		
		$is_selected = false;
		
		$loop_search = dahz_framework_get_query(
			array(
				'post_per_page'	=> 50,
				'keyword'		=> $keyword,
				'post_type'		=> $post_type
			)
		);
		
		if( is_array( $selected ) && !empty( $selected ) ){
			
			$loop_selected = dahz_framework_get_query(
				array(
					'post_type'	=> $post_type,
					'post__in'	=> $selected
				
				)
			);
			$loop = array();
		
			$loop = array_merge( $loop_search->posts, $loop_selected->posts );
			
			$loop_search = $loop;
			
			$is_selected = true;
			
		}
		
		$loop_items = $is_selected ? $loop_search : $loop_search->posts;

		foreach( $loop_items as $key => $product ){
			
			$full_product_list[] = array(
				'id'	=> "{$product->ID}",
				'text'	=> $product->post_title,
				'label'	=> $product->post_title,
				'val'	=> $product->ID
			);	
		
		}
		wp_reset_postdata();
		
		return $full_product_list;
		
	}
	
}
if( !function_exists( 'dahz_framework_search_terms' ) ){
	
	function dahz_framework_search_terms( $keyword, $taxonomy, $selecteds ){
			
		$term_list = array();
		
		$args = array(
			'taxonomy'      => $taxonomy, // taxonomy name
			'orderby'       => 'name', 
			'order'         => 'ASC',
			'hide_empty'    => false,
			'fields'        => 'all',
			'name__like'    => $keyword
		); 

		$terms = get_terms( $args );
		
		$terms_selected = array();
		
		foreach( explode( ',', $selecteds ) as $selected ){
			
			if( $selected !== '' ){
								
				if( empty( 
						array_filter( $terms, function ($term) use ($selected) {
							return $term->term_id == $selected;
						}) 
					) 
				){
					
					$get_term = get_term_by( 'id', $selected, $taxonomy );
			
					if( $get_term ){
						
						$terms_selected[] = $get_term;
						
					}
					
				}
				
			}
			
		}
		
		$terms = array_merge( $terms, $terms_selected );
		
		$count = count($terms);
		
		if( $count > 0 ){
			foreach ($terms as $term) {
				$term_list[] = array(
					'id'	=> "{$term->term_id}",
					'text'	=> $term->name,
					'label'	=> $term->name,
					'val'	=> $term->term_id
				);
			}
		}
		
		return $term_list;
		
	}
	
}

if( function_exists( 'dahz_framework_autocomplete2' ) ){
	
	function dahz_framework_autocomplete2(){
		
		$output = '';
		$sss;
		switch($_POST['source']){
			
			case "product":
			$output = json_encode(dahz_framework_get_list_autocomplete($_POST['keyword'],'product',explode(',',$_POST['selected'])));
				break;
			case "post":
			$output = json_encode(dahz_framework_get_list_autocomplete($_POST['keyword'],'post',explode(',',$_POST['selected'])));
				break;
			case "portfolio":
			$output = json_encode(dahz_framework_get_list_autocomplete($_POST['keyword'],'portfolio',explode(',',$_POST['selected'])));
				break;
				
		}
		
		printf( "%s", $output );
		
		die();
	}
	
}
