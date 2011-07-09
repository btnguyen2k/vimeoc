function showErrorMessage(msg){
	$('#error_message').html(msg);
	$('#info_message').html('');
}
function showInfoMessage(msg){
	$('#info_message').html(msg);
	$('#error_message').html('');
}
$(document).ready(function(){
	$("#video_thumbnail_form").submit(function(){
		if($('#thumbnail_image').val() == ''){
			showErrorMessage('Please select file to upload.');
			return false;
		}
		function set() {
			$('#upload_frame').attr('src',$('#ctx').val() + '/upload_frame.php?upId=' + $('#APC_UPLOAD_PROGRESS').val());
		}
		setTimeout(set);
		$('#upload_frame').show();
		$(this).ajaxSubmit(function(json){
			var data = eval('('+json+')');
			$('#APC_UPLOAD_PROGRESS').val(data.upId);
			$('#thumbnail_image').val('');
			if(data.status == 1){
				showInfoMessage(data.successMessage);
				$("#thumbnail").attr("src", data.thumbnail);
				$("#menu_video_thumbnail").attr("src", data.thumbnail);
				$('#upload_frame').hide('slow');
			}else{
				showErrorMessage(data.errorMessage);
				$('#upload_frame').hide();
			}
		});
		return false;
	});
});