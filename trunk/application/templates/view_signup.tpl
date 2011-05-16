<html>
	<head>
		<title>Ongsoft</title>
		<script  type="text/javascript">
			
					function checkEmail()
					{	
						var x = document.getElementById("password").value;
						var y = document.getElementById("rpassword").value;
						var z = document.getElementById("fullname").value;
						if(x=="")
						{
							alert("Password not null");
							return false;
						}
						else if(y=="")
						{
								alert("Retype Password not null");
								return false;
						}
						else if(z=="")
						{
								alert("Full name not null");
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
		
			<div>
				{$fullname}
				<input id="fullname">
				
				</input>
			</div>
		<form onSubmit="return checkEmail()" name="signupform">{$email} 
			<input name="email" type="text" class="inputs" id="email_address""
			size="35" maxlength="255"> 
			<div>
				{$password}
				<input id="password" type="password">
				</input>
			</div>
			<div>
				{$rpassword}
				<input id="rpassword" type="password">
				
				</input>
			</div>
			<div>	
				<input id="agree" type="checkbox"/> understand and agree with <a href="#">Terms of Service</a>
			</div>

			<div>
				<input type="submit" value="SIgn Up" />
			</div>	
		</form>	
	</body>
</html>