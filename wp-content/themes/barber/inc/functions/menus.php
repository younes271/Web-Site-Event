<?php
//Saves new custom options for navigation
add_action('wp_update_nav_menu_item', 'apr_custom_nav_update', 10, 3);

function apr_custom_nav_update($menu_id, $menu_item_db_id, $args) {
    $use_megamenu = isset($_POST['menu-item-use_megamenu'][$menu_item_db_id]) ? 1 : 0;
    update_post_meta($menu_item_db_id, '_menu_item_use_megamenu', $use_megamenu);
    if(isset($_POST['menu-item-panel_column'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_panel_column', $_POST['menu-item-panel_column'][$menu_item_db_id]);
    }
    if(isset($_POST['menu-item-mega_item_column'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_mega_item_column', $_POST['menu-item-mega_item_column'][$menu_item_db_id]);
    }
    
    $check = array('tip_label', 'tip_color', 'tip_bg', 'icon', 'block1', 'block2', 'block3');

    foreach ( $check as $key ) {

        if (!isset($_POST['menu-item-'.$key][$menu_item_db_id])){
            if (!isset($args['menu-item-'.$key]))
                $value = "";
            else
                $value = $args['menu-item-'.$key];
        } else {
            $value = $_POST['menu-item-'.$key][$menu_item_db_id];
        }

        if ($value)
            update_post_meta( $menu_item_db_id, '_menu_item_'.$key, $value );
        else
            delete_post_meta( $menu_item_db_id, '_menu_item_'.$key );
    }
}
//Adds value of custom option to $item object that will be passed to Apr_Walker_Nav_Menu_Edit
add_filter('wp_setup_nav_menu_item', 'apr_custom_nav_item');

function apr_custom_nav_item($menu_item) {
	if(isset($menu_item->ID)){	
	$menu_item->tip_label = get_post_meta( $menu_item->ID, '_menu_item_tip_label', true );
    $menu_item->tip_color = get_post_meta( $menu_item->ID, '_menu_item_tip_color', true );
    $menu_item->tip_bg = get_post_meta( $menu_item->ID, '_menu_item_tip_bg', true );	
	$menu_item->icon = get_post_meta( $menu_item->ID, '_menu_item_icon', true );
    $menu_item->use_megamenu = get_post_meta($menu_item->ID, '_menu_item_use_megamenu', true);
    $menu_item->panel_column = get_post_meta($menu_item->ID, '_menu_item_panel_column', true);
    $menu_item->mega_item_column = get_post_meta($menu_item->ID, '_menu_item_mega_item_column', true);
    $menu_item->block1 = get_post_meta( $menu_item->ID, '_menu_item_block1', true );
    $menu_item->block2 = get_post_meta( $menu_item->ID, '_menu_item_block2', true );
    $menu_item->block3 = get_post_meta( $menu_item->ID, '_menu_item_block3', true );
    }
    return $menu_item;
}

add_filter('wp_edit_nav_menu_walker', 'apr_custom_nav_edit_walker', 10, 2);

function apr_custom_nav_edit_walker($walker, $menu_id) {
    return 'Apr_Walker_Nav_Menu_Edit';
}
//Add menu item options
if (!class_exists('Apr_Walker_Nav_Menu_Edit')) {
    
    function apr_get_megamenu_columns() {
        return array(
            '2' => esc_html__('2 columns', 'barber'),
            '3' => esc_html__('3 columns', 'barber'),
            '4' => esc_html__('4 columns', 'barber'),
            '5' => esc_html__('5 columns', 'barber'),
            '6' => esc_html__('6 columns', 'barber'),
        );
    }

    class Apr_Walker_Nav_Menu_Edit extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = array() ) {}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {}
        
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $_wp_nav_menu_max_depth;
		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

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
			//$original_title = get_the_title( $original_object->ID );
			$original_title = isset( $original_object->post_title ) ? $original_object->post_title : '';
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
			$title = sprintf( esc_html__( '%s (Invalid)', 'barber' ), $item->title );
		} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( esc_html__('%s (Pending)', 'barber'), $item->title );
		}

		$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

		$submenu_text = '';
		if ( 0 == $depth )
			$submenu_text = 'style="display: none;"';

		?>
		<li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo implode(' ', $classes ); ?>">
			<div class="menu-item-bar">
				<div class="menu-item-handle">
					<span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo esc_attr($submenu_text); ?>><?php echo esc_html__( 'sub item','barber' ); ?></span></span>
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
							?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up','barber'); ?>">&#8593;</abbr></a>
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
							?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down','barber'); ?>">&#8595;</abbr></a>
						</span>
						<a class="item-edit" id="edit-<?php echo esc_attr($item_id); ?>" title="<?php esc_attr_e('Edit Menu Item','barber'); ?>" href="<?php
							echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
						?>"><?php echo esc_html__( 'Edit Menu Item','barber' ); ?></a>
					</span>
				</div>
			</div>

			<div class="menu-item-settings" id="menu-item-settings-<?php echo esc_attr($item_id); ?>">
				<?php if ( 'custom' == $item->type ) : ?>
					<p class="field-url description description-wide">
						<label for="edit-menu-item-url-<?php echo esc_attr($item_id); ?>">
							<?php echo esc_html__( 'URL','barber' ); ?><br />
							<input type="text" id="edit-menu-item-url-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-wide">
					<label for="edit-menu-item-title-<?php echo esc_attr($item_id); ?>">
						<?php echo esc_html__( 'Navigation Label','barber' ); ?><br />
						<input type="text" id="edit-menu-item-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
					</label>
				</p>
				<p class="field-title-attribute description description-wide">
					<label for="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>">
						<?php echo esc_html__( 'Title Attribute','barber' ); ?><br />
						<input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
					</label>
				</p>
				<p class="field-link-target description">
					<label for="edit-menu-item-target-<?php echo esc_attr($item_id); ?>">
						<input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr($item_id); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr($item_id); ?>]"<?php checked( $item->target, '_blank' ); ?> />
						<?php echo esc_html__( 'Open link in a new window/tab','barber' ); ?>
					</label>
				</p>
				<p class="description description-wide">
			        <label for="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>">
			            <?php echo 'Icon Class'; ?><br />
			            <input type="text" id="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-icon"
			                <?php if (esc_attr( $item->icon )) : ?>
			                    name="menu-item-icon[<?php echo esc_attr($item_id); ?>]"
			                <?php endif; ?>
			                   data-name="menu-item-icon[<?php echo esc_attr($item_id); ?>]"
			                   value="<?php echo esc_attr( $item->icon ); ?>" />
			            <span><?php echo wp_kses(__('Input icon class. You can see <a target="_blank" href="http://fortawesome.github.io/Font-Awesome/icons/">Font Awesome Icons</a>, <a target="_blank" href="https://linearicons.com/free">Linearicons </a>, <a target="_blank" href="http://themes-pixeden.com/font-demos/7-stroke/">Pe stroke icon7 </a>. For example: fa fa-picture-o', 'barber'),array(
			            		'a'=> array('href'=>array(), 'target' => array()
			            			),
			            	)) ?></span>
			        </label>
			    </p>
			    <p class="description">
			        <label for="edit-menu-item-tip_label-<?php echo esc_attr($item_id); ?>">
			            <?php echo 'Tip Label'; ?><br />
			            <input type="text" id="edit-menu-item-tip_label-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-tip_label"
			                <?php if (esc_attr( $item->tip_label )) : ?>
			                    name="menu-item-tip_label[<?php echo esc_attr($item_id); ?>]"
			                <?php endif; ?>
			                   data-name="menu-item-tip_label[<?php echo esc_attr($item_id); ?>]"
			                   value="<?php echo esc_attr( $item->tip_label ); ?>" />
			        </label>
			    </p>
			    <p class="description">
			        <label for="edit-menu-item-tip_color-<?php echo esc_attr($item_id); ?>">
			            <?php echo 'Tip Text Color'; ?><br />
			            <input type="text" id="edit-menu-item-tip_color-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-tip_color"
			                <?php if (esc_attr( $item->tip_color )) : ?>
			                    name="menu-item-tip_color[<?php echo esc_attr($item_id); ?>]"
			                <?php endif; ?>
			                   data-name="menu-item-tip_color[<?php echo esc_attr($item_id); ?>]"
			                   value="<?php echo esc_attr( $item->tip_color ); ?>" />
			        </label>
			    </p>
			    <p class="description">
			        <label for="edit-menu-item-tip_bg-<?php echo esc_attr($item_id); ?>">
			            <?php echo 'Tip BG Color'; ?><br />
			            <input type="text" id="edit-menu-item-tip_bg-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-tip_bg"
			                <?php if (esc_attr( $item->tip_bg )) : ?>
			                    name="menu-item-tip_bg[<?php echo esc_attr($item_id); ?>]"
			                <?php endif; ?>
			                   data-name="menu-item-tip_bg[<?php echo esc_attr($item_id); ?>]"
			                   value="<?php echo esc_attr( $item->tip_bg ); ?>" />
			        </label>
			    </p><br>
				<p class="field-css-classes description description-thin">
					<label for="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>">
						<?php echo esc_html__( 'CSS Classes (optional)','barber' ); ?><br />
						<input type="text" id="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
					</label>
				</p>
				<p class="field-xfn description description-thin">
					<label for="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>">
						<?php echo esc_html__( 'Link Relationship (XFN)','barber' ); ?><br />
						<input type="text" id="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
					</label>
				</p>
				<p class="field-description description description-wide">
					<label for="edit-menu-item-description-<?php echo esc_attr($item_id); ?>">
						<?php echo esc_html__( 'Description','barber' ); ?><br />
						<textarea id="edit-menu-item-description-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr($item_id); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
						<span class="description"><?php echo esc_html__('The description will be displayed in the menu if the current theme supports it.','barber'); ?></span>
					</label>
				</p>
                                
                                <?php
                                /*
                                 * Add custom options
                                 */
                                ?>  
                                    <div class="wrap-custom-options-level0-<?php echo esc_attr($item_id); ?>" style="<?php echo $depth == 0 ? 'display:block;' : 'display:none;' ?>">
                                        <p class="description">
                                            <label for="edit-menu-item-use_megamenu-<?php echo esc_attr($item_id); ?>">
                                                <input type="checkbox" id="edit-menu-item-use_megamenu-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-use_megamenu"
                                                       <?php if (esc_attr( $item->use_megamenu )) : ?>
                                                        name="menu-item-use_megamenu[<?php echo esc_attr($item_id); ?>]"
                                                        <?php endif; ?>
                                                        data-name="menu-item-use_megamenu[<?php echo esc_attr($item_id); ?>]"
                                                        value="1" <?php echo $item->use_megamenu && $item->use_megamenu == 1 ? 'checked' : '' ?> />
                                                <?php echo esc_html__('Mega menu', 'barber'); ?>
                                            </label>
                                        </p>
                                        <?php $panel_columns = apr_get_megamenu_columns(); ?>
                                        <p class="description" id="wrap-edit-menu-item-panel_column-<?php echo esc_attr($item_id) ?>" style="<?php echo !($item->use_megamenu && $item->use_megamenu == 1) ? 'display:none;' : '' ?>">
                                            <label for="edit-menu-item-panel_column-<?php echo esc_attr($item_id); ?>">
                                                <?php echo esc_html__('Display number of panel columns', 'barber'); ?>
                                                <select id="edit-menu-item-panel_column-<?php echo esc_attr($item_id); ?>" class="edit-menu-item-panel_column"
                                                        <?php if (esc_attr( $item->panel_column )) : ?>
                                                        name="menu-item-panel_column[<?php echo esc_attr($item_id); ?>]"
                                                        <?php endif; ?>
                                                        data-name="menu-item-panel_column[<?php echo esc_attr($item_id); ?>]">
                                                    <?php foreach($panel_columns as $key => $_val): ?>
                                                    <option value="<?php echo esc_attr($key); ?>" <?php echo ($item->panel_column && $item->panel_column == $key) ? 'selected' : '' ?>><?php echo $_val ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </label>
                                        </p>
								        <p class="description" style="<?php echo !($item->use_megamenu && $item->use_megamenu == 1) ? 'display:none;' : 'display:block;' ?>">
								            <label for="edit-menu-item-block1-<?php echo $item_id; ?>">
								                <?php echo 'Block 1 Name'; ?><br />
								                <input type="text" id="edit-menu-item-poup_block1-<?php echo $item_id; ?>" class="widefat edit-menu-item-block1"
								                    <?php if (esc_attr( $item->block1 )) : ?>
								                        name="menu-item-block1[<?php echo $item_id; ?>]"
								                    <?php endif; ?>
								                       data-name="menu-item-block1[<?php echo $item_id; ?>]"
								                       value="<?php echo esc_attr( $item->block1 ); ?>"/>
								            </label>
								        </p>
								        <p class="description" style="<?php echo !($item->use_megamenu && $item->use_megamenu == 1) ? 'display:none;' : 'display:block;' ?>">
								            <label for="edit-menu-item-block2-<?php echo $item_id; ?>">
								                <?php echo 'Block 2 Name '; ?><br />
								                <input type="text" id="edit-menu-item-poup_block2-<?php echo $item_id; ?>" class="widefat edit-menu-item-block2"
								                    <?php if (esc_attr( $item->block2 )) : ?>
								                        name="menu-item-block2[<?php echo $item_id; ?>]"
								                    <?php endif; ?>
								                       data-name="menu-item-block2[<?php echo $item_id; ?>]"
								                       value="<?php echo esc_attr( $item->block2 ); ?>"/>
								            </label>
								        </p>
								        <p class="description" style="<?php echo !($item->use_megamenu && $item->use_megamenu == 1) ? 'display:none;' : 'display:block;' ?>">
								            <label for="edit-menu-item-block3-<?php echo $item_id; ?>">
								                <?php echo 'Block 3 Name '; ?><br />
								                <input type="text" id="edit-menu-item-poup_block3-<?php echo $item_id; ?>" class="widefat edit-menu-item-block3"
								                    <?php if (esc_attr( $item->block3 )) : ?>
								                        name="menu-item-block3[<?php echo $item_id; ?>]"
								                    <?php endif; ?>
								                       data-name="menu-item-block3[<?php echo $item_id; ?>]"
								                       value="<?php echo esc_attr( $item->block3 ); ?>"/>
								            </label>
								        </p>
                                    </div>
                                    <?php
                                    $parent_use_megamenu = 0;
                                    if($depth == 1) {
                                        if($item->menu_item_parent) {
                                            $parent_item = get_post_meta($item->menu_item_parent, '_menu_item_use_megamenu', true);
                                            $parent_use_megamenu = $parent_item ? $parent_item : 0;
                                        }
                                    }
                                    ?>
                                    <div class="wrap-custom-options-level1-<?php echo esc_attr($item_id); ?>" style="<?php echo $depth == 1 ? 'display:block;' : 'display:none;' ?>">
                                        <p class="description wrap-edit-menu-item-mega_item_column" id="wrap-edit-menu-item-mega_item_column-<?php echo esc_attr($item_id) ?>" style="<?php echo !($parent_use_megamenu) ? 'display:none;' : '' ?>">
                                            <label for="edit-menu-item-mega_item_column-<?php echo esc_attr($item_id); ?>">
                                                <?php echo esc_html__('Item Columns(depend on parent panel columns)', 'barber'); ?><br>
                                                <input type="text" id="edit-menu-item-mega_item_column-<?php echo esc_attr($item_id); ?>" class="edit-menu-item-mega_item_column"
                                                       <?php if (esc_attr( $item->mega_item_column )) : ?>
                                                        name="menu-item-mega_item_column[<?php echo esc_attr($item_id); ?>]"
                                                        <?php endif; ?>
                                                        data-name="menu-item-mega_item_column[<?php echo esc_attr($item_id); ?>]"
                                                        value="<?php echo esc_attr( $item->mega_item_column ) ? esc_attr( $item->mega_item_column ) : 1 ?>" />
                                            </label>
                                        </p>
                                    </div>
                                <?php
                                /*
                                 * end custom options
                                 */
                                ?>

				<p class="field-move hide-if-no-js description description-wide">
					<label>
						<span><?php echo esc_html__( 'Move', 'barber' ); ?></span>
						<a href="#" class="menus-move menus-move-up" data-dir="up"><?php echo esc_html__( 'Up one', 'barber' ); ?></a>
						<a href="#" class="menus-move menus-move-down" data-dir="down"><?php echo esc_html__( 'Down one', 'barber' ); ?></a>
						<a href="#" class="menus-move menus-move-left" data-dir="left"></a>
						<a href="#" class="menus-move menus-move-right" data-dir="right"></a>
						<a href="#" class="menus-move menus-move-top" data-dir="top"><?php echo esc_html__( 'To the top', 'barber' ); ?></a>
					</label>
				</p>

				<div class="menu-item-actions description-wide submitbox">
					<?php if ( 'custom' != $item->type && $original_title !== false ) : ?>
						<p class="link-to-original">
							<?php printf( esc_html__('Original: %s', 'barber'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
						</p>
					<?php endif; ?>
					<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr($item_id); ?>" href="<?php
					echo wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'delete-menu-item',
								'menu-item' => $item_id,
							),
							admin_url( 'nav-menus.php' )
						),
						'delete-menu_item_' . $item_id
					); ?>"><?php echo esc_html__( 'Remove', 'barber' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo esc_attr($item_id); ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
						?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php echo esc_html__('Cancel', 'barber'); ?></a>
				</div>

				<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item_id); ?>" />
				<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
				<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
				<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
				<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
				<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
			</div><!-- .menu-item-settings-->
			<ul class="menu-item-transport"></ul>
		<?php
		$output .= ob_get_clean();
	}
    }

}

