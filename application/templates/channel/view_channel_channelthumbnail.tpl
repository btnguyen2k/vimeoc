<div id="channel_thumbnail" class="page">
	<:include file="<:$base_dir_templates:>/blocks/channel_left_menu.tpl":>
	<div id="channel_channelthumbnail_body" class="page_body">
		<center><h1><:$channelName|escape:'html':><:$name:></h1></center>
			<:if $succeesMessage eq "":>
  				 &nbsp;
			<:else:>
   				<span class="green" align="center"><:$succeesMessage:></span>
			<:/if:>
		<form action="<:$ctx:>/channel/channelThumbnail/?channelId=<:$channelId:>" method="post" name="channelThumbnail" >
			<fieldset>
				<ul>
					<li>
						<span><:$choose:></span><br/>
						<:if $error eq "":>
  				 			&nbsp;
						<:else:>
   							<span class="red" align="center"><:$error:></span>
						<:/if:>
					</li>
					<li>
						<:if $error eq "":>
  							 &nbsp;
  							 <input type="submit" value="Save" />
						<:/if:>
					</li>
					<li>
						<:section name=a loop=$videoThumbnails:>
						<:if $videoThumbnails[a].thumbnails_path == '':>
							<input type="radio" name="videoThumbnail" value="<:$videoThumbnails[a].thumbnails_path:>"/>
							<img width="100" height="100" src="<:$ctx:>/images/icon-video.gif" width="100"/>
						<:else:>
							<:if $channelThumbnail eq $videoThumbnails[a].thumbnails_path:>
								<input checked="true" type="radio" name="videoThumbnail" value="<:$videoThumbnails[a].thumbnails_path:>" />
								<img width="100" height="100" src="<:$ctx:>/images/upload/<:$videoThumbnails[a].thumbnails_path:>" />
							<:else:>
								<input type="radio" name="videoThumbnail" value="<:$videoThumbnails[a].thumbnails_path:>"/>
								<img width="100" height="100" src="<:$ctx:>/images/upload/<:$videoThumbnails[a].thumbnails_path:>" />
							<:/if:>
						<:/if:>
						<:$videoThumbnails[a].video_title|escape:'html':><br/>
						<:/section:>
					</li>
					<li>
						<input type="hidden" id="channelId" name="channelId" value="<:$channelId:>"/>
						<input type="hidden" id="radioCheck" name="radioCheck" value=""/>
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
	<div id="user_info_help" class="page_help">
		<:$help:><div><:$hint:></div>
	</div>
</div>
