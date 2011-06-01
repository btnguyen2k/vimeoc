<link href="(:$ctx:)/css/user_home.css" rel="stylesheet" type="text/css">
<link href="(:$ctx:)/css/user_video.css" rel="stylesheet" type="text/css">
<div id="user_info" class="user_page">
	(:include file="(:$base_dir_templates:)/blocks/user_left_menu.tpl":)
	<div id="user_home_body" class="user_page_body">
		<div id="video_album_count">
			<span>(:$video_count:) Videos</span><span style="margin: 0 0 0 30px">(:$album_count:) Albums</span>
		</div>
		<div id="video_list">
			<div style="float: left; margin: 0 0 0 30px">
				Your recent videos(<a href="(:$ctx:)/user/video">see all</a>)
				<div>
					(:section name=index loop=$recent_videos:)
					  video: (:$recent_videos[index].id:) <img src="(:$videos[index].thumbnails_path:)"></img><br />
					(:/section:)<br/>
				</div>
			</div>
		</div>
	</div>
</div>