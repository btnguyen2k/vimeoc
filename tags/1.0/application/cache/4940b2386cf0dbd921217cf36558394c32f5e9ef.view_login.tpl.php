<?php /*%%SmartyHeaderCode:186044dd24387d32a14-87145178%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4940b2386cf0dbd921217cf36558394c32f5e9ef' => 
    array (
      0 => 'C:\\Users\\son\\Desktop\\Tai lieu lam viec\\PHP\\xampp\\htdocs\\vimeoc\\application/templates/view_login.tpl',
      1 => 1305618918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '186044dd24387d32a14-87145178',
  'has_nocache_code' => false,
  'cache_lifetime' => 3600,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!$no_render) {?>
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
		<h1 align="center">Login</h1>
			<form onSubmit="return checkEmail()" name="signupform">Email 
			<input name="email" type="text" class="inputs" id="email_address"
			size="35" maxlength="255"> 
			<div>
				Password
				<input id="password" type="password">
				</input>
			</div>
			<div>
				<input type="submit" value="Log in"/><a href="forgotpassword" >[Forgot your password ?]</a>
			</div>
		</form>
	</body>
</html>
<?php } ?>