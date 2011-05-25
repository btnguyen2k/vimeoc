<link href="{$ctx}/css/user_video.css" rel="stylesheet" type="text/css">
{include file="{$base_dir_templates}/blocks/user_left_menu.tpl"}
<div id="user_home_body"><div><span>{$video_count} Videos</span><span style="margin: 0 0 0 30px">{$album_count} Albums</span></div>
<div>
	<div style="float: left; margin: 0 0 0 30px">
		Your recent videos(<a href="{$ctx}/user/video">see all</a>)
		<div>
			{section name=index loop=$recent_videos}
			  video: {$recent_videos[index].id} <img src="{$videos[index].thumbnails_path}"></img><br />
			{/section}<br/>
		</div>
	</div>
</div>
</div>