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
		<input type="submit" value="Submit"></input>
		</form>
		<:section name=index loop=$videos:>
			<div>
				<:if $videos[index].thumbnails_path != '':>
				<img src="<:$videos[index].thumbnails_path:>" />			
				<:else:>
				<img src="<:$ctx:>/images/icon-video.gif" width="100"/>
				<:/if:>
				video: <:$videos[index].id:>
			</div>	  
		<:/section:><br/>
		<:$message:>
		<:$pagination:>
	</div>
</div>