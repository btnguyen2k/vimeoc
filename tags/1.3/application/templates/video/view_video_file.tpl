<script type="text/javascript">
	$(document).ready(function(){
		var videoExtArray = '<:$videoExtSupport:>'.split(",");
		var upId = '<:$upId:>';
		$("#videoForm").submit(function(){
			var form = this;
			if($(form.video).val() == ''){
				$("#error_file").show();				
			}else{
				if(limitAttach(form, form.video.value, videoExtArray)){
					$("#error_file").hide();
					function set() {
						$('#upload_frame').attr('src','<:$ctx:>/upload_frame.php?upId='+upId);
					}
					setTimeout(set);
					$('#upload_frame').show();
					$("#videoForm").ajaxSubmit(function(json){
						var data = eval('('+json+')');
						$("#progress_key").val(data.upId);
						upId = data.upId;
						form.video.value = '';
						
						if(data.status == 1){
							$("#top_error").hide();
							$("#top_success").html(data.successMessage).show();
							$('#upload_frame').hide('slow');
						}else{
							$("#top_success").hide();
							$("#top_error").html(data.errorMessage).show();
							$('#upload_frame').hide();
						}
					});
				}
			}
			return false;
		});
	});
</script>
<div id="video_custom_url" class="page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
	<div id="video_file_body" class="page_body">
		<center><h1><:$videoTitle:> - <:$message_title:></h1></center><br/>		
		<span class="red" id="top_error"><:$errorMessage:></span>
		<span class="green" id="top_success"><:$successMessage:></span>
		<form action="<:$ctx:>/video/updateVideoFile/" id="videoForm" method="post" enctype="multipart/form-data">
			<fieldset>
				<ul>
					<li>
						<span><:$choose:> </span><br/>	
						<!--APC hidden field-->
    					<input type="hidden" name="APC_UPLOAD_PROGRESS" id="progress_key" value="<:$upId:>"/>
    					<input type="hidden" name="videoId" value="<:$videoId:>"/>
						<input type="file" name="video" /><br/>
						<span style="display: none" class="red" id="error_file"><:$requiredFields:></span>
						<span style="display: none" class="red" id="notSupportExt"><:$videoExtSupport:></span>
					</li>
					<li>
						<input type="submit" value="Upload" />
					</li>
				</ul>
			</fieldset>		
		</form>
		<iframe id="upload_frame" name="upload_frame" frameborder="0" border="0" src="" scrolling="no" scrollbar="no" > </iframe>
	</div>
	
	<div id="user_info_help" class="page_help">
		Help?<div><:$message_url_hint:></div>
	</div>
</div>