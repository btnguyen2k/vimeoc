<script  type="text/javascript">		
function checkEmail()
{	
	var x = document.getElementById("password").value;
	if(x==""){
		alert("Password not null");
		return false;
	}else{
	    var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
	    if(pattern.test(document.loginform.email.value)){     
			return true;  
	    }else{   
			alert("Email invailid"); 
			return false;
		}
	}
}
</script>
<h1 align="center">{$loginForm}</h1>
{if $errorMessage eq ""}
   &nbsp;
{else}
   <span class="red">{$errorMessage}</span>
{/if}
<form onSubmit="return checkEmail()" action="{$ctx}/auth/login/" name="loginform" method="post">
	<div>
		{$email}<input name="email" type="text" value="{$username}" class="inputs" id="email_address" size="35" maxlength="255">
	</div> 
	<div>
		{$password}<input id="password" name="password" type="password" />
	</div>
	<div>
		<input type="submit" value="{$submit}"/><a href="{$ctx}/auth/forgotPassword">[Forgot your password ?]</a>
	</div>
</form>
