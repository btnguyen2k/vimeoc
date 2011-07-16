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
			error: function(exp){
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
			error: function(exp){
				alert ("can't connected");
			}
		});
	}	
</script>

<div id="user_info" class="page">
	<:include file="<:$base_dir_templates:>/blocks/user_left_menu.tpl":>
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
		<:if $search_term != "":>
			<input type="text" id="term" name="term" value="<:$search_term:>"></option>
		<:else:>
			<input type="text" id="preTerm" value="Search Video" onClick="editSearchTerm()">
			<input type="text" id="term" name="term" value="<:$search_term:>" style="display:none;"></option>
		<:/if:>
		<input type="hidden" name="page" value="<:$page:>"></input>
		<!--input type="hidden" name="albumid" value=""/>
		<input type="hidden" name="videoid" value="" /-->
		<input type="submit" value="Submit"></input>
		</form>

		<:if 2 == $display_mode:>
			<:foreach from=$videos key=k item=v:>
				<a href="<:$ctx:>/video/videopage/?videoId=<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>" /></a><br/>
				<:if $v['video_title'] != '':>
				Title: <:$v['video_title']:><br/>
				<:/if:>
				<div class="creation_date">Uploaded: <span class="relative_time"><:$v['creation_date']:></span></div>
				Play count: <:$v['play_count']:><br/>
				Comment count: <:$v['comment_count']:><br/>
				Like count: <:$v['like_count']:><br/>
				<:if $v['album']|@count gt 0:>
				Albums: <:foreach from=$v['album'] key=k1 item=v1 name=albums:><a href="<:$ctx:>/album/?albumId=<:$v1['album_id']:>"><:$v1['album_name']:></a><:if $smarty.foreach.albums.last:><:else:>, <:/if:><:/foreach:><br/>
				<:/if:>
				<:if $v['tag']|@count gt 0:>
				Tags: <:foreach from=$v['tag'] key=k1 item=v1 name=tags:><a href="<:$ctx:>/tag/<:$v1['tag_id']:>"><:$v1['tag_name']:></a><:if $smarty.foreach.tags.last:> <:else:>, <:/if:><:/foreach:><br/>
				<:/if:>
				<:if $albums|@count gt 0:>
				Choose albums:
				<:foreach from=$albums key=l item=a:>					
					<input type="checkbox" id="<:$a['id']:>" name ="<:$v['id']:>" onclick="addVideoToAlbum(this)" <:foreach from=$v['album'] key=l1 item=va:><:if $va['album_id'] eq $a['id']:>checked='true'<:/if:><:/foreach:>><:$a['album_name']:></input>
				<:/foreach:><br/>
				<:/if:>
				<:if $channels|@count gt 0:>
				Choose channels:
				<:foreach from=$channels key=l item=a:>					
					<input type="checkbox" id="<:$a['id']:>" name ="<:$v['id']:>" onclick="addVideoToChannel(this)" <:foreach from=$v['channel'] key=l1 item=va:><:if $va['channel_id'] eq $a['id']:>checked='true'<:/if:><:/foreach:>><:$a['channel_name']:></input>
				<:/foreach:><br/>
				<:/if:>
				<br/>
			<:/foreach:>
		<:else:>
			<div>
				<ul id="thumbnail">
					<:foreach from=$videos key=k item=v:>
						<li>
							<span>
								<table>
									<tr>
										<td>
											<a href="<:$ctx:>/video/videopage/?videoId=<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>"/></a>
										</td>
									</tr>
									<tr>
										<td>
											<:if $v['video_title'] != '':>
												Title: <:$v['video_title']:>
											<:/if:>
										</td>
									</tr>
								</table>
							</span>
						</li>
					<:/foreach:>
					<li style="width:100%"><:$pagination:></li>
				</ul>
			</div>
		<:/if:>
		<:$message:>	
	</div>
	<div id="user_info_help" class="page_help">
		Help?<div><:$hint:></div>
	</div>
</div>