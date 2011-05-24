<?php /* Smarty version Smarty-3.0.7, created on 2011-05-23 20:01:21
         compiled from "C:\Users\son\Desktop\Tai lieu lam viec\PHP\xampp\htdocs\vimeoc\application/templates/view_resetpassword.tpl" */ ?>
<?php /*%%SmartyHeaderCode:41274dda4c91951179-42481452%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd19ca08f2ff386569b438a094d6810f82ab6a36f' => 
    array (
      0 => 'C:\\Users\\son\\Desktop\\Tai lieu lam viec\\PHP\\xampp\\htdocs\\vimeoc\\application/templates/view_resetpassword.tpl',
      1 => 1306152002,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '41274dda4c91951179-42481452',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<title>Reset Password</title>
<h1 align="center"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</h1>
<form " name="resetpasswordform" action="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/auth/resetpassword/" method="post">
	<div>
		<?php echo $_smarty_tpl->getVariable('password')->value;?>

		<input id="password" type="password" name='password'/>
		<input type="hidden" name="email" value="<?php echo $_smarty_tpl->getVariable('email')->value;?>
"/>
	</div>
	<div>
	<input id="save" type="submit" value="Save"/>
	</div>
</form>