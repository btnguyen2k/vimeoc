<script src="<:$ctx:>/script/file_uploader.js" type="text/javascript"></script>
<script src="<:$ctx:>/script/uploadify/swfobject.js" type="text/javascript"></script>
<script src="<:$ctx:>/script/uploadify/jquery.uploadify.v2.1.4.min.js" type="text/javascript"></script>
<link href="<:$ctx:>/css/file_uploader.css" rel="stylesheet" type="text/css">
<link href="<:$ctx:>/css/uploadify.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	var waitingForSubmit = false;
	$(document).ready(function(){
		var videoExtArray = '<:$videoExtSupport:>'.split(",");
		$('#file_upload').uploadify({
          'uploader'  : '<:$ctx:>/script/uploadify/uploadify.swf',
          'script'    : '<:$ctx:>/uploader/uploadUserVideo.php',
          'cancelImg' : '<:$ctx:>/script/uploadify/cancel.png',
          'scriptData': {'PHPSESSID':'<:$sessionId:>'},
          'fileExt'      : '<:$videoExtSupport:>',          
          'fileDesc'    : 'Video Files',
          'sizeLimit' : <:$maxSize:>,
          'auto'      : false,
          'onAllComplete' : function(event,data) {
            if(waitingForSubmit == true){
            	checkvalidate();
            	$("#top_success").html('Updating the video information ...');
            }
          },
          'onError' : function (event,ID,fileObj,errorObj) {
        	  $("#top_error").html(errorObj.type + ' Error: ' + errorObj.info);
          },'onSelect'    : function(event,ID,fileObj) {			  
        	  var exts = '<:$videoExtSupport:>';
        	  if(exts.indexOf(fileObj.type) < 0){
        		  $("#top_success").hide();
        		  $("#top_error").html('You selected wrong file type.').show();
        		  $('#file_upload').uploadifyCancel($('.uploadifyQueueItem').first().attr('id').replace('file_upload',''));
        	  }else{
        		  $("#top_error").hide();     
        		  setTimeout('upload();', 200);   		  
        	  }
          },
          'onComplete' : function(event, ID, fileObj, response, data){
              if(response == 'invalid-file.error'){
            	  $("#top_error").html('Upload failed.').show();
              }else{
                  var fileName = fileObj.name;
                  fileName = fileName.replace(fileObj.type, "");
            	  $("#top_success").html("Video '" + fileName + "' has been uploaded successfully.").show();
            	  if($("#title").val()==""){
                	  $("#title").val(fileName);
            	  }
            	  $("#videoPath").val(response);
               	  var videoId = $("#videoid").val();
            	  if(!(videoId=="")){
            		  createUploadingVideo();
            	  }   
              }
          }
        });
	});

	function upload(){
		$("#file_upload").uploadifyUpload();
	}

	function checkvalidate()
	{
		var title= $("#title").val();
		var description= $("#description").val();
		var tag= $("#tag").val();
		var videoId = $("#videoid").val();

		var flag=true;

		if(title==""){
			$("#error_valid_title").show();
			flag=false;
		}else{
			$("#error_valid_title").hide();
		}	

		if(description==""){
			$("#error_valid_description").show();
			flag=false;
		}else{
			$("#error_valid_description").hide();
		}	

		if(tag==""){
			$("#error_valid_tag").show();
			flag=false;
		}else{
			$("#error_valid_tag").hide();
		}	
		if(flag){
			createUploadingVideo();
		}
	}

	function createUploadingVideo()
	{
		var title = $("#title").val();
		var tag = $("#tag").val();
		var desc = $("#description").val();
		var tcid = $("#tcid").val();
		var videoPath = $("#videoPath").val();
		var videoid = $("#videoid").val();
		$.ajax({
			url : '<:$ctx:>/user/createUploadingVideo/',
			data: 'title='+title+'&tag='+tag+'&description='+desc+'&tcid='+tcid+'&videoPath='+videoPath+'&videoid='+videoid,
			type: 'POST',
			success: function(data){
				$("#videoid").val(data);
				$("#submit-button").attr("disabled","disabled");
				$("#title").attr("disabled","disabled");
				$("#description").attr("disabled","disabled");
				$("#tag").attr("disabled","disabled");
				$("#success").show();
				if(!(videoPath=="")){
					window.location = "<:$ctx:>/user/video";
				}
			}
		});
	}
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
				<li>
					<input id="file_upload" name="file_upload" type="file" />					
				</li>				
				<li style="width: 200px;">
					<div id="upload-processing" style="width: 0%; background: green;">&nbsp;</div>
				</li>
			</ul>
			<div id="log"></div>
			<h3>Video File Information</h3>
			<span class="green" id="success" style="display: none;"><:$success:></span>
			<ul id="video_information">				
				<li>
					<span><:$name:> </span><br/>						
					<input type="text" name="title" id="title"/>
					<span class="red" id="error_valid_title" style="display: none;"><:$titleiInvalid:></span>
				</li>					
				<li>
					<span><:$description:></span><br/>
					<textarea type="text" name="description" id="description" ></textarea>
					<span class="red" id="error_valid_description" style="display: none;"><:$descriptionInvalid:></span>
				</li>
				<li>
					<span><:$tag:></span><br/>
					<input type="text" name="tag" id="tag" size="40"/>
					<span class="red" id="error_valid_tag" style="display: none;"><:$tagInvalid:></span>
				</li>
				<li>
					<input type="hidden" name="tcid" id="tcid" value="<:$tcid:>" />
					<input type="hidden" name="videoPath" id="videoPath"/>
					<input type="hidden" id="videoid" name="videoid" />
					<input id="submit-button" type="button" value="Save" onclick="checkvalidate()"/>
				</li>
			</ul>
		</fieldset>
	</div>
	<div id="user_info_help" class="page_help">
			Help?<div><:$hint:></div>
	</div>
</div> 