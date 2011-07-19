<script src="<:$ctx:>/script/file_uploader.js" type="text/javascript"></script>
<script src="<:$ctx:>/script/uploadify/swfobject.js" type="text/javascript"></script>
<script src="<:$ctx:>/script/uploadify/jquery.uploadify.v2.1.4.min.js" type="text/javascript"></script>
<link href="<:$ctx:>/css/file_uploader.css" rel="stylesheet" type="text/css">
<link href="<:$ctx:>/css/uploadify.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	$(document).ready(function(){
		$('#file_upload').uploadify({
          'uploader'  : '<:$ctx:>/script/uploadify/uploadify.swf',
          'script'    : '<:$ctx:>/uploader/uploadUpdateVideoFile.php',
          'cancelImg' : '<:$ctx:>/script/uploadify/cancel.png',
          'scriptData': {'guid':'<:$guid:>','uid':'<:$uid:>','vid':'<:$vid:>'},
          'fileExt'      : '<:$videoExtSupport:>',          
          'fileDesc'    : 'Video Files',
          'sizeLimit' : <:$maxSize:>,
          'auto'      : true,
          'onAllComplete' : function(event,data) {
          	$("#top_success").html(data.filesUploaded + ' files uploaded successfully!').show();
          },
          'onError' : function (event,ID,fileObj,errorObj) {
        	  $("#top_error").html(errorObj.type + ' Error: ' + errorObj.info);
          }
        });
	});
</script>
<div id="video_custom_url" class="page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
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
		Help?<div><:$message_url_hint:></div>
	</div>
</div>