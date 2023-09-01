<?php

if( !function_exists( 'dahz_framework_set_customize_options' ) ){

	function dahz_framework_set_customize_options( $property = null, $object_id = null ){

		global $dahz_framework;

		if( is_customize_preview() ){

			global $dahz_framework_customizer;

			if( !empty( $dahz_framework_customizer->settings ) ){

				foreach( $dahz_framework_customizer->settings as $property ){

					$object = ( object ) array();

					foreach( $property['default'] as $key => $default ){

						$object->{$key} = isset( $dahz_framework->mods[$property['id'].'_'.$key] ) ? $dahz_framework->mods[$property['id'].'_'.$key] : $default;

					}

					$dahz_framework->module->{$property['id']} = $object;

				}

			}

		} else {

			if( !empty( $property ) ){

				$object = ( object ) array();

				foreach( $property as $key => $default ){

					$object->{$key} = isset( $dahz_framework->mods[$object_id.'_'.$key] ) ? $dahz_framework->mods[$object_id.'_'.$key] : $default;

				}

				$dahz_framework->module->{$object_id} = $object;

			}

		}

	}

}

if( !function_exists( 'dahz_framework_register_customizer' ) ){

	function dahz_framework_register_customizer( $class, $options = null, $default = array() ){

		$default_options = array( 'id' => null, 'title' => '', 'panel' => '', 'is_extend' => false  );

		if( is_array( $options ) ){

			$options = array_merge( $default_options, $options );

		} else {

			$default_options['id'] = $options;

			$options = $default_options;

		}
		if( !empty( $options ) ){

			if( is_customize_preview() ){

				global $dahz_framework_customizer;

				$customizer = new $class();

				$customizer->dahz_framework_customizer_init( $options['id'], $options['title'], $options['panel'], $options['is_extend'] );

				if( !empty( $default ) && is_array( $default ) ){

					$dahz_framework_customizer->settings[] = array( 'id' => $options['id'], 'default' => $default );

				}

			}

			if( ( !is_admin() || defined( 'DOING_AJAX' ) ) && !is_customize_preview() ){

				if( !empty( $default ) && is_array( $default ) ){

					dahz_framework_set_customize_options( $default, $options['id'] );

				}

			}

		}

	}

}

if( !function_exists( 'dahz_framework_get_builder_items' ) ){

	function dahz_framework_get_builder_items( $builder_type ){

		return apply_filters( "dahz_framework_customize_{$builder_type}_builder_items", array() );

	}

}

if( !function_exists( 'dahz_framework_customize_render_builder_items' ) ){

	function dahz_framework_customize_render_builder_items( $builder_type ){

		$builder_items = dahz_framework_get_builder_items( $builder_type );

		foreach( $builder_items as $item_id => $item ){

			dahz_framework_customize_render_builder_item(
				$builder_type,
				$item_id,
				!empty( $item['title'] ) ? $item['title']  : "",
				!empty( $item['description'] ) ? $item['description']  : "",
				!empty( $item['section_callback'] ) ? $item['section_callback'] : ""
			);

		}

	}

}

if( !function_exists( 'dahz_framework_customize_render_builder_item' ) ){

	function dahz_framework_customize_render_builder_item( $builder_type, $item_id, $title, $description, $section_callback ){
	?>
		<span data-item="<?php echo esc_attr( $item_id );?>" data-section="<?php echo esc_attr( $section_callback );?>" class="de-<?php echo esc_attr( $builder_type );?>-items de-custom-<?php echo esc_attr( $builder_type );?>__element-item" >
			<span class="de-custom-<?php echo esc_attr( $builder_type );?>__element-name"><?php printf( esc_html__( '%s', 'kitring' ), $title ) ; ?></span>
			<span class="de-custom-<?php echo esc_attr( $builder_type );?>__element-description"><?php printf( esc_html( '%s', 'kitring' ), $description ); ?></span>
		</span>

	<?php
	}

}

