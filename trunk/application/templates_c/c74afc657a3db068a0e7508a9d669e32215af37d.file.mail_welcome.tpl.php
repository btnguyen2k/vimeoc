<?php /* Smarty version Smarty-3.0.7, created on 2011-05-24 17:24:39
         compiled from "C:\Users\son\Desktop\Tai lieu lam viec\PHP\xampp\htdocs\vimeoc\application/templates/mail/mail_welcome.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20524ddb7957da8d68-25358529%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c74afc657a3db068a0e7508a9d669e32215af37d' => 
    array (
      0 => 'C:\\Users\\son\\Desktop\\Tai lieu lam viec\\PHP\\xampp\\htdocs\\vimeoc\\application/templates/mail/mail_welcome.tpl',
      1 => 1306229042,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20524ddb7957da8d68-25358529',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
Wellcome to vimeoc
Dear Mr/Ms <?php echo $_smarty_tpl->getVariable('user')->value['full_name'];?>

your username is <?php echo $_smarty_tpl->getVariable('user')->value['username'];?>

your password is <?php echo $_smarty_tpl->getVariable('user')->value['password'];?>

Now, you were one of member in vimeoc.


