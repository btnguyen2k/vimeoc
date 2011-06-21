<?php /* Smarty version Smarty-3.0.7, created on 2011-05-28 01:22:58
         compiled from "D:/Workspace/GPV/Projects/vimeoc/application/templates/mail/mail_forgotpassword.tpl" */ ?>
<?php /*%%SmartyHeaderCode:198134ddfec02672fb1-42487898%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '339dbe69744008829b36ba34ba35d75c4cc6e7cc' => 
    array (
      0 => 'D:/Workspace/GPV/Projects/vimeoc/application/templates/mail/mail_forgotpassword.tpl',
      1 => 1306511559,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '198134ddfec02672fb1-42487898',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
Forgot password
Dear Mr/Ms <?php echo $_smarty_tpl->getVariable('user')->value['full_name'];?>
 ,
Your username is <?php echo $_smarty_tpl->getVariable('user')->value['username'];?>

Please click <a href="<?php echo $_smarty_tpl->getVariable('user')->value['domain'];?>
/auth/resetPassword/?email=<?php echo $_smarty_tpl->getVariable('user')->value['email'];?>
&secret=<?php echo $_smarty_tpl->getVariable('user')->value['code'];?>
">here</a>
Regard