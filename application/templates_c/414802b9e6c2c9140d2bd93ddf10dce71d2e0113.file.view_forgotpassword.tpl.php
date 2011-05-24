<?php /* Smarty version Smarty-3.0.7, created on 2011-05-23 18:03:55
         compiled from "C:\Users\son\Desktop\Tai lieu lam viec\PHP\xampp\htdocs\vimeoc\application/templates/view_forgotpassword.tpl" */ ?>
<?php /*%%SmartyHeaderCode:279314dda310beee1c8-69059233%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '414802b9e6c2c9140d2bd93ddf10dce71d2e0113' => 
    array (
      0 => 'C:\\Users\\son\\Desktop\\Tai lieu lam viec\\PHP\\xampp\\htdocs\\vimeoc\\application/templates/view_forgotpassword.tpl',
      1 => 1306145032,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '279314dda310beee1c8-69059233',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
		<title>Forgot Password</title>
		<script  type="text/javascript">
			
					function checkEmail()
					{	
					    var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
					    
					    if(pattern.test(document.forgotpasswordform.email.value))
						{         
							alert("Welcome");
							return true;   
					    }
					    else
						{   
							alert("Email invailid"); 
							return false;
					    }
					}
		</script>
<h1 align="center"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</h1>
<?php if ($_smarty_tpl->getVariable('error')->value==''){?>
   &nbsp;
<?php }else{ ?>
   <span class="red"><?php echo $_smarty_tpl->getVariable('error')->value;?>
</span>
<?php }?>
<form onSubmit="return checkEmail()" name="forgotpasswordform" action="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/auth/forgotpassword/" method="post"/>
	<?php echo $_smarty_tpl->getVariable('email')->value;?>
 <input name="xemail" type="text" class="inputs" id="email_address" "
	size="35" maxlength="255"> 
	<div>
	<input type="submit" value="Help Me" />
	</div>
</form>

