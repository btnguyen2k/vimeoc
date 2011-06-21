<?php /* Smarty version Smarty-3.0.7, created on 2011-05-28 01:23:22
         compiled from "D:/Workspace/GPV/Projects/vimeoc/application/templates/view_user_info.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16824ddfec1a315d55-12314118%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b54f19a91965a1d982ea4b2c311fa222c520ea79' => 
    array (
      0 => 'D:/Workspace/GPV/Projects/vimeoc/application/templates/view_user_info.tpl',
      1 => 1306511564,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16824ddfec1a315d55-12314118',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript">
	function checkUserInfoForm(form){
		var $form = $(form);
		var fullName = $form.find("input[name=fullName]").val();
		var email = $form.find("input[name=email]").val();
		var website = $form.find("input[name=website]").val();

		if($.trim(fullName) == '' || $.trim(email) == ''){
			$("#error_required_fields").show();
			return false;
		}else{
			$("#error_required_fields").hide();
		}

		if(!checkEmail(email)){
			$("#error_valid_email").show();
			return false;
		}else{
			$("#error_valid_email").hide();
		}

		if($.trim(website) != '' && !checkUrl(website)){
			$("#error_valid_url").show();
			return false;
		}else{
			$("#error_valid_url").hide();
		}
		return true;
	}
</script>

<div id="user_info" class="user_page">
	<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('base_dir_templates')->value)."/blocks/user_left_menu.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	
	<div id="user_info_body" class="user_page_body">
		<center><h1><?php echo $_smarty_tpl->getVariable('title')->value;?>
</h1></center><br/>
		<span class="red"><?php echo $_smarty_tpl->getVariable('errorMessage')->value;?>
</span>
		<span class="green"><?php echo $_smarty_tpl->getVariable('successMessage')->value;?>
</span>
		<form action="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/user/personalInfo/" method="post" onsubmit="return checkUserInfoForm(this);">
			<fieldset>
				<ul>
					<li>
						<span><?php echo $_smarty_tpl->getVariable('fullNameTitle')->value;?>
 *</span><br/>						
						<input type="text" name="fullName" value="<?php echo $_smarty_tpl->getVariable('fullName')->value;?>
"/>
					</li>					
					<li>
						<span><?php echo $_smarty_tpl->getVariable('emailTitle')->value;?>
 *</span><br/>
						<input type="text" name="email" value="<?php echo $_smarty_tpl->getVariable('email')->value;?>
"/>
						<span class="red" id="error_valid_email" style="display: none;"><?php echo $_smarty_tpl->getVariable('emailInvalid')->value;?>
</span>
					</li>
					<li>
						<span><?php echo $_smarty_tpl->getVariable('yourWebsiteTitle')->value;?>
</span><br/>
						<input type="text" name="website" value="<?php echo $_smarty_tpl->getVariable('website')->value;?>
"/>
						<span class="red" id="error_valid_url" style="display: none;"><?php echo $_smarty_tpl->getVariable('urlInvalid')->value;?>
</span>
					</li>
					<li>
						<span class="red" id="error_required_fields" style="display: none;"><?php echo $_smarty_tpl->getVariable('requiredField')->value;?>
</span>
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