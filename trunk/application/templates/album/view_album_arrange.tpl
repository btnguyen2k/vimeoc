<link href="<:$ctx:>/css/album_arrange.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/album_arrange.js"></script>
<div id="user_info" class="page">
	<:include file="<:$base_dir_templates:>/blocks/album_left_menu.tpl":>	
	<br/><br/>
	<div id="album_page_body" class="page_body">
		<center><h1><:$album_title:> - <:$title:></h1></center><br/>
		<span id="error_message" class="red"><:$errorMessage:></span>
		<span id="info_message" class="green"><:$successMessage:></span>
		<form id="album_arrange_form" name="album_arrange_form" method="post" action="">
			<input type="hidden" id="albumId" name="albumId" value="<:$album_id:>"></input>
			<select id="sort" name="sort">
				<:foreach from=$sort_modes key=k item=v:>
					<option <:if $k == $sort_mode:>selected="selected"<:/if:> value="<:$k:>"><:$v:></option>
				<:/foreach:>
			</select>
			<input type="hidden" id="id" name="id" value="<:$album_id:>"></input>
			<input type="submit" value="Save"></input>
		</form>
		<div id="video_list">
		<:foreach from=$videos key=k item=v:>
			<a href="<:$ctx:>/video/videopage/?videoId=<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>" /></a><br/>
			title: <:$v['video_title']:><br/>
			<div class="creation_date">uploaded: <span class="relative_time"><:$v['creation_date']:></span></div><br/>
		<:/foreach:>
		</div>
	</div>
	<div id="user_info_help" class="page_help">
		Help?<div><:$hint:></div>
	</div>
</div>