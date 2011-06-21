<?php /* Smarty version Smarty-3.0.7, created on 2011-05-30 14:11:22
         compiled from "D:/Workspace/GPV/Projects/vimeoc/application/templates//blocks/user_left_menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:234194de3431a3056d5-10123760%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '75a65a876861e3674c993ab81db4a1554d057673' => 
    array (
      0 => 'D:/Workspace/GPV/Projects/vimeoc/application/templates//blocks/user_left_menu.tpl',
      1 => 1306567956,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '234194de3431a3056d5-10123760',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="user_menu">
	<ul class="portrait">
		<li>
			<a href="#">
				<a href="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/">
				<?php if ($_smarty_tpl->getVariable('userAvatar')->value!=null){?>
				<img src="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/images/upload/<?php echo $_smarty_tpl->getVariable('userAvatar')->value;?>
" width="50" height="50"/>
				<?php }else{ ?>
				<img src="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/images/avatar.png" width="50" height="50"/>
				<?php }?>
				</a>
			</a>
		</li>
	</ul>
	<ul>
		<li>
			<a href="#"><?php echo $_smarty_tpl->getVariable('menuUploadVideo')->value;?>
</a>
		</li>
		<li>
			<a href="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/user/video"><?php echo $_smarty_tpl->getVariable('menuVideos')->value;?>
</a>
		</li>
		<li>
			<a href="#"><?php echo $_smarty_tpl->getVariable('menuAlbums')->value;?>
</a>
		</li>
	</ul>
	<ul>
		<li>
			<a href="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/user/personalInfo"><?php echo $_smarty_tpl->getVariable('menuPersonalInfo')->value;?>
</a>
		</li>
		<li>
			<a href="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/user/portrait"><?php echo $_smarty_tpl->getVariable('menuPortrait')->value;?>
</a>
		</li>
		<li>
			<a href="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/user/passwordpages"><?php echo $_smarty_tpl->getVariable('menuPassword')->value;?>
</a>
		</li>
		<li>
			<a href="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/user/profileShortcut"><?php echo $_smarty_tpl->getVariable('menuShortcutURL')->value;?>
</a>
		</li>
		<li>
			<a href="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/auth/logout"><?php echo $_smarty_tpl->getVariable('menuLogout')->value;?>
</a>
		</li>
	</ul>
</div>