<?php /* Smarty version Smarty-3.0.7, created on 2011-05-17 17:52:17
         compiled from "C:\Users\son\Desktop\Tai lieu lam viec\PHP\xampp\htdocs\vimeoc\application/templates/view_resetpassword.tpl" */ ?>
<?php /*%%SmartyHeaderCode:229074dd2455117f240-34091185%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd19ca08f2ff386569b438a094d6810f82ab6a36f' => 
    array (
      0 => 'C:\\Users\\son\\Desktop\\Tai lieu lam viec\\PHP\\xampp\\htdocs\\vimeoc\\application/templates/view_resetpassword.tpl',
      1 => 1305534009,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '229074dd2455117f240-34091185',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>
	<head>
		<title>Reset Password</title>
	</head>
	<body>
		<h1 align="center"><?php echo $_smarty_tpl->getVariable('title')->value;?>
</h1>
		<div>
			<?php echo $_smarty_tpl->getVariable('password')->value;?>

				<input id="password" type="password">
				</input>
		</div>
		<div>
			<input id="save" type="submit" value="Save"/>
		</div>
	</body>
</html>
