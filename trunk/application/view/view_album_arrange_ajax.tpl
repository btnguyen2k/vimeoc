<:foreach from=$videos key=k item=v:>
	<a href="<:$ctx:>/video/<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>" /></a><br/>
	<:$messages['video.videoaddtoalbum.title']:> <:$v['video_title']|escape:'html':><br/>
	<div class="creation_date"><:$messages['video.videoaddtoalbum.upload']:> <span class="relative_time"><:$v['creation_date']:></span></div><br/>
<:/foreach:>