<div id="menu">
	<:if $show_user_avatar == 1:>
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
	<:/if:>
	<:if $show_user_avatar != 1:>
		<ul id="video_thumb">
			<li>
				<:if $videoThumbnail != '':>
					<img src="<:$ctx:><:$videoThumbnail:>" width="100"/>
				<:else:>
					<img src="<:$ctx:>/images/icon-video.gif" width="100"/>
				<:/if:>
			</li>
		</ul>
	<:/if:>
	<:if $authorized == true:>
	<ul>
		<li>
			<a href="<:$ctx:>/video/videosetting/?videoId=<:$videoId:>"><:$videobasicinfo:></a>
		</li>
		<li>
			<a href="<:$ctx:>/video/thumbnail/?videoId=<:$videoId:>"><:$videothumbnail:></a>
		</li>
		<li>
			<a href="<:$ctx:>/video/updateVideoFile/?videoId=<:$videoId:>"><:$videovideofile:></a>
		</li>
		<li>
			<a href="<:$ctx:>/video/preandpostroll/?videoId=<:$videoId:>"><:$videopreandpost:></a>
		</li>
	</ul>
	<ul>
		<li>
			<a href="<:$ctx:>/video/customUrl/?videoId=<:$videoId:>"><:$videocustomurl:></a>
		</li>
		<li>
			<a href="<:$ctx:>/video/addtopage/?videoId=<:$videoId:>"><:$videoaddto:></a>
		</li>
		<li>
			<a href="<:$ctx:>/video/addtochannel/?videoId=<:$videoId:>"><:$videoaddtochannel:></a>
		</li>
	</ul>
	<ul>
		<li>
			<a href="<:$ctx:>/user/video/"><:$videobacktovideo:></a>
		</li>
	</ul>
	<:/if:>
	<:if $authorized == false:>
	<ul>
		<li><a href="<:$ctx:>">Back to homepage</a>
	</ul>
	<:/if:>
	<:if $proxy eq true:>
	<ul>
		<li><a href="<:$ctx:>/admin/switchBackToAdmin">Switch back to admin</a>
	</ul>
	<:elseif $smarty.session.admin:>
	<ul>
		<li><a href="<:$ctx:>/admin">Administer Page</a>
	</ul>
	<:/if:>
	<ul>
	<li>
		<a href="<:$ctx:>/auth/logout"><:$menuLogout:></a>
	</li>
</div>