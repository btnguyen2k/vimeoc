<link href="<:$ctx:>/css/video_thumbnail.css" rel="stylesheet" type="text/css">
<script src="/vimeoc/script/file_uploader.js" type="text/javascript"></script>
<link href="/vimeoc/css/file_uploader.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/video_thumbnail.js"></script>
<script type="text/javascript">
	var imageExtArray = '<:$imageExtSupport:>'.split(",");
	var imageContext = '<:$ctx:>/images/upload/';
	$(document).ready(function(){
		var uploader = new qq.FileUploader({
            element: document.getElementById('file-uploader'),
            action: '<:$ctx:>/video/thumbnail/',
            params: {
				videoId: '<:$videoId:>'
            },
            allowedExtensions: imageExtArray,
        	// you can return false to abort submit
            onSubmit: function(id, fileName){},
            onProgress: function(id, fileName, loaded, total){
                var percent = Math.round(loaded / total * 100);
				$("#upload-processing").css("width", percent +"%");
            },
            onComplete: function(id, fileName, responseJSON){
            	$("#upload-processing").css("width", "100%");
            	$("#top_success").show();
            	setTimeout('$("#top_success").slideUp()',2000);
            	setTimeout('$("#upload-processing").css("width","0%")',2000);
            	$("#thumbnail").attr("src", imageContext+responseJSON.filename);
            },
            onCancel: function(id, fileName){
            	$("#upload-processing").css("width", "0%");
            },
            showErrorMessage: function(message){
            	$("#top_error").html(message).show();
            	setTimeout('$("#top_error").slideUp()',2000);
            }
        });
	});
</script>
<div id="video_custom_url" class="page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
	<div id="video_thumbnail_body" class="page_body">
		<center><h1><:$videoTitle:> - <:$title:></h1></center><br/>		
		<span id="error_message" class="red" style="display: none"><:$errorMessage:></span>
		<span id="info_message" class="green" style="display: none"><:$successMessage:></span>
		<fieldset>
			<ul>
				<li>
					<span><:$currentThumbnail:></span><br/>
					<img id="thumbnail" src="<:$ctx:>/<:$videoThumbnail:>"></img>
				</li>
				<li id="file-uploader">
					 <noscript>			
						<p>Please enable JavaScript to use file uploader.</p>
						<!-- or put a simple form for upload here -->
					</noscript>	  
				</li>
				<li style="width: 200px;">
					<div id="upload-processing" style="width: 0%; background: green;">&nbsp;</div>
				</li>
			</ul>				
		</fieldset>
	</div>
	
	<div id="user_info_help" class="page_help">
		Help?<div><:$hint:></div>
	</div>
</div>