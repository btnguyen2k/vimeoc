<div id="channel_menu">
	<:if $show_user_avatar == 1 && authorized eq true :>
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
		<:if $create_channel != 1:>		
			<li>
				<a href="<:$ctx:>/channel/createNewChannel/?channelId=<:$channelId:>"><:$menuchannelcreate:></a>
			</li>
		<:/if:>
		<:if $authorized == true:>
			<li>
				<a href="<:$ctx:>/channel/channelsetting/?channelId=<:$channelId:>"><:$menuchannelsetting:></a>
			</li>
			<li>
				<a href="<:$ctx:>/channel/channelThumbnail/?channelId=<:$channelId:>"><:$menuchannelthumbnail:></a>
			</li>
			<li>
				<a href="<:$ctx:>/channel/arrange/?channelId=<:$channelId:>"><:$menuchannelarrange:></a>
			</li>
			<:if $create_channel != 1:>
				<li>
					<a href="<:$ctx:>/channel/channeldelete/?channelId=<:$channelId:>"><:$menuchanneldelete:></a>
				</li>
				<li>
					<a href="<:$ctx:>/channel/?channelId=<:$channelId:>"/><:$menuBackToChannel:></a>
				</li>
			<:/if:>
			<li>
				<a href="<:$ctx:>/user/channel/"/><:$menumychannel:></a>
			</li>
			<li>
				<a href="<:$ctx:>/user/video/"><:$videobacktovideo:></a>
			</li>
		<:/if:>		
	</ul>
	<:if $proxy eq true:>
	<ul>
		<li><a href="<:$ctx:>/admin/switchBackToAdmin">Switch back to admin</a>
	</ul>
	<:elseif $smarty.session.admin:>
	<ul>
		<li><a href="<:$ctx:>/admin">Administer Page</a>
	</ul>
	<:/if:>
	<ul>
	<li>
		<a href="<:$ctx:>/auth/logout"><:$menuLogout:></a>
	</li>
</div>
