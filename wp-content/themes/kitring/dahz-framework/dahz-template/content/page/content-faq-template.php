<div class="ds-faq-template">
	<div class="de-faq">
		<div class="de-faq__left">
			<?php
				$menu_name = dahz_framework_get_meta( get_the_ID(), 'dahz_meta_page', 'faq_menu_tab', '' );
				$args = array(
					'menu'       => $menu_name,
					'menu_class' => 'de-faq__menu',
				);
				echo wp_nav_menu( $args );
			?>
		</div>
		<div class="de-faq__right">
			<div class="de-faq__right-inner" data-title="Search">
				<?php echo do_shortcode( the_content() ); ?>
			</div>
		</div>
	</div>
	<div class="de-faq__search-result">
		<div class="de-faq__search-result-inner"></div>
	</div>
</div>