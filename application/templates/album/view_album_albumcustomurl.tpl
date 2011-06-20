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
		<center><h1></h1></center>
		<form action="<:$ctx:>/album/albumCustomUrl/?albumId=<:$albumId:>" method="post" name="albumCustomUrl" >
			<fieldset>
				<ul>
				
				</ul>
			</fieldset>
		</form>
	</div>
	<div id="user_info_help" class="user_page_help">
		Help?<div><:$hint:></div>
	</div>
</div>
