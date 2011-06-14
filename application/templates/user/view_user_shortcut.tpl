<script type="text/javascript">
	function checkProfileAlias(form){
		var regex = /^[a-zA-Z0-9]{1,16}$/;
		var alias = $(form).find("input[name=alias]").val();		

		var flag = regex.test(alias) && alias.length <= 16;

		if(!flag){
			$("#error_valid_alias").show();
			return false;
		}else{
			$("#error_valid_alias").hide();
			return true;
		}
	}
</script>
<div id="user_shortcut" class="user_page">
	<:include file="<:$base_dir_templates:>/blocks/user_left_menu.tpl":>
	
	<div id="user_shortcut_body" class="user_page_body">
		<center><h1><:$title:></h1></center><br/>		
		<span class="red"><:$errorMessage:></span>
		<span class="green"><:$successMessage:></span>
		<form action="<:$ctx:>/user/profileShortcut/" method="post" onsubmit="return checkProfileAlias(this);">
			<fieldset>
				<ul>
					<li>
						<span><:$profileShortcut:></span><br/>
						<:$domain:>/<input name="alias" value="<:$alias:>" maxlength="16"/>	
						<span class="red" id="error_valid_alias" style="display: none;">Invalid shortcut</span>					
					</li>
					<li>
						<span>It can be up to 16 characters long, but only letters and numbers</span>
					</li>
					<li>
						<input type="submit" value="Save" />
					</li>
				</ul>				
			</fieldset>
		</form>
	</div>
	
	<div id="user_info_help" class="user_page_help">
		Help?<div><:$hint:></div>
	</div>
</div>