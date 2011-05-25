<link href="{$ctx}/css/user_video.css" rel="stylesheet" type="text/css">
<div id="user_info" class="user_page">
	{include file="{$base_dir_templates}/blocks/user_left_menu.tpl"}
	<div id="user_video_body" class="user_page_body">
	{section name=index loop=$videos}
	  video: {$videos[index].id} <img src="{$videos[index].thumbnails_path}"></img><br />
	{/section}<br/>
	{$message}
	{$pagination}
	</div>
</div>