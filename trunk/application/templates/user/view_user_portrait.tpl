<script src="<:$ctx:>/script/file_uploader.js" type="text/javascript"></script>
<link href="<:$ctx:>/css/file_uploader.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	var imageExtArray = '<:$imageExtSupport:>'.split(",");
	var imageContext = '<:$ctx:>/images/upload/';
	$(document).ready(function(){
		var uploader = new qq.FileUploader({
            element: document.getElementById('file-uploader'),
            action: '<:$ctx:>/user/portrait/',
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
            	$(".userAvatar").attr("src", imageContext+responseJSON.filename);
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
<div id="user_portrait" class="page">
	<:include file="<:$base_dir_templates:>/blocks/user_left_menu.tpl":>
	
	<div id="user_portrait_body" class="page_body">
		<center><h1><:$title:></h1></center><br/>		
		<span class="red" id="top_error" style="display: none"><:$errorMessage:></span>
		<span class="green" id="top_success" style="display: none"><:$successMessage:></span>
		<fieldset>
			<ul>
				<li>
					<span><:$currentPortrait:></span><br/>
					<:if $avatar != '':>
					<img class="userAvatar" src="<:$ctx:>/images/upload/<:$avatar:>" width="50" height="50"/>
					<:else:>
					<img class="userAvatar" src="<:$ctx:>/images/avatar.png" width="50" height="50"/>
					<:/if:>
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