if( !function_exists( 'dahz_framework_render_builder_items' ) ){

	function dahz_framework_render_builder_items( $available_items, $content, $builder_type = null, $section = null, $row = null, $column = null ){

		$args = '';

		$item = is_array( $content ) ? $content['value'] : $content;

		if( isset( $available_items[$item]['render_callback'] ) ){

			$args = $available_items[$item]['render_callback'];

		}


		return dahz_framework_get_buffer_html( $args, $builder_type, $section, $row, $column );

	}

}

if( !function_exists( 'dahz_framework_get_template_part' ) ){

	function dahz_framework_get_template_part( $slug, $name = '' ){

		global $dahz_framework;

		$dahz_template = '';

		if ( $name ) {
			$dahz_template = locate_template( array( "{$slug}-{$name}.php", $dahz_framework->template_path . "{$slug}-{$name}.php" ) );
		}

		if( $name && !$dahz_template && file_exists( $dahz_framework->core_template_path . "{$slug}-{$name}.php" ) ){
			$dahz_template = $dahz_framework->core_template_path . "{$slug}-{$name}.php";
		}

		if ( !$dahz_template ) {
			$dahz_template = locate_template( array( "{$slug}.php", $dahz_framework->template_path . "{$slug}.php" ) );
		}

		$dahz_template = apply_filters( 'dahz_framework_get_template_part', $dahz_template, $slug, $name );

		if ( $dahz_template ) {
			load_template( $dahz_template, false );
		}

	}

}

if( !function_exists( 'dahz_framework_locate_template' ) ){

	function dahz_framework_locate_template( $template, $template_path = '', $default_path = '' ){

		global $dahz_framework;

		$dahz_locate_template = '';

		if( empty( $template_path ) ){
			$template_path = $dahz_framework->template_path;
		}

		if( empty( $default_path ) ){
			$default_path = $dahz_framework->core_template_path;
		}
		$dahz_locate_template = locate_template( array( trailingslashit( $template_path ) . $template, $template ) );

		if( !$dahz_locate_template ){
			$dahz_locate_template = $default_path . $template_path . $template;
		}

		return apply_filters( 'dahz_framework_locate_template', $dahz_locate_template, $template, $template_path, $default_path );

	}

}

if( !function_exists( 'dahz_framework_get_template' ) ){

	function dahz_framework_get_template( $template, $params = array(), $template_path = '', $default_path = '' ){

		$dahz_template = dahz_framework_locate_template( $template, $template_path, $default_path );

		if( file_exists( $dahz_template ) ){

			do_action( 'dahz_framework_before_get_template', $dahz_template, $params, $template_path, $default_path );

			dahz_framework_include( $dahz_template, $params );

			do_action( 'dahz_framework_after_get_template', $dahz_template, $params, $template_path, $default_path );

		}

	}

}

if( !function_exists( 'dahz_framework_get_template_html' ) ){

	function dahz_framework_get_template_html( $template, $params = array(), $template_path = '', $default_path = '' ){

		ob_start();
		dahz_framework_get_template( $template, $params, $template_path, $default_path );
		return ob_get_clean();

	}

}

if( !function_exists( 'dahz_framework_get_buffer_html' ) ){

	function dahz_framework_get_buffer_html( $function, $builder_type, $section, $row, $column ){
		
		$html = '';
		try{
			ob_start();
				if( 
					(
						!empty( $function ) && 
						is_array( $function ) && 
						isset( $function[0] ) && 
						isset( $function[1] ) && 
						method_exists( $function[0], $function[1] ) 
					) ||
					(
						!empty( $function ) && 
						is_string( $function ) && 
						function_exists( $function ) 
					)
				){
					call_user_func( $function, $builder_type, $section, $row, $column );
				}
				$html = ob_get_contents();
			ob_end_clean();
			return $html;
		}
		catch( Exception $err){
			print_r($function);
			return $html;
		}

	}

}

