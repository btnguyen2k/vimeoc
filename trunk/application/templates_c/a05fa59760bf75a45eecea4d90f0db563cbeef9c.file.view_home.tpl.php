<?php /* Smarty version Smarty-3.0.7, created on 2011-05-25 15:26:07
         compiled from "E:\work\env\xampp\htdocs\vimeoc\application/templates/view_home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:234844ddcaf0f9f05b0-00608562%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a05fa59760bf75a45eecea4d90f0db563cbeef9c' => 
    array (
      0 => 'E:\\work\\env\\xampp\\htdocs\\vimeoc\\application/templates/view_home.tpl',
      1 => 1306234488,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '234844ddcaf0f9f05b0-00608562',
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

