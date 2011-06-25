<link href="<:$ctx:>/css/user_video.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/user_video.js"></script>
<script type="text/javascript">
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
//				if(data == 1){
//					
//				}else{
//					
//				}
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
		<input type="text" id="term" name="term" value="<:$search_term:>"></option>
		<input type="hidden" name="page" value="<:$page:>"></input>
		<input type="hidden" name="albumid" value=""/>
		<input type="hidden" name="videoid" value="" />
		<input type="submit" value="Submit"></input>
		</form>

		<:if 2 == $display_mode:>
			<:foreach from=$videos key=k item=v:>
				<a href="<:$ctx:>/video/videopage/?videoId=<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>" /></a><br/>
				id: <:$v['id']:><br/>
				title: <:$v['video_title']:><br/>
				<div class="creation_date">uploaded: <span class="relative_time"><:$v['creation_date']:></span></div>
				play count: <:$v['play_count']:><br/>
				comment count: <:$v['comment_count']:><br/>
				like count: <:$v['like_count']:><br/>
				album: <:foreach from=$v['album'] key=k1 item=v1:><a href="<:$ctx:>/album/?albumId=<:$v1['album_id']:>"><:$v1['album_name']:></a>, <:/foreach:><br/>
				tag: <:foreach from=$v['tag'] key=k1 item=v1:><a href="<:$ctx:>/tag/<:$v1['tag_id']:>"><:$v1['tag_name']:></a>, <:/foreach:><br/><br/>
				<:foreach from=$albums key=l item=a:>					
					<input type="checkbox" id="<:$a['id']:>" name ="<:$v['id']:>" onclick="addVideoToAlbum(this)" <:foreach from=$v['album'] key=l1 item=va:><:if $va['album_id'] eq $a['id']:>checked='true'<:/if:><:/foreach:>><:$a['album_name']:></input><br/>
				<:/foreach:>
			<:/foreach:>
		<:else:>
			<:foreach from=$videos key=k item=v:>
				<a href="<:$ctx:>/video/videopage/?videoId=<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>" /></a><br/>
				title: <:$v['video_title']:><br/><br/>
			<:/foreach:>
		<:/if:>
		<:$message:>
		<:$pagination:>
	</div>
	<div id="user_info_help" class="page_help">
		Help?<div><:$hint:></div>
	</div>
</div>