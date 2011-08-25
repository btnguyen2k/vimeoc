<link href="<:$ctx:>/css/video_thumbnail.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/video_thumbnail.js"></script>
<script src="<:$ctx:>/script/file_uploader.js" type="text/javascript"></script>
<script src="<:$ctx:>/script/uploadify/swfobject.js" type="text/javascript"></script>
<script src="<:$ctx:>/script/uploadify/jquery.uploadify.v2.1.4.min.js" type="text/javascript"></script>
<link href="<:$ctx:>/css/file_uploader.css" rel="stylesheet" type="text/css">
<link href="<:$ctx:>/css/uploadify.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	function selectImageFromScreenShot(){
		var selectedImage = $('input[name=videoScreenShot]:checked').val();
		$.ajax({
			url : '<:$ctx:>/video/updateThumbnailFromScreenShot/',
			data: 'videoId=<:$videoId:>&imageName='+selectedImage,
			type: 'POST',
			success: function(res){
				$("#thumbnail").attr('src','<:$ctx:><:$imageUpload:>'+res);
			}
		});
	}
	
	$(document).ready(function(){
		var imageExtArray = '<:$imageExtSupport:>'.split(",");
		var imageContext = '<:$ctx:>/images/upload/';

		$('#file_upload').uploadify({
          'uploader'  : '<:$ctx:>/script/uploadify/uploadify.swf',
          'script'    : '<:$ctx:>/uploader/uploadVideoThumbnail.php',
          'cancelImg' : '<:$ctx:>/script/uploadify/cancel.png',
          'scriptData': {'PHPSESSID':'<:$sessionId:>','vid':'<:$videoId:>'},
          'fileExt'   : '<:$imageExtSupport:>',          
          'fileDesc'  : 'Image Files',
          'sizeLimit' : <:$maxSize:>,
          'auto'      : false,
          'onAllComplete' : function(event,data) {
			$("#top_success").html(data.filesUploaded + ' files uploaded successfully!').show();
			$.ajax({
    			url : '<:$ctx:>/video/refreshVideoThumbnail/',
    			data: 'videoId=<:$videoId:>',
    			type: 'POST',
    			success: function(thumbnail){
        			$("#thumbnail").attr('src','<:$ctx:>/images/upload/'+thumbnail);
    			}
			});
          },
          'onError' : function (event,ID,fileObj,errorObj) {
        	$("#top_error").html(errorObj.type + ' Error: ' + errorObj.info);
          },'onSelect'    : function(event,ID,fileObj) {			  
        	  var exts = '<:$imageExtSupport:>';
        	  var type = getFileType(fileObj.name);
        	  if(!type || exts.indexOf(type) < 0){
        		  $("#top_success").hide();
        		  $("#top_error").html('You selected wrong file type.').show();
        		  $('#file_upload').uploadifyCancel($('.uploadifyQueueItem').first().attr('id').replace('file_upload',''));
        	  }else{
        		  $("#top_error").hide();
        		  setTimeout('upload();', 200);
        	  }
          }
        });
	});

	function upload(){
		$("#file_upload").uploadifyUpload();
	}
</script>
<style type="text/css">
div.scroll
{
	width:620px;
	height:200px;
	overflow:auto;
}
</style>
<div id="video_custom_url" class="page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
	<div id="video_thumbnail_body" class="page_body">
		<center><h1><:if $videoTitle!='':><:$videoTitle|escape:'html':> - <:/if:><:$title:></h1></center><br/>		
		<span id="top_error" class="red" style="display: none"><:$errorMessage:></span>
		<span id="top_success" class="green" style="display: none"><:$successMessage:></span>
			<fieldset>
				<ul>
					<li>
						<span><:$currentThumbnail:></span><br/>
						<img width="150" height="150" id="thumbnail" src="<:$videoThumbnail:>"></img>
					</li>
					<li>
						<input id="file_upload" name="file_upload" type="file" />
					</li>
					<li style="width: 200px;">
						<div id="upload-processing" style="width: 0%; background: green;">&nbsp;</div>
					</li>
						<:if $arrayImage:>
						<div class="scroll">					
							<:section name=a loop=$arrayImage:>
								<input type="radio" name="videoScreenShot" value="<:$arrayImage[a]:>"/>
								<img width="100" height="100" id="arrayThumbnail" src="<:$ctx:><:$folder:>/<:$arrayImage[a]:>" />
							<:/section:>
						</div>
						<li>
							<input type="button" value="Save" onclick="selectImageFromScreenShot()"/>
						</li>
						<:/if:>
				</ul>				
			</fieldset>
	</div>
	
	<div id="user_info_help" class="page_help">
		<:$help:><div><:$hint:></div>
	</div>
</div>