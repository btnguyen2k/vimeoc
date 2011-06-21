<?php /* Smarty version Smarty-3.0.7, created on 2011-05-28 01:23:10
         compiled from "D:/Workspace/GPV/Projects/vimeoc/application/templates/view_login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:140234ddfec0ece1bf0-91159625%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e2a0fd8f81dcd37ac773f00adf24d5733a4bc8c7' => 
    array (
      0 => 'D:/Workspace/GPV/Projects/vimeoc/application/templates/view_login.tpl',
      1 => 1306511564,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '140234ddfec0ece1bf0-91159625',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script  type="text/javascript">		
function checkEmail()
{	
	var x = document.getElementById("password").value;
	var e = document.getElementById("email_address").value;
	
	var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
	var flag=true;
	
    if(pattern.test(e)){     
    	$("#error_valid_email").hide();
    }else{   
    	$("#error_valid_email").show();
    	flag=false;
	}
	if(x==""){
		$("#error_password_invalid").show();
		flag=false;
	}else{
		$("#error_password_invalid").hide();
	}	 
	return flag;
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
		<span class="red" id="error_valid_email" style="display: none;"><?php echo $_smarty_tpl->getVariable('emailInvalid')->value;?>
</span>
		
	</div> 
	<div>
		<?php echo $_smarty_tpl->getVariable('password')->value;?>
<input id="password" name="password" type="password" />
		<span class="red" id="error_password_invalid" style="display: none;"><?php echo $_smarty_tpl->getVariable('passwordInvalid')->value;?>
</span>
	</div>
	<div>
		<input type="submit" value="<?php echo $_smarty_tpl->getVariable('submit')->value;?>
"/><a href="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/auth/forgotPassword">[Forgot your password ?]</a>
	</div>
</form>
