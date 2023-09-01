<?php
if( !class_exists( 'Dahz_Framework_Preset_Export_Import_Footer' ) ){
	
	Class Dahz_Framework_Preset_Export_Import_Footer extends WP_Customize_Control{
		
		public $type = 'dahz_preset_export_import_footer';
		
		public function render_content() {
		?>
			<div class="de-customizer-title">
				<?php esc_html_e( 'Export Footer Preset', 'kitring' ); ?>
			</div>
			<span class="description customize-control-description">
				<?php esc_html_e( 'Click the button below to export the customization settings for this theme.', 'kitring' ); ?>
			</span>
			<input type="button" class="button" data-to-export="footer-preset" name="dahz-preset-export" value="<?php esc_attr_e( 'Export Footer Preset', 'kitring' ); ?>" />

			<div class="de-customizer-title">
				<?php esc_html_e( 'Import Footer Preset', 'kitring' ); ?>
			</div>
			<span class="description customize-control-description">
				<?php esc_html_e( 'Upload a file to import customization settings for this theme.', 'kitring' ); ?>
			</span>
			<div class="dahz-footer-preset-import-controls">
				<input type="file" name="dahz-footer-preset-import-file"/>
				<?php wp_nonce_field( 'dahz-footer-preset-import', 'dahz-header-preset-importing' ); ?>
			</div>
			<div class="dahz-footer-preset-uploading"><?php esc_html_e( 'Please Wait ...', 'kitring' ); ?></div>
			<input type="button" class="button" data-to-export="footer-preset" name="dahz-preset-import" value="<?php esc_attr_e( 'Import Footer Preset', 'kitring' ); ?>" />
		<?php
		}
		
	}
	
}