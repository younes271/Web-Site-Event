<?php
	/*
	stored variable
		current_id : current product id
		total_product : total product to render
		total_column : total column per row
	*/
?>
<div 
	class="de-upsells__wrapper uk-position-relative uk-margin" 
	data-upsell-ids="<?php echo esc_attr( json_encode( $upsell_ids ) );?>" 
	data-upsell-is-lazyload="true"
>
</div>