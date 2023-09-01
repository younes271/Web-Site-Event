<?php

/**

Background image + colors

**/

class Vamtam_Customize_Background_Control extends Vamtam_Customize_Control {
	public $type = 'vamtam-background';

	/**
	 * Media control mime type.
	 *
	 * @access public
	 * @var string
	 */
	public $mime_type = 'image';

	/**
	 * Button labels.
	 *
	 * @access public
	 * @var array
	 */
	public $button_labels = array();

	/**
	 * Defines which properties are configurable
	 */
	public $show = array();

	/**
	 * Holds all possible values for the dropdown options
	 *
	 * @var array
	 */
	public static $selects = array();

	/**
	 * Constructor.
	 *
	 * @since 4.1.0
	 * @since 4.2.0 Moved from WP_Customize_Upload_Control.
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    Optional. Arguments to override class property defaults.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );

		$this->button_labels = wp_parse_args( $this->button_labels, array(
			'select'       => esc_html__( 'Select Image', 'coiffure' ),
			'change'       => esc_html__( 'Change Image', 'coiffure' ),
			'remove'       => esc_html__( 'Remove', 'coiffure' ),
			'default'      => esc_html__( 'Default', 'coiffure' ),
			'placeholder'  => esc_html__( 'No image selected', 'coiffure' ),
			'frame_title'  => esc_html__( 'Select Image', 'coiffure' ),
			'frame_button' => esc_html__( 'Choose Image', 'coiffure' ),
		) );

		$this->show = wp_parse_args( $this->show, array(
			'background-image'      => true,
			'background-color'      => true,
			'background-attachment' => true,
			'background-size'       => true,
			'background-repeat'     => true,
			'background-position'   => true,
		) );

		self::$selects = array(
			'background-repeat' => array(
				'no-repeat' => esc_html__( 'No repeat', 'coiffure' ),
				'repeat-x'  => esc_html__( 'Repeat horizontally', 'coiffure' ),
				'repeat-y'  => esc_html__( 'Repeat vertically', 'coiffure' ),
				'repeat'    => esc_html__( 'Repeat both', 'coiffure' ),
			),
			'background-attachment' => array(
				'scroll' => esc_html__( 'scroll', 'coiffure' ),
				'fixed'  => esc_html__( 'fixed', 'coiffure' ),
			),
			'background-size' => array(
				'auto'    => esc_html__( 'auto', 'coiffure' ),
				'cover'   => esc_html__( 'cover', 'coiffure' ),
				'contain' => esc_html__( 'contain', 'coiffure' ),
			),
			'background-position' => array(
				'left top'      => esc_html__( 'left top', 'coiffure' ),
				'left center'   => esc_html__( 'left center', 'coiffure' ),
				'left bottom'   => esc_html__( 'left bottom', 'coiffure' ),
				'center top'    => esc_html__( 'center top', 'coiffure' ),
				'center center' => esc_html__( 'center center', 'coiffure' ),
				'center bottom' => esc_html__( 'center bottom', 'coiffure' ),
				'right top'     => esc_html__( 'right top', 'coiffure' ),
				'right center'  => esc_html__( 'right center', 'coiffure' ),
				'right bottom'  => esc_html__( 'right bottom', 'coiffure' ),
			),
		);
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since 3.4.0
	 * @since 4.2.0 Moved from WP_Customize_Upload_Control.
	 */
	public function enqueue() {
		wp_enqueue_media();

		wp_enqueue_script(
			'customizer-control-vamtam-background-js',
			VAMTAM_CUSTOMIZER_LIB_URL . 'assets/js/background' . ( WP_DEBUG ? '' : '.min' ) . '.js',
			array( 'jquery', 'customize-base', 'wp-color-picker' ),
			Vamtam_Customizer::$version,
			true
		);

		wp_enqueue_style(
			'customizer-control-vamtam-background',
			VAMTAM_CUSTOMIZER_LIB_URL . 'assets/css/background.css',
			array( 'wp-color-picker' ),
			Vamtam_Customizer::$version
		);
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 3.4.0
	 * @since 4.2.0 Moved from WP_Customize_Upload_Control.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		$this->json['label']         = html_entity_decode( $this->label, ENT_QUOTES, get_bloginfo( 'charset' ) );
		$this->json['mime_type']     = $this->mime_type;
		$this->json['button_labels'] = $this->button_labels;
		$this->json['canUpload']     = current_user_can( 'upload_files' );
		$this->json['show']          = $this->show;
		$this->json['alt_medium']    = esc_html__( 'Medium-sized attachment', 'coiffure' );
		$this->json['alt_full']      = esc_html__( 'Full-sized attachment', 'coiffure' );

		$this->json['option_labels'] = array(
			'background-type'       => esc_html__( 'Background Type', 'coiffure' ),
			'background-repeat'     => esc_html__( 'Repeat', 'coiffure' ),
			'background-image'      => esc_html__( 'Image', 'coiffure' ),
			'background-attachment' => esc_html__( 'Attachment', 'coiffure' ),
			'background-size'       => esc_html__( 'Size', 'coiffure' ),
			'background-position'   => esc_html__( 'Position', 'coiffure' ),
			'background-color'      => esc_html__( 'Color', 'coiffure' ),
			'background-gradient'   => [
				'color-1'              => esc_html__( 'Color 1', 'coiffure' ),
				'color-2'              => esc_html__( 'Color 2', 'coiffure' ),
				'location'             => esc_html__( 'Location', 'coiffure' ),
				'type'                 => esc_html__( 'Type', 'coiffure' ),
				'position'             => esc_html__( 'Position', 'coiffure' ),
				'angle'                => esc_html__( 'Angle', 'coiffure' ),
			],
		);

		$this->json['l10n'] = array(
			'background-gradient'   => [
				'type'              => [
					'linear' => esc_html__( 'Linear', 'coiffure' ),
					'radial' => esc_html__( 'Radial', 'coiffure' ),
				],
				'position'          => [
					'center center' =>  esc_html__( 'Center Center' , 'coiffure' ),
					'center left'   =>  esc_html__( 'Center Left' , 'coiffure' ),
					'center right'  =>  esc_html__( 'Center Right' , 'coiffure' ),
					'top center'    =>  esc_html__( 'Top Center' , 'coiffure' ),
					'top left'      =>  esc_html__( 'Top Left' , 'coiffure' ),
					'top right'     =>  esc_html__( 'Top Right' , 'coiffure' ),
					'bottom center' =>  esc_html__( 'Bottom Center' , 'coiffure' ),
					'bottom left'   =>  esc_html__( 'Bottom Left' , 'coiffure' ),
					'bottom right'  =>  esc_html__( 'Bottom Right' , 'coiffure' ),
				],
			],
		);

		$this->json['selects'] = self::$selects;

		$value = $this->value();

		if ( ! is_array( $value ) ) {
			$value = [];
		}

		if ( ! isset( $value['background-type'] ) ) {
			$value['background-type'] = 'default';
		}

		if ( ! isset( $value['background-gradient'] ) ) {
			$value['background-gradient'] = [
				'color-1'     => '#ffffff',
				'color-2'     => '#ffffff',
				'location-1'  => 0,
				'location-2'  => 100,
				'type'        => 'linear',
				'angle'       => 180,
				'position'    => 'center center',
			];
		}

		$defaults = array(
			'background-image'            => '',
			'background-image-attachment' => '',
			'background-color'            => '#ffffff',
			'background-repeat'           => 'no-repeat',
			'background-attachment'       => 'fixed',
			'background-size'             => 'auto',
			'background-position'         => 'top center',
			'background-type'             => 'default',
			'background-gradient'         => [
				'color-1'     => '#ffffff',
				'color-2'     => '#ffffff',
				'location-1'  => 0,
				'location-2'  => 100,
				'type'        => 'linear',
				'angle'       => 180,
				'position'    => 'center center',
			],

		);

		// if ( ! empty( $value['background-image'] ) && 0 !== ( $bg_image_id = attachment_url_to_postid( $value['background-image'] ) ) ) {
		// 	$value['background-image'] = wp_prepare_attachment_for_js( $bg_image_id );
		// }

		$this->json['default'] = $defaults;

		$this->json['value'] = $value;
	}

