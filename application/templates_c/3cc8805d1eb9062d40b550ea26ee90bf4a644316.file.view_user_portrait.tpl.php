<?php /* Smarty version Smarty-3.0.7, created on 2011-05-25 15:23:58
         compiled from "E:\work\env\xampp\htdocs\vimeoc\application/templates/view_user_portrait.tpl" */ ?>
<?php /*%%SmartyHeaderCode:275674ddcae8ec50840-25869293%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3cc8805d1eb9062d40b550ea26ee90bf4a644316' => 
    array (
      0 => 'E:\\work\\env\\xampp\\htdocs\\vimeoc\\application/templates/view_user_portrait.tpl',
      1 => 1306308235,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '275674ddcae8ec50840-25869293',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="user_portrait" class="user_page">
	<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('base_dir_templates')->value)."/blocks/user_left_menu.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	
	<div id="user_portrait_body" class="user_page_body">
		<center><h1><?php echo $_smarty_tpl->getVariable('title')->value;?>
</h1></center><br/>		
		<span class="red"><?php echo $_smarty_tpl->getVariable('errorMessage')->value;?>
</span>
		<span class="green"><?php echo $_smarty_tpl->getVariable('successMessage')->value;?>
</span>
		<form action="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/user/portrait/" method="post" enctype="multipart/form-data">
			<fieldset>
				<ul>
					<li>
						<span><?php echo $_smarty_tpl->getVariable('currentPortrait')->value;?>
</span><br/>
						<?php if ($_smarty_tpl->getVariable('avatar')->value!=''){?>
						<img src="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/images/upload/<?php echo $_smarty_tpl->getVariable('avatar')->value;?>
" width="50" height="50"/>
						<?php }else{ ?>
						<img src="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/images/avatar.png" width="50" height="50"/>
						<?php }?>
					</li>
					<li>
						<span><?php echo $_smarty_tpl->getVariable('uploadNew')->value;?>
</span><br/>
						<input type="file" name="portrait" />
					</li>
					<li>
						<input type="submit" value="Upload" />
					</li>
				</ul>				
			</fieldset>
		</form>
	</div>
	
	<div id="user_info_help" class="user_page_help">
		Help?
	</div>
</div>