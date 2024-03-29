<link href="<:$ctx:>/css/user_video.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/user_video.js"></script>
<div id="user_info" class="page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
	<div id="user_video_body" class="page_body">
		<center><h1><:$user_fullname:>'s <:$title:></h1></center><br/>
		<form id="search_form" name="search_from" action="<:$ctx:>/user/video/">
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
		<input type="text" id="term" name="term" value="<:$search_term|escape:'html':>"></option>
		<input type="hidden" name="page" value="<:$page:>"></input>
		<input type="submit" value="Submit"></input>
		</form>

		<:if 2 == $display_mode:>
			<:foreach from=$videos key=k item=v:>
				<a href="<:$ctx:>/video/<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>" /></a><br/>
				<:$messages['video.videoaddtoalbum.id']:> <:$v['id']:><br/>
				<:$messages['video.videoaddtoalbum.title']:> <:$v['video_title']|escape:'html':><br/>
				<div class="creation_date"><:$messages['video.videoaddtoalbum.upload']:> <span class="relative_time"><:$v['creation_date']:></span></div>
				<:$messages['video.videoaddtoalbum.playcount']:> <:$v['play_count']:><br/>
				<:$messages['video.videoaddtoalbum.comment']:> <:$v['comment_count']:><br/>
				<:$messages['video.videoaddtoalbum.likecount']:> <:$v['like_count']:><br/>
				<:$messages['video.videoaddtoalbum.album']:> <:foreach from=$v['album'] key=k1 item=v1:><a href="<:$ctx:>/album/<:$v1['album_id']:>"><:$v1['album_name']|escape:'html':></a>, <:/foreach:><br/>
				<:$messages['video.videoaddtoalbum.tag']:> <:foreach from=$v['tag'] key=k1 item=v1:><a href="<:$ctx:>/tag/<:$v1['tag_id']:>"><:$v1['tag_name']|escape:'html':></a>, <:/foreach:><br/><br/>
			<:/foreach:>
		<:else:>
			<:foreach from=$videos key=k item=v:>
				<a href="<:$ctx:>/video/<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>" /></a><br/>
				title: <:$v['video_title']|escape:'html':><br/><br/>
			<:/foreach:>
		<:/if:>
		<:$message:>
		<:$pagination:>
	</div>
	<div id="user_info_help" class="page_help">
		<:$help:><div><:$hint:></div>
	</div>
</div>