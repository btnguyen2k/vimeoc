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
					<th><:$id:></th>
					<th><:$titleLable:></th>
					<th><:$createDate:></th>
					<th><:$creatorName:></th>
					<th><:$modifyDate:></th>
					<th><:$modifierName:></th>
					<th><:$publish:></th>
					<th><:$edit:></th>
					<th><:$status:></th>
					<th><:$delete:></th>
					<th><:$category:></th>
				</tr>
			<:foreach from=$contents key=k item=v:>
				<tr>
					<td><:$v['id']:></td>
					<td><:$v['title']:></td>
					<td><:$v['create_date']:></td>
					<td><:if isset($v['creator']):><:$v['creator']['full_name']|escape:'html':><:else:>#<:$v['creator_id']:><:/if:></td>
					<td><:$v['modify_date']:></td>
                    <td><:if isset($v['modifier']):><:$v['modifier']['full_name']|escape:'html':><:else:>#<:$v['modifier_id']:><:/if:></td>
					<td>
						<:if $v['publish'] eq 0:>
							<:$UnpublishLable:>
						<:else:>
							<:$publishLable:>
						<:/if:>
					</td>
					<td><a href="<:$ctx:>/content/updatecontent/?id=<:$v['id']:>"><:$edit:></a></td>
					<td>
						<:if $v['publish'] eq 0:>
							<a href="<:$ctx:>/content/publishContent/?contentId=<:$v['id']:>" onclick="return confirmActionPublish()"><:$publishLable:></a>
						<:else:>
							<a href="<:$ctx:>/content/unpublishContent/?contentId=<:$v['id']:>" onclick="return confirmActionUnPublish()"><:$UnpublishLable:></a>
						<:/if:>
					</td>
					<td><a href="<:$ctx:>/content/deleteContent/?contentId=<:$v['id']:>" onclick="return confirmActionDelete()"><:$delete:></a></td>
					<td>
						<:foreach from=$categories key=i item=c:>
							<:if $v['category_id'] eq $c['id']:>
								<:$c['name']:>
							<:/if:>
						<:/foreach:>
					</td>
				</tr>
			<:/foreach:>
		</table>
		<:$message:>
		<:$pagination:>
	</div>
</div>