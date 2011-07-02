<div id="menu">
	<ul class="portrait">
		<li>
			<a href="<:$ctx:>/">
			<:if $userAvatar != null:>
			<img class="userAvatar" src="<:$ctx:>/images/upload/<:$userAvatar:>" width="50" height="50"/>
			<:else:>
			<img class="userAvatar" src="<:$ctx:>/images/avatar.png" width="50" height="50"/>
			<:/if:>
			</a>
		</li>
	</ul>
	<ul>
		<li>
			<a href="<:$ctx:>/user/addvideoupload/"><:$menuUploadVideo:></a>
		</li>
		<li>
			<a href="<:$ctx:>/user/video"><:$menuVideos:></a>
		</li>
		<li>
			<a href="<:$ctx:>/user/album"><:$menuAlbums:></a>
		</li>
		<li>
			<a href="<:$ctx:>/user/channel"><:$menuChannels:></a>
		</li>
	</ul>
	<ul>
		<li>
			<a href="<:$ctx:>/user/personalInfo"><:$menuPersonalInfo:></a>
		</li>
		<li>
			<a href="<:$ctx:>/user/portrait"><:$menuPortrait:></a>
		</li>
		<li>
			<a href="<:$ctx:>/user/passwordpages"><:$menuPassword:></a>
		</li>
		<li>
			<a href="<:$ctx:>/user/profileShortcut"><:$menuShortcutURL:></a>
		</li>
		<li>
			<a href="<:$ctx:>/auth/logout"><:$menuLogout:></a>
		</li>
	</ul>
</div>