		<title>Forgot Password</title>
		<script  type="text/javascript">
			
					function checkEmail()
					{	
					    var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
					    if(pattern.test(document.signupform.email.value))
						{         
							alert("true");
							return true;   
					    }
					    else
						{   
							alert("Email invailid"); 
							return false;
					    }
					}
		</script>
<h1 align="center">{$title}</h1>
<form onSubmit="return checkEmail()" name="signupform">{$email} <input name="email" type="text" class="inputs" id="email_address" "
	size="35" maxlength="255"> 
	<div>
	<input type="submit" value="Help Me" />
	</div>
</form>

