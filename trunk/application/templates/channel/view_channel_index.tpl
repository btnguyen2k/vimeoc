<link href="<:$ctx:>/css/channel_index.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/channel_index.js"></script>
<div id="user_info" class="page">
	<:include file="<:$base_dir_templates:>/blocks/channel_left_menu.tpl":>	
	<br/><br/>
	<div id="user_video_body" class="page_body">
		<center><h1><:$title:> <:$channel_name:></h1></center><br/>
		<form id="search_form" name="search_from" action="<:$ctx:>/channel/" method="GET">
		<input type="hidden" id="channelId" name="channelId" value="<:$channelId:>"></input>
		<select id="mode" name="mode">
			<:foreach from=$display_modes key=k item=v:>
				<option <:if $k == $display_mode:>selected="selected"<:/if:> value="<:$k:>"><:$v:></option>
			<:/foreach:>
		</select>
		<select id="psize" name="psize">
			<:foreach from=$page_sizes key=k item=v:>
				<option <:if $k == $page_size:>selected="selected"<:/if:> value="<:$k:>"><:$v:></option>
			<:/foreach:>
		</select>
		<input type="text" id="term" name="term" value="<:$search_term:>"></option>
		<input type="hidden" name="page" value="<:$page:>"></input>
		<input type="submit" name="search" value="Submit"></input>
		</form>

		<:if 2 == $display_mode:>
			<:foreach from=$videos key=k item=v:>
				<a href="<:$ctx:>/video/videopage/?videoId=<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>" /></a><br/>
				id: <:$v['id']:><br/>
				title: <:$v['video_title']:><br/>
				<div class="creation_date">uploaded: <span class="relative_time"><:$v['creation_date']:></span></div>
				play count: <:$v['play_count']:><br/>
				comment count: <:$v['comment_count']:><br/>
				like count: <:$v['like_count']:><br/>
				album: <:foreach from=$v['album'] key=k1 item=v1:><a href="<:$ctx:>/album/?albumId=<:$v1['album_id']:>"><:$v1['album_name']:></a>, <:/foreach:><br/>
				tag: <:foreach from=$v['tag'] key=k1 item=v1:><a href="<:$ctx:>/tag/<:$v1['tag_id']:>"><:$v1['tag_name']:></a>, <:/foreach:><br/><br/>
			<:/foreach:>
		<:else:>
			<:foreach from=$videos key=k item=v:>
				<a href="<:$ctx:>/video/videopage/?videoId=<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>" /></a><br/>
				title: <:$v['video_title']:><br/><br/>
			<:/foreach:>
		<:/if:>
		<:$message:>
		<:$pagination:>
	</div>
</div>