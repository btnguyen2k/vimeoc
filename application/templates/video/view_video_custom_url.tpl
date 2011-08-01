<link href="<:$ctx:>/css/video_custom_url.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	invalid_url_message = '<:$message_invalid_url:>';
</script>
<script type="text/javascript" src="<:$ctx:>/script/video_custom_url.js"></script>
<script type="text/javascript">
	function checkUrl(form){
		var url = $(form).find("input[name=url_alias]").val();
		if(url == '')
		{
			$("#error_valid_alias").show();		
			return false;
		}else{
			$("#error_valid_alias").hide();
		}

		if(url==$('#videourl').val()){
			return false;
		}

		var flag = shortcutReg.test(url) && url.length <= 32;

		if(!flag){
			$("#error_message").hide();					
			$("#info_message").hide();
			$("#error_valid_alias").show();			
			return false;
		}else{
			$("#error_valid_alias").hide();
			return true;
		}
	}
</script>
<div id="video_custom_url" class="page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
	<div id="video_custom_url_body" class="page_body">
		<center><h1><:$videoTitle|escape:'html':> - <:$title:></h1></center><br/>		
		<span id="error_message" class="red"><:$errorMessage:></span>
		<span id="info_message" class="green"><:$successMessage:></span>
		<form action="<:$ctx:>/video/customUrl/" method="post" onsubmit="return checkUrl(this);">
			<fieldset>
				<ul>
					<li>
						<span><:$chooseYourCustomUrl:></span><br/>
						<:$domain:>/<:$user_alias|escape:'html':>/<input id="url_alias" name="url_alias" value="<:$video_alias:>" maxlength="32"/>
						<span class="red" id="error_valid_alias" style="display: none;">Invalid shortcut</span>						
					</li>
					<li>
						Preview url: <a href="<:$previewUrl:>"><:$previewUrl:></a>
					</li>
					<li>
						<input type="submit" value="Save" />
						<input type="hidden" id="videoId" name="videoId" value="<:$videoId:>" />		
						<input type="hidden" id="videourl" name="videourl" value="<:$video_alias:>" />
					</li>
				</ul>				
			</fieldset>
		</form>
	</div>
	
	<div id="user_info_help" class="page_help">
		Help?<div><:$message_url_hint:></div>
	</div>
</div>