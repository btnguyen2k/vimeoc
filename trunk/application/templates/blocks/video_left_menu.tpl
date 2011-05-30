<div id="video_menu">
	<ul class="portrait">
		<li>
			<a href="#">
				<a href="{$ctx}/">
				{if $userAvatar != null}
				<img src="{$ctx}/images/upload/{$userAvatar}" width="50" height="50"/>
				{else}
				<img src="{$ctx}/images/icon-video.gif" width="50" height="50"/>
				{/if}
				</a>
			</a>
		</li>
	</ul>
	<ul>
		<li>
			<a href="#">{$videobasicinfo}</a>
		</li>
		<li>
			<a href="#">{$videothumbnail}</a>
		</li>
		<li>
			<a href="#">{$videovideofile}</a>
		</li>
	</ul>
	<ul>
		<li>
			<a href="#">{$videocustomurl}</a>
		</li>
		<li>
			<a href="#">{$videoaddto}</a>
		</li>
	</ul>
	<ul>
		<li>
			<a href="#">{$videodelete}</a>
		</li>
		<li>
			<a href="{$ctx}/user/videopage">{$videobacktovideo}</a>
		</li>
	</ul>
</div>