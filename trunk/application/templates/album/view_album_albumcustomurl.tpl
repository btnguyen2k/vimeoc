<script type="text/javascript">
	function checkUrl(form){
	var regex = /^[a-zA-Z0-9]{1,32}$/;
	var url = $(form).find("input[name=url]").val();		

	var flag = regex.test(url) && url.length <= 32;
	
	if(!flag){
		$("#error_valid_url").show();
		return false;
	}else{
		$("#error_valid_url").hide();
		return true;
	}
}

</script>

<div id="album_customURL" class="album_page">
<div>
	<:if $albumThumbnail != '':>
		<img src="<:$ctx:><:$albumThumbnail:>" />
	<:else:>
		<img src="<:$ctx:>/images/icon-video.gif" width="100"/>
	<:/if:>
</div>
	<:include file="<:$base_dir_templates:>/blocks/album_left_menu.tpl":>	
	<div id="album_albumcustomURL_body" class="album_page_body">
		<center><h1><:$albumName:><:$title:></h1></center>
			<:if $successMessage eq "":>
  				 &nbsp;
			<:else:>
   				<span class="green" align="center"><:$successMessage:></span>
			<:/if:>
		<form action="<:$ctx:>/album/albumCustomUrl/?albumId=<:$albumId:>" method="post" name="albumCustomUrl" onsubmit="return checkUrl(this);">
			<fieldset>
				<ul>
					<li>
						<span ><:$name:></span>
					</li>
					<li>
						<input type="text" id="url" name="url" value="<:$albumCustomUrl:>"/>
						<span class="red" id="error_valid_url" style="display: none;">Invalid shortcut</span>
					</li>
					<li>
						<span><:$preview:> </span>
					</li>
					<li>
						<span><a href="#">http://domain.com/<:$fullName:>/<:$albumCustomUrl:></a></span>
					</li>
					<li>
						<input type="submit" value="Save"/>
					</li>
					<li>
						<input type="hidden" id="albumId" name="albumId" value="<:$albumId:>" /> 
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
	<div id="user_info_help" class="user_page_help">
		Help?<div><:$hint:></div>
	</div>
</div>
