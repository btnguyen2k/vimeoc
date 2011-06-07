<title>Forgot Password</title>
<script  type="text/javascript">
	function checkEmail(){	
	    var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
	    if(pattern.test(document.forgotpasswordform.email.value)){
	    	$("#error_valid_email").hide();        
			return true;   
	    }else{   
	    	$("#error_valid_email").show();
			return false;
	    }
	}
</script>
<h1 align="center"><:$title:></h1>
	<:if $error eq "":>
	   &nbsp;
	<:else:>
	   <span class="red"><:$error:></span>
	<:/if:>
	<br/>
	<:if $errorNull eq "":>
	   &nbsp;
	<:else:>
	   <span class="red"><:$errorNull:></span>
	<:/if:>
<form onSubmit="return checkEmail()" name="forgotpasswordform" action="<:$ctx:>/auth/forgotpassword/" method="post">
	<:$email:> <input name="xemail" type="text" class="inputs" id="email_address" size="35" maxlength="255"/>
	<span class="red" id="error_valid_email" style="display: none;"><:$emailInvalid:></span>
	<div>
		<input type="submit" value="Help Me" />
	</div>
</form>

