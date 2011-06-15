<script>

</script>

<div id="album_albumthumbnail" class="album_page">
	<:include file="<:$base_dir_templates:>/blocks/album_left_menu.tpl":>	
	<div id="album_albumthumbnail_body" class="album_page_body">
		<center><h1><:$title_:><:$name:></h1></center>
		<form action="<:$ctx:>/album/albumThumbnail/?albumId=<:$albumId:>" method="post" name="albumThumbnail" >
			<fieldset>
				<ul>
					<li>
						<span><:$choose:></span><br/>
						
					</li>
					<li>
						<input type="submit" value="Save" />
					</li>
					<li>
						<:section name=a loop=$videoThumbnails:>
						<input type="radio" name="video_thumbnail" id="" value="<:$videoThumbnails[a].id:>"/>
						<:if $video.thumbnails_path != '':>
							<img src="<:$videoThumbnails[a].thumbnails_path:>" />
						<:else:>
							<img src="<:$ctx:>/images/icon-video.gif" width="100"/>
						<:/if:>
						<:$videoThumbnails[a].video_title:><br/>
						<:/section:>
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
	<div id="user_info_help" class="user_page_help">
		Help?<div><:$hint:></div>
	</div>
</div>