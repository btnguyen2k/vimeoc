<?php /* Smarty version Smarty-3.0.7, created on 2011-05-28 11:24:23
         compiled from "D:/Workspace/GPV/Projects/vimeoc/application/templates/view_user_password.tpl" */ ?>
<?php /*%%SmartyHeaderCode:104884de078f72af809-39620792%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3d84a952740fd61597fe5883a8af8ee3b2cee481' => 
    array (
      0 => 'D:/Workspace/GPV/Projects/vimeoc/application/templates/view_user_password.tpl',
      1 => 1306511564,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '104884de078f72af809-39620792',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript">
	function checkpassword(){
		var x = document.getElementById("currentpassword").value;
		var y = document.getElementById("newpassword").value;
		var z = document.getElementById("retypepassword").value
		
		if(x==""){
			alert("Current password not null");
			return false;
		}else if(y==""){
			alert("New password not null");
			return false;
		}else if(z==""){
			alert("Retype password not null");
			return false;
		}else if(y!=z){
			alert("New Password and retype the password must be the same !");
			return false;
		}			
	}
</script>
<div id="user_password" class="user_page">
	<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('base_dir_templates')->value)."/blocks/user_left_menu.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	
	<div id="user_password_body" class="user_page_body">
		<center><h1><?php echo $_smarty_tpl->getVariable('title')->value;?>
</h1></center><br/>
			
			<?php if ($_smarty_tpl->getVariable('FailMessage')->value==''){?>
		  		 &nbsp;
			<?php }else{ ?>
		   		<span class="red"><?php echo $_smarty_tpl->getVariable('FailMessage')->value;?>
</span>
			<?php }?>
			
			<?php if ($_smarty_tpl->getVariable('successMessage')->value==''){?>
  				 &nbsp;
			<?php }else{ ?>
   				<span class="green" align="center"><?php echo $_smarty_tpl->getVariable('successMessage')->value;?>
</span>
			<?php }?>
			

		<form action="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/user/passwordpages/" method="post" onSubmit="return checkpassword(this)">
			<fieldset>
				<ul>
					<li>
						<span><?php echo $_smarty_tpl->getVariable('currentpassword')->value;?>
 </span><br/>						
						<input type="password" name="currentpassword" id="currentpassword"/>
						<?php if ($_smarty_tpl->getVariable('errorMessage')->value==''){?>
  				 			&nbsp;
						<?php }else{ ?>
   							<span class="red"><?php echo $_smarty_tpl->getVariable('errorMessage')->value;?>
</span>
						<?php }?>	
					</li>					
					<li>
						<span><?php echo $_smarty_tpl->getVariable('newpassword')->value;?>
</span><br/>
						<input type="password" name="newpassword" id="newpassword"/>
					</li>
					<li>
						<span><?php echo $_smarty_tpl->getVariable('repassword')->value;?>
</span><br/>
						<input type="password" name="retypepassword" id="retypepassword"/>
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
