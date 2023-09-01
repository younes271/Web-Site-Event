<?php
if( !class_exists( 'Dahz_Framework_Customizer_Export_Import' ) ){
	
	Class Dahz_Framework_Customizer_Export_Import extends WP_Customize_Control{
		
		public $type = 'dahz_export_import';
		
		public function render_content() {
		?>
			<div class="de-customizer-title">
				<?php esc_html_e( 'Export Customizer', 'kitring' ); ?>
			</div>
			<span class="description customize-control-description">
				<?php esc_html_e( 'Click the button below to export the customization settings for this theme.', 'kitring' ); ?>
			</span>
			<input type="button" class="button" name="dahz-customizer-export" value="<?php esc_attr_e( 'Export', 'kitring' ); ?>" />

			<div class="de-customizer-title">
				<?php esc_html_e( 'Import Customizer', 'kitring' ); ?>
			</div>
			<span class="description customize-control-description">
				<?php esc_html_e( 'Upload a file to import customization settings for this theme.', 'kitring' ); ?>
			</span>
			<div class="dahz-customizer-import-controls">
				<input type="file" name="dahz-customizer-import-file"/>
				<!--
				<label class="dahz-customizer-import-images">
					<input type="checkbox" name="dahz-customizer-import-images" value="1" /> <?php esc_html_e( 'Download and import image files?', 'kitring' ); ?>
				</label>
				-->
				<?php wp_nonce_field( 'dahz-customizer-import', 'dahz-customizer-importing' ); ?>
			</div>
			<div class="dahz-customizer-uploading"><?php esc_html_e( 'Please Wait ...', 'kitring' ); ?></div>
			<input type="button" class="button" name="dahz-customizer-import" value="<?php esc_attr_e( 'Import', 'kitring' ); ?>" />
		<?php
		}
		
	}
	
}