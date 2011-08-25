<link href="<:$ctx:>/css/userlist.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<:$ctx:>/script/userlist.js"></script>
<script type="text/javascript">
	function validateForm(){
		var password=$("#password").val();
		var fullname=$("#fullname").val();
		var email=$("#email").val();
		var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
		var flag=true;
		
		if(password!=""){
			if(password.length<5){
				$("#error_invalid_password").show();
				flag=false;
			}else{
				$("#error_invalid_password").hide();
			}			
		}	 
		
		

		if(fullname=="" || email==""){
			$("#error_required_fields").show();
			flag=false;
		}
		else{
			$("#error_required_fields").hide();
		}
		
		if(fullname.length>150){
			$("#error_length_fullname").show();
			flag=false;
		}else{
			$("#error_length_fullname").hide();
		}	
		
	    if(pattern.test(email)){     
	    	$("#error_valid_email").hide();
	    }else{   
	    	$("#error_valid_email").show();
	    	flag=false;
		}
		return flag;
	}
</script>
<div id="admin_edit_user_profile" class="page">
	<:include file="<:$base_dir_templates:>/blocks/admin_left_menu.tpl":>
	<div id="admin_edit_user_profile_body" class="page_body">
		<center><h1><:$title:></h1></center><br/>
		<span class="red"><:$errorMessage:></span>
		<span class="green"><:$successMessage:></span>
		<form action="<:$ctx:>/admin/editUserProfile" method="post" onsubmit="return validateForm();">
			<fieldset>
				<ul>
					<li>
						<center><span><:$messages['admin.edit.user.edit.username']:> <:$username:></span></center>
					</li>
					<li>
						<span><:$fullNameTitle:> *</span><br/>						
						<input type="text" id="fullname" name="fullname" value="<:$fullname:>" maxlength="150"/>
						<input type="hidden" name="id" value="<:$id:>"/>
						<input type="hidden" name="username" value="<:$username:>"/>
						<span class="red" id="error_valid_fullname" style="display: none;"><:$fullnameInvalid:></span>
						<span class="red" id="error_length_fullname" style="display: none;"><:$fullnamelength:></span>
					</li>					
					<li>
						<span><:$emailTitle:> *</span><br/>
						<input type="text" id="email" name="email" value="<:$email:>"/>
						<span class="red" id="error_valid_email" style="display: none;"><:$emailInvalid:></span>
					</li>
					<li>
						<span class="red" id="error_required_fields" style="display: none;"><:$requiredField:></span>
					</li>
					<li>
						<span><:$newPasswordTitle:></span>
						<input type="password" id="password" name="password" value=""/>
						<span class="red" id="error_invalid_password" style="display: none"><:$passwordless:></span>
					</li>
					<li>
						<span><:$roleTitle:>: </span>
						<select id="role" name="role">
						<:section name=a loop=$roles:>
							<:if $role == $roles[a].id:>
								<option value="<:$roles[a].id:>" selected="selected"><:$roles[a].name:></option>
							<:else:>
								<option value="<:$roles[a].id:>"><:$roles[a].name:></option>
							<:/if:>
						<:/section:>
  						</select>
					</li>
					<li>
						<span><:$statusTitle:>: </span>
						<select id="status" name="status">
							<:if $status == "1":>
								<option value="1" selected="selected"><:$enable:></option>
								<option value="0"><:$disable:></option>
							<:else:>
								<option value="1"><:$enable:></option>
								<option value="0" selected="selected"><:$disable:></option>
							<:/if:>
						</select>
					</li>
					<li>
						<input type="submit" value="Update" />
					</li>

				</ul>
			</fieldset>
		</form>
	</div>
</div>