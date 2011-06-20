<link href="<:$ctx:>/css/user_home.css" rel="stylesheet" type="text/css">
<link href="<:$ctx:>/css/user_video.css" rel="stylesheet" type="text/css">
<div id="user_info" class="user_page">
	<:include file="<:$base_dir_templates:>/blocks/user_left_menu.tpl":>
	<div id="user_home_body" class="user_page_body">
		<div id="video_album_count">
			<span><:$video_count:> Videos</span><span style="margin: 0 0 0 30px"><:$album_count:> Albums</span>
		</div>
		<div id="video_list">
			<div style="float: left; margin: 0 0 0 30px">
				Your recent videos(<a href="<:$ctx:>/user/video">see all</a>)
				<div>
					<:foreach from=$recent_videos key=k item=v:>
						<a href="<:$ctx:>/video/videopage/?videoId=<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>" /></a><br/>
						<:$v['video_title']:><br/><br/>
					<:/foreach:>
				</div>
			</div>
		</div>
	</div>
</div>