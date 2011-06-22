<div id="channel_menu">
	<:if $show_user_avatar != 1:>
		<ul id="channel_thumb">
			<li>
				<:if $channelThumbnail != '':>
					<img src="<:$ctx:><:$channelThumbnail:>" width="100"/>
				<:else:>
					<img src="<:$ctx:>/images/icon-video.gif" width="100"/>
				<:/if:>
			</li>
		</ul>
	<:/if:>
	<ul>
		<li>
			<a href="#"><:$menuChannel:></a>
		</li>
		<li>
			<a href="<:$ctx:>/channel/createNewChannel/?channelId=<:$channelId:>"><:$menuchannelcreate:></a>
		</li>
		<li>
			<a href="<:$ctx:>/channel/channelsetting/?channelId=<:$channelId:>"><:$menuchannelsetting:></a>
		</li>
		<li>
			<a href="#"><:$menuchannelthumbnail:></a>
		</li>
		<li>
			<a href="#"><:$menuchanneladdto:></a>
		</li>
		<li>
			<a href="#"><:$menuchannelarrange:></a>
		</li>
		<li>
			<a href="<:$ctx:>/channel/channeldelete/?channelId=<:$channelId:>"><:$menuchanneldelete:></a>
		</li>
		<li>
			<a href="#"/><:$menuBackToChannel:></a>
		</li>
	</ul>
</div>
