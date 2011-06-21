<?php /* Smarty version Smarty-3.0.7, created on 2011-05-28 01:23:08
         compiled from "D:/Workspace/GPV/Projects/vimeoc/application/templates/view_home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:286784ddfec0c9bcb76-97547160%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7ec265cdc0450a1d1329c51cd794966c45eda631' => 
    array (
      0 => 'D:/Workspace/GPV/Projects/vimeoc/application/templates/view_home.tpl',
      1 => 1306511564,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '286784ddfec0c9bcb76-97547160',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<center>
	<h1>Welcome to our product</h1><br/>
	<a href="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/auth/login" title="Sign in">Sign in</a> 
	or <a href="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/auth/signup" title="Register">Register</a> now.
</center>

