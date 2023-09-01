<?php
/**
 *  /!\ This is a copy of Walker_Nav_Menu_Edit class in core
 *
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
class Dahz_Framework_Megamenu_Admin_Walker extends Walker_Nav_Menu {

	/**
	 * @see Walker_Nav_Menu::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function start_lvl(&$output,  $depth = 0, $args= array()) {
	}

	/**
	 * @see Walker_Nav_Menu::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function end_lvl(&$output,  $depth = 0, $args= array()) {
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param object $args
	 */

	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $_wp_nav_menu_max_depth;
		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		ob_start();
		$item_id = esc_attr( $item->ID );
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);

		$original_title = '';
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
			if ( is_wp_error( $original_title ) )
				$original_title = false;
		} elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );
			$original_title = $original_object ? $original_object->post_title : '';

		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
		);

		$title = $item->title;

		if ( ! empty( $item->_invalid ) ) {
			$classes[] = 'menu-item-invalid';
			/* translators: %s: title of menu item which is invalid */
			$title = sprintf( __( '%s (Invalid)', 'kitring' ), $item->title );
		} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( __('%s (Pending)' , 'kitring' ), $item->title );
		}

		$title = empty( $item->label ) ? $title : $item->label;

		$submenu_text = '';
		if ( 0 == $depth )
			$submenu_text = 'style="display: none;"';

		?>
		<li id="menu-item-<?php echo esc_attr( $item_id ); ?>" class="<?php echo esc_attr( implode(' ', $classes ) ); ?>">
			<dl class="menu-item-bar">
				<dt class="menu-item-handle">
					<span class="item-title"><?php echo esc_html( $title ); ?> <span class="is-submenu" <?php echo esc_attr( $submenu_text ); ?>><?php esc_html_e( 'sub item', 'kitring' ); ?></span></span>
					<span class="item-controls">
						<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
						<span class="item-order hide-if-js">
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-up-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'kitring' ); ?>">&#8593;</abbr></a>
							|
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-down-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'kitring' ); ?>">&#8595;</abbr></a>
						</span>
						<a class="item-edit" id="edit-<?php echo esc_attr( $item_id ); ?>" title="<?php esc_attr_e( 'Edit Menu Item', 'kitring' ); ?>" href="<?php
							echo esc_url( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) ) );
						?>"><?php esc_html_e( 'Edit Menu Item', 'kitring' ); ?></a>
					</span>
				</dt>
			</dl>

			<div class="menu-item-settings" id="menu-item-settings-<?php echo esc_attr( $item_id ); ?>">


				<?php if ( 'custom' == $item->type ) : ?>
					<p class="field-url description description-wide">
						<label for="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'URL', 'kitring' ); ?><br />
							<input type="text" id="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-wide">
					<label for="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'Navigation Label', 'kitring' ); ?><br />
						<input type="text" id="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
					</label>
				</p>
				<p class="description description-wide">
					<label for="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'Title Attribute', 'kitring' ); ?><br />
						<input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
					</label>
				</p>
				<p class="field-link-target description">
					<label for="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>">
						<input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr( $item_id ); ?>]"<?php checked( $item->target, '_blank' ); ?> />
						<?php esc_html_e( 'Open link in a new window/tab', 'kitring' ); ?>
					</label>
				</p>
				<p class="field-css-classes description description-wide">
					<label for="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'CSS Classes (optional)', 'kitring' ); ?><br />
						<input type="text" id="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
					</label>
				</p>
				<p class="field-xfn description description-wide">
					<label for="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'Link Relationship (XFN)' , 'kitring' ); ?><br />
						<input type="text" id="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
					</label>
				</p>
				<p class="field-description description description-wide">
					<label for="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'Description', 'kitring' ); ?><br />
						<textarea id="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr( $item_id ); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
						<span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.' , 'kitring' ); ?></span>
					</label>
				</p>

				<?php
				/* New fields (select category for megamenu) starts here */
				$dahz_mega_menu = get_post_meta( $item->ID, 'mega_menu', true );

				if ( $depth == 0 ) {

					$is_mega_menu = !empty($dahz_mega_menu['is_mega_menu']) ? $dahz_mega_menu['is_mega_menu'] : false;

					$dropdown_width = !empty($dahz_mega_menu['dropdown_width']) ? $dahz_mega_menu['dropdown_width'] : '2';

					$dropdown_alignment = !empty($dahz_mega_menu['dropdown_alignment']) ? $dahz_mega_menu['dropdown_alignment'] : 'auto';

					$submenu_background_image = !empty($dahz_mega_menu['submenu_background_image']) ? $dahz_mega_menu['submenu_background_image'] : "";

					$submenu_background_image_src = !empty( $submenu_background_image )
						?
							wp_get_attachment_image_src( $submenu_background_image, 'medium' )
						:
							'';

					$submenu_background = !empty( $submenu_background_image_src )
						?
							sprintf( '<img src="%1$s" width="%2$s" height="%3$s">', $submenu_background_image_src[0], $submenu_background_image_src[1], $submenu_background_image_src[2] )
						:
							'';

					$background_repeat = !empty($dahz_mega_menu['background_repeat']) ?$dahz_mega_menu['background_repeat'] : "no-repeat";

					$background_position = !empty($dahz_mega_menu['background_position']) ? $dahz_mega_menu['background_position'] : "left top";

					$background_size = !empty($dahz_mega_menu['background_size']) ? $dahz_mega_menu['background_size'] : "auto";

				?>
					<p class="description-thin description">
						<label for="is-mega-menu-<?php echo esc_attr( $item_id ); ?>">
							<input type="checkbox" class="is-dahz-mega-menu"id="is-mega-menu-<?php echo esc_attr( $item_id ); ?>" value="yes" name="is_mega_menu[<?php echo esc_attr( $item_id ); ?>]"<?php checked( $is_mega_menu, 'yes' ); ?> />
							<?php esc_html_e( 'Enable Mega Menu', 'kitring' ); ?>
							<span></span>
						</label>
					</p>
					<p class="description-wide description de-mega-menu">
						<label for="dropdown-width-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Mega Menu Width', 'kitring' ); ?>
							<select id="dropdown-width-<?php echo esc_attr( $item_id ); ?>" class="widefat code de-to-element" name="dropdown_width[<?php echo esc_attr( $item_id ); ?>]">
								<option <?php selected( $dropdown_width, '5-6' ); ?> value="5-6"><?php esc_html_e( 'Width 83%', 'kitring' ); ?></option>
								<option <?php selected( $dropdown_width, '4-5' ); ?> value="4-5"><?php esc_html_e( 'Width 80%', 'kitring' ); ?></option>
								<option <?php selected( $dropdown_width, '3-5' ); ?> value="3-5"><?php esc_html_e( 'Width 60%', 'kitring' ); ?></option>
								<option <?php selected( $dropdown_width, '1-2' ); ?> value="1-2"><?php esc_html_e( 'Width 50%', 'kitring' ); ?></option>
								<option <?php selected( $dropdown_width, '1-3' ); ?> value="1-3"><?php esc_html_e( 'Width 33%', 'kitring' ); ?></option>
								<option <?php selected( $dropdown_width, '1-4' ); ?> value="1-4"><?php esc_html_e( 'Width 25%', 'kitring' ); ?></option>
								<option <?php selected( $dropdown_width, '1-5' ); ?> value="1-5"><?php esc_html_e( 'Width 20%', 'kitring' ); ?></option>
								<option <?php selected( $dropdown_width, '1-6' ); ?> value="1-6"><?php esc_html_e( 'Width 16%', 'kitring' ); ?></option>
								<option <?php selected( $dropdown_width, 'full' ); ?> value="full"><?php esc_html_e( 'Full Screen', 'kitring' ); ?></option>
							</select>
						</label>
					</p>
					<p class="description-wide description de-mega-menu">
						<label for="dropdown-alignment-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Dropdown Alignment', 'kitring' ); ?>
							<select id="dropdown-alignment-<?php echo esc_attr( $item_id ); ?>" class="widefat code de-to-element" name="dropdown_alignment[<?php echo esc_attr( $item_id ); ?>]">
								<option <?php selected( $dropdown_alignment, 'auto' ); ?> value="auto"><?php esc_html_e( 'Auto', 'kitring' ); ?></option>
								<option <?php selected( $dropdown_alignment, 'left' ); ?> value="left"><?php esc_html_e( 'Left', 'kitring' ); ?></option>
								<option <?php selected( $dropdown_alignment, 'center' ); ?> value="center"><?php esc_html_e( 'Center', 'kitring' ); ?></option>
								<option <?php selected( $dropdown_alignment, 'right' ); ?> value="right"><?php esc_html_e( 'Right', 'kitring' ); ?></option>
							</select>
						</label>
					</p>
					<p class="description description-wide de-mega-menu">
						<label><?php esc_html_e( 'Submenu Background Image', 'kitring' ); ?></label>
						<div class="de-uploader de-mega-menu">
							<?php echo !empty( $submenu_background_image_src )
								?
								sprintf( '<img src="%1$s" width="%2$s" height="%3$s">', $submenu_background_image_src[0], $submenu_background_image_src[1], $submenu_background_image_src[2] )
								:
								'';
							?>
							<div class="de-to-upload-button">
								<input type="hidden" class="de-to-element de-uploader-path" name="submenu_background_image[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr($submenu_background_image);?>"/>
								<a type="button" class="button de-upload-button"><?php esc_html_e("Upload Image", 'kitring' ); ?></a>
								<a type="button" class="button de-delete-upload-button"><?php esc_html_e("Remove", 'kitring' ); ?></a>
							</div>
						</div>
					</p>
					<p class="description-wide description de-mega-menu">
						<label for="background-size-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Image Size', 'kitring' ); ?>
							<select id="background-size-<?php echo esc_attr( $item_id ); ?>" class="widefat code de-to-element" name="background_size[<?php echo esc_attr( $item_id ); ?>]">
								<option <?php selected( $background_size, 'auto' ); ?> value="auto"><?php esc_html_e( 'Auto', 'kitring' ); ?></option>
								<option <?php selected( $background_size, 'contain' ); ?> value="contain"><?php esc_html_e( 'Contain', 'kitring' ); ?></option>
								<option <?php selected( $background_size, 'cover' ); ?> value="cover"><?php esc_html_e( 'Cover', 'kitring' ); ?></option>
							</select>
						</label>
					</p>
					<p class="description-wide description de-mega-menu">
						<label for="background-repeat-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Image Repeat', 'kitring' ); ?>
							<select id="background-repeat-<?php echo esc_attr( $item_id ); ?>" class="widefat code de-to-element" name="background_repeat[<?php echo esc_attr( $item_id ); ?>]">
								<option <?php selected( $background_repeat, 'no-repeat' ); ?> value="no-repeat"><?php esc_html_e( 'No Repeat', 'kitring' ); ?></option>
								<option <?php selected( $background_repeat, 'repeat-x' ); ?> value="repeat-x"><?php esc_html_e( 'Repeat x', 'kitring' ); ?></option>
								<option <?php selected( $background_repeat, 'repeat-y' ); ?> value="repeat-y"><?php esc_html_e( 'Repeat y', 'kitring' ); ?></option>
								<option <?php selected( $background_repeat, 'repeat' ); ?> value="repeat"><?php esc_html_e( 'Repeat', 'kitring' ); ?></option>
							</select>
						</label>
					</p>
					<p class="description-wide description de-mega-menu">
						<label for="background-position-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Image Position', 'kitring' ); ?>
							<select id="background-position-<?php echo esc_attr( $item_id ); ?>" class="widefat code de-to-element" name="background_position[<?php echo esc_attr( $item_id ); ?>]">
								<option <?php selected( $background_position, 'left top' ); ?> value="left top"><?php esc_html_e( 'Left Top', 'kitring' ); ?></option>
								<option <?php selected( $background_position, 'left center' ); ?> value="left center"><?php esc_html_e( 'Left Center', 'kitring' ); ?></option>
								<option <?php selected( $background_position, 'left bottom' ); ?> value="left bottom"><?php esc_html_e( 'Left Bottom', 'kitring' ); ?></option>
								<option <?php selected( $background_position, 'right top' ); ?> value="right top"><?php esc_html_e( 'Right Top', 'kitring' ); ?></option>
								<option <?php selected( $background_position, 'right center' ); ?> value="right center"><?php esc_html_e( 'Right Center', 'kitring' ); ?></option>
								<option <?php selected( $background_position, 'right bottom' ); ?> value="right bottom"><?php esc_html_e( 'Right Botttom', 'kitring' ); ?></option>
								<option <?php selected( $background_position, 'center top' ); ?> value="center top"><?php esc_html_e( 'Center Top', 'kitring' ); ?></option>
								<option <?php selected( $background_position, 'center center' ); ?> value="center center"><?php esc_html_e( 'Center Center', 'kitring' ); ?></option>
								<option <?php selected( $background_position, 'center bottom' ); ?> value="center bottom"><?php esc_html_e( 'Center Bottom', 'kitring' ); ?></option>
							</select>
						</label>
					</p>
				<?php
				}
				if ( $depth == 0 || $depth == 1 ) {
					$submenu_text_align = !empty($dahz_mega_menu['submenu_text_align']) ? $dahz_mega_menu['submenu_text_align'] : "left";
				?>
					<p class="description-wide description de-mega-menu">
						<label><?php esc_html_e( 'Submenu Text Align', 'kitring' ); ?>
							<select id="is-fullscreen-<?php echo esc_attr( $item_id ); ?>" class="widefat code de-to-element" name="submenu_text_align[<?php echo esc_attr( $item_id ); ?>]">
								<option <?php selected( $submenu_text_align, 'left' ); ?> value="left"><?php esc_html_e( 'Left', 'kitring' ); ?></option>
								<option <?php selected( $submenu_text_align, 'center' ); ?>value="center"><?php esc_html_e( 'Center', 'kitring' ); ?></option>
								<option <?php selected( $submenu_text_align, 'right' ); ?> value="right"><?php esc_html_e( 'Right', 'kitring' ); ?></option>
							</select>
						</label>
					</p>
				<?php
				}
				if ( $depth == 1 ) {

					$is_display_as_header = !empty($dahz_mega_menu['is_display_as_header']) ? $dahz_mega_menu['is_display_as_header'] : false;

					$is_carousel = !empty($dahz_mega_menu['is_carousel']) ? $dahz_mega_menu['is_carousel'] : false;

					$column_width = !empty($dahz_mega_menu['column_width']) ? $dahz_mega_menu['column_width'] : '1';

					$source_carousel = !empty($dahz_mega_menu['source_carousel']) ? $dahz_mega_menu['source_carousel'] : "product";

					$carousel_content = !empty($dahz_mega_menu['carousel_content']) ? $dahz_mega_menu['carousel_content'] : "";

					$column_carousel = !empty($dahz_mega_menu['column_carousel']) ? $dahz_mega_menu['column_carousel'] : "4";
				?>

					<p class="description-wide description de-mega-menu">
						<label for="is-carousel-<?php echo esc_attr( $item_id ); ?>">
							<input type="checkbox" id="is-carousel-<?php echo esc_attr( $item_id ); ?>" class="widefat code de-to-element" name="is_carousel[<?php echo esc_attr( $item_id ); ?>]" value="yes"<?php checked( $is_carousel, 'yes' );?> />
							<?php esc_html_e( 'Enable Carousel', 'kitring' ); ?>
						</label>
					</p>

					<p class="description-wide description de-mega-menu">
						<label for="column-width-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Column Width', 'kitring' ); ?>
							<select id="column-width-<?php echo esc_attr( $item_id ); ?>" class="widefat code de-to-element" name="column_width[<?php echo esc_attr( $item_id ); ?>]">
								<option <?php selected( $column_width, '1' ); ?> value="1"><?php esc_html_e( '1', 'kitring' ); ?></option>
								<option <?php selected( $column_width, '1/2' ); ?> value="1/2"><?php esc_html_e( '1/2', 'kitring' ); ?></option>
								<option <?php selected( $column_width, '1/3' ); ?> value="1/3"><?php esc_html_e( '1/3', 'kitring' ); ?></option>
								<option <?php selected( $column_width, '1/4' ); ?> value="1/4"><?php esc_html_e( '1/4', 'kitring' ); ?></option>
								<option <?php selected( $column_width, '1/5' ); ?> value="1/5"><?php esc_html_e( '1/5', 'kitring' ); ?></option>
								<option <?php selected( $column_width, '1/6' ); ?> value="1/6"><?php esc_html_e( '1/6', 'kitring' ); ?></option>
								<option <?php selected( $column_width, '2/3' ); ?> value="2/3"><?php esc_html_e( '2/3', 'kitring' ); ?></option>
								<option <?php selected( $column_width, '2/5' ); ?> value="2/5"><?php esc_html_e( '2/5', 'kitring' ); ?></option>
								<option <?php selected( $column_width, '3/4' ); ?> value="3/4"><?php esc_html_e( '3/4', 'kitring' ); ?></option>
								<option <?php selected( $column_width, '3/5' ); ?> value="3/5"><?php esc_html_e( '3/5', 'kitring' ); ?></option>
								<option <?php selected( $column_width, '4/5' ); ?> value="4/5"><?php esc_html_e( '4/5', 'kitring' ); ?></option>
								<option <?php selected( $column_width, '5/6' ); ?> value="5/6"><?php esc_html_e( '5/6', 'kitring' ); ?></option>
							</select>
						</label>
					</p>

					<p class="description-wide description de-mega-menu">
						<label for="source-carousel-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Carousel Source', 'kitring' ); ?>
							<select id="source-carousel-<?php echo esc_attr( $item_id ); ?>" class="source-carousel widefat code de-to-element" name="source_carousel[<?php echo esc_attr( $item_id ); ?>]">
								<option <?php selected( $source_carousel, 'product' ); ?> value="product"><?php esc_html_e( 'Product', 'kitring' ); ?></option>
								<option <?php selected( $source_carousel, 'product_category' ); ?> value="product_category"><?php esc_html_e( 'Product Category', 'kitring' ); ?></option>
								<option <?php selected( $source_carousel, 'post' ); ?> value="post"><?php esc_html_e( 'Post', 'kitring' ); ?></option>
								<option <?php selected( $source_carousel, 'post_category' ); ?> value="post_category"><?php esc_html_e( 'Post Category', 'kitring' ); ?></option>
								<option <?php selected( $source_carousel, 'brand' ); ?> value="brand"><?php esc_html_e( 'Product Brand', 'kitring' ); ?></option>
							</select>
						</label>
					</p>

					<p class="description description-wide de-mega-menu">
						<label for="carousel-content-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'Carousel Content', 'kitring' ); ?><br />
							<input type="text" multiple="multiple" id="carousel-content-<?php echo esc_attr( $item_id ); ?>" class="widefat background-position de-autocomplete-megamenu" name="carousel_content[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $carousel_content ); ?>" />
						</label>
					</p>
					<p class="description-wide description de-mega-menu">
						<label for="column-carousel-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Carousel Column', 'kitring' ); ?>
							<select id="column-carousel-<?php echo esc_attr( $item_id ); ?>" class="column-carousel widefat code de-to-element" name="column_carousel[<?php echo esc_attr( $item_id ); ?>]">
								<option <?php selected( $column_carousel, '1' ); ?> value="1"><?php esc_html_e( '1 Column', 'kitring' ); ?></option>
								<option <?php selected( $column_carousel, '2' ); ?> value="2"><?php esc_html_e( '2 Column', 'kitring' ); ?></option>
								<option <?php selected( $column_carousel, '3' ); ?> value="3"><?php esc_html_e( '3 Column', 'kitring' ); ?></option>
								<option <?php selected( $column_carousel, '4' ); ?> value="4"><?php esc_html_e( '4 Column', 'kitring' ); ?></option>
							</select>
						</label>
					</p>
				<?php
				}
				if ( $depth == 1 || $depth == 2 ) {

					$is_hide_title = !empty($dahz_mega_menu['is_hide_title']) ? $dahz_mega_menu['is_hide_title'] : false;

					$image_replace_link = !empty($dahz_mega_menu['image_replace_link']) ? $dahz_mega_menu['image_replace_link'] : "";

					$image_replace_src = !empty( $image_replace_link )
						?
							wp_get_attachment_image_src( $image_replace_link, 'medium' )
						:
							'';

					$image_replace = !empty( $image_replace_src )
						?
							sprintf( '<img src="%1$s" width="%2$s" height="%3$s">', $image_replace_src[0], $image_replace_src[1], $image_replace_src[2] )
						:
							'';
				?>
					<p class="description-wide description de-mega-menu">
						<label for="is-hide-title-<?php echo esc_attr( $item_id ); ?>">
							<input type="checkbox" id="is-hide-title<?php echo esc_attr( $item_id ); ?>" class="widefat code de-to-element" name="is_hide_title[<?php echo esc_attr( $item_id ); ?>]" value="yes"<?php checked( $is_hide_title, 'yes' );?> />
							<?php esc_html_e( 'Enable Hide Title', 'kitring' ); ?>
						</label>
					</p>

					<p class="description-wide description de-mega-menu">
						<label><?php esc_html_e( 'Replace Link With Image', 'kitring' ); ?></label><br>
						<div class="de-uploader de-mega-menu">
							<?php echo !empty( $image_replace_src )
								?
									sprintf( '<img src="%1$s" width="%2$s" height="%3$s">', $image_replace_src[0], $image_replace_src[1], $image_replace_src[2] )
								:
									'';
							?>
							<div class="de-to-upload-button">
								<input type="hidden" class="de-to-element de-uploader-path" name="image_replace_link[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr($image_replace_link);?>"/>
								<a type="button" class="button de-upload-button"><?php esc_html_e("Upload Image", 'kitring' ); ?></a>
								<a type="button" class="button de-delete-upload-button"><?php esc_html_e("Remove", 'kitring' ); ?></a>
							</div>
						</div>
					</p>
				<?php
				}
				?>

				<p class="menu-item-actions description-wide submitbox">
					<?php if ( 'custom' != $item->type && $original_title !== false ) : ?>
						<span class="link-to-original">
							<?php printf( __('Original: %s' , 'kitring' ), '<a href="' . esc_url( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
						</span>
					<?php endif; ?>
					<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr( $item_id ); ?>" href="<?php
					echo wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'delete-menu-item',
								'menu-item' => $item_id,
							),
							remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
						),
						'delete-menu_item_' . $item_id
					); ?>"><?php esc_html_e('Remove', 'kitring' ); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo esc_attr( $item_id ); ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
						?>#menu-item-settings-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e('Cancel', 'kitring' ); ?></a>
				</p>

				<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item_id ); ?>" />
				<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
				<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
				<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
				<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
				<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
			</div><!-- .menu-item-settings-->

			<ul class="menu-item-transport"></ul>
		<?php

		$output .= ob_get_clean();

	}

}





