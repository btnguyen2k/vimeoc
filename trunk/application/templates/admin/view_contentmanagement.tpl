<link href="<:$ctx:>/css/userlist.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/userlist.js"></script>
<script type="text/javascript">
	function confirmActionPublish() {
	    if (confirm("Are you sure you want to publish the following content?"))
	    {
	    	$("form").submit();
	    }
	    else
	    {
	    	return false;
	    }
	  }
	
	function confirmActionUnPublish() {
	    if (confirm("Are you sure you want to unpublish the following user?"))
	    {
	    	$("form").submit();
	    }
	    else
	    {
	    	return false;
	    }
	  }
	
	function confirmActionDelete() {
	    if (confirm("Are you sure you want to delete the following content?"))
	    {
	    	$("form").submit();
	    }
	    else
	    {
	    	return false;
	    }
	  }

</script>
<div id="admin_contentmanagement" class="page">
	<:include file="<:$base_dir_templates:>/blocks/admin_left_menu.tpl":>
	<div id="admin_content_body" class="page_body">
	<center><h1><:$title:></h1></center><br/>
	<form id="search_form" name="search_from" action="<:$ctx:>/admin/contentList/" method="GET">
		<select id="sort" name="sort">
			<:foreach from=$sort_modes key=k item=v:>
				<option <:if $k == $sort_mode:>selected="selected"<:/if:> value="<:$k:>"><:$v:></option>
			<:/foreach:>
		</select>
		<select id="psize" name="psize">
			<:foreach from=$page_sizes key=k item=v:>
				<option <:if $k == $page_size:>selected="selected"<:/if:> value="<:$k:>"><:$v:></option>
			<:/foreach:>
		</select>
		<input type="text" id="term" name="term" value="<:$search_term:>"></option>
		<input type="hidden" name="page" value="<:$page:>"></input>
		<input type="submit" value="Submit"></input>
	</form>
	<table border="1">
				<tr>
					<th>Id</th>
					<th>Title</th>
					<th>create_date</th>
					<th>creator name</th>
					<th>modify_date</th>
					<th>modifier name</th>
					<th>publish status</th>
					<th>edit</th>
					<th>publish/unpublish</th>
					<th>delete</th>
				</tr>
			<:foreach from=$contents key=k item=v:>
				<tr>
					<td><:$v['id']:></td>
					<td><:$v['title']:></td>
					<td><:$v['create_date']:></td>
					<td><:$v['creator_id']:></td>
					<td><:$v['modify_date']:></td>
					<td><:$v['modifier_id']:></td>
					<td>
						<:if $v['publish'] eq 0:>
							unpublish
						<:else:>
							publish
						<:/if:>
					</td>
					<td><a href="<:$ctx:>/admin/updatecontent/?id=<:$v['id']:>">Edit</a></td>
					<td>
						<:if $v['publish'] eq 0:>
							<a href="<:$ctx:>/admin/publishContent/?contentId=<:$v['id']:>" onclick="return confirmActionPublish()">Publish</a>
						<:else:>
							<a href="<:$ctx:>/admin/unpublishContent/?contentId=<:$v['id']:>" onclick="return confirmActionUnPublish()">UnPublish</a>
						<:/if:>
					</td>
					<td><a href="<:$ctx:>/admin/deleteContent/?contentId=<:$v['id']:>" onclick="return confirmActionDelete()">Delete</a></td>					
				</tr>
			<:/foreach:>				
		</table>
		<:$message:>
		<:$pagination:>
	</div>
</div>