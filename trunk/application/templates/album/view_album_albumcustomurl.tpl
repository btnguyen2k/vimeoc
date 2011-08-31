<script type="text/javascript">
function checkUrl(form){
	var url = $(form).find("input[name=url]").val();
	var link = "<:$domain:>/";
	var flag = shortcutReg.test(url) && url.length <= 16;

	if(url == '')
	{
		$("#error_valid_url").show();
		return false;
	}else{
		$("#error_valid_url").hide();
	}

	if(url==$('#albumCustom').val())
	{
		return false;
	}

	if(!flag){
		$("#error_message").hide();
		$("#info_message").hide();
		$("#error_valid_url").show();
		return false;
	}else{
		$("#error_valid_url").hide();
		return true;
	}
}

</script>

<div id="album_customURL" class="page">
	<:include file="<:$base_dir_templates:>/blocks/album_left_menu.tpl":>
	<div id="album_albumcustomURL_body" class="page_body">
		<center><h1><:$albumName|escape:'html':><:$title:></h1></center>
			<:if $successMessage eq "":>
  				 &nbsp;
			<:else:>
   				<span id="info_message" class="green" align="center"><:$successMessage:></span>
			<:/if:>

			<:if $errorMessage eq "":>
  				 &nbsp;
			<:else:>
   				<span class="red" id="error_message" align="center"><:$errorMessage:></span>
			<:/if:>
		<form action="<:$ctx:>/album/albumCustomUrl/?albumId=<:$albumId:>" method="post" name="albumCustomUrl" onsubmit="return checkUrl(this);">
			<fieldset>
				<ul>
					<li>
						<span ><:$name:></span>
					</li>
					<li>
						<:$domain:>/<input type="text" id="url" name="url" value="<:$albumCustomUrl|escape:'html':>" maxlength="32"/>
						<span class="red" id="error_valid_url" style="display: none;"><:$messages['album.customURL.invalid']:></span>
					</li>
					<li>
						<span><:$preview:> </span>
					</li>
					<li>
						<span><a id="link" href="<:$previewUrl:>"><:$previewUrl:></a></span>
					</li>
					<li>
						<input type="submit" value="Save"/>
					</li>
					<li>
						<input type="hidden" id="albumId" name="albumId" value="<:$albumId:>" />
						<input type="hidden" id="albumCustom" name="albumCustom" value="<:$albumCustomUrl|escape:'html':>" />
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
	<div id="user_info_help" class="page_help">
		<:$help:><div><:$hint:></div>
	</div>
</div>
