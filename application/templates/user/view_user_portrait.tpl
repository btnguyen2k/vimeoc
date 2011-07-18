<script src="<:$ctx:>/script/uploadify/swfobject.js" type="text/javascript"></script>
<script src="<:$ctx:>/script/file_uploader.js" type="text/javascript"></script>
<script src="<:$ctx:>/script/uploadify/swfobject.js" type="text/javascript"></script>
<script src="<:$ctx:>/script/uploadify/jquery.uploadify.v2.1.4.min.js" type="text/javascript"></script>
<link href="<:$ctx:>/css/file_uploader.css" rel="stylesheet" type="text/css">
<link href="<:$ctx:>/css/uploadify.css" rel="stylesheet" type="text/css">
<script type="text/javascript">	
	$(document).ready(function(){
		var imageExtArray = '<:$imageExtSupport:>'.split(",");
		var imageContext = '<:$ctx:>/images/upload/';

		$('#file_upload').uploadify({
          'uploader'  : '<:$ctx:>/script/uploadify/uploadify.swf',
          'script'    : '<:$ctx:>/uploader/uploadUserAvatar.php',
          'cancelImg' : '<:$ctx:>/script/uploadify/cancel.png',
          'folder'    : '<:$guid:>|<:$uid:>',
          'fileExt'   : '<:$imageExtSupport:>',          
          'fileDesc'  : 'Image Files',
          'sizeLimit' : <:$maxSize:>,
          'auto'      : true,
          'onAllComplete' : function(event,data) {
          	$("#top_success").html(data.filesUploaded + ' files uploaded successfully!').show();
          	$.ajax({
    			url : '<:$ctx:>/user/refreshUserAvatar/',
    			data: 'userId=<:$uid:>',
    			type: 'POST',
    			success: function(avatar){
        			$("#uAvatar").attr('src','<:$ctx:>/images/upload/'+avatar);
        			$("#lAvatar").attr('src','<:$ctx:>/images/upload/'+avatar);
    			}
    		});
          },
          'onError' : function (event,ID,fileObj,errorObj) {
        	  $("#top_error").html(errorObj.type + ' Error: ' + errorObj.info);
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
					<img class="userAvatar" id="uAvatar" src="<:$ctx:>/images/upload/<:$avatar:>" width="50" height="50"/>
					<:else:>
					<img class="userAvatar" id="uAvatar" src="<:$ctx:>/images/avatar.png" width="50" height="50"/>
					<:/if:>
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