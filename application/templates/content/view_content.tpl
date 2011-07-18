<div id="user_content" class="page">
	<:include file="<:$base_dir_templates:>/blocks/user_left_menu.tpl":>
	<div id="user_content_body" class="page_body">
	<h1 align="center"><:$content['title']:>-<:$title:></h1>
		<form onSubmit="" name="contentform" action="" method="post">
		<:if $errorMessage eq "":>
	  			 &nbsp;
			<:else:>
	   			<span class="red" align="center"><:$errorMessage:></span>
			<:/if:>
			<fieldset>
				<ul>
					<li>
						<:$name:><input name="title" type="text" value="<:$content['title']:>" class="inputs" id="title"  maxlength="255" />
					</li>
					<li>
						<:$body:><textarea name="body" id="body" size="40"  ><:$content['body']:></textarea>
					</li>
					<li>
						<:$keyword:><textarea name="keuword" id="keyword" size="40"  ><:$content['keywords']:></textarea>
					</li>
					<li>
						<:if $content['publish'] eq 1:>
						Publish
						<:else:>
						Unpublish
						<:/if:>
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
</div>