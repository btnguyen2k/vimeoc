<title>Ongsoft</title>
<script  type="text/javascript">
	function checkEmail()
	{	
		var x = document.getElementById("password").value;
		var y = document.getElementById("rpassword").value;
		var z = document.getElementById("fullname").value;
		//var a = document.getElementById("agree").value;
		if(z=="")
		{
			alert("Full name not null");
			return false;
		}
		
		else if(x=="")
		{
			alert("Password not null");
			return false;
		}
		else if(y=="")
		{
			alert("Retype Password not null");
			return false;
		}
		else if(x!=y)
		{
			alert("Password and retype the password must be the same !");
			return false;
		}	
		else if(!document.signupform.agree.checked)
		{
			alert("You must checked the term of service");
			return false;
		}
		else
		{
		    var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
		    if(pattern.test(document.signupform.email.value))
			{         
				alert("Wellcome !");
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
<h1 align="center">{$title}</h1>
<div>
	{$fullname}
	<input id="fullname" name="fullname" />
</div>
<form onSubmit="return checkEmail()" name="signupform" action="/vimeoc/auth/signup/" method="post">
		{$email} 
	<input name="email" type="text" class="inputs" id="email_address""
	size="35" maxlength="255"> 
	<div>
		{$password}
		<input id="password" type="password" name="password" />
	</div>
	<div>
		{$rpassword}
		<input id="rpassword" type="password" name="rpassword" />
	</div>
	<div>	
		<input id="agree" type="checkbox" name="agree"/> {$understand}<a href="#">{$term}</a>
	</div>

	<div>
		<input type="submit" value="Sign Up" />
	</div>	
</form>	