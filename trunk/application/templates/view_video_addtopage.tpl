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
<h1 align="center"><:$video:>-<:$title:></h1>
<div id="video_addtopage" class="video_page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
	<div id="video_addtopage_body" class="video_page_body">	
		<div>	
			<br/>
			<:if $successMessage eq "":>
  				 &nbsp;
			<:else:>
   				<span class="green" align="center"><:$successMessage:></span>
			<:/if:>
			
			<:if $errorMessage eq "":>
  				 &nbsp;
			<:else:>
   				<span class="red" align="center"><:$errorMessage:></span>
			<:/if:>
		</div>
		<:if $albums|@count == 0:>
		Cannot find any albums. Please <a href="#">add</a> some.
		<:else:>
		<form action="<:$ctx:>/video/addtopage/?videoId=<:$videoid:>" method="post" name="addtopageform">
			<fieldset>
				<ul>
					<li>
						<:section name=a loop=$albums:>
						<input type="checkbox" name="albums" id="album_<:$albums[a].id:>" value="<:$albums[a].id:>"/>
						<:$albums[a].album_name:><br/>
						<:/section:>
					</li>
					<li>
						<input type="submit" name="save" value="Save" onClick="checkClick()" />
					</li>
					<li>
						<input type="hidden" name="videoid" value="<:$videoid:>">
					</li>
					<li>
						<input type="hidden" name="album_id" id="album_id" value=""/>
					</li>
					<li>
						<input type="hidden" name="albumUncheck" id="albumUncheck" value="" />
						<input type="hidden" id="checkedAlbums" value="<:$checkedAlbums:>"/>
					</li>
				</ul>
			</fieldset>
		</form>		
		<:/if:>
	</div>
</div>
