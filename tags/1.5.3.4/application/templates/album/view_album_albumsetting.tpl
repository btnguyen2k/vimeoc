<script type="text/javascript">
function checkValidForm()
{
	
	if($("#title").val()==""){
		$("#title").val("Untitled");
	}

	if($("#description").val()==""){
		$("#error_valid_description").show();
		return false;
	}else{
		$("#error_valid_description").hide();
	}	
}
</script>
<div id="album_albumsetting" class="page">
	<:include file="<:$base_dir_templates:>/blocks/album_left_menu.tpl":>	
	<div id="album_albumsetting_body" class="page_body">
		<center><h1><:$title_|escape:'html':><:$name:></h1></center>
		<span class="green" align="center"><:$successMessage:></span>
		<form action="<:$ctx:>/album/albumsetting/?albumId=<:$albumId:>" method="post" name="albumsetting" onSubmit="return checkValidForm(this)" >
			<fieldset>
				<ul>
					<li>
						<span><:$title:></span><br/>
					</li>
					<li>
						<input type="text" name="title" id="title" value="<:$title_:>"/> <br/>
					</li>
					<li>
						<span><:$description:></span><br/>
					</li>
					<li>
						<textarea name="description" id="description" cols="30" rows="5"><:$description_:></textarea>
						<span class="red" id="error_valid_description" style="display: none;"><:$errorDescription:></span>
					</li>
					<li>
						<input type="submit" value="Save"/>
						<input type="hidden" id="albumid" name="albumid" value="<:$albumId:>" />
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
		</div>
		<div id="user_info_help" class="page_help">
		<:$help:><div><:$hint:></div>
	</div>
</div>