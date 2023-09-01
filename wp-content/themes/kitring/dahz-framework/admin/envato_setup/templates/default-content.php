<?php
	$available_content = $_this->_get_json( 'default.json' );
	$post_types = get_post_types();
?>
<h1><?php esc_html_e( 'Default Content', 'kitring' ); ?></h1>
<form method="post">
	<?php if ( $_this->is_possible_upgrade() ) { ?>
		<p><?php esc_html_e( 'It looks like you already have content installed on _this website. If you would like to install the default demo content as well you can select it below. Otherwise just choose the upgrade option to ensure everything is up to date.', 'kitring' ); ?></p>
	<?php } else { ?>
		<p><?php printf( esc_html__( 'It\'s time to insert some default content for your new WordPress website. Choose what you would like inserted below and click Continue. It is recommended to leave everything selected. Once inserted, _this content can be managed from the WordPress admin dashboard. ', 'kitring' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=page' ) ) . '" target="_blank">', '</a>' ); ?></p>
	<?php } ?>
	<table class="envato-setup-pages" cellspacing="0">
		<thead>
		<tr>
			<td class="check"></td>
			<th class="item"><?php esc_html_e( 'Item', 'kitring' ); ?></th>
			<th class="description"><?php esc_html_e( 'Description', 'kitring' ); ?></th>
			<th class="status"><?php esc_html_e( 'Status', 'kitring' ); ?></th>
		</tr>
		</thead>
		<tbody>
		
		<?php foreach ( $_this->_content_default_get() as $slug => $default ) { ?>
			<?php if( $slug === 'attachment' && !$_this->enable_identic )continue;?>
			<tr class="envato_default_content" data-content="<?php echo esc_attr( $slug ); ?>">
				<td class="check">
					<input type="checkbox" name="default_content[<?php echo esc_attr( $slug ); ?>]"
						   class="envato_default_content"
						   id="default_content_<?php echo esc_attr( $slug ); ?>"
						   value="1" <?php echo ( ! isset( $default['checked'] ) || $default['checked'] ) ? ' checked' : ''; ?>>
				</td>
				<td><label
						for="default_content_<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $default['title'] ); ?></label>
				</td>
				<td class="description column-3"><?php echo esc_html( $default['description'] ); ?></td>
				<td class="status"><span><?php echo esc_html( $default['pending'] ); ?></span>
					<div class="spinner"></div>
				</td>
			</tr>
			<?php if( in_array( $slug, $post_types ) && $slug !== 'attachment' && $slug !== 'nav_menu_item' ) : ?>
				<tr class="envato_default_sub_content" data-sub-content="<?php echo esc_attr( $slug ); ?>">
					<td class="column-4 toggle-header"><?php esc_html_e( 'Click here to select manually', 'kitring' ); ?></td>
					<td class="column-4 toggle-body">
						<?php foreach( $available_content[$slug] as $post_data ){ ?>
							<span class="toggle-item">
								<input type="checkbox" name="default_sub_content[<?php echo esc_attr( $slug ); ?>][<?php echo esc_attr( $post_data['post_id'] ); ?>]"
										class="envato_default_sub_content"
										id="default_sub_content<?php echo esc_attr( $slug ); ?>_<?php echo esc_attr( $post_data['post_id'] ); ?>"
										value="<?php echo esc_attr( $post_data['post_id'] ); ?>">
								<span><?php echo esc_html( $post_data['post_title'] ); ?></span>
							</span>
						<?php } ?>
					</td>
				</tr>
			<?php endif; ?>
		<?php } ?>
		</tbody>
	</table>
	<p class="envato-setup-actions step">
		<a href="<?php echo esc_url( $_this->get_next_step_link() ); ?>"
		   class="button-primary button button-large button-next"
		   data-callback="install_content"><?php esc_html_e( 'Continue', 'kitring' ); ?></a>
		<a href="<?php echo esc_url( $_this->get_next_step_link() ); ?>"
		   class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'kitring' ); ?></a>
		<?php wp_nonce_field( 'envato-setup' ); ?>
	</p>
</form>