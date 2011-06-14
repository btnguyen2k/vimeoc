<link href="<:$ctx:>/css/video_custom_url.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/video_custom_url.js"></script>
<div id="video_custom_url" class="user_page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
	<div id="video_custom_url_body" class="user_page_body">
		<center><h1><:$videoTitle:> - <:$message_title:></h1></center><br/>		
		<span class="red"><:$errorMessage:></span>
		<span class="green"><:$successMessage:></span>
		<form action="" method="post" onsubmit="return checkVideoCustomUrl(this);">
			<fieldset>
				<ul>
					<li>
						<span><:$chooseYourCustomUrl:></span><br/>
						<:$domain:>/<:$user_alias:>/<input id="url_alias" name="url_alias" value="<:$video_alias:>" maxlength="32"/>
						<input type="hidden" id="videoId" name="videoId" value="<:$videoId:>"></input>
						<span class="red" id="error_valid_alias" style="display: none;"><:$message_invalid_url:></span>		
					</li>
					<li>
						Preview url: <a href="<:$previewUrl:>"><:$previewUrl:></a>
					</li>
					<li>
						<input type="submit" value="Save" />
					</li>
				</ul>				
			</fieldset>
		</form>
	</div>
	
	<div id="user_info_help" class="user_page_help">
		Help?<div><:$message_url_hint:></div>
	</div>
</div>