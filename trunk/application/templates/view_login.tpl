<script  type="text/javascript">		
function checkEmail()
{	
	var x = document.getElementById("password").value;
	if(x=="")
	{
		alert("Password not null");
		return false;
	}
	else
	{
	    var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
	    if(pattern.test(document.signupform.email.value))
		{     
			return true;  
	    }
	    else
		{   
		alert("Email invailid"); 
			return false;
		}
	}
}
</script>
<h1 align="center">{$loginForm}</h1>
{if $error eq ""}
   &nbsp;
{else}
   <span>{$error}</span>
{/if}
<form onSubmit="return checkEmail()" action="/vimeoc/auth/submitsucceed/" name="signupform">
	<div>
		{$email} <input name="email" type="text" class="inputs" id="email_address" size="35" maxlength="255">
	</div> 
	<div>
		{$password} <input id="password" name="password" type="password" />
	</div>
	<div>
		<input type="submit" value="{$submit}"/><a href="forgotpassword" action="vimeoc/auth/forgotpassword">[Forgot your password ?]</a>
	</div>
</form>