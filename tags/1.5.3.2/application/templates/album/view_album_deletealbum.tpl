<div id="album_delete" class="page">
	<:include file="<:$base_dir_templates:>/blocks/album_left_menu.tpl":>	
	<div id="album_albumdelete_body" class="page_body">
		<center><h1><:$albumName|escape:'html':>-<:$name:></h1></center>
		<form action="<:$ctx:>/album/albumDelete/?albumId=<:$albumId:>" method="post" name="albumDelete" >
			<fieldset>
				<ul>
					<li>
						<span ><center><:$question:></span></center><br/>
					</li>
					<li>
						<center>
							<input type="submit" value="Yes" />
							<input type="button" value="No" onClick="window.location.href='<:$ctx:>/album/<:$albumId:>'">
						</center>
					</li>
					<li>
						<input type="hidden" id="albumId" name="albumId" value="<:$albumId:>" />
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
	<div id="user_info_help" class="page_help">
		Help?<div><:$hint:></div>
	</div>
</div>	