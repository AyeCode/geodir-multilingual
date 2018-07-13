jQuery(function($) {
	if ($('#gd_make_duplicates').length) {
		$("#gd_make_duplicates").on("click", function(e) {
		  geodir_multilingual_wpml_duplicate(this, e);
		});
	}
	if ($('#geodir_copy_from_original').length && $('input#icl_cfo').length) {
		var lang, trid;
		lang = $('#geodir_copy_from_original').data('source_lang');
		trid = $('#geodir_copy_from_original').data('trid');
		if (lang && trid) {
			$("input#icl_cfo").on("click", function(e) {
			  setTimeout(function() {
				geodir_multilingual_wpml_copy_from_original(this, lang, trid, e);
			  }, 2000);
			});
		}
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

function geodir_multilingual_wpml_copy_from_original( el, lang, trid, e ) {
    var $el
	$el	= jQuery(el);
	var $form = jQuery('#geodir_post_info').closest('form');
	
	//has visual = set to normal non-html editing mode
    var ed;
    var content_type = (typeof tinyMCE !== 'undefined' && ( ed = tinyMCE.get('content') ) && !ed.isHidden() && ed.hasVisual === true) ? 'rich' : 'html';
    var excerpt_type = (typeof tinyMCE !== 'undefined' && ( ed = tinyMCE.get('excerpt') ) && !ed.isHidden() && ed.hasVisual === true) ? 'rich' : 'html';

	// figure out all available editors and their types
	jQuery.ajax({
		type:     "POST",
		dataType: 'json',
		url:      icl_ajx_url,
		data:     "icl_ajx_action=copy_from_original&lang=" + lang + '&trid=' + trid + '&content_type=' + content_type + '&excerpt_type=' + excerpt_type + '&_icl_nonce=' + jQuery('#_icl_nonce_cfo_' + trid).val() + '&has_gd=1',
		success:  function (msg) {
			console.log(msg);

			if (!msg.error) {
				try {
					if (msg.content) {
						if (typeof tinyMCE !== 'undefined' && ( ed = tinyMCE.get('content') ) && !ed.isHidden()) {
							ed.focus();
							if (tinymce.isIE) {
								ed.selection.moveToBookmark(tinymce.EditorManager.activeEditor.windowManager.bookmark);
							}
							ed.execCommand('mceInsertContent', false, msg.content);
						} else {
							wpActiveEditor = 'content';
							edInsertContent(edCanvas, msg.content);
						}
					}
					if (typeof msg.title !== "undefined") {
						jQuery('#title-prompt-text').hide();
						jQuery('#title').val(msg.title);
					}

					for (var element in msg.builtin_custom_fields) {
						var ele = msg.builtin_custom_fields[element];
						if (msg.builtin_custom_fields.hasOwnProperty(element) && msg.builtin_custom_fields[element].editor_type === 'editor') {
							if (typeof tinyMCE !== 'undefined' && ( ed = tinyMCE.get(msg.builtin_custom_fields[element].editor_name) ) && !ed.isHidden()) {
								ed.focus();
								if (tinymce.isIE) {
									ed.selection.moveToBookmark(tinymce.EditorManager.activeEditor.windowManager.bookmark);
								}
								ed.execCommand('mceInsertContent', false, msg.builtin_custom_fields[element].value);
							} else {
								wpActiveEditor = msg.builtin_custom_fields[element].editor_name;
								edInsertContent(edCanvas, msg.builtin_custom_fields[element].value);
							}
						} else {
							var name = ele.editor_name;
							var type = ele.editor_type;
							var value = ele.value;
							if (type == 'checkbox') {
								var value = parseInt(value) > 0 ? 1 : 0;
								jQuery('input[name="' + name + '"]').val(value);
								var el = jQuery('input[name="' + name + '"][value="' + value + '"]', $form);
								if (jQuery(el).prop('type') == 'checkbox') {
									jQuery(el).prop('checked', value);
								} else {
									jQuery(el).closest('.geodir_form_row').find('input[type="checkbox"]').prop('checked', value);
								}
								jQuery('input[name="' + name + '"][value="' + value + '"]', $form);
							} else if (type == 'radio') {
								jQuery('input[name="' + name + '"][value="' + value + '"]', $form).prop('checked', true);
							} else if (type == 'select') {
								jQuery('[name="' + name + '"]+').val(value);
							} else if (type == 'multiselect') {
								jQuery('[name="' + name + '[]"]+').val(value);
							} else {
								jQuery('#' + name).val(value);
							}
						}
					}
					$form.find('select').trigger("change.select2");
				} catch (err) {
					console.log(err);
				}
			} else {
				console.log(msg.error);
			}
		}
	});

	return false;
}