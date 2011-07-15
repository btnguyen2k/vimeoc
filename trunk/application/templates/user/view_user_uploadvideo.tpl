<script src="<:$ctx:>/script/file_uploader.js" type="text/javascript"></script>
<script src="<:$ctx:>/script/uploadify/swfobject.js" type="text/javascript"></script>
<script src="<:$ctx:>/script/uploadify/jquery.uploadify.v2.1.4.min.js" type="text/javascript"></script>
<link href="<:$ctx:>/css/file_uploader.css" rel="stylesheet" type="text/css">
<link href="<:$ctx:>/css/uploadify.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	$(document).ready(function(){
		var videoExtArray = '<:$videoExtSupport:>'.split(",");
		/*
		var uploader = new qq.FileUploader({
            element: document.getElementById('file-uploader'),
            action: '<:$ctx:>/user/addvideoupload/',
            allowedExtensions: videoExtArray,
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
            },
            onCancel: function(id, fileName){
            	$("#upload-processing").css("width", "0%");
            },
            showErrorMessage: function(message){
            	$("#top_error").html(message).show();
            	setTimeout('$("#top_error").slideUp()',2000);
            }
        });
        */        
		$('#file_upload').uploadify({
          'uploader'  : '<:$ctx:>/script/uploadify/uploadify.swf',
          'script'    : '<:$ctx:>/uploader/uploadUserVideo.php',
          'cancelImg' : '<:$ctx:>/script/uploadify/cancel.png',
          'folder'    : '/uploads',
          'auto'      : true,
          'onAllComplete' : function(event,data) {
        	//alert(data.filesUploaded + ' files uploaded successfully!');
          	$("#top_success").html(data.filesUploaded + ' files uploaded successfully!').show();
          },
          'onError' : function (event,ID,fileObj,errorObj) {
          	//alert(errorObj.type + ' Error: ' + errorObj.info);
          }
        });
	});
</script>
<div id="user_addvideoupload" class="page">
	<:include file="<:$base_dir_templates:>/blocks/user_left_menu.tpl":>
	
	<div id="user_addvideoupload_body" class="page_body">
		<center><h1><:$title:></h1></center><br/>
		<span class="red" id="top_error" style="display: none;"><:$errorMessage:></span>
		<span class="green" id="top_success" style="display: none;"><:$successMessage:></span>
		<fieldset>
			<ul>
				<li>
					<span><:$choose:> </span><br/>	
					<span style="display: none" class="red" id="error_file"><:$requiredFields:></span>
					<span style="display: none" class="red" id="notSupportExt"><:$videoExtSupport:></span>
				</li>
				<li id="file-uploader">			
					 <noscript>			
						<p>Please enable JavaScript to use file uploader.</p>
						<!-- or put a simple form for upload here -->
					</noscript>	  
				</li>
				<li>
					<input id="file_upload" name="file_upload" type="file" />
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