jQuery(function($) {

	$(document).ready(function() {
		$("#plugin-load-order").sortable({
			items: 'li',
			cursor: 'move',
			axis: 'y',
			containment: '#plugin-load-order',
			stop: function(ev,ui) {
				css_plugin_load_order_activity_spinner(true);
				var rows = new Array([]);

				$('ul#plugin-load-order > li').each(function(i,el) {
					rows[i] = $(el).attr('data-plugin-path');
				});
console.log('before:'); console.log(rows);
				$.post(ajaxurl,{'rows': rows,'action': 'change_plugin_load_order'},function(response) {
					css_plugin_load_order_activity_spinner(false);
					console.log('response:'); console.log(response);
				});
			}
		});
	});

	function css_plugin_load_order_activity_spinner(status) {
		if (status === true)
			$("h2").find('.spinner').show().css('display','inline-block');
		else
			$("h2").find('.spinner').hide();
	}

});