<script type="text/javascript">
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
</script>
<h1 align="center"><:$video:>-<:$title:></h1>
<div id="video_addtopage" class="video_page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
	<div id="video_addtopage_body" class="video_page_body">	
		<div>	
			<:$add:>
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
		<form action="<:$ctx:>/video/addtopage" method="post" name="addtopageform">
			<fieldset>
				<ul>
					<div>
						<:section name=a loop=$albums:>
						<input type="checkbox" id="album_check" name="albums" value="<:$albums[a].id:>"/>
						<:$albums[a].album_name:><br/>
						<:/section:>
					</div>
					<div>
						<input type="submit" name="save" value="Save" onClick="checkClick()" />
					</div>
					<div>
						<input type="hidden" name="videoid" value="<:$videoid:>">
					</div>
					<div>
						<input type="hidden" name="album_id" id="album_id" value=""/>
					</div>
					<div>
						<input type="hidden" name="albumUncheck" id="albumUncheck" value="" />
					</div>
				</ul>
			</fieldset>
		</form>		
	</div>
</div>
