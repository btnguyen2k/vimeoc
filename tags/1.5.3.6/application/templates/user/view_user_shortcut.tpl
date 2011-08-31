<script type="text/javascript">
	var reservedAlias = '<:$reservedUrl:>'.split(',');
	function checkProfileAlias(form){
        //reset: hide all error messages
        $("#error_reserved_alias").hide();
		$("#error_valid_alias").hide();
        $(".top_error_msg").hide();
        $(".top_success_msg").hide();

        var aliasRegExp = /^[a-zA-Z][a-zA-Z0-9]{0,15}$/;
        var defaultAliasRegExp = /^user[0-9]+$/;
        var defaultAlias = '<:$defaultAlias:>';
        var alias = $(form).find("input[name=alias]").val();

        //check for reserved alias
        for ( var i = 0; i < reservedAlias.length; i++ ) {
            if ( reservedAlias[i] == alias ) {
                $("#error_reserved_alias").show();
                return false;
            }
        }

        //check for default alias format
        if ( defaultAliasRegExp.test(alias) && alias != defaultAlias ) {
            $("#error_reserved_alias").show();
            return false;
        }

        //finally check alias format
        if ( alias != '' && !aliasRegExp.test(alias) ) {
            $("#error_valid_alias").show();
            return false;
        }

        return true;
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
						<:$domain:>/<input name="alias" value="<:$alias|escape:'html':>" maxlength="16"/>
						<span class="red" id="error_valid_alias" style="display: none;"><:$error_invalidShortcut:></span>
						<span class="red" id="error_reserved_alias" style="display: none;"><:$error_reservedAlias:></span>
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