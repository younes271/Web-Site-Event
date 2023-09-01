<?php
if( !class_exists( 'Dahz_Framework_Lazyload' ) ){

	Class Dahz_Framework_Lazyload {
		
		public $placeholder = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAFoEvQfAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA4RpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTExIDc5LjE1ODMyNSwgMjAxNS8wOS8xMC0wMToxMDoyMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDowOTk4N2QyNS05ZmFkLTJhNDQtOGY1ZS1kMjMzZjk4NDA1N2IiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6ODM0QkY4N0RGOEIwMTFFNkJGMTI4Q0NFQURDNkZDMEMiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6ODM0QkY4N0NGOEIwMTFFNkJGMTI4Q0NFQURDNkZDMEMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MDk5ODdkMjUtOWZhZC0yYTQ0LThmNWUtZDIzM2Y5ODQwNTdiIiBzdFJlZjpkb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6NGI1ZWJlZDctZjhiMC0xMWU2LTg3ZjAtZDE4OTI4MzI3NzFmIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+/GQgSgAAAA1JREFUeNpjOHjwIC8ABtsCUaEjc34AAAAASUVORK5CYII=";

        public function __construct(){

            add_filter( 'body_class', array( $this, 'dahz_framework_lazy_load_class' ) );
			
            add_filter( 'wp_get_attachment_image_attributes', array( $this, 'dahz_framework_lazy_load' ), 9999, 3 );
			
			add_action( 'dahz_framework_module_lazy-load_init', array( $this, 'dahz_framework_lazy_load_init' ) );
			
			add_filter( 'dahz_framework_default_styles', array( $this, 'dahz_framework_lazyload_style' ) );

        }
				
		private function dahz_framework_is_lazy_load(){
			
			return !is_admin() && dahz_framework_get_option( 'global_enable_lazy_load', false ) && !isset( $_GET['vc_action'] ) && !isset( $_POST['vc_inline'] );
			
		}

		public function dahz_framework_lazy_load_init( $path ){

			if( is_customize_preview() ){

				dahz_framework_include( $path . '/lazy-load-customizers.php' );

			}

		}

        public function dahz_framework_lazy_load_class( $classes ){

			$value = '';

			if( $this->dahz_framework_is_lazy_load() ){

				$value = 'de-is-lazyload-image';

			}

			return array_merge( $classes, array( $value ) );

		}

		public function dahz_framework_lazy_load( $attr, $a, $size ){

            if( $this->dahz_framework_is_lazy_load() ){
				
				if( isset( $attr['data-is-ignore-lazyload'] ) ){
					return $attr;
				}
				
				$attr['data-uk-img'] = '';
				
				$attr['class'] = $attr['class'] . ' ds-lazy-image';
				
				if( isset( $attr['src'] ) ){
					$attr['data-src'] = $attr['src'];
					$attr['src'] = $this->placeholder;			
				}
                

				if ( isset( $attr['srcset'] ) ) {
					$attr['data-srcset'] = $attr['srcset'];
					unset( $attr['srcset'] );
				}
				
				if ( isset( $attr['sizes'] ) ) {
					$attr['data-sizes'] = $attr['sizes'];
					unset( $attr['sizes'] );
				}

            }

            return $attr;

        }
		
		public function dahz_framework_lazyload_style( $default_styles ){
			
			$default_styles .= sprintf(
				'
				img[data-src][src*="data:image"]{background:%1$s;}
				',
				dahz_framework_get_option( 'global_lazy_load_placeholder_color', 'rgba(0,0,0,0.1)' )
			);
			
			return $default_styles;
			
		}

	}

    new Dahz_Framework_Lazyload();

}