if( !function_exists( 'dahz_framework_categorized_blog' ) ){

	function dahz_framework_categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'dahz_categories' ) ) ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories( array(
				'fields'     => 'ids',
				'hide_empty' => 1,
				// We only need to know if there is more than one category.
				'number'     => 2,
			) );

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'dahz_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so egikasep_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so egikasep_categorized_blog should return false.
			return false;
		}
	}

}

if( !function_exists( 'dahz_framework_get_content_block') ){

	function dahz_framework_get_content_block( $inherit = false ){

		global $post;

		if( !class_exists('DahzExtender_Content_Blocks') ) return array( '' => esc_html__( 'empty', 'kitring' ) );

		$args = array( 
			'post_type' 	=> 'content-block',
			'posts_per_page'=> -1
		
		);

		$content_blocks = get_posts( $args );
		
		if( $inherit ){
			
			$content = array(
				'inherit'	=> esc_html__( 'Inherit', 'kitring' ),
				''			=> 	esc_html__('Disable', 'kitring' )
			);

		} else {
			
			$content = array(
				''	=> 	esc_html__('Disable', 'kitring' )
			);
			
		}

		if( !empty( $content_blocks ) && is_array( $content_blocks ) ){

			foreach( $content_blocks as $content_block ){
				
				$slug = $content_block->post_name;
				
				$content[$slug] = $content_block->post_title;
				
			}

		}
		wp_reset_postdata();

		return $content;
		
	}

}

if( !function_exists( 'dahz_framework_get_portfolio') ){

	function dahz_framework_get_portfolio(){

		$args =  array(
			'post_type' 	=> 'page',
			'meta_key' 		=> '_wp_page_template',
			'meta_value' 	=> 'portfolio-page.php',
			'post_status' 	=> 'publish',
		);

		$the_query = new WP_Query( $args );

		$content = array();

		if( $the_query->have_posts() ) :

			while ( $the_query->have_posts() ) : $the_query->the_post();

			$content[get_the_title()] = get_the_title();

			endwhile;

		endif;
		
		wp_reset_postdata();

		return $content;
	}

}

if( !function_exists( 'dahz_framework_get_builder_presets_option') ){

	function dahz_framework_get_builder_presets_option( $builder_type, $is_default = false ){

		$customize_builder_presets = array();
		
		$customize_builder_presets[''] = esc_html__( 'Inherit', 'kitring' );
		
		if( $builder_type == 'footer' ){
			
			$customize_builder_presets['disable'] = esc_html__( 'Disable Footer', 'kitring' );
			
		}
		
		$customize_presets = array();

		if( ! $is_default ){

			$customize_presets = dahz_framework_get_presets( 'saved', $builder_type );

		} else {

			$presets = $builder_type == 'headermobile' ? 'header_mobile' : $builder_type;
			$customize_presets = dahz_framework_get_presets( 'default', $builder_type );
			$customize_presets = isset( $customize_presets["{$presets}_presets"] ) ? $customize_presets["{$presets}_presets"] : array();

		}
		if( !empty( $customize_presets ) ){
			
			foreach( $customize_presets as $id => $value ){
				
				$customize_builder_presets[$id] = __( "Preset", 'kitring' ) . " : $id";
				
			}
			
		}

		return $customize_builder_presets;
	}

}

if( !function_exists( 'dahz_framework_get_all_menu') ){

	function dahz_framework_get_all_menu(){

		$menu_obj = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
		
		$menus_array = array( '' => 'Inherit');
		
		foreach( $menu_obj as $menu_items => $menu_name ){

			$menus_array[$menu_name->slug] = $menu_name->name;

		}

		return $menus_array;

	}

}

if( !function_exists( 'dahz_framework_get_portfolio_category') ){

	function dahz_framework_get_portfolio_category(){

		$cat_obj = get_terms(
			array(
				'taxonomy'	 => 'portfolio_categories',
				'hide_empty' => false,
			)
		);
		$cat_array = array();

		foreach( $cat_obj as $cat_items => $cat_name ){
			if( is_object($cat_name) )
				$cat_array[$cat_name->slug] = $cat_name->name;

		}

		return $cat_array;

	}

}

