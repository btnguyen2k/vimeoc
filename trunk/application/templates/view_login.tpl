
<html>
	<head>
		<title>Log in</title>
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
								alert("true");
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
	</head>
	<body>
		<h1 align="center">{$title}</h1>
			<form onSubmit="return checkEmail()" name="signupform">{$email} 
			<input name="email" type="text" class="inputs" id="email_address""
			size="35" maxlength="255"> 
			<div>
				{$password}
				<input id="password" type="password">
				</input>
			</div>
			<div>
				<input type="submit" value="Log in" /><a href="#" >[Forgot your password ?]</a>
			</div>
		</form>
	</body>
</html>
