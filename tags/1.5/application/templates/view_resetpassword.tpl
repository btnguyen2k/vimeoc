<<script type="text/javascript">
<!--
	function validatePassword(){
		var password=$("#password").val();
		var flag=true;
	
		if(password.length<5){
			$("#error_less_password").show();
			flag=false;
		}else{
			$("#error_less_password").hide();
		}
		return flag;
	}
//-->
</script>
<h1 align="center"><:$title:></h1>
<form onSubmit="return validatePassword()" name="resetpasswordform" action="<:$ctx:>/auth/resetPassword/" method="post">
	<div>
		<:$password:><input id="password" type="password" name='password'/>
		<span class="red" id="error_less_password" style="display: none;"><:$passwordInvalid:></span>
		<input type="hidden" name="email" value="<:$email:>"/>
	</div>
	<div>
		<input id="save" type="submit" value="Save"/>
	</div>
</form>