<?php /* Smarty version Smarty-3.0.7, created on 2011-05-23 19:03:17
         compiled from "C:\Users\son\Desktop\Tai lieu lam viec\PHP\xampp\htdocs\vimeoc\application/templates/mail/mail_forgotpassword.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13564dda3ef5438d05-61508960%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e52f06a64417596fa7c8d540200eba5eafeaa776' => 
    array (
      0 => 'C:\\Users\\son\\Desktop\\Tai lieu lam viec\\PHP\\xampp\\htdocs\\vimeoc\\application/templates/mail/mail_forgotpassword.tpl',
      1 => 1306148580,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13564dda3ef5438d05-61508960',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
Forgot password
Dear Mr/Ms <?php echo $_smarty_tpl->getVariable('user')->value['full_name'];?>
 ,
Your username is <?php echo $_smarty_tpl->getVariable('user')->value['username'];?>

Please click here: http://localhost/vimeoc/auth/resetpassword/?email=<?php echo $_smarty_tpl->getVariable('user')->value['email'];?>
&secret=<?php echo $_smarty_tpl->getVariable('user')->value['code'];?>

Regard