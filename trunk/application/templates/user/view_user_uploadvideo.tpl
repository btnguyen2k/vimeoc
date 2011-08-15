<script src="<:$ctx:>/script/file_uploader.js" type="text/javascript"></script>
<script src="<:$ctx:>/script/uploadify/swfobject.js" type="text/javascript"></script>
<script src="<:$ctx:>/script/uploadify/jquery.uploadify.v2.1.4.min.js" type="text/javascript"></script>
<link href="<:$ctx:>/css/file_uploader.css" rel="stylesheet" type="text/css">
<link href="<:$ctx:>/css/uploadify.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
    var videoUploaded = false;
    var videoInfoSaved = false;
    var videoInfoAutoSave = false;
    
	var waitingForSubmit = false;
	$(document).ready(function(){
		var videoExtArray = '<:$videoExtSupport:>'.split(",");
		$('#file_upload').uploadify({
            'uploader'  : '<:$ctx:>/script/uploadify/uploadify.swf',
            'script'    : '<:$ctx:>/uploader/uploadUserVideo.php',
            'cancelImg' : '<:$ctx:>/script/uploadify/cancel.png',
            'scriptData': {'PHPSESSID':'<:$sessionId:>'},
            'fileExt'   : '<:$videoExtSupport:>',          
            'fileDesc'  : 'Video Files',
            'sizeLimit' : <:$maxSize:>,
            'auto'      : false,
            'multi'     : false,
            'onError' : function (event,ID,fileObj,errorObj) {
                $("#top_error").html(errorObj.type + ' Error: ' + errorObj.info);
            },
            'onSelect' : function(event,ID,fileObj) {			  
                var exts = '<:$videoExtSupport:>';
                var type = getFileType(fileObj.name);
                if(!type || exts.indexOf(type) < 0){
                    $("#top_success").hide();
                    $("#top_error").html('You selected wrong file type.').show();
                    $('#file_upload').uploadifyCancel($('.uploadifyQueueItem').first().attr('id').replace('file_upload',''));
                }else{
                    $("#top_error").hide();     
                    setTimeout('upload();', 200);   		  
                }
            },
            'onOpen' : function(event,ID,fileObj) {
                $("#top_success").html("Uploading, please wait...").show();
                //enable the Save button so that user can save video information while uploading
                $('#submit-button').removeAttr("disabled");
            },
            'onComplete' : function(event, ID, fileObj, response, data){
                videoUploaded = true; //mark file uploading completed
                $('#submit-button').removeAttr("disabled");
                if (response == 'invalid-file.error') {
                    $("#top_error").html('Upload failed.').show();
                } else {
                    var fileName = fileObj.name;
                    fileName = fileName.replace(fileObj.type, "");
                    $("#top_success").html("Video '" + fileName + "' has been uploaded successfully.").show();
                    if ($("#title").val()=="") {
                        //auto save the video
                        videoInfoAutoSave = true;
                        $("#top_success").html("Auto saving video, please wait...").show();
                        $("#title").val(fileName);
                        createUploadingVideo();
                    }
                    $("#videoPath").val(response);
                    var videoId = $("#videoid").val();
                    if ( !(videoId=="") && videoInfoSaved ) {
                        createUploadingVideo();
                    }   
                }
            }
        });
	});

	function upload() {
		$("#file_upload").uploadifyUpload();
	}

	function checkvalidate() {
		var title= $("#title").val();

		var flag=true;

		if (title=="") {
			$("#error_valid_title").show();
			flag=false;
		} else {
			$("#error_valid_title").hide();
		}

		if (flag) {
			createUploadingVideo();
		}
	}

	function createUploadingVideo() {
		var title = $("#title").val();
		var tag = $("#tag").val();
		var desc = $("#description").val();
		var tcid = $("#tcid").val();
		var videoPath = $("#videoPath").val();
		var videoid = $("#videoid").val();
        $("#success").html("Please wait...").show();
		$.ajax({
			url : '<:$ctx:>/user/createUploadingVideo/',
			data: 'title='+title+'&tag='+tag+'&description='+desc+'&tcid='+tcid+'&videoPath='+videoPath+'&videoid='+videoid,
			type: 'POST',
			success: function(data){
                videoInfoSaved = true; //mark video info has been saved
                if ( videoInfoAutoSave ) {
                    $("#top_success").html("Auto saving video, please wait...done!").show();
                }
				$("#videoid").val(data);
				//$("#submit-button").attr("disabled","disabled");
				//$("#title").attr("disabled","disabled");
				//$("#description").attr("disabled","disabled");
				//$("#tag").attr("disabled","disabled");
				$("#success").html("<:$success:>").show();
				if( !(videoPath=="") && !videoInfoAutoSave){
					window.location = "<:$ctx:>/user/video";
				}
                videoInfoAutoSave = false;
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
			<h3><:$messages['user.uploadvideo.infor']:></h3>
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
				</li>
				<li>
					<span><:$tag:></span><br/>
					<input type="text" name="tag" id="tag" size="40"/>
				</li>
				<li>
					<input type="hidden" name="tcid" id="tcid" value="<:$tcid:>" />
					<input type="hidden" name="videoPath" id="videoPath"/>
					<input type="hidden" id="videoid" name="videoid" />
					<input id="submit-button" type="button" value="Save" onclick="checkvalidate()" disabled="disabled"/>
				</li>
			</ul>
		</fieldset>
	</div>
	<div id="user_info_help" class="page_help">
			<:$help:><div><:$hint:></div>
	</div>
</div> 