if( !function_exists( 'dahz_framework_debug') ){
	
	function dahz_framework_debug( $dv_value, $dv_bgcolor = '#666', $dv_fontcolor='#fff', $dv_height = '450' ){
		
		$dv_height = ( $dv_height == '' ) ? '450' : $dv_height;
		
		$dv_output = '<pre style="font-size:13px; height:'.$dv_height.'px; overflow:scroll-y; background: '.$dv_bgcolor.'; color: '.$dv_fontcolor.';">';
		
		$dv_output .= '<p> memory usage : '. dahz_framework_convert_memory( dahz_framework_get_memory_usage() ) .'</p>';
		
		$dv_output .= print_r( $dv_value, true );
		
		$dv_output .= '</pre>';
		
		printf( "%s", $dv_output );
	
	}
	
}

if( !function_exists( 'dahz_framework_get_memory_usage') ){
	
	function dahz_framework_get_memory_usage( ){
		
		return memory_get_usage();
	
	}
	
}

if( !function_exists( 'dahz_framework_convert_memory') ){

	function dahz_framework_convert_memory( $size ){
		
		$unit = array('b','kb','mb','gb','tb','pb');
		
		return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];

	}

}

if( !function_exists( 'dahz_framework_get_default_presets') ){
	
	function dahz_framework_get_default_presets( $builder_type ){

		global $dahz_framework_presets;

		$default_presets = array();

		$preset_type = $builder_type == 'headermobile' ? 'header' : $builder_type;

		if( !is_array( $dahz_framework_presets ) ){
			$dahz_framework_presets = array();
		}

		if( !isset( $dahz_framework_presets['default'] ) || !is_array( $dahz_framework_presets['default'] ) ){
			$dahz_framework_presets['default'] = array();
		}

		if( !isset( $dahz_framework_presets['default'][$builder_type] ) ){

			$text = dahz_framework_return_include( DAHZ_FRAMEWORK_PATH ."admin/customizer/presets/data-dahz-{$preset_type}-presets-default.php" );

			$dahz_framework_presets['default'][$builder_type] = maybe_unserialize( $text );

		}

		return $dahz_framework_presets['default'][$builder_type];

	}
	
}

if( !function_exists( 'dahz_framework_get_presets') ){
	
	function dahz_framework_get_presets( $preset_option, $builder_type ){

		global $dahz_framework_presets;

		$preset_type = $preset_option == 'default' && $builder_type == 'headermobile' ? 'header' : $builder_type;

		if( !is_array( $dahz_framework_presets ) ){
			$dahz_framework_presets = array();
		}

		if( !isset( $dahz_framework_presets[$preset_option] ) || !is_array( $dahz_framework_presets[$preset_option] ) ){
			$dahz_framework_presets[$preset_option] = array();
		}

		if( !isset( $dahz_framework_presets[$preset_option][$preset_type] ) ){

			switch( $preset_option ){

				case 'default':

					$text = dahz_framework_return_include( get_template_directory() ."/assets/presets/{$preset_type}-preset/data-dahz-{$preset_type}-presets-default.php" );

					$dahz_framework_presets[$preset_option][$preset_type] = maybe_unserialize( $text );

					break;
				case 'saved':
					$dahz_framework_presets[$preset_option][$preset_type] = get_option( "dahz_customize_{$preset_type}_builder_presets" );
					break;

			}

		}

		return $dahz_framework_presets[$preset_option][$preset_type];

	}
	
}

if( !function_exists( 'dahz_framework_get_preset') ){
	
	function dahz_framework_get_preset( $preset_option, $builder_type, $preset_name ){

		$preset = array();

		switch( $preset_option ){

			case 'default':

				$preset_type = $builder_type == 'headermobile' ? 'header_mobile' : $builder_type;

				$presets = dahz_framework_get_presets( 'default', $builder_type );

				$preset = isset( $presets["{$preset_type}_presets"][$preset_name]['preset_value'] ) ? $presets["{$preset_type}_presets"][$preset_name]['preset_value'] : array();

				break;

			case 'saved':

				$preset = get_option( "dahz_customize_{$builder_type}_builder_preset_{$preset_name}" );

				break;

		}

		return $preset;

	}
	
}

