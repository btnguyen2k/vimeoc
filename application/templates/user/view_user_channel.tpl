<link href="<:$ctx:>/css/user_channel.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/user_channel.js"></script>
<script type="text/javascript">
function editSearchTerm(){
	preTerm = $("#preTerm");
	preTerm.hide();
	term = $("#term");
	term.show();
	term.focus();
}
</script>
<div id="user_info" class="page">
	<:include file="<:$base_dir_templates:>/blocks/user_left_menu.tpl":>
	<div id="user_channel_body" class="page_body">
		<center><h1><:$title:></h1></center><br/>
		<form id="search_form" name="search_from" action="<:$ctx:>/user/channel/" method="GET">
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
			<:if $search_term != "":>
				<input type="text" id="term" name="term" value="<:$search_term|escape:'html':>"></option>
			<:else:>
				<input type="text" id="preTerm" value="Search Channel" onClick="editSearchTerm()">
				<input type="text" id="term" name="term" value="<:$search_term|escape:'html':>" style="display:none;"></option>
			<:/if:>
			<input type="hidden" name="page" value="<:$page:>"></input>
			<input type="submit" value="Submit"></input>
		</form>
        <div>
			<ul id="thumbnail">
                <li style="width: 100%"><:$pagination:></li>
				<:foreach from=$channels key=k item=v:>
					<li>
						<a href="<:$ctx:>/channel/?channelId=<:$v['channel_id']:>"><img width="100" src="<:$v['thumbnail']:>" /></a><br/>
						<a style="font-size:16px;font-weight:bold;" href="<:$ctx:>/channel/?channelId=<:$v['channel_id']:>"><:$v['channel_name']|escape:'html':></a><br/>
                        <:$v['create_date']:> <:$messages['user.channel.ago']:><br/>
                        <:$v['video_count']:> <:$messages['user.channel.video']:><br/>
                    </li>
				<:/foreach:>
                <li style="width: 100%"><a href="<:$ctx:>/channel/createnewchannel/"><:$messages['user.channel.create']:></a></li>
                <li style="width: 100%"><:$pagination:></li>
			</ul>
        </div>
	</div>
	<div id="user_info_help" class="page_help">
		<:$help:><div><:$hint:></div>
	</div>
</div>