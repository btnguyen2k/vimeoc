<?php /* Smarty version Smarty-3.0.7, created on 2011-05-28 09:59:01
         compiled from "D:/Workspace/GPV/Projects/vimeoc/application/templates/view_user_shortcut.tpl" */ ?>
<?php /*%%SmartyHeaderCode:268714de064f58e9569-94141391%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b5128c69762592aec87740ba8db959ec9abef6d' => 
    array (
      0 => 'D:/Workspace/GPV/Projects/vimeoc/application/templates/view_user_shortcut.tpl',
      1 => 1306511564,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '268714de064f58e9569-94141391',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript">
	function checkProfileAlias(form){
		var regex = /[^a-zA-Z0-9]/;
		var alias = $(form).find("input[name=alias]").val();		

		var flag = !regex.test(alias) && alias.length <= 16;

		if(!flag){
			$("#error_valid_alias").show();
			return false;
		}else{
			$("#error_valid_alias").hide();
			return true;
		}
	}
</script>
<div id="user_shortcut" class="user_page">
	<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('base_dir_templates')->value)."/blocks/user_left_menu.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	
	<div id="user_shortcut_body" class="user_page_body">
		<center><h1><?php echo $_smarty_tpl->getVariable('title')->value;?>
</h1></center><br/>		
		<span class="red"><?php echo $_smarty_tpl->getVariable('errorMessage')->value;?>
</span>
		<span class="green"><?php echo $_smarty_tpl->getVariable('successMessage')->value;?>
</span>
		<form action="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/user/profileShortcut/" method="post" onsubmit="return checkProfileAlias(this);">
			<fieldset>
				<ul>
					<li>
						<span><?php echo $_smarty_tpl->getVariable('profileShortcut')->value;?>
</span><br/>
						<?php echo $_smarty_tpl->getVariable('domain')->value;?>
/<input name="alias" value="<?php echo $_smarty_tpl->getVariable('alias')->value;?>
" maxlength="16"/>	
						<span class="red" id="error_valid_alias" style="display: none;">Invalid shortcut</span>					
					</li>
					<li>
						<span>It can be up to 16 characters long, but only letters and numbers</span>
					</li>
					<li>
						<input type="submit" value="Save" />
					</li>
				</ul>				
			</fieldset>
		</form>
	</div>
	
	<div id="user_info_help" class="user_page_help">
		Help?
	</div>
</div>