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
			<a href="<:$ctx:>/album/albumsetting"/><:$menubasicinfoAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/album/albumthumbnail"/><:$menuthumbnailAlbum:></a>
		</li>
		<li>
			<a href="#"><:$menuarrangeAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/album/albumPassword"/><:$menupasswordAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/album/albumDelete"/><:$menudeleteAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/user/album"/><:$menubackAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/user/album/"><:$menuMyAlbum:></a>
		</li>
	</ul>
</div>