<div id="channel_menu"><br/><br/>
	<:if $show_user_avatar == 1:>
	<ul class="portrait">
		<li>			
			<a href="<:$ctx:>/">
			<:if $userAvatar != null:>
			<img class="userAvatar" src="<:$ctx:>/images/upload/<:$userAvatar:>" width="50" height="50"/>
			<:else:>
			<img class="userAvatar" src="<:$ctx:>/images/avatar.png" width="50" height="50"/>
			<:/if:>
			</a>
		</li>
	</ul>
	<:/if:>
	<:if $show_user_avatar != 1:>
		<ul id="channel_thumb">
			<li>
				<:if $channelThumbnail != '':>
					<img src="<:$ctx:>/images/upload/<:$channelThumbnail:>" width="100"/>
				<:else:>
					<img src="<:$ctx:>/images/channel.jpg" width="100"/>
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
			<a href="<:$ctx:>/channel/arrange/?channelId=<:$channelId:>"><:$menuchannelarrange:></a>
		</li>
		<li>
			<a href="<:$ctx:>/channel/channeldelete/?channelId=<:$channelId:>"><:$menuchanneldelete:></a>
		</li>
		<li>
			<a href="<:$ctx:>/channel/?channelId=<:$channelId:>"/><:$menuBackToChannel:></a>
		</li>
	</ul>
</div>
