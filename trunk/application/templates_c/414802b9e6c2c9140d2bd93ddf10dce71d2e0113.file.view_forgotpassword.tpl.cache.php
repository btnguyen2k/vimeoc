<?php /* Smarty version Smarty-3.0.7, created on 2011-05-16 17:56:00
         compiled from "C:\Users\son\Desktop\Tai lieu lam viec\PHP\xampp\htdocs\vimeoc\application/templates/view_forgotpassword.tpl" */ ?>
<?php /*%%SmartyHeaderCode:62574dd0c16064fe17-68493219%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '414802b9e6c2c9140d2bd93ddf10dce71d2e0113' => 
    array (
      0 => 'C:\\Users\\son\\Desktop\\Tai lieu lam viec\\PHP\\xampp\\htdocs\\vimeoc\\application/templates/view_forgotpassword.tpl',
      1 => 1305539623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '62574dd0c16064fe17-68493219',
  'function' => 
  array (
  ),
  'cache_lifetime' => 3600,
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<html>
	<head>
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
	</head>
<body>
	
	
<h1 align="center"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</h1>
<form onSubmit="return checkEmail()" name="signupform"><?php echo $_smarty_tpl->getVariable('email')->value;?>
 <input name="email" type="text" class="inputs" id="email_address" "
	size="35" maxlength="255"> 
	<div>
	<input type="submit" value="Help Me" />
	</div>
</form>
</body>
</html>
