<script type="text/javascript">
	$(document).ready(function(){
		var imageExtArray = new Array(".jpg", ".png", ".gif");
		var upId = '<:$upId:>';
		var imageContext = '<:$ctx:>/images/upload/';
		$("#videoForm").submit(function(){
			if($(this.portrait).val() == ''){
				$("#error_file").show();
			}else{
				if(limitAttach(this, this.portrait.value, imageExtArray)){
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
						
						if(data.status == 1){
							$("#top_error").hide();
							$("#top_success").html(data.successMessage).show();
							$(".userAvatar").attr("src", imageContext+data.avatar);
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
<div id="user_portrait" class="user_page">
	<:include file="<:$base_dir_templates:>/blocks/user_left_menu.tpl":>
	
	<div id="user_portrait_body" class="user_page_body">
		<center><h1><:$title:></h1></center><br/>		
		<span class="red" id="top_error"><:$errorMessage:></span>
		<span class="green" id="top_success"><:$successMessage:></span>
		<form action="<:$ctx:>/user/portrait/" id="videoForm" method="post" enctype="multipart/form-data">
			<fieldset>
				<ul>
					<li>
						<span><:$currentPortrait:></span><br/>
						<:if $avatar != '':>
						<img class="userAvatar" src="<:$ctx:>/images/upload/<:$avatar:>" width="50" height="50"/>
						<:else:>
						<img class="userAvatar" src="<:$ctx:>/images/avatar.png" width="50" height="50"/>
						<:/if:>
					</li>
					<li>
						<span><:$uploadNew:></span>*<br/>
						<!--APC hidden field-->
    					<input type="hidden" name="APC_UPLOAD_PROGRESS" id="progress_key" value="<:$upId:>"/>
						<input type="file" name="portrait"/><br/>
						<span style="display: none" class="red" id="error_file"><:$requiredFields:></span>
						<span style="display: none" class="red" id="notSupportExt"><:$requiredFields:></span>
					</li> 
					<li>
						<input type="submit" value="Upload" />
					</li>
				</ul>				
			</fieldset>
		</form>
		<iframe id="upload_frame" name="upload_frame" frameborder="0" border="0" src="" scrolling="no" scrollbar="no" > </iframe>
	</div>
	
	<div id="user_info_help" class="user_page_help">
		Help?
	</div>
</div>