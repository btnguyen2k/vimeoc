<script type="text/javascript">
function checkValidForm()
{
	
	if($("#title").val()==""){
		$("#title").val("Untitled");
	}

	if($("#description").val()==""){
		$("#error_valid_description").show();
		return false;
	}else{
		$("#error_valid_description").hide();
	}	
}
</script>
<div id="channel_create" class="page">
	<:include file="<:$base_dir_templates:>/blocks/channel_left_menu.tpl":>	
	<div id="channel_channelcreate_body" class="page_body">
		<center><h1><:$title_|escape:'html':>-<:$name:></h1></center>
		<span class="green" align="center"><:$successMessage:></span>
		<form action="<:$ctx:>/channel/channelSetting/?channelId=<:$channelId:>" method="post" name="channelcreate" onSubmit="return checkValidForm(this)" >
			<fieldset>
				<ul>
					<li>
						<span><:$title:></span><br/>
					</li>
					<li>
						<input type="text" name="title" id="title" value="<:$title_:>"/> <br/>
					</li>
					<li>
						<span><:$description:></span><br/>
					</li>
					<li>
						<textarea name="description" id="description" cols="30" rows="5"><:$description_:></textarea>
						<span class="red" id="error_valid_description" style="display: none;"><:$errorDescription:></span>
					</li>
					<li>
						<input type="submit" value="Save"/>
						<input type="hidden" id="channelId" name="channelId" value="<:$channelId:>" />
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
	<div id="user_info_help" class="page_help">
		Help?<div><:$hint:></div>
	</div>
</div>		
		