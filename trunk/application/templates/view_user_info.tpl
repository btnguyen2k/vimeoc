<script type="text/javascript">
	function checkUserInfoForm(form){
		var $form = $(form);
		var fullName = $form.find("input[name=fullName]").val();
		var email = $form.find("input[name=email]").val();
		var website = $form.find("input[name=website]").val();

		if($.trim(fullName) == '' || $.trim(email) == ''){
			$("#error_required_fields").show();
			return false;
		}else{
			$("#error_required_fields").hide();
		}

		if(!checkEmail(email)){
			$("#error_valid_email").show();
			return false;
		}else{
			$("#error_valid_email").hide();
		}

		if($.trim(website) != '' && !checkUrl(website)){
			$("#error_valid_url").show();
			return false;
		}else{
			$("#error_valid_url").hide();
		}
		return true;
	}
</script>

<div id="user_info" class="user_page">
	<:include file="<:$base_dir_templates:>/blocks/user_left_menu.tpl":>
	
	<div id="user_info_body" class="user_page_body">
		<center><h1><:$title:></h1></center><br/>
		<span class="red"><:$errorMessage:></span>
		<span class="green"><:$successMessage:></span>
		<form action="<:$ctx:>/user/personalInfo/" method="post" onsubmit="return checkUserInfoForm(this);">
			<fieldset>
				<ul>
					<li>
						<span><:$fullNameTitle:> *</span><br/>						
						<input type="text" name="fullName" value="<:$fullName:>"/>
					</li>					
					<li>
						<span><:$emailTitle:> *</span><br/>
						<input type="text" name="email" value="<:$email:>" readonly="readonly"/>
						<span class="red" id="error_valid_email" style="display: none;"><:$emailInvalid:></span>
					</li>
					<li>
						<span><:$yourWebsiteTitle:></span><br/>
						<input type="text" name="website" value="<:$website:>"/>
						<span class="red" id="error_valid_url" style="display: none;"><:$urlInvalid:></span>
					</li>
					<li>
						<span class="red" id="error_required_fields" style="display: none;"><:$requiredField:></span>
					</li>
					<li>
						<input type="submit" value="Save" />
					</li>
				</ul>
			</fieldset>
		</form>
	</div>
	
	<div id="user_info_help" class="user_page_help">
		Help?
	</div>
</div>