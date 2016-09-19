jQuery(document).on('ready', function() {
		jQuery('a[href="#compare-results"]').on('click', function() {

		$this = jQuery(this);
		$file_path = $this.parent().parent().find('.file_path').text();

		jQuery('#compare-container').fadeOut();
		$this.attr('disabled', 'disabled');

		var data = {
			'action': 'umbrella_compare_file',
			'file_path': $file_path
		};

		jQuery.post(ajaxurl, data, function(response) {
			jQuery('#compare-results-data').html(response);
			jQuery('#compare-container').fadeIn();
			jQuery('#file_path_header').text($file_path);
			jQuery('table.diff colgroup').remove();
			jQuery('table.diff').prepend('<colgroup><col class="content diffsplit left"><col class="content diffsplit right"></colgroup>');
			jQuery('.diffDeleted').addClass('diff-deletedline');
			jQuery('.diffInserted').addClass('diff-addedline');
			location.href='#compare-results';
			$this.removeAttr('disabled');
		});

		return false;
	});
});

jQuery("#startscanner").on('click', function() {

	$ = jQuery;
	$console = $('#umbrella-scan-console');
	$('#umbrella-scan-console button').attr('disabled', 'disabled').removeClass('button-primary');
	$('#umbrella-scan-console button .label').text('Scanning core files and folders');
	$('.scanner-ajax-loader').fadeIn();

	$thelist = $('#the-list');

	$('#no-errors-found').fadeOut();
	$('#filescanner').fadeOut();
	$('#latest-results').fadeOut();
	$('tbody').empty();

	var data = {
		'action': 'umbrella_filescan',
		'whatever': 1234
	};

	$.post(ajaxurl, data, function(response) {

		$('#umbrella-scan-console button .label').text('Scan core files');

		console.log(response);
		
		var fileslist = JSON.parse(response);

		$('#umbrella-scan-console button').removeAttr('disabled').addClass('button-primary');
		$('.scanner-ajax-loader').fadeOut();

		// If no errors is found.
		if (fileslist.length == 0)
			$('#no-errors-found').fadeIn();

		else {
			location.href='admin.php?page=umbrella-scanner';
		}

		
	});

});

function umbrella_check_file( file, percent, index)
{
	$.get( "admin.php?page=umbrella-scanner&action=check_file&file=" + file, function( data ) {
		
		$console.text("Scanning: " + file);
		$("#progress" + percent).css('visibility', 'visible');
		var obj = JSON.parse(data);
		var buttons = "";

		if(obj.error)
		{

			if (obj.buttons) {

				for (var i = obj.buttons.length - 1; i >= 0; i--) {
					buttons += '<a href="' + obj.buttons[i].href + '" class="button">' + obj.buttons[i].label + '</a>';
				};
				
			}

			$thelist.append("<tr class='alternate'><td><strong>"+obj.error.msg+"</strong><br><small>#"+obj.error.code+"</small></td><td>"+obj.file+"</td><td>"+buttons+"</td></tr>");
		}

	});
}