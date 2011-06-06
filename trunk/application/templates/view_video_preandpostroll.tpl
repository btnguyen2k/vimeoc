
<h1 align="center"><:$title:></h1>
<div id="video_preandpostroll" class="video_page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
	<div id="video_preandpostroll_body" class="video_page_body">	
		<div>
			<br/>
			<:if $successMessage eq "":>
  				 &nbsp;
			<:else:>
   				<span class="green" align="center"><:$successMessage:></span>
			<:/if:>
		</div>
		<form action="<:$ctx:>/video/preandpostroll" method="post" name="preandpostrollform">
			<fieldset>
				<ul>
					<div>
						<input type="checkbox" id="album_check1" name="albums1"/><:$PreRoll:>
					</div>
					
					<div>
						<input type="checkbox" id="album_check2" name="albums2"/><:$PostRoll:>
					</div>
					
					<div>
						<input type="submit" value="Save"  />
					</div>
				</ul>
			</fieldset>
		</form>
	</div>
</div>