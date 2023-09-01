<form role="search" method="get" id="searchform" class="searchform product-search" action="<?php echo home_url( '/' ); ?>">
    <div class="search-form">
        <input type="text" onfocus="if (this.value == '<?php echo esc_html__("Blog Search...", "barber") ?>') {this.value = '';}" onblur="if (this.value == '')  {this.value = '<?php echo esc_html__("Blog Search...", "barber") ?>';}" value="<?php echo esc_html__("Blog Search...", "barber") ?>" name="s" id="s" placeholder="Blog Search..."/>
        <button type="submit" id="searchsubmit" class="button btn-search"><i class="fa fa-search" aria-hidden="true"></i></button>
    </div>
</form>