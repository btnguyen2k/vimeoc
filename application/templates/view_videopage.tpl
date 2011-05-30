<h1 align="center">{$title}</h1>

	<div align="right">
		<a href="{$ctx}/video/videosetting">[Setting]</a><a href="{$ctx}/auth/Delete">[Delete]</a> 				
	</div>
	<div align="right">
		{$day}{$by}:<span class=blue>{$fullname}</span>
	</div>
	<div align="right">
		{$play}{$plays},{$comment}{$comments},{$like}{$likes}
	</div>
	<div align="right">
		{$tag}
	</div>
	<div align="right">
		{$albums}<span class=blue>{$album}</span>
	</div>
	<div align="left">
		{if $video.thumbnails_path != ''}
			<img src="{$video.thumbnails_path}" />
		{else}
			<img src="{$ctx}/images/icon-video.gif" width="100"/>
		{/if}
	</div>	