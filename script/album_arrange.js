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
					var text = $(msg).find('result message').text();						
					$('#video_list').html(text);
					$('#info_message').html('Done');
				}
			},
			error: function(msg){
				$('#info_message').html('');
			},
		});
	 });
});
