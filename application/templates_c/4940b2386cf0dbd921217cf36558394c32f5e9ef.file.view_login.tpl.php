<?php /* Smarty version Smarty-3.0.7, created on 2011-05-23 14:55:57
         compiled from "C:\Users\son\Desktop\Tai lieu lam viec\PHP\xampp\htdocs\vimeoc\application/templates/view_login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:136914dda04fd649dc9-36990558%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4940b2386cf0dbd921217cf36558394c32f5e9ef' => 
    array (
      0 => 'C:\\Users\\son\\Desktop\\Tai lieu lam viec\\PHP\\xampp\\htdocs\\vimeoc\\application/templates/view_login.tpl',
      1 => 1306133751,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '136914dda04fd649dc9-36990558',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
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
	    if(pattern.test(document.loginform.email.value))
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
<h1 align="center"><?php echo $_smarty_tpl->getVariable('loginForm')->value;?>
</h1>
<?php if ($_smarty_tpl->getVariable('errorMessage')->value==''){?>
   &nbsp;
<?php }else{ ?>
   <span class="red"><?php echo $_smarty_tpl->getVariable('errorMessage')->value;?>
</span>
<?php }?>
<form onSubmit="return checkEmail()" action="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/auth/login/" name="loginform" method="post">
	<div>
		<?php echo $_smarty_tpl->getVariable('email')->value;?>
 <input name="email" type="text" value="<?php echo $_smarty_tpl->getVariable('username')->value;?>
" class="inputs" id="email_address" size="35" maxlength="255">
	</div> 
	<div>
		<?php echo $_smarty_tpl->getVariable('password')->value;?>
 <input id="password" name="password" type="password" />
	</div>
	<div>
		<input type="submit" value="<?php echo $_smarty_tpl->getVariable('submit')->value;?>
"/><a href="forgotpassword">[Forgot your password ?]</a>
	</div>
</form>
