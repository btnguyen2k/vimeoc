<script type="text/javascript">
	$(document).ready(function(){
		$("#portraitForm").submit(function(){
			function set() {
				$('#upload_frame').attr('src','<:$ctx:>/upload_frame.php?upId=<:$upId:>');
			}
			setTimeout(set);
			$('#upload_frame').show();
			$(this).ajaxSubmit({
				success: function(data){
				}
			});						
		});
	});
</script>
<div id="user_addvideoupload" class="user_page">
	<:include file="<:$base_dir_templates:>/blocks/user_left_menu.tpl":>
	
	<div id="user_addvideoupload_body" class="user_page_body">
		<center><h1><:$title:></h1></center><br/>
		<span class="red"><:$errorMessage:></span>
		<span class="green"><:$successMessage:></span>
		<form action="<:$ctx:>/user/addvideoupload/" id="portraitForm" method="post" enctype="multipart/form-data">
			<fieldset>
				<ul>
					<li>
						<span><:$choose:> </span><br/>	
						<:if $avatar != '':>
						<img src="<:$ctx:>/video/upload/<:$avatar:>" width="50" height="50"/>
						<:else:>
						<img src="<:$ctx:>/video/avatar.png" width="50" height="50"/>
						<:/if:>
						<!--APC hidden field-->
    					<input type="hidden" name="APC_UPLOAD_PROGRESS" id="progress_key" value="<:$upId:>"/>
						<input type="file" name="video" />
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