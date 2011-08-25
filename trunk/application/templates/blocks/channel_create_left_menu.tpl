<div id="channel_menu">
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
            <p>
            <:$smarty.session.fullname|escape:'html':>
            </p>
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
			<a href="<:$ctx:>/user/channel/"/><:$menumychannel:></a>
		</li>
	</ul>
	<:if $proxy eq true:>
	<ul>
		<li><a href="<:$ctx:>/admin/switchBackToAdmin">Switch back to admin</a>
	</ul>
	<:/if:>
</div>

