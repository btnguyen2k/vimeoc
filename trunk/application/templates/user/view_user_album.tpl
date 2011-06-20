<link href="<:$ctx:>/css/user_album.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/user_album.js"></script>
<div id="user_info" class="user_page">
	<:include file="<:$base_dir_templates:>/blocks/user_left_menu.tpl":>
	<br/><br/>
	<div id="user_album_body" class="user_page_body">
		<center><h1><:$user_fullname:><:$title:></h1></center><br/>
		<form id="search_form" name="search_from" action="<:$smarty.const.BASE_PATH:><:$smarty.const.CONTEXT:>/user/album/">
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
			<:foreach from=$albums key=k item=v:>
				<a href="<:$ctx:>/album/?id=<:$v['album_id']:>"><img width="100" src="<:$v['thumbnail']:>" /></a><br/>
				name: <:$v['album_name']:><br/>
				created: <span class="relative_time"><:$v['create_date']:></span><br/>
				<:$v['video_count']:> video(s)<br/>
				<br/>
			<:/foreach:>
		<:$message:>
		<:$pagination:>
	</div>
	<div id="user_info_help" class="">
		Help?<div><:$hint:></div>
	</div>
</div>