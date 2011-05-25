<div id="user_menu">
	<ul class="portrait">
		<li>
			<a href="#">
				{if $userAvatar != null}
				<img src="{$ctx}/images/upload/{$userAvatar}" width="50" height="50"/>
				{else}
				<img src="{$ctx}/images/avatar.png" width="50" height="50"/>
				{/if}
			</a>
		</li>
	</ul>
	<ul>
		<li>
			<a href="#">{$menuUploadVideo}</a>
		</li>
		<li>
			<a href="{$ctx}/user/video">{$menuVideos}</a>
		</li>
		<li>
			<a href="#">{$menuAlbums}</a>
		</li>
	</ul>
	<ul>
		<li>
			<a href="{$ctx}/user/personalInfo">{$menuPersonalInfo}</a>
		</li>
		<li>
			<a href="{$ctx}/user/portrait">{$menuPortrait}</a>
		</li>
		<li>
			<a href="#">{$menuPassword}</a>
		</li>
		<li>
			<a href="{$ctx}/user/profileShortcut">{$menuShortcutURL}</a>
		</li>
		<li>
			<a href="{$ctx}/auth/logout">{$menuLogout}</a>
		</li>
	</ul>
</div>