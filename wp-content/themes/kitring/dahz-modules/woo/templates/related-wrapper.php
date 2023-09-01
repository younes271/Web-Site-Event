<?php
	/*
	stored variable
		current_id : current product id
		total_product : total product to render
		total_column : total column per row
	*/
?>
<section 
	class="related de-related__wrapper uk-position-relative uk-margin" 
	data-upsell-ids="<?php echo esc_attr( json_encode( $upsell_ids ) );?>" 
	data-product-id="<?php echo esc_attr( $product_id );?>" 
	data-related-is-lazyload="false"
>
</section>