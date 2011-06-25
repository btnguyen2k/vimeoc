/*$(document).ready(function(){
	 var options = { 
		target:        '#video_list',   // target element(s) to be updated with server response 
		//beforeSubmit:  showRequest,  // pre-submit callback 
		success:       showResponse  // post-submit callback 
	 }; 
	 $('#album_arrange_form select').change(function(){
		 $('#album_arrange_form').ajaxSubmit(function(data){
			 //$('#video_list').html(data);
		 });
	 });
});
function showResponse(responseText, statusText, xhr, $form){
//    alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + 
//        '\n\nThe output div should have already been updated with the responseText.'); 
	return false;
}*/

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
	$('#info_message').html('Processing...');
}
function ajax_stop(){
	$('#info_message').html('');
}