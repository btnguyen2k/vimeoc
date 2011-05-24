<?php /* Smarty version Smarty-3.0.7, created on 2011-05-24 15:08:39
         compiled from "C:\Users\son\Desktop\Tai lieu lam viec\PHP\xampp\htdocs\vimeoc\application/templates/decorator/default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5054ddb597791a217-85550743%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5250a9811fd63e2dffbfdd2599d88ad7d39b24f7' => 
    array (
      0 => 'C:\\Users\\son\\Desktop\\Tai lieu lam viec\\PHP\\xampp\\htdocs\\vimeoc\\application/templates/decorator/default.tpl',
      1 => 1306220527,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5054ddb597791a217-85550743',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php  $_config = new Smarty_Internal_Config("template.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('base_dir_decorator')->value)."/default_header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
</head>
<body>
<center>
<div id="main">
<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('body_code')->value), $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('base_dir_decorator')->value)."/default_footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
</div>
</center>
</body>
</html>