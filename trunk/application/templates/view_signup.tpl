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
						else if(document.getElementById("agree").checked=false)
						{
							alert("You must tick the checkbox to agree with website’s Terms of service.");
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
				<input id="fullname" name="fullname">
				
				</input>
			</div>
		<form onSubmit="return checkEmail()" name="signupform">{$email} 
			<input name="email" type="text" class="inputs" id="email_address""
			size="35" maxlength="255"> 
			<div>
				{$password}
				<input id="password" type="password" name="password">
				</input>
			</div>
			<div>
				{$rpassword}
				<input id="rpassword" type="password" name="rpassword">
				
				</input>
			</div>
			<div>	
				<input id="agree" type="checkbox"/> {$understand}<a href="#">{$term}</a>
			</div>

			<div>
				<input type="submit" value="Sign Up" action="vimeoc/auth/thankyou/" />
			</div>	
		</form>	