jQuery(document).on("click",".bpa_bring_anyone_error_notice .notice-dismiss",function(n){var i=jQuery(this).parent().data("bookingpress_confirm");if(!confirm(i))return n.preventDefault(),!1;jQuery.ajax({type:"POST",url:appoint_ajax_obj.ajax_url,data:{action:"bookingpress_dismisss_pro_admin_notice"}})});