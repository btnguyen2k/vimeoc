<link href="<:$ctx:>/css/userlist.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/userlist.js"></script>
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
		<input type="text" id="term" name="term" value="<:$search_term:>"></option>
		<input type="hidden" name="page" value="<:$page:>"></input>
		<input type="submit" value="Submit"></input>

	</form>
			<table>
				<tr>
					<th>User Id</th>
					<th>Username</th>
					<th>Fullname</th>
					<th>Enable/Disable</th>
					<th>Creation date</td>
				</tr>
			<:foreach from=$users key=k item=v:>
				<tr>
					<td><:$v['id']:></td>
					<td><:$v['username']:></td>
					<td><:$v['full_name']:></td>
					<td><:$v['account_enabled']:></td>
					<td><:$v['creation_date']:></td>
				</tr>
			<:/foreach:>
				
			</table>
		<:$message:>
		<:$pagination:>
	</div>	
</div>
