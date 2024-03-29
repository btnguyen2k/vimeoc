<link href="<:$ctx:>/css/userlist.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/userlist.js"></script>

<script type="text/javascript">
	function confirmActionDisable() {
	    if (confirm("Are you sure you want to disable the following user?"))
	    {
	    	$("form").submit();
	    }
	    else
	    {
	    	return false;
	    }
	  }

	function confirmActionEnable() {
	    if (confirm("Are you sure you want to enable the following user?"))
	    {
	    	$("form").submit();
	    }
	    else
	    {
	    	return false;
	    }
	  }

	function confirmActionDelete() {
	    if (confirm("Are you sure you want to delete the following user?"))
	    {
	    	$("form").submit();
	    }
	    else
	    {
	    	return false;
	    }
	  }

</script>

<div id="admin_user_list" class="page">
	<:include file="<:$base_dir_templates:>/blocks/admin_left_menu.tpl":>
	<div id="admin_user_list_body" class="page_body">
	<center><h1><:$title:></h1></center><br/>
	<form id="search_form" name="search_from" action="<:$ctx:>/admin/userlist/" method="GET">
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
		<input type="text" id="term" name="term" value="<:$search_term|escape:'html':>"></option>
		<input type="hidden" name="page" value="<:$page:>"></input>
		<input type="submit" value="Submit"></input>
	</form>
		<table border="1">
				<tr>
					<th><:$userid:></th>
					<th><:$username:></th>
					<th><:$fullname:></th>
					<th><:$status:></th>
					<th><:$creationDate:></th>
					<th><:$editProfile:></th>
					<th><:$changeStatus:></th>
					<th><:$deleteTitle:></th>
					<th><:$loginasUser:></th>
				</tr>
			<:foreach from=$users key=k item=v:>
				<tr>
					<td><:$v['id']:></td>
					<td><:$v['username']|escape:'html':></td>
					<td><:$v['full_name']|escape:'html':></td>
					<td>
						<:if $v['enabled'] eq 0:>
							<:$disable:>
						<:else:>
							<:$enable:>
						<:/if:>
					</td>
					<td><:$v['creation_date']:></td>
					<td><a href="<:$ctx:>/admin/editUserProfile/?userId=<:$v['id']:>"><:$edit:></a></td>
					<td>
						<:if $v['enabled'] eq 0:>
							<a href="<:$ctx:>/admin/enableAccount/?userId=<:$v['id']:>" onclick="return confirmActionEnable()"> <:$enable:></a>
						<:else:>
							<a href="<:$ctx:>/admin/disableAccount/?userId=<:$v['id']:>" onclick="return confirmActionDisable()"> <:$disable:></a></td>
						<:/if:>
					</td>
					<td><a href="<:$ctx:>/admin/deleteAccount/?userId=<:$v['id']:>" onclick="return confirmActionDelete()"><:$delete:></a></td>
					<td>
						<a href="<:$ctx:>/admin/loginAsUser/?userId=<:$v['id']:>"><:$login:></a>
					</td>
				</tr>
			<:/foreach:>
		</table>
		<:$message:>
		<:$pagination:>
	</div>
</div>
