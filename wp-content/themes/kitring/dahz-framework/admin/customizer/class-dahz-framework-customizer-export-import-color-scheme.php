<?php
if( !class_exists( 'Dahz_Framework_Customizer_Export_Import_Color_Scheme' ) ){
	
	Class Dahz_Framework_Customizer_Export_Import_Color_Scheme extends WP_Customize_Control{
		
		public $type = 'dahz_export_import_color_scheme';
		
		public function render_content() {
		?>
			<div class="de-customizer-title">
				<?php esc_html_e( 'Export Color Scheme', 'kitring' ); ?>
			</div>
			<span class="description customize-control-description">
				<?php esc_html_e( 'Click the button below to export the customization settings for this theme.', 'kitring' ); ?>
			</span>
			<input type="button" class="button" name="dahz-customizer-export-color-scheme" value="<?php esc_attr_e( 'Export Color Scheme', 'kitring' ); ?>" />
		<?php
		}
		
	}
	
}