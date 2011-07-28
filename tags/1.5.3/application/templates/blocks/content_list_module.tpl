<:if $contentLinkList|@count > 0:>
<div>
	<ul class="content-list">
		<:foreach from=$contentLinkList item=content:>
			<li>
				<a href="<:$ctx:>/content/<:$content['alias']:>" target="_blank"><:$content['title']:></a>
			</li>
		<:/foreach:>
	</ul>
</div>
<:/if:>