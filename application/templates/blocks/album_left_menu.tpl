<div id="album_menu">
	<:if $show_user_avatar == 1:>
	<ul class="portrait">
		<li>			
			<a href="<:$ctx:>/">
			<:if $userAvatar != null:>
			<img class="userAvatar" src="<:$ctx:>/images/upload/<:$userAvatar:>" width="50" height="50"/>
			<:else:>
			<img class="userAvatar" src="<:$ctx:>/images/icon-video.gif" width="50" height="50"/>
			<:/if:>
			</a>
		</li>
	</ul>
	<:/if:>
	<:if $show_user_avatar != 1:>
	<ul id="album_thumb">
		<li>
		<:if $albumThumbnail != '':>
			<img src="<:$ctx:><:$albumThumbnail:>" width="100"/>
		<:else:>
			<img src="<:$ctx:>/images/icon-video.gif" width="100"/>
		<:/if:>
		</li>
	</ul>
	<:/if:>
	<ul>
		<li>
			<a href="<:$ctx:>/album/albumsetting/?albumId=<:$albumId:>"><:$menubasicinfoAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/album/albumthumbnail/?albumId=<:$albumId:>"><:$menuthumbnailAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/album/arrange/?albumId=<:$albumId:>"><:$menuarrangeAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/album/albumCustomUrl/?albumId=<:$albumId:>"><:$menuCustomUrlAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/album/albumPassword/?albumId=<:$albumId:>"><:$menupasswordAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/album/albumDelete/?albumId=<:$albumId:>"><:$menudeleteAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/album/?albumId=<:$albumId:>"/><:$menubackAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/user/album/"><:$menuMyAlbum:></a>
		</li>
	</ul>
</div>