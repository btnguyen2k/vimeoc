<div id="album_password" class="album_page">
<div>
	<:if $albumThumbnail != '':>
		<img src="<:$ctx:><:$albumThumbnail:>" />
	<:else:>
		<img src="<:$ctx:>/images/icon-video.gif" width="100"/>
	<:/if:>
</div>
	<:include file="<:$base_dir_templates:>/blocks/album_left_menu.tpl":>	
	<div id="album_albumpassword_body" class="album_page_body">
		<center><h1><:$albumName:>-<:$name:></h1></center>
		<form action="<:$ctx:>/album/albumPassword/?albumId=<:$albumId:>" method="post" name="albumPassword" >
			<fieldset>
				<ul>
					<li>
						<input type="checkbox" id="passwordCheck" name="passwordCheck" />
						<span><:$protected:></span><br/>
					</li>
					<li>
						<input type="text" id="password" name="password"  />
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