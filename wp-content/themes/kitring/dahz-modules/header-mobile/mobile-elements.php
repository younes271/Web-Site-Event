<?php
	
 ?>
 
<a href="#offcanvas-usage" data-uk-toggle><?php esc_html_e( 'Open', 'kitring' );?></a>

<div id="offcanvas-usage" data-uk-offcanvas>
	<div class="uk-offcanvas-bar">
		<button class="uk-offcanvas-close" type="button" data-uk-close></button>
		<?php echo apply_filters( 'dahz_framework_mobile_menu_elements', $elements );?>
	</div>
</div>
