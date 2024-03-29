<link href="<:$ctx:>/css/user_video.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/user_video.js"></script>
<script type="text/javascript">
	function editSearchTerm(){
		preTerm = $("#preTerm");
		preTerm.hide();
		term = $("#term");
		term.show();
		term.focus();
	}
	function addVideoToAlbum(params)
	{
		var videoId = params.name;
		var albumId = params.id;
		var videoChecked = params.checked;
		$.ajax({
			url : '<:$ctx:>/user/addVideoToAlbum/',
			data: 'videoId='+videoId+'&albumId='+albumId+'&videoChecked='+videoChecked,
			type: 'POST',
			success: function(data){
			},
			error: function(data){
				alert ("can't connected");
			}
		});
	}

	function addVideoToChannel(params)
	{
		var videoId = params.name;
		var channelId = params.id;
		var videoChecked = params.checked;
		$.ajax({
			url : '<:$ctx:>/user/addVideoToChannel/',
			data: 'videoId='+videoId+'&channelId='+channelId+'&videoChecked='+videoChecked,
			type: 'POST',
			success: function(data){
			},
			error: function(data){
				alert ("can't connected");
			}
		});
	}
</script>

<div id="user_info" class="page">
	<:include file="<:$base_dir_templates:>/blocks/user_left_menu.tpl":>
	<div id="user_video_body" class="page_body">
		<center><h1><:$user_fullname|escape:'html':>'s <:$title|escape:'html':></h1></center><br/>
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
		<:if $search_term != "":>
			<input type="text" id="term" name="term" value="<:$search_term|escape:'html':>"></option>
		<:else:>
			<input type="text" id="preTerm" value="Search Video" onClick="editSearchTerm()">
			<input type="text" id="term" name="term" value="<:$search_term|escape:'html':>" style="display:none;"></option>
		<:/if:>
		<input type="hidden" name="page" value="<:$page:>"></input>
		<input type="submit" value="Submit"></input>
		</form>

		<:if 2 == $display_mode:>
			<:foreach from=$videos key=k item=v:>
				<a href="<:$ctx:>/video/<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>" /></a><br/>
				<:if $v['video_title'] != '':>
                    <a style="font-size:16px;font-weight:bold;" href="<:$ctx:>/video/<:$v['id']:>"><:$v['video_title']|escape:'html':></a><br/>
				<:/if:>
				<div class="creation_date"><span class=""><:$v['creation_date']:> <:$messages['user.video.ago']:></span></div>
				<:$v['play_count']:> <:$messages['user.video.play']:>
				<:$v['comment_count']:> <:$messages['user.video.comment']:>
				<:$v['like_count']:> <:$messages['user.video.like']:> <br/>
				<:if $v['album']|@count gt 0:>
                    <!--
                    Albums: <:foreach from=$v['album'] key=k1 item=v1 name=albums:><a href="<:$ctx:>/album/<:$v1['album_id']:>"><:$v1['album_name']:></a><:if $smarty.foreach.albums.last:><:else:>, <:/if:><:/foreach:><br/>
                    -->
				<:/if:>
				<:if $v['tag']|@count gt 0:>
                    <:$messages['user.video.tag']:><:foreach from=$v['tag'] key=k1 item=v1 name=tags:><:$v1['tag_name']|escape:'html':><:if $smarty.foreach.tags.last:> <:else:>, <:/if:><:/foreach:><br/>
				<:/if:>
				<:if $albums|@count gt 0:>
                    <:$messages['user.video.album']:>
                    <:foreach from=$albums key=l item=a:>
                        <input type="checkbox" id="<:$a['id']:>" name ="<:$v['id']:>" onclick="addVideoToAlbum(this)" <:foreach from=$v['album'] key=l1 item=va:><:if $va['album_id'] eq $a['id']:>checked='true'<:/if:><:/foreach:>><a href="<:$ctx:>/album/<:$a['id']:>"><:$a['album_name']|escape:'html':></a></input>
                    <:/foreach:><br/>
				<:/if:>
				<:if $channels|@count gt 0:>
                    <:$messages['user.video.channel']:>
                    <:foreach from=$channels key=l item=a:>
                        <input type="checkbox" id="<:$a['id']:>" name ="<:$v['id']:>" onclick="addVideoToChannel(this)" <:foreach from=$v['channel'] key=l1 item=va:><:if $va['channel_id'] eq $a['id']:>checked='true'<:/if:><:/foreach:>><a href="<:$ctx:>/channel/<:$a['id']:>"><:$a['channel_name']|escape:'html':></a></input>
                    <:/foreach:><br/>
				<:/if:>
				<br/>
			<:/foreach:>
			<span style="width:100%"><:$pagination:></span>
		<:else:>
			<div>
				<ul id="thumbnail">
					<:foreach from=$videos key=k item=v:>
						<li>
                            <a href="<:$ctx:>/video/<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>"/></a><br/>
                            <:if $v['video_title'] != '':>
								<a style="font-size:16px;font-weight:bold;" href="<:$ctx:>/video/<:$v['id']:>"><:$v['video_title']|escape:'html':></a>
							<:/if:>
						</li>
					<:/foreach:>
					<li style="width:100%"><:$pagination:></li>
				</ul>
			</div>
		<:/if:>
		<:$message:>
	</div>
	<div id="user_info_help" class="page_help">
		<:$help:><div><:$hint:></div>
	</div>
</div>