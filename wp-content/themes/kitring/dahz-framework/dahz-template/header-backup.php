if( !function_exists( 'dahz_framework_get_header' ) ){
	
	function dahz_framework_get_header(){
		?>
		<header id="masthead" class="site-header" role="banner">
			<div class="ds-header-wrapper de-header de-header--default">
			<?php
			
				$available_items = dahz_framework_get_builder_items( 'footer' );

				$footer_builder_element = get_theme_mod('footer_builder_element');

				$footer = json_decode($footer_builder_element,true);
				$row_element = '';

				$column_element = '';

				$item_elemen ='';

				if( !empty($footer) ){

					foreach( $footer as $section => $rows ){
						$row_element = '';
						if( !empty( $rows ) ){

							foreach( $rows as $row => $columns ){
								$column_element = '';
								if( !empty( $columns ) ){

									foreach( $columns['columns'] as $column => $items ){
										$item_elemen ='';
										if( !empty( $items ) ){

											foreach( $items['items'] as $item => $content ){

												$item_content = dahz_framework_render_builder_items( $available_items, $content );
										
												$item_elemen .= sprintf( "<div id='%s'>%s</div>", $item, $item_content );

											}

										}
										
										$column_element .= sprintf( "<div id='%s' class='%s column'>%s</div>", $column, $items['columnClass'], $item_elemen );

									}

								}

								$row_element .= sprintf( "<div id='%s' class='expanded row'>%s</div>", $row, $column_element );

							}
							printf( "<div id='footer-%s'>%s</div>", $section, $row_element );
						}
					}
				}
			?>
			</div>
		</header><!-- #masthead -->
		<?php
	}
	
}