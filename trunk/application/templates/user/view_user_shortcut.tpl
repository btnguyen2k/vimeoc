<script type="text/javascript">
	var reservedUrls = '<:$reservedUrl:>'.split(',');
	function checkProfileAlias(form){
		var allowReg = /^user[0-9]{1,12}$/;
		var defaultAlias = '<:$defaultAlias:>';
		var alias = $(form).find("input[name=alias]").val();		

		var flag = true;

		flag = shortcutReg.test(alias) && alias.length <= 16;

		if(allowReg.test(alias)){
			flag = alias == defaultAlias;
			if(!flag){
				$("#error_reserved_alias").show();
				$("#error_valid_alias").hide();
				return false;
			}else{
				$("#error_reserved_alias").hide();
			}
		}
		
		if(!flag){
			$(".top_error_msg").hide();
			$(".top_success_msg").hide();
			$("#error_valid_alias").show();			
			return false;
		}else{
			$("#error_valid_alias").hide();
			return true;
		}
	}
</script>
<div id="user_shortcut" class="page">
	<:include file="<:$base_dir_templates:>/blocks/user_left_menu.tpl":>
	
	<div id="user_shortcut_body" class="page_body">
		<center><h1><:$title:></h1></center><br/>		
		<span class="top_error_msg red"><:$errorMessage:></span>
		<span class="top_success_msg green"><:$successMessage:></span>
		<form action="<:$ctx:>/user/profileShortcut/" method="post" onsubmit="return checkProfileAlias(this);">
			<fieldset>
				<ul>
					<li>
						<span><:$profileShortcut:></span><br/>
						<:$domain:>/<input name="alias" value="<:$alias:>" maxlength="16"/>	
						<span class="red" id="error_valid_alias" style="display: none;"><:$shortcutInvalid:></span>
						<span class="red" id="error_reserved_alias" style="display: none;"><:$errorMessage:></span>											
					</li>
					<li>
						<span><:$notice:></span>
					</li>
					<li>
						<input type="submit" value="Save" />
					</li>
				</ul>				
			</fieldset>
		</form>
	</div>
	
	<div id="user_info_help" class="page_help">
		<:$help:><div><:$hint:></div>
	</div>
</div>