if( !function_exists( 'dahz_framework_render_default_presets') ){
	
	function dahz_framework_render_default_presets( $builder_type ){

		$presets = $builder_type == 'headermobile' ? 'header_mobile' : $builder_type;

		$default_presets = dahz_framework_get_presets( 'default', $builder_type );

		echo dahz_framework_default_preset_item( !empty( $default_presets["{$presets}_presets"] ) ? $default_presets["{$presets}_presets"] : array(), $builder_type );

	}
	
}

if( !function_exists( 'dahz_framework_default_preset_item') ){
	
	function dahz_framework_default_preset_item( $presets, $builder_type ){

		$preset = '';

		$preset_value = array();

		$preset_category = '';

		$current_preset_category = array();

		$preset .= sprintf( '<div class="de-custom-%1$s__preset-item-wrapper">', esc_attr( $builder_type ) );

		if( !empty( $presets ) && is_array( $presets ) ){

			foreach( $presets as $name => $value ){

				if( !in_array( $value['preset_category_id'], $current_preset_category ) ){

					$preset_category .= sprintf(
						'<li data-show="%1$s">%2$s</li>',
						esc_attr( $value['preset_category_id'] ),
						sprintf( __( '%1$s', 'kitring' ), $value['preset_category_name'] )
					);

					$current_preset_category[] = $value['preset_category_id'];

				}

				$preset_value = $value['preset_value'];

				$preset .= sprintf(
					'<div class="de-custom-%1$s__preset-item" data-item="%4$s" data-preset-value="%3$s" data-preset-name="%2$s">
						<div class="de-custom-%1$s__preset-item-placeholder">
							<img src="%5$s" alt="%8$s">
							<p>%7$s</p>
							<div class="de-custom-%1$s__preset-item-state">
								<p>Default %1$s</p>
							</div>
							<div class="de-custom-%1$s__preset-item-action">
								<a class="de-custom-%1$s__preset-item-set-template">
									<span>
										<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490.1 490.1" style="enable-background:new 0 0 490.1 490.1;" xml:space="preserve">
											<g>
												<path d="M490.05,404.8V85.2c0-47-38.2-85.2-85.2-85.2c-9.5,0-17.2,7.7-17.2,17.1c0,9.5,7.7,17.2,17.2,17.2
													c28,0,50.9,22.8,50.9,50.9v319.7c0,28.1-22.8,50.9-50.9,50.9H85.25c-28.1,0-50.9-22.8-50.9-50.9V85.2c0-28.1,22.8-50.9,50.9-50.9
													h0.5c9.5,0,16.9-7.7,16.9-17.2S94.75,0,85.25,0c-47,0-85.2,38.2-85.2,85.2v319.7c0,47,38.2,85.2,85.2,85.2h319.7
													C451.85,490,490.05,451.8,490.05,404.8z"/>
												<path d="M165.95,397.4c6.9,0,13.6-2.6,18.9-7.3l59.4-53.5l59.4,53.5c5.2,4.7,11.9,7.3,18.9,7.3c15.6,0,28.3-12.7,28.3-28.3v-352
													c0-9.5-7.7-17.1-17.1-17.1h-179c-9.5,0-17.2,7.7-17.2,17.1v352C137.55,384.7,150.35,397.4,165.95,397.4z M171.85,34.3h144.5
													v321.3l-53.3-48.1c-5.2-4.7-11.9-7.3-18.9-7.3s-13.7,2.6-18.9,7.3l-53.3,48.1V34.3H171.85z"/>
											</g>
										</svg>
									</span>
									Set Template
								</a>
							</div>
						</div>
					</div>',
					esc_attr( $builder_type ),
					esc_html( $name ),
					esc_attr( htmlspecialchars( json_encode( $preset_value, true ) ) ),
					esc_attr( $value['preset_category_id'] ),
					esc_url( get_template_directory_uri() . '/assets/images/' . $value['preset_image'] ),
					esc_attr( $value['preset_category_name'] ),
					esc_html( $value['preset_title'] ),
					esc_attr( $value['preset_title'] )
				);

			}

		}

		$preset .= '</div>';

		$preset .= sprintf(
			'
			<ul class="de-custom-%1$s__preset-filter">
				<li data-show="all">%2$s</li>
				%4$s
				<li data-show="saved">%3$s</li>
			</ul>
			',
			esc_attr( $builder_type ),
			esc_html__( 'All', 'kitring' ),
			esc_html__( 'Saved Preset', 'kitring' ),
			$preset_category
		);

		return $preset;

	}
	
}

