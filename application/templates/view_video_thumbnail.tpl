<link href="<:$ctx:>/css/video_thumbnail.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/video_thumbnail.js"></script>
<div id="video_custom_url">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
	<div id="video_thumbnail_body">
		<center><h1><:$videoTitle:> - <:$title:></h1></center><br/>		
		<span id="error_message" class="red"><:$errorMessage:></span>
		<span id="info_message" class="green"><:$successMessage:></span>
		<form id="video_thumbnail_form" action="" method="post" enctype="multipart/form-data">
			<fieldset>
				<ul>
					<li>
						<span><:$currentThumbnail:></span><br/>
						<img id="thumbnail" src="<:$videoThumbnail:>"></img>
						<input type="hidden" id="videoId" name="videoId" value="<:$videoId:>"></input>
					</li>
					<li>
						<span><:$uploadNewThumbnail:></span><br/>
						<input type="hidden" id="ctx" value="<:$ctx:>"></input>
						<input type="hidden" id="APC_UPLOAD_PROGRESS" name="APC_UPLOAD_PROGRESS" id="progress_key" value="<:$upId:>"/>
						<input type="file" id="thumbnail_image" name="thumbnail_image"></input>	
					</li>
					<li>
						<input type="submit" value="Upload" />
					</li>
					<li>
						<iframe id="upload_frame" name="upload_frame" frameborder="0" border="0" src="" scrolling="no" scrollbar="no" > </iframe>
					</li>
				</ul>				
			</fieldset>
		</form>
	</div>
	
	<div id="user_info_help" class="user_page_help">
		Help?<div><:$hint:></div>
	</div>
</div>