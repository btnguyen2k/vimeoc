

<div id="album_albumthumbnail" class="album_page">
	<:include file="<:$base_dir_templates:>/blocks/album_left_menu.tpl":>	
	<div id="album_albumthumbnail_body" class="album_page_body">
		<center><h1><:$albumName:><:$name:></h1></center>
			<:if $succeesMessage eq "":>
  				 &nbsp;
			<:else:>
   				<span class="green" align="center"><:$succeesMessage:></span>
			<:/if:>
			
			
		<form action="<:$ctx:>/album/albumThumbnail/?albumId=<:$albumId:>" method="post" name="albumThumbnail" >
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
							<img src="<:$ctx:>/images/icon-video.gif" width="100"/>
						<:else:>
							<:if $albumThumbnail eq $videoThumbnails[a].thumbnails_path:>
								<input checked="true" type="radio" name="videoThumbnail" value="<:$videoThumbnails[a].thumbnails_path:>" />
								<img src="<:$ctx:><:$videoThumbnails[a].thumbnails_path:>" />
							<:else:>
								<input type="radio" name="videoThumbnail" value="<:$videoThumbnails[a].thumbnails_path:>"/>
								<img src="<:$ctx:><:$videoThumbnails[a].thumbnails_path:>" />
							<:/if:>
						<:/if:>
						<:$videoThumbnails[a].video_title:><br/>
						<:/section:>
					
					</li>
					<li>
						<input type="hidden" id="albumId" name="albumId" value="<:$albumId:>"/>
						<input type="hidden" id="radioCheck" name="radioCheck" value=""/>
					</li>
					
				</ul>
			</fieldset>
		</form>
	</div>
	<div id="user_info_help" class="user_page_help">
		Help?<div><:$hint:></div>
	</div>
</div>