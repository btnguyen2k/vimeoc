<div id="video_page" class="user_page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
	<div id="video_page_body" class="user_page_body">
		<center><h1><:$title:></h1></center><br/>
		<div>
			<div style="float: left">
				<:if $video.thumbnails_path != '':>
					<img src="<:$video.thumbnails_path:>" />
				<:else:>
					<img src="<:$ctx:>/images/icon-video.gif" width="100"/>
				<:/if:>
			</div>
			<div style="float: left">
				<p><a href="<:$ctx:>/video/videosetting/?videoId=<:$videoid:>">[Setting]</a><a href="<:$ctx:>/auth/Delete">[Delete]</a></p>
				<p><:$day:><:$by:>:<span class=blue><:$fullname:></span></p>
				<p><:$play:><:$plays:>,<:$comment:><:$comments:>,<:$like:><:$likes:></p>
				<p><:$tag:><:section name=a loop=$tags:><:$tags[a].name:>,<:/section:></p>
				<p><:$albums:><span class=blue><:$album:></span></p>
				<input type="hidden" id="videoid" name="videoid" value="<:$videoid:>"/>
			</div>
		</div>		
	</div>
	
	<div id="user_info_help" class="user_page_help">
		Help?<div><:$message_url_hint:></div>
	</div>
</div>
