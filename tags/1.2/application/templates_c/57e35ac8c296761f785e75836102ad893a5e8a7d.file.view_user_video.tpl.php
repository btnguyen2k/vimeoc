<?php /* Smarty version Smarty-3.0.7, created on 2011-05-28 11:26:41
         compiled from "D:/Workspace/GPV/Projects/vimeoc/application/templates/view_user_video.tpl" */ ?>
<?php /*%%SmartyHeaderCode:290154de079810b3577-46757212%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '57e35ac8c296761f785e75836102ad893a5e8a7d' => 
    array (
      0 => 'D:/Workspace/GPV/Projects/vimeoc/application/templates/view_user_video.tpl',
      1 => 1306511564,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '290154de079810b3577-46757212',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link href="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/css/user_video.css" rel="stylesheet" type="text/css">
<div id="user_info" class="user_page">
	<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('base_dir_templates')->value)."/blocks/user_left_menu.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
	<div id="user_video_body" class="user_page_body">
	<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['index']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['name'] = 'index';
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('videos')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['index']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['index']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['index']['total']);
?>
		<div>
			<?php if ($_smarty_tpl->getVariable('videos')->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['thumbnails_path']!=''){?>
			<img src="<?php echo $_smarty_tpl->getVariable('videos')->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['thumbnails_path'];?>
" />			
			<?php }else{ ?>
			<img src="<?php echo $_smarty_tpl->getVariable('ctx')->value;?>
/images/icon-video.gif" width="100"/>
			<?php }?>
			video: <?php echo $_smarty_tpl->getVariable('videos')->value[$_smarty_tpl->getVariable('smarty')->value['section']['index']['index']]['id'];?>

		</div>	  
	<?php endfor; endif; ?><br/>
	<?php echo $_smarty_tpl->getVariable('message')->value;?>

	<?php echo $_smarty_tpl->getVariable('pagination')->value;?>

	</div>
</div>