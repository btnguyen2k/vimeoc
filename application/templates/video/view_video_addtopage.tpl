<script type="text/javascript">
	$(document).ready(function() {
		   loadCheckedAlbum();
		});

	function checkClick()
	{	
		var str = "";
	    $(':checkbox:checked').each(function(){
	      str += $(this).val();
	      str+=",";
	    });
	    str = str.substring(0, str.length-1);
	    $("#album_id").val(str);	

	    
	    var stru = "";
	    $(':checkbox:').each(function(){
	      stru += $(this).val();
	      stru+=",";
	    });
	    stru = stru.substring(0, stru.length-1);
	    $("#albumUncheck").val(stru);
	}

	function loadCheckedAlbum()
	{
		var checkedAlbumIds = $("#checkedAlbums").val();
		var ids = checkedAlbumIds.split(',');
		for(var i=0; i<ids.length; i++){
			$("#album_"+ids[i]).attr("checked","checked");
		}
	}
</script>
<div id="video_addtopage" class="page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
	<div id="video_addtopage_body" class="page_body">	
		<h1 align="center"><:$video|escape:'html':> - <:$title:></h1><br/>
		<span class="green" align="center"><:$successMessage:></span>
		<span class="red" align="center"><:$errorMessage:></span>		
		<:if $albums|@count == 0:>
		<:$messages['video.addtopage.cannot']:><a href="<:$ctx:>/album/createNewAlbum/"> <:$messages['video.addtopage.add']:></a> <:$messages['video.addtopage.some']:>
		<:else:>
		<form action="<:$ctx:>/video/addtopage/?videoId=<:$videoid:>" method="post" name="addtopageform">
			<fieldset>
				<ul>
					<li>
						<:section name=a loop=$albums:>
						<input type="checkbox" name="albums" id="album_<:$albums[a].id:>" value="<:$albums[a].id:>"/>
						<:$albums[a].album_name|escape:'html':><br/>
						<:/section:>
						<input type="hidden" name="videoid" value="<:$videoid:>">
						<input type="hidden" name="album_id" id="album_id" value=""/>
						<input type="hidden" name="albumUncheck" id="albumUncheck" value="" />
						<input type="hidden" id="checkedAlbums" value="<:$checkedAlbums:>"/>
					</li>
					<li>
						<input type="submit" name="save" value="Save" onClick="checkClick()" />
					</li>
				</ul>
			</fieldset>
		</form>		
		<:/if:>
	</div>
		<div id="user_info_help" class="page_help">
		<:$help:><div><:$hint:></div>
	</div>
</div>
