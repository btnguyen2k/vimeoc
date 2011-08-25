<:foreach from=$videos key=k item=v:>
	<a href="<:$ctx:>/video/<:$v['id']:>"><img width="100" src="<:$v['thumbnails_path']:>" /></a><br/>
	title: <:$v['video_title']:><br/>
	<div class="creation_date">uploaded: <span class="relative_time"><:$v['creation_date']:></span></div><br/>
<:/foreach:>