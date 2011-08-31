<link href="<:$ctx:>/css/channel_index.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="/script/facebox/facebox.css" />
<script type="text/javascript" src="<:$ctx:>/script/channel_index.js"></script>
<script language="javascript" src="/script/jquery.min.js"></script>
<script language="javascript" src="/script/facebox/facebox.js"></script>
<script>
	var currentUrl = document.location.href;
	function updateVideoToChannel()
	{
		$("#updateVideosToChannel").ajaxSubmit(function(data){
			if(data=="true"){
				document.location.reload();
			}else{
				$.facebox.close()
				var newUrl = currentUrl;
				if(currentUrl.indexOf('?') > 0){
					newUrl=currentUrl + "&updatedVideos=1";
				}else{
					newUrl="<:$ctx:>/channel/?channelId=<:$channelId:>&updatedVideos=1";
				}
				document.location.href=newUrl;
			}
		});
	}

	function loadVideos()
	{
		$.ajax({
			url : '<:$ctx:>/channel/loadVideosForChannel/',
			data: 'channelId=<:$channelId:>&sortMode=<:$sort_mode:>',
			type: 'GET',
			success: function(json){
				var data = eval('(' + json + ')');
				var owner = data.owner;
				var items = data.items;
				var div = $("<div>").attr('id','videoList');
				var list = $("<form id='updateVideosToChannel' name='updateVideosToChannel' action='<:$ctx:>/channel/updateVideosToChannel/' method='POST'>");
				for(var i=0;i<items.length;i++)
				{
					var input = $("<input name='videoList[]' type='checkbox' value='"+items[i].id+"' >");
					var title = items[i].title;
					if(items[i].status){
						if(owner)
							input.attr('checked',true);
						else
							input.attr('checked',true).attr('disabled',true);
					}
					list.append(input).append(title).append('<br>');
				}
				var channelId= $("<input name='channelId' type='hidden' value='<:$channelId:>'>");
				var update= $("<input type='button' value='Update' onclick='updateVideoToChannel()'>");
				var cancel= $("<input type='button' value='Cancel' onclick='$.facebox.close();'>");
				list.append(channelId).append(update).append(cancel);
				div.append(list);
				$.facebox(div);

			}
		});
	}
</script>
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
		<input type="text" id="term" name="term" value="<:$search_term|escape:'html':>"></option>
		<input type="hidden" name="page" value="<:$page:>"></input>
		<input type="submit" name="search" value="Submit"></input>
		<:if $smarty.get.updatedVideos eq 1:>
			<br><center><span style="display:none" class="green" id="message"><:$messages['index.addvideo.successfull']:></span></center>
		<:/if:>
		<:if $videoExist gt 0:>
			<!--
       		<br><center><a href="###" onclick="loadVideos()"><:$messages['channel.index.addtovideo']:></a></center>
       		 -->
        <:/if:>
		</form>

		<:if 2 == $display_mode:>
            <:$pagination:>
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
                    <:$messages['user.video.album']:> <:foreach from=$v['album'] key=k1 item=v1 name=albums:><a href="<:$ctx:>/album/<:$v1['album_id']:>"><:$v1['album_name']|escape:'html':></a><:if $smarty.foreach.albums.last:> <:else:>, <:/if:><:/foreach:><br/>
				<:/if:>
				<:if $v['tag']|@count gt 0:>
                    <!--
                    Tags: <:foreach from=$v['tag'] key=k1 item=v1 name=tags:><a href="<:$ctx:>/tag/<:$v1['tag_id']:>"><:$v1['tag_name']:></a><:if $smarty.foreach.tags.last:> <:else:>, <:/if:><:/foreach:><br/><br/>
                    -->
                    <:$messages['user.video.tag']:> <:foreach from=$v['tag'] key=k1 item=v1 name=tags:><:$v1['tag_name']|escape:'html':><:if $smarty.foreach.tags.last:> <:else:>, <:/if:><:/foreach:><br/><br/>
				<:/if:>
			<:/foreach:>
            <:$pagination:>
		<:else:>
            <div>
				<ul id="thumbnail">
                    <li style="width:100%"><:$pagination:></li>
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
</div>