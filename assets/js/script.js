jQuery(function($) {
	if ($('#gd_make_duplicates').length) {
		$("#gd_make_duplicates").on("click", function(e) {
		  geodir_multilingual_wpml_duplicate(this, e);
		});
	}
});

function geodir_multilingual_wpml_duplicate( el, e ) {
    var $btn = jQuery(el);
	var $table = jQuery(el).closest('.gd-duplicate-table');
	var nonce = jQuery(el).data('nonce');
	var post_id = jQuery(el).data('post-id');
	var dups = [];
	jQuery.each(jQuery('input[name="gd_icl_dup[]"]:checked', $table), function() {
		dups.push(jQuery(this).val());
	});
	if (!dups.length || !post_id) {
		jQuery('input[name="gd_icl_dup[]"]', $table).focus();
		return false;
	}
	var data = {
		action: 'geodir_wpml_duplicate',
		post_id: post_id,
		dups: dups.join(','),
		security: nonce
	};
	jQuery.ajax({
		url: geodir_params.ajax_url,
		data: data,
		type: 'POST',
		cache: false,
		dataType: 'json',
		beforeSend: function(xhr) {
			jQuery('.fa-refresh', $table).show();
			$btn.attr('disabled', 'disabled');
		},
		success: function(res, status, xhr) {
			if (typeof res == 'object' && res) {
				if (res.data.message) {
					alert(res.data.message);
				}
				if (res.success) {
					window.location.href = document.location.href;
					return;
				}
			}
		}
	}).complete(function(xhr, status) {
		jQuery('.fa-refresh', $table).hide();
		$btn.removeAttr('disabled');
	});
}