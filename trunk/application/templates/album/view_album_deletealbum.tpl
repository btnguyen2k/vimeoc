<div id="album_delete" class="album_page">
<div>
	<:if $albumThumbnail != '':>
		<img src="<:$ctx:><:$albumThumbnail:>" />
	<:else:>
		<img src="<:$ctx:>/images/icon-video.gif" width="100"/>
	<:/if:>
</div>
	<:include file="<:$base_dir_templates:>/blocks/album_left_menu.tpl":>	
	<div id="album_albumdelete_body" class="album_page_body">
		<center><h1><:$albumName:>-<:$name:></h1></center>
		<form action="<:$ctx:>/album/albumDelete/?albumId=<:$albumId:>" method="post" name="albumDelete" >
			<fieldset>
				<ul>
					<li>
						<span ><center><:$question:></span></center><br/>
					</li>
					<li>
						<center>
							<input type="submit" value="Yes"  />
							<input type="button" value="No" onClick="window.location.href='<:$ctx:>/album/albumsetting/?albumId=<:$albumId:>'">
						</center>
						
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