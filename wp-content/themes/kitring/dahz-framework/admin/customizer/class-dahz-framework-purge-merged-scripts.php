<?php

if ( !class_exists( 'Dahz_Framework_Purge_Merged_Scripts' ) ) {

	Class Dahz_Framework_Purge_Merged_Scripts extends WP_Customize_Control {

		public $type = 'dahz_purge_merged_scripts';

		public function render_content() {
			?>
			<span class="customize-control-title"><?php esc_html_e( 'Purged Merged Script', 'kitring' ); ?></span>
			<span class="description customize-control-description"><?php esc_html_e( 'Click the button below to delete all merged script', 'kitring' ); ?></span>
			<input type="button" class="button" name="dahz-purge-merged-scripts" value="<?php esc_attr_e( 'Purge Merged Script', 'kitring' ); ?>" />
			<?php
		}

	}

}