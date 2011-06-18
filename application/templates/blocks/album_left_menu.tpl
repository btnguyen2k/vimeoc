<div id="album_menu">
	<ul class="portrait">
		<li>
			<a href="#">
				<a href="<:$ctx:>/">
				<:if $userAvatar != null:>
				<img class="userAvatar" src="<:$ctx:>/images/upload/<:$userAvatar:>" width="50" height="50"/>
				<:else:>
				<img class="userAvatar" src="<:$ctx:>/images/icon-video.gif" width="50" height="50"/>
				<:/if:>
				</a>
			</a>
		</li>
	</ul>
	<ul>
		<li>
			<a href="<:$ctx:>/album/albumsetting/?albumId=<:$albumId:>"><:$menubasicinfoAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/album/albumthumbnail/?albumId=<:$albumId:>"><:$menuthumbnailAlbum:></a>
		</li>
		<li>
			<a href="#"><:$menuarrangeAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/album/albumPassword/?albumId=<:$albumId:>"><:$menupasswordAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/album/albumDelete/?albumId=<:$albumId:>"><:$menudeleteAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/user/album"/><:$menubackAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/user/album/"><:$menuMyAlbum:></a>
		</li>
	</ul>
</div>