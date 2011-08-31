<script type="text/javascript">
	function checkValidForm()
	{

		if($("#title").val()==""){
			$("#title").val("Untitled");
		}

	}
</script>
<div id="album_createnewalbum" class="page">
	<:include file="<:$base_dir_templates:>/blocks/album_left_menu.tpl":>
	<div id="album_createnewalbum_body" class="page_body">
		<center><h1><:$name:></h1></center>
		<div>
			<br/>
			<:if $successMessage eq "":>
  				 &nbsp;
			<:else:>
   				<span class="green" align="center"><:$successMessage:></span>
			<:/if:>
		</div>
		<form action="<:$ctx:>/album/createnewalbum/" method="post" name="createnewalbum" onSubmit="return checkValidForm(this)">
			<fieldset>
				<ul>
					<li>
						<span><:$title:></span><br/>
					</li>
					<li>
						<input type="text" name="title" id="title" value="<:$title_|escape:'html':>"/> <br/>
					</li>
					<li>
						<span><:$description:></span><br/>
					</li>
					<li>
						<textarea type="text" name="description" id="description" ><:$description_|escape:'html':></textarea>
						<span class="red" id="error_valid_description" style="display: none;"><:$errorDescription:></span>
					</li>
					<li>
						<input type="submit" value="Save"/>
						<input type=button onClick="window.location.href='<:$ctx:>/user/album/albumsetting/'" value='Cancel'>
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
		<div id="user_info_help" class="page_help">
		<:$help:><div><:$hint:></div>
	</div>
</div>