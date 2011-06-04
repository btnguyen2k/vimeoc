<link href="<:$ctx:>/css/user_video.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/user_video.js"></script>
<div id="user_info" class="user_page">
	<:include file="<:$base_dir_templates:>/blocks/user_left_menu.tpl":>
	<br/><br/>
	<div id="user_video_body" class="user_page_body">
		<form id="search_form" name="search_from" action="<:$smarty.const.BASE_PATH:><:$smarty.const.CONTEXT:>/user/video/">
		<select id="mode" name="mode">
			<:foreach from=$display_modes key=k item=v:>
				<option <:if $k == $display_mode:>selected="selected"<:/if:> value="<:$k:>"><:$v:></option>
			<:/foreach:>
		</select>
		<select id="sort" name="sort">
			<:foreach from=$sort_modes key=k item=v:>
				<option <:if $k == $sort_mode:>selected="selected"<:/if:> value="<:$k:>"><:$v:></option>
			<:/foreach:>
		</select>
		<select id="psize" name="psize">
			<:foreach from=$page_sizes key=k item=v:>
				<option <:if $k == $page_size:>selected="selected"<:/if:> value="<:$k:>"><:$v:></option>
			<:/foreach:>
		</select>
		<input type="text" id="term" name="term" value="<:$search_term:>"></option>
		<input type="hidden" name="page" value="<:$page:>"></input>
		<input type="submit" value="Submit"></input>
		</form>

		<:if 2 == $display_mode:>
			<:foreach from=$videos key=k item=v:>
				<a href="<:$ctx:>/video/<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>" /></a><br/>
				id: <:$v['id']:><br/>
				title: <:$v['video_title']:><br/>
				<div class="creation_date">uploaded: <span class="relative_time"><:$v['creation_date']:></span></div>
				play count: <:$v['play_count']:><br/>
				comment count: <:$v['comment_count']:><br/>
				like count: <:$v['like_count']:><br/>
				album: <:foreach from=$v['album'] key=k1 item=v1:><a href="<:$ctx:>/album/<:$v1['album_id']:>"><:$v1['album_name']:></a>, <:/foreach:><br/>
				tag: <:foreach from=$v['tag'] key=k1 item=v1:><a href="<:$ctx:>/tag/<:$v1['tag_id']:>"><:$v1['tag_name']:></a>, <:/foreach:><br/><br/>
			<:/foreach:>
		<:else:>
			<:foreach from=$videos key=k item=v:>
				<img width="100" src="<:$v['thumbnails_path']:>" /><br/>
				title: <:$v['video_title']:><br/><br/>
			<:/foreach:>
		<:/if:>
		<:$message:>
		<:$pagination:>
	</div>
</div>