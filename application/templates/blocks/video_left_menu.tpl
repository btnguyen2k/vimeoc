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
			<a href="<:$ctx:>/video/videosetting"><:$videobasicinfo:></a>
		</li>
		<li>
			<a href="#"><:$videothumbnail:></a>
		</li>
		<li>
			<a href="<:$ctx:>/video/updateVideoFile/?videoId=<:$videoId:>"><:$videovideofile:></a>
		</li>
		<li>
			<a href="<:$ctx:>/video/preandpostroll"><:$videopreandpost:></a>
		</li>
	</ul>
	<ul>
		<li>
			<a href="<:$ctx:>/video/customUrl/?videoId=<:$videoId:>"><:$videocustomurl:></a>
		</li>
		<li>
			<a href="<:$ctx:>/video/addtopage"><:$videoaddto:></a>
		</li>
	</ul>
	<ul>
		<li>
			<a href="#"><:$videodelete:></a>
		</li>
		<li>
			<a href="<:$ctx:>/user/videopage"><:$videobacktovideo:></a>
		</li>
	</ul>
</div>