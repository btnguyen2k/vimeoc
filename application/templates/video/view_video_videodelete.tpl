<div id="video_delete" class="page">
	<:include file="<:$base_dir_templates:>/blocks/video_left_menu.tpl":>
			<div id="video_delete_body" class="page_body">
				<center><h1><:$videoName:> - <:$name:></h1></center>
				<form action="<:$ctx:>/video/videoDelete/?videoId=<:$videoId:>" method="post" name="albumDelete" >
					<fieldset>
						<ul>
							<li>
								<span ><center><:$question:></span></center><br/>
							</li>
							<li>
								<center>
									<input type="submit" value="Yes" />
									<input type="button" value="No" onClick="window.location.href='<:$ctx:>/video/videopage/?videoId=<:$videoId:>'">
								</center>
							</li>
							<li>
								<input type="hidden" id="videoId" name="videoId" value="<:$videoId:>" />
							</li>
						</ul>
					</fieldset>
				</form>
			</div>
		<div id="user_info_help" class="page_help">
			Help?<div><:$hint:></div>
		</div>
</div>