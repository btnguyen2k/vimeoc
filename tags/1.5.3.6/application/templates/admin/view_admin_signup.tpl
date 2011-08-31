<script type="text/javascript">
	function validate()
	{

		var password=$("#password").val();
		var fullname=$("#fullname").val();
		var email=$("#email").val();
		var term=$("#agree").attr("checked");
		var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
		var flag=true;



		if(fullname.length>150){
			$("#error_length_fullname").show();
			flag=false;
		}else{
			$("#error_length_fullname").hide();
		}

		if(email.length>50){
			$("#error_length_email").show();
			flag=false;
		}else{
			$("#error_length_email").hide();
		}

		if(password==""&&fullname==""&&email==""){
			$("#error_existed_email").hide();
			flag=false;
		}

		if(password==""){
			$("#error_valid_password").show();
			$("#error_less_password").hide();
			flag=false;
		}
		else if(password.length<5){
			$("#error_less_password").show();
			$("#error_valid_password").hide();
			flag=false;
		}else{
			$("#error_less_password").hide();
			$("#error_valid_password").hide();
		}

		if(fullname==""){
			$("#error_valid_fullname").show();
			flag=false;
		}else{
			$("#error_valid_fullname").hide();
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

<div id="admin_user_list" class="page">
	<:include file="<:$base_dir_templates:>/blocks/admin_left_menu.tpl":>
	<div id="admin_user_list_body" class="page_body">
		<h1 align="center"><:$title:></h1>
		<form onSubmit="return validate()" name="signupform" action="<:$ctx:>/admin/createNewAccount/" method="post">
		<div>
			<fieldset>
				<ul>
					<li>
						<:$fullname:><input type="text" id="fullname" name="fullname" value="<:$fullname_|escape:'html':>" />
						<span class="red" id="error_valid_fullname" style="display: none;"><:$fullnameInvalid:></span>
						<span class="red" id="error_length_fullname" style="display: none;"><:$fullnamelength:></span>
					</li>
					<li>
						<:$email:><input type="text" id="email" name="email" value="<:$username_|escape:'html':>" />
						<span class="red" id="error_valid_email" style="display: none;"><:$emailInvalid:></span>
						<:if $errorMessage eq "":>
				  			 &nbsp;
						<:else:>
				   			<span class="red" id="error_existed_email"><:$username:> <:$errorMessage:></span>
						<:/if:>
					</li>
					<li>
						<span class="red" id="error_length_email" style="display: none;"><:$emaillength:></span>
					</li>
					<li>
						<:$password:><input type="password" id="password" name="password" />
						<span class="red" id="error_valid_password" style="display: none;"><:$passwordInvalid:></span>
					</li>
					<li>
						<span class="red" id="error_less_password" style="display: none;"><:$passwordless:></span>
					</li>
					<li>
					<:$role:>
						<select id="role" name="role">
						<:section name=a loop=$getrole:>
						  <option value="<:$getrole[a].id:>"><:$getrole[a].name|escape:'html':></option>
						<:/section:>
  						</select>
					</li>
					<li>
						<input type="submit" value="Sign up" />
					</li>
				</ul>
			</fieldset>
		</div>
	</div>
</div>