	/**
	 * Don't render any content for this control from PHP.
	 *
	 * @since 3.4.0
	 * @since 4.2.0 Moved from WP_Customize_Upload_Control.
	 *
	 * @see WP_Customize_Media_Control::content_template()
	 */
	public function render_content() {}

	/**
	 * Render a JS template for the content of the media control.
	 *
	 * @since 4.1.0
	 * @since 4.2.0 Moved from WP_Customize_Upload_Control.
	 */
	public function content_template() {
		?>
		<label for="{{ data.settings['default'] }}-button">
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>

		<div class="background-type base-control input-control">
			<div class="options">
				<h5>{{ data.option_labels[ 'background-type' ] }}</h5>
			</div>
			<div class="values" data-type="radio">
				<input data-value="background-type" type="radio" name="{{ data.id }}-background-type" {{ data.value['background-type'] === 'default' ? 'checked' : '' }} value="default">Default<br>
				<input data-value="background-type" type="radio" name="{{ data.id }}-background-type" {{ data.value['background-type'] === 'gradient' ? 'checked' : '' }} value="gradient">Gradient<br>
			</div>
		</div>

		<# if ( data.value['background-type'] === 'default' ) { #>

			<# if ( data.show['background-color'] ) { #>
				<div class="background-color base-control color-picker-control">
					<div class="options">
						<h5>{{ data.option_labels[ 'background-color' ] }}</h5>
					</div>
					<div class="values" data-type="color-picker">
						<input data-value="background-color" id="{{ data.id }}-color" type="text" data-default-color="{{ data.default[ 'background-color' ] }}" data-alpha="true" value="{{ data.value[ 'background-color' ] }}" class="vamtam-color-picker" />
					</div>
				</div>
			<# } #>

			<div class="background-image">
				<h5>{{ data.option_labels[ 'background-image' ] }}</h5>
				<# if ( data.value['background-image'] && data.value['background-image-attachment'] ) { #>
					<div class="current">
						<div class="container">
							<div class="attachment-media-view attachment-media-view-{{ data.value['background-image-attachment'].type }} {{ data.value['background-image-attachment'].orientation }}">
								<div class="thumbnail thumbnail-{{ data.value['background-image-attachment'].type }}">
									<# if ( data.value['background-image-attachment'].sizes && data.value['background-image-attachment'].sizes.medium ) { #>
										<img class="attachment-thumb" src="{{ data.value['background-image-attachment'].sizes.medium.url }}" draggable="false" alt="{{ data.alt_medium }}" />
									<# } else if ( data.value['background-image-attachment'].sizes && data.value['background-image-attachment'].sizes.full ) { #>
										<img class="attachment-thumb" src="{{ data.value['background-image-attachment'].sizes.full.url }}" draggable="false" alt="{{ data.alt_full }}" />
									<# } #>
								</div>
							</div>
						</div>
					</div>
					<div class="actions">
						<# if ( data.canUpload ) { #>
						<button type="button" class="button remove-button">{{ data.button_labels.remove }}</button>
						<button type="button" class="button upload-button control-focus" id="{{ data.settings['default'] }}-button">{{ data.button_labels.change }}</button>
						<div style="clear:both"></div>
						<# } #>
					</div>
					<# for ( key in data.selects ) { #>
						<# if ( data.show[ key ] ) { #>
						<!-- Selects -->
						<div class="background-selects base-control select-control">
							<div class="options">
								<h5 class="option-label">{{ data.option_labels[ key ] }}</h5>
							</div>
							<div class="values">
								<select data-value="{{ key }}" id="{{ data.id }}-{{ key }}" data-key="{{ key }}">
									<# _.each( data.selects[ key ], function( val, opt_key ) { #>
										<option {{ data.value[ key ] === opt_key ? 'selected' : '' }} value="{{ opt_key }}">{{ val }}</option>
									<# } ) #>
								</select>
							</div>
						</div>
						<# } #>
					<# } #>
				<# } else { #>
					<div class="current">
						<div class="container">
							<div class="placeholder">
								<div class="inner">
									<span>
										{{ data.button_labels.placeholder }}
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="actions">
						<# if ( data.canUpload ) { #>
						<button type="button" class="button upload-button full-width" id="{{ data.settings['default'] }}-button">{{ data.button_labels.select }}</button>
						<# } #>
					</div>
				<# } #>
			</div>
		<# } else { #>
			<# for (let i = 1; i < 3; i++) { #>
				<div class="background-gradient-color-{{ i }} base-control color-picker-control">
					<div class="options">
						<h5>{{ data.option_labels[ 'background-gradient' ][ 'color-' + i ] }}</h5>
					</div>
					<div class="values" data-type="color-picker">
						<input data-value="background-gradient.color-{{ i }}" type="text" data-default-color="{{ data.default[ 'background-gradient' ][ 'color-' + i ] }}" data-alpha="true" value="{{ data.value[ 'background-gradient' ][ 'color-' + i ] }}" class="vamtam-color-picker" />
					</div>
				</div>
				<div class="background-gradient-location-{{ i }} base-control input-control">
					<div class="options">
						<h5 class="option-label">{{ data.option_labels['background-gradient'][ 'location' ] }}</h5>
					</div>
					<div class="values" data-type="slider">
						<input data-value="background-gradient.location-{{ i }}" type="range" value="{{ parseInt( data.value[ 'background-gradient' ][ 'location-' + i ], 10 ) }}" min="0" max="100" step="1" oninput="jQuery(this).trigger('change');" />
						<input data-value="background-gradient.location-{{ i }}" type="number" value="{{ parseInt( data.value[ 'background-gradient' ][ 'location-' + i ], 10 ) }}" min="0" max="100" step="1" oninput="jQuery(this).trigger('change');" />
					</div>
				</div>
			<# } #>

			<!-- Gradient Type -->
			<div class="background-gradient-type base-control select-control">
				<div class="options">
					<h5 class="option-label">{{ data.option_labels['background-gradient']['type'] }}</h5>
				</div>
				<div class="values">
					<select data-value="background-gradient.type" data-id="vamtam-background-gradient-type-{{{ data.id }}}">
						<option {{ data.value[ 'background-gradient' ][ 'type' ] === 'linear' ? 'selected="1"' : '' }} value="linear">{{ data.l10n[ 'background-gradient' ][ 'type' ][ 'linear' ] }}</option>
						<option {{ data.value[ 'background-gradient' ][ 'type' ] === 'radial' ? 'selected="1"' : '' }} value="radial">{{ data.l10n[ 'background-gradient' ][ 'type' ][ 'radial' ] }}</option>
					</select>
				</div>
			</div>
			<# if ( data.value['background-gradient'][ 'type' ] === 'linear' ) { #>
				<!-- Gradient Angle -->
				<div class="background-gradient-angle base-control input-control">
					<div class="options">
						<h5 class="option-label">{{ data.option_labels['background-gradient'][ 'angle' ] }}</h5>
					</div>
					<div class="values" data-type="slider">
						<input data-value="background-gradient.angle" type="range" value="{{ parseInt( data.value[ 'background-gradient' ][ 'angle' ], 10 ) }}" min="0" max="360" step="1" oninput="jQuery(this).trigger('change');" />
						<input data-value="background-gradient.angle" type="number" value="{{ parseInt( data.value[ 'background-gradient' ][ 'angle' ], 10 ) }}" min="0" max="360" step="1" oninput="jQuery(this).trigger('change');" />
					</div>
				</div>
			<# } else { #>
				<!-- Gradient Position -->
				<div class="gradient-position base-control select-control">
					<div class="options">
						<h5 class="option-label">{{ data.option_labels['background-gradient']['position'] }}</h5>
					</div>
					<div class="values">
						<select data-value="background-gradient.position" data-id="vamtam-background-gradient-position-{{{ data.id }}}">
							<option {{ data.value[ 'background-gradient' ][ 'position' ] === 'center center' ? 'selected="1"' : '' }} value="center center">{{ data.l10n[ 'background-gradient' ][ 'position' ][ 'center center' ] }}</option>
							<option {{ data.value[ 'background-gradient' ][ 'position' ] === 'center left'   ? 'selected="1"' : '' }} value="center left">{{ data.l10n[ 'background-gradient' ][ 'position' ][ 'center left' ] }}</option>
							<option {{ data.value[ 'background-gradient' ][ 'position' ] === 'center right'  ? 'selected="1"' : '' }} value="center right">{{ data.l10n[ 'background-gradient' ][ 'position' ][ 'center right' ] }}</option>
							<option {{ data.value[ 'background-gradient' ][ 'position' ] === 'top center'    ? 'selected="1"' : '' }} value="top center">{{ data.l10n[ 'background-gradient' ][ 'position' ][ 'top center' ] }}</option>
							<option {{ data.value[ 'background-gradient' ][ 'position' ] === 'top left'      ? 'selected="1"' : '' }} value="top left">{{ data.l10n[ 'background-gradient' ][ 'position' ][ 'top left' ] }}</option>
							<option {{ data.value[ 'background-gradient' ][ 'position' ] === 'top right'     ? 'selected="1"' : '' }} value="top right">{{ data.l10n[ 'background-gradient' ][ 'position' ][ 'top right' ] }}</option>
							<option {{ data.value[ 'background-gradient' ][ 'position' ] === 'bottom center' ? 'selected="1"' : '' }} value="bottom center">{{ data.l10n[ 'background-gradient' ][ 'position' ][ 'bottom center' ] }}</option>
							<option {{ data.value[ 'background-gradient' ][ 'position' ] === 'bottom left'   ? 'selected="1"' : '' }} value="bottom left">{{ data.l10n[ 'background-gradient' ][ 'position' ][ 'bottom left' ] }}</option>
							<option {{ data.value[ 'background-gradient' ][ 'position' ] === 'bottom right'  ? 'selected="1"' : '' }} value="bottom right">{{ data.l10n[ 'background-gradient' ][ 'position' ][ 'bottom right' ] }}</option>
						</select>
					</div>
				</div>
			<# } #>
		<# } #>
		<?php
	}

