<?php /*%%SmartyHeaderCode:288394dd22c375ba454-07240720%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4847d23744df2a9ca550e136ca33348be0447b90' => 
    array (
      0 => 'C:\\Users\\son\\Desktop\\Tai lieu lam viec\\PHP\\xampp\\htdocs\\vimeoc\\application/templates/view_signup.tpl',
      1 => 1305621132,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '288394dd22c375ba454-07240720',
  'cache_lifetime' => 3600,
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?><html>
	<head>
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
	</head>
	<body>
		<h1 align="center">Membership Signup</h1>
		
			<div>
				Full Name
				<input id="fullname">
				
				</input>
			</div>
		<form onSubmit="return checkEmail()" name="signupform">Email 
			<input name="email" type="text" class="inputs" id="email_address""
			size="35" maxlength="255"> 
			<div>
				Password
				<input id="password" type="password">
				</input>
			</div>
			<div>
				Retype Password
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
</html><?php } ?>