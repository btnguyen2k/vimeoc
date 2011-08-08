$(document).ready(function(){
	$('#album_arrange_form select').change(function(){
		$.ajax({ 
			type: "POST", 
			url: $('#album_arrange_form').attr('action'), 
			data: 'albumId=' + $('#albumId').val() + '&sort=' + $('#sort').val(), 
			dataType: 'xml',
			success: function(msg){
				error = $(msg).find('result error').text();
				if(error == '0'){
					$('#video_list').html($(msg).find('result message').text());
					$('.relative_time').each(function(){
						$(this).html(relativeTime($(this).html()));
					});
				}
			},
			error: function(msg){
				//alert(0);
			},
		});
	 });
	$('.relative_time').each(function(){
		$(this).html(relativeTime($(this).html()));
	});
	$('#info_message').ajaxStart(ajax_start);
	$('#info_message').ajaxStop(ajax_stop);
});
function ajax_start(){
    $('#info_message').html('Sorting, please wait...');
}
function ajax_stop(){
    $('#info_message').html('Sort done! Click "Save" to save the setting.');
}