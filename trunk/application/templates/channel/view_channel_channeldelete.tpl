<div id="channel_delete" class="page">
	<:include file="<:$base_dir_templates:>/blocks/channel_left_menu.tpl":>	
	<div id="channel_channeldelete_body" class="page_body">
		<center><h1><:$title:>-<:$name:></h1></center>
		<span class="green" align="center"><:$successMessage:></span>
		<form action="<:$ctx:>/channel/channelDelete/?channelId=<:$channelId:>" method="post" name="channeldelete" >
			<fieldset>
				<ul>
					<li>
						<span ><center><:$question:></span></center><br/>
					</li>
					<li>
						<center>
							<input type="submit" value="Yes" />
							<input type="button" value="No" />
						</center>
					</li>
					<li>
						<input type="hidden" id="channelId" name="channelId" value="<:$channelId:>" />
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
	<div id="user_info_help" class="page_help">
		Help?<div><:$hint:></div>
	</div>
</div>