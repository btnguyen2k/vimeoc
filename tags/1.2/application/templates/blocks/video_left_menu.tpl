<div id="video_menu">
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
	</ul>
	<ul>
		<li>
			<a href="<:$ctx:>/user/video/"><:$videobacktovideo:></a>
		</li>
	</ul>
</div>