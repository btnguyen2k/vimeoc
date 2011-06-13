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
			<a href="<:$ctx:>/album/albumsetting"><:$menubasicinfoAlbum:></a>
		</li>
		<li>
			<a href="#"><:$menuthumbnailAlbum:></a>
		</li>
		<li>
			<a href="#"><:$menuarrangeAlbum:></a>
		</li>
		<li>
			<a href="#"><:$menupasswordAlbum:></a>
		</li>
		<li>
			<a href="#"><:$menudeleteAlbum:></a>
		</li>
		<li>
			<a href="#"><:$menubackAlbum:></a>
		</li>
		<li>
			<a href="<:$ctx:>/user/video/"><:$menuMyAlbum:></a>
		</li>
	</ul>
</div>