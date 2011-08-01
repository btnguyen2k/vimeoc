<link href="<:$ctx:>/css/channel_index.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/channel_index.js"></script>
<div id="user_info" class="page">
	<:include file="<:$base_dir_templates:>/blocks/channel_left_menu.tpl":>		
	<div id="user_video_body" class="page_body">
		<center><h1><:$title:> <:$channel_name|escape:'html':></h1></center><br/>
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
				<a href="<:$ctx:>/video/<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>" /></a><br/>
				<:if $v['video_title'] != '':>
				Title: <:$v['video_title']|escape:'html':><br/>
				<:/if:>
				<div class="creation_date">Uploaded: <span class=""><:$v['creation_date']:></span></div>
				Play count: <:$v['play_count']:><br/>
				Comment count: <:$v['comment_count']:><br/>
				Like count: <:$v['like_count']:><br/>
				<:if $v['album']|@count gt 0:>
				Albums: <:foreach from=$v['album'] key=k1 item=v1 name=albums:><a href="<:$ctx:>/album/<:$v1['album_id']:>"><:$v1['album_name']:></a><:if $smarty.foreach.albums.last:> <:else:>, <:/if:><:/foreach:><br/>
				<:/if:>
				<:if $v['tag']|@count gt 0:>
				Tags: <:foreach from=$v['tag'] key=k1 item=v1 name=tags:><a href="<:$ctx:>/tag/<:$v1['tag_id']:>"><:$v1['tag_name']:></a><:if $smarty.foreach.tags.last:> <:else:>, <:/if:><:/foreach:><br/><br/>
				<:/if:>
			<:/foreach:>
		<:else:>
			<:foreach from=$videos key=k item=v:>
				<a href="<:$ctx:>/video/<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>" /></a><br/>
				<:if $v['video_title'] != '':>
				Title: <:$v['video_title']|escape:'html':>
				<:/if:><br/><br/>
			<:/foreach:>
		<:/if:>
		<:$message:>
		<:$pagination:>
	</div>
</div>