if( !function_exists( 'dahz_framework_filesystem_init' ) ){

	function dahz_framework_filesystem_init() {
		$access_type = get_filesystem_method();
		if($access_type === 'direct')
		{
			/* you can safely run request_filesystem_credentials() without any issues and don't need to worry about passing in a URL */
			$creds = request_filesystem_credentials(site_url() . '/wp-admin/', '', false, false, array());

			/* initialize the API */
			if ( ! WP_Filesystem($creds) ) {
				/* any problems and we exit */
				return false;
			}

			global $wp_filesystem;
			return true;
		}
		else
		{
			return false;
		}
	}

}

if( !function_exists( 'dahz_framework_override_theme_mods' ) ){

	function dahz_framework_override_theme_mods( $mods ) {

		global $dahz_framework;

		foreach( $mods as $mod_id => $mod ){

			$dahz_framework->mods[$mod_id] = $mod === 'false' ? false : $mod;

		}

	}

}

if( !function_exists( 'dahz_framework_override_static_option' ) ){

	function dahz_framework_override_static_option( $mods ) {

		global $dahz_framework;

		foreach( $mods as $mod_id => $mod ){

			$dahz_framework->static_options[$mod_id] = $mod;

		}

	}

}

if( !function_exists( 'dahz_framework_get_option' ) ){

	function dahz_framework_get_option( $option_id, $default = "" ) {

		global $dahz_framework;

		return !isset( $dahz_framework->mods[$option_id] ) ? $default !== '' ? $default : null : $dahz_framework->mods[$option_id] ;

	}

}

if( !function_exists( 'dahz_framework_get_static_option' ) ){

	function dahz_framework_get_static_option( $option_id, $default = "" ) {

		global $dahz_framework;

		return !isset( $dahz_framework->static_options[$option_id] ) ? $default !== '' ? $default : null : $dahz_framework->static_options[$option_id] ;

	}

}

if( !function_exists( 'dahz_framework_get_meta' ) ){

	function dahz_framework_get_meta( $id, $meta_name, $meta_key, $default = '' ) {

		global $dahz_framework;

		if( !isset( $dahz_framework->meta ) ){

			$dahz_framework->meta = array();

		}

		if( !isset( $dahz_framework->meta[$id] ) ){

			$dahz_framework->meta[$id] = array();

		}

		if( !isset( $dahz_framework->meta[$id][$meta_name] ) ){

			$dahz_framework->meta[$id][$meta_name] = get_post_meta( $id, $meta_name, true );

		}

		return !isset( $dahz_framework->meta[$id][$meta_name][$meta_key] ) ? $default !== '' ? $default : null : $dahz_framework->meta[$id][$meta_name][$meta_key] ;

	}

}

if( !function_exists( 'dahz_framework_get_term_meta' ) ){

	function dahz_framework_get_term_meta( $taxonomy, $term_id, $meta_key, $default = '' ) {

		global $dahz_framework;

		if( !isset( $dahz_framework->term_meta ) ){

			$dahz_framework->term_meta = array();

		}

		if( !isset( $dahz_framework->term_meta[$taxonomy] ) ){

			$dahz_framework->term_meta[$taxonomy] = get_option( "dahz_framework_taxonomy_{$taxonomy}" );

		}

		return !isset( $dahz_framework->term_meta[$taxonomy][$term_id][$meta_key] ) ? $default !== '' ? $default : null : $dahz_framework->term_meta[$taxonomy][$term_id][$meta_key] ;

	}

}

