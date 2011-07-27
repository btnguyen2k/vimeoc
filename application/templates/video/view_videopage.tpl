<script>

function confirmAction() {
    if (confirm("Are you sure you want to delete the following video?"))
    {
    	$("form").submit();
    }
    else
    {
    	return false;
    }
  }
</script>
<div id="video_page" class="page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
	<div id="video_page_body" class="page_body">
		<center><h1><:$title:></h1></center><br/>
		<form action="<:$ctx:>/video/videopage/" id="form" method="post">
			<div>
				<div style="float: left">
						<img src="<:$ctx:>/<:$videoThumbnail:>" />
				</div>
				<div style="float: left">
					<:if $videoOwner:>
					<p><a href="<:$ctx:>/video/videosetting/?videoId=<:$videoid:>">[Setting]</a><a href="<:$ctx:>/video/videodelete/?videoId=<:$videoid:>">[Delete]</a></p>
					<:/if:>
					<p><:$days:> ago<:$by:><span class=blue><:$fullname:></span></p>
					<p><:$play:> <:$plays:>,<:$comment:> <:$comments:>,<:$like:><:$likes:></p>
					<:if $strTags != '':>
					<p><:$tag:><:$strTags:></p>
					<:/if:>
					<:if $strAlbums != '':>
					<p><:$albums:><:$strAlbums:> </p>
					<:/if:>
					<input type="hidden" id="videoid" name="videoid" value="<:$videoid:>"/>
					<input type="hidden" id="confirm" name="confirm" value=""/>
				</div>
			</div>	
		</form>		
	</div>
</div>
