<link href="<:$ctx:>/css/album_arrange.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/album_arrange.js"></script>
<div id="user_info" class="page">
	<:include file="<:$base_dir_templates:>/blocks/album_left_menu.tpl":>	
	<br/><br/>
	<div id="album_page_body" class="page_body">
		<center><h1><:$album_title|escape:'html':> - <:$title:></h1></center><br/>
		<span id="error_message" class="red"><:$errorMessage:></span>
		<span id="info_message" class="green"><:$successMessage:></span>
		<form id="album_arrange_form" name="album_arrange_form" method="post" action="${ctx}/album/arrange/">
			<input type="hidden" id="albumId" name="albumId" value="<:$album_id:>"></input>
			<:if $video_count > 0:>
			<select id="sort" name="sort">
				<:foreach from=$sort_modes key=k item=v:>
					<option <:if $k == $sort_mode:>selected="selected"<:/if:> value="<:$k:>"><:$v:></option>
				<:/foreach:>
			</select>
			<input type="submit" value="Save"></input>
			<:/if:>
		</form>
		<div id="video_list">
            <:foreach from=$videos key=k item=v:>
                <a href="<:$ctx:>/video/<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>" /></a><br/>
                <a style="font-size:16px;font-weight:bold;" href="<:$ctx:>/video/<:$v['id']:>"><:$v['video_title']|escape:'html':></a><br/>
                <div class="creation_date"><span class=""><:$v['creation_date']:> ago</span></div><br/>
            <:/foreach:>
		</div>
		<div><:$message:></div>
	</div>
	<div id="user_info_help" class="page_help">
		<:$help:><div><:$hint:></div>
	</div>
</div>