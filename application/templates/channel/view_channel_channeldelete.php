<div id="channel_delete" class="channel_page">
	<:include file="<:$base_dir_templates:>/blocks/channel_left_menu.tpl":>	
	<div id="channel_channeldelete_body" class="channel_page_body">
		<center><h1><:$title_:>-<:$name:></h1></center>
		<span class="green" align="center"><:$successMessage:></span>
		<form action="<:$ctx:>/channel/channelSetting/?channelId=<:$channelId:>" method="post" name="channelcreate" onSubmit="return checkValidForm(this)" >
			<fieldset>
				<ul>
					<li>
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
</div>