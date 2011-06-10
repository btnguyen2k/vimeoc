<div id="video_menu">
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
			<a href="<:$ctx:>/video/videosetting/?videoId=<:$videoId:>"><:$videobasicinfo:></a>
		</li>
		<li>
			<a href="#"><:$videothumbnail:></a>
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
	</ul>
	<ul>
		<li>
			<a href="#"><:$videodelete:></a>
		</li>
		<li>
			<a href="<:$ctx:>/user/video/"><:$videobacktovideo:></a>
		</li>
	</ul>
</div>