	/**
	 * Sanitize setting value
	 *
	 * @uses shortcode_atts to ensure that a fixed set of properties is saved for this setting
	 */
	public static function sanitize_callback( $value ) {
		// must-have attributes
		$value = shortcode_atts( array(
			'background-image'            => '',
			'background-image-attachment' => '',
			'background-color'            => '',
			'background-repeat'           => '',
			'background-attachment'       => '',
			'background-size'             => '',
			'background-position'         => '',
			'background-type'             => '',
			'background-gradient'         => '',
		), $value );

		// sanitize color, image, type and gradient.
		$value['background-color']                  = sanitize_hex_color( $value['background-color'] );
		$value['background-image']                  = esc_url_raw( $value['background-image'] );
		$value['background-type']                   = $value['background-type'] === 'gradient' ? 'gradient' : 'default';
		$value['background-gradient']['color-1']    = sanitize_hex_color( $value['background-gradient']['color-1'] );
		$value['background-gradient']['color-2']    = sanitize_hex_color( $value['background-gradient']['color-2'] );
		$value['background-gradient']['location-1'] = is_numeric( $value['background-gradient']['location-1'] ) ? $value['background-gradient']['location-1'] : 0;
		$value['background-gradient']['location-2'] = is_numeric( $value['background-gradient']['location-2'] ) ? $value['background-gradient']['location-2'] : 100;
		$value['background-gradient']['angle']      = is_numeric( $value['background-gradient']['angle'] ) ? $value['background-gradient']['angle'] : 180;
		$value['background-gradient']['type']       = $value['background-gradient']['type'] === 'radial' ? 'radial' : 'linear';
		$possible_positions                         = [ 'center center', 'center left', 'center right', 'top center', 'top left', 'top right', 'bottom center', 'bottom left', 'bottom right' ];
		$value['background-gradient']['position']   = in_array( $value['background-gradient']['position'], $possible_positions, true ) ? $value['background-gradient']['position'] : 'center center';

		// sanitize selects
		if ( ! in_array( $value['background-repeat'], array_keys( self::$selects['background-repeat'] ), true ) ) {
			$value['background-repeat'] = 'repeat';
		}

		if ( ! in_array( $value['background-attachment'], array_keys( self::$selects['background-attachment'] ), true ) ) {
			$value['background-attachment'] = 'scroll';
		}

		if ( ! in_array( $value['background-size'], array_keys( self::$selects['background-size'] ), true ) ) {
			$value['background-size'] = 'auto';
		}

		if ( ! in_array( $value['background-position'], array_keys( self::$selects['background-position'] ), true ) ) {
			$value['background-position'] = 'left top';
		}

		return $value;
	}
}