//Primary menu
if (!class_exists('Apr_Primary_Walker_Nav_Menu')) {

    class Apr_Primary_Walker_Nav_Menu extends Walker_Nav_Menu {

        public function start_lvl(&$output, $depth = 0, $args = array()) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"sub-menu clearfix\">\n";
        }
        protected function apr_get_megamenu_item_column_class($total = 4, $col = 1) {
            $col = $col > $total ? $total : $col;
            if($total == 5) {
                return '15';
            }
            return 12/$total*$col;
        }
        public function end_lvl(&$output, $depth = 0, $args = array()){
		        $indent = str_repeat("\t", $depth);
		        	$items = wp_get_nav_menu_items($args->menu->term_id);

		            foreach ($items as $item) {
		            	if ($item->block1 && $depth == 0 && $item->use_megamenu == 1){
		            		$classes_image="";
		                    if($item->panel_column) {
		                        $total_col = $item->panel_column;
		                        $num_col = $item->mega_item_column && $item->mega_item_column > 0 ? $item->mega_item_column : 1;
		                        $classes_image = 'col-md-'.$this->apr_get_megamenu_item_column_class($total_col, $num_col).' col-sm-6 col-xs-12';
		                    }
		            		$output .= '<li class="menu-block1 menu-item-'.esc_attr($item->ID).' '.esc_attr($classes_image).'">';
		            		$output .= '<div class="menu-block1-item">'.do_shortcode('[arrowpress_static_block static="'.$item->block1.'"]').'</div>';
		            		$output .= '</li>';
		            	}
		            	if ($item->block2 && $depth == 0 && $item->use_megamenu == 1){
		            		$classes_image="";
		                    if($item->panel_column) {
		                        $total_col = $item->panel_column;
		                        $num_col = $item->mega_item_column && $item->mega_item_column > 0 ? $item->mega_item_column : 1;
		                        $classes_image = 'col-md-'.$this->apr_get_megamenu_item_column_class($total_col, $num_col).' col-sm-6 col-xs-12';
		                    }
		            		$output .= '<li class="menu-block2 menu-item-'.esc_attr($item->ID).' '.esc_attr($classes_image).'">';
		            		$output .= '<div class="menu-block2-item">'.do_shortcode('[arrowpress_static_block static="'.$item->block2.'"]').'</div>';
		            		$output .= '</li>';
		            	}
		            	if ($item->block3 && $depth == 0 && $item->use_megamenu == 1){
		            		$classes_image="";
		                    if($item->panel_column) {
		                        $total_col = $item->panel_column;
		                        $num_col = $item->mega_item_column && $item->mega_item_column > 0 ? $item->mega_item_column : 1;
		                        $classes_image = 'col-md-'.$this->apr_get_megamenu_item_column_class($total_col, $num_col).' col-sm-6 col-xs-12';
		                    }
		            		$output .= '<li class="menu-block2 menu-item-'.esc_attr($item->ID).' '.esc_attr($classes_image).'">';
		            		$output .= '<div class="menu-block2-item">'.do_shortcode('[arrowpress_static_block static="'.$item->block3.'"]').'</div>';
		            		$output .= '</li>';
		            	}
       				}

		        $output .= "$indent</ul>\n";
		}
        public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
            $indent = ( $depth ) ? str_repeat("\t", $depth) : '';
            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;
            if($item->use_megamenu && $depth == 0) {
                $classes[] = 'megamenu';
            }
            $parent_use_megamenu = false;

            if ($item->use_megamenu && $depth == 0 && $item->popup_bg_image) {
                if ($item->popup_pos == "pos-left" ) {
                	$classes[] ='image_pos_left';
                } else {
                	$classes[] ='image_pos_bottom';
                }
            }
            if($depth == 1) {
                if($item->menu_item_parent) {
                    $parent_use_megamenu = get_post_meta($item->menu_item_parent, '_menu_item_use_megamenu', true);
                    $parent_panel_column = get_post_meta($item->menu_item_parent, '_menu_item_panel_column', true);
                    if($parent_use_megamenu) {
                        $total_col = $parent_panel_column ? $parent_panel_column : 4;
                        $num_col = $item->mega_item_column && $item->mega_item_column > 0 ? $item->mega_item_column : 1;
                        $classes[] = 'col-md-'.$this->apr_get_megamenu_item_column_class($total_col, $num_col).' col-sm-6 col-xs-12';
                    }
                }
            }
            if($args->has_children){
                $classes[] = 'page_item_has_children';
            }
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $output .= $indent . '<li' . $id . $class_names . '>';

            $atts = array();
            $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
            $atts['target'] = !empty($item->target) ? $item->target : '';
            $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
            $atts['href'] = !empty($item->url) ? $item->url : '';
            
            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $value = ( 'href' === $attr ) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .=  ($item->icon ? '<i class="' . esc_attr($item->icon) . '"></i>' : '');
            /** This filter is documented in wp-includes/post-template.php */
            $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
            if ($item->tip_label) {
                $item_style = '';
                $item_arrow_style = '';
                if ($item->tip_color) {
                    $item_style .= 'color:'.$item->tip_color.';';
                }
                if ($item->tip_bg) {
                    $item_style .= 'background:'.$item->tip_bg.';';
                    $item_arrow_style .= 'color:'.$item->tip_bg.';';
                }
                $item_output .= '<span class="tip" style="'.$item_style.'"><span class="tip-arrow" style="'.$item_arrow_style.'"></span>'.$item->tip_label.'</span>';
            }
            if($args->has_children && ($depth == 0 || ($depth == 1 && !$parent_use_megamenu))) {
                $item_output .= '<span class="open-submenu"><i class="fa fa-angle-down"></i></span></a>';
            }
            else{
            	$item_output .= '</a>';
            }
            if($args->has_children && ($depth == 0 || ($depth == 1))) {
                $item_output .= '<span class="caret-submenu"><i class="fa fa-angle-down" aria-hidden="true"></i></span>';
            }

            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);

        }
        public function display_element( $element, &$children_elements, $max_depth, $depth=0, $args = null, &$output = null ) {
            $id_field = $this->db_fields['id'];
            if ( is_object( $args[0] ) ) {
                $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
            }
            return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
        }

    }

}
