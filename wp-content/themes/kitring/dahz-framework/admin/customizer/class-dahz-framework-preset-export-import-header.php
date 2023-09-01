<?php
if( !class_exists( 'Dahz_Framework_Preset_Export_Import_Header' ) ){
	
	Class Dahz_Framework_Preset_Export_Import_Header extends WP_Customize_Control{
		
		public $type = 'dahz_preset_export_import_header';
		
		public function render_content() {
		?>
		
			<div class="de-customizer-title">
				<?php esc_html_e( 'Export Header Preset', 'kitring' ); ?>
			</div>
			<span class="description customize-control-description">
				<?php esc_html_e( 'Click the button below to export the customization settings for this theme.', 'kitring' ); ?>
			</span>
			<input type="button" class="button" data-to-export="header-preset" name="dahz-preset-export" value="<?php esc_attr_e( 'Export Header Preset', 'kitring' ); ?>" />
			<div class="de-customizer-title">
				<?php esc_html_e( 'Import Header Preset', 'kitring' ); ?>
			</div>
			<span class="description customize-control-description">
				<?php esc_html_e( 'Upload a file to import customization settings for this theme.', 'kitring' ); ?>
			</span>
			<div class="dahz-header-preset-import-controls">
				<input type="file" name="dahz-header-preset-import-file"/>
				<?php wp_nonce_field( 'dahz-header-preset-import', 'dahz-header-preset-importing' ); ?>
			</div>
			<div class="dahz-header-preset-uploading"><?php esc_html_e( 'Please Wait ...', 'kitring' ); ?></div>
			<input type="button" class="button" data-to-export="header-preset" name="dahz-preset-import" value="<?php esc_attr_e( 'Import Header Preset', 'kitring' ); ?>" />
		
		<?php
		}
		
	}
	
}