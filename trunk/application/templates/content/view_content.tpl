<div id="content_list">
<:include file="<:$base_dir_templates:>/blocks/content_list_module.tpl":>
</div>
<div id="content">
	<div>
		<h1><:$content['title']|escape:'html':></h1>
		<:$content['body']:>
	</div>
</div>