if( !function_exists( 'dahz_framework_create_hook_documentation' ) ){
	
	function dahz_framework_create_hook_documentation(){
		global $wp_filter;
		echo '<table border="1">';
		echo '<h1 align="center">Dahz Action Hook</h1>';
		echo '
			<thead>
				<tr>
					<th rowspan="2">No.</th>
					<th rowspan="2">Action Name</th>
					<th colspan="5" valign="center">Function Hooked</th>
					<th rowspan="2">Description</th>
				</tr>
				<tr>
					<th>type</th>
					<th>Class Name</th>
					<th>Function Name</th>
					<th>File</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
		';

		$i = 1 ;
		foreach( $wp_filter as $action => $value ){
			if ( !strstr( $action, 'dahz_' ) ) continue;
			
			$callbacks = isset( $value->callbacks[10] ) ? $value->callbacks[10] : array();
			$details = '';
			$j = 1;
			foreach( $callbacks as $function => $functions  ){
				$details .= '<tr>';
				if( is_array( $functions['function'] ) ){
					$reflFunc = new ReflectionClass(get_class($functions['function'][0]));
					$details .= '<td>OOP</td>';
					$details .= "<td>" . get_class($functions['function'][0]) . '</td>';
					$details .= "<td>" . $functions['function'][1] . '</td>';
					$details .= "<td>" . $reflFunc->getMethod($functions['function'][1])->getFileName() . ' : ' . $reflFunc->getMethod($functions['function'][1])->getStartLine() . '</td>';
				} else {
					$reflFunc = new ReflectionFunction($functions['function']);
					$details .= '<td>Procedural</td>';
					$details .= "<td> - </td>";
					$details .= "<td>" . $functions['function'] . '</td>';
					$details .= "<td>" . $reflFunc->getFileName() . ' : ' . $reflFunc->getStartLine() . '</td>';
				}
				$details .= "<td></td></tr>";
				$j++;
			}
			
			echo sprintf( '<tr>
			<td rowspan="%4$s">%1$s</td>
			<td rowspan="%4$s">%2$s</td>
			<td colspan="5"></td>
			<td rowspan="%4$s"> --- </td>
			</tr>
			%3$s
			',
			$i,
			$action,
			$details,
			$j
			);
			
			$i++;
		}

		echo '</tbody>';
		echo '</table>';
	}
	
}

if( !function_exists( 'dahz_framework_get_metabox_repeater_values' ) ){
	
	function dahz_framework_get_metabox_repeater_values( $values ) {
		
		$url_decoded_values = urldecode( $values );
		
		$json_decoded_values = json_decode( $url_decoded_values, true );
		
		usort( $json_decoded_values, 'dahz_framework_sort_repeater_values' );
		
		return $json_decoded_values;
		
	}
	
}

if ( !function_exists( 'dahz_framework_sort_repeater_values' ) ) {

	function dahz_framework_sort_repeater_values( $a, $b ) {
					
		return isset( $a['priority'] ) && isset( $b['priority'] ) ? $a['priority'] > $b['priority'] : 0;

	}

}

if ( ! function_exists('dahz_framework_micro_data') ) {

	add_action( 'wp_head', 'dahz_framework_micro_data' );
	/**
	 *
	 */
	function dahz_framework_micro_data(){
		// Require Once file json to be regenerated on header
		foreach ( glob( get_template_directory() . "/dahz-framework/admin/json-ld/*.php" ) as $filename ) {
			require_once $filename;
		}
		?>
		<script type="application/ld+json"><?php echo json_encode($ldSinglePost); ?></script>
		<?php
	}

}

if( ! function_exists( 'dahz_framework_elements' ) ){
	
	function dahz_framework_elements(){
		
		return Dahz_Framework_Elements::dahz_framework_instance();
		
	}
	
}
