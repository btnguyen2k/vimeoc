<?php /* Smarty version Smarty-3.0.7, created on 2011-05-24 17:08:36
         compiled from "C:\Users\son\Desktop\Tai lieu lam viec\PHP\xampp\htdocs\vimeoc\application/templates/view_signup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:107004ddb7594d6f483-55570961%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4847d23744df2a9ca550e136ca33348be0447b90' => 
    array (
      0 => 'C:\\Users\\son\\Desktop\\Tai lieu lam viec\\PHP\\xampp\\htdocs\\vimeoc\\application/templates/view_signup.tpl',
      1 => 1306228113,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '107004ddb7594d6f483-55570961',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
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
<h1 align="center"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</h1>

<form onSubmit="return checkEmail()" name="signupform" action="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/auth/signup/" method="post">
	<div>
		<?php echo $_smarty_tpl->getVariable('fullname')->value;?>

		<input id="fullname" name="fullname" />
	</div>
	<div>
		<?php echo $_smarty_tpl->getVariable('email')->value;?>
 
	<input name="email" type="text" class="inputs" id="email_address""
	size="35" maxlength="255"><?php if ($_smarty_tpl->getVariable('errorMessage')->value==''){?>
   &nbsp;
<?php }else{ ?>
   <span class="red"><?php echo $_smarty_tpl->getVariable('errorMessage')->value;?>
</span>
<?php }?>
	</div> 
	<div>
		<?php echo $_smarty_tpl->getVariable('password')->value;?>

		<input id="password" type="password" name="password" />
	</div>
	<div>
		<?php echo $_smarty_tpl->getVariable('rpassword')->value;?>

		<input id="rpassword" type="password" name="rpassword" />
	</div>
	<div>	
		<input id="agree" type="checkbox" name="agree"/> <?php echo $_smarty_tpl->getVariable('understand')->value;?>
<a href="#"><?php echo $_smarty_tpl->getVariable('term')->value;?>
</a>
	</div>

	<div>
		<input type="submit" value="Sign Up" />
	</div>	
</form>	