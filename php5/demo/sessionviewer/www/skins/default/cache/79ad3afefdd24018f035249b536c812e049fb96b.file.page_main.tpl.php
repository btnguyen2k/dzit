<?php /* Smarty version Smarty-3.0.7, created on 2011-05-29 08:47:12
         compiled from "skins/default/page_main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:221134de1a5a03d4746-43016750%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '79ad3afefdd24018f035249b536c812e049fb96b' => 
    array (
      0 => 'skins/default/page_main.tpl',
      1 => 1306633630,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '221134de1a5a03d4746-43016750',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include 'D:\Workspace\PHP\Dzit\demo\sessionviewer\libs\smarty-3.0.7\plugins\modifier.escape.php';
?><?php $_template = new Smarty_Internal_Template('inc_header.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
<p>Current session values:</p>
<table border="1" cellpadding="4">
    <thead>
        <tr>
            <th>Key</th>
            <th>Value</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('MODEL')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
            <tr>
                <td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['key']->value,'html');?>
</td><td><?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['value']->value,'html');?>
</td>
                <td><a href="<?php echo $_SERVER['SCRIPT_NAME'];?>
/delete?key=<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['key']->value,'url');?>
">Delete</a></td>
            </tr>
        <?php }} ?>
    </tbody>
</table>

<p>Add a new value:</p>
<form method="post" action="<?php echo $_SERVER['SCRIPT_NAME'];?>
/add">
<table>
    <tr>
        <td>Name:</td>
        <td><input type="text" name="key"></td>
    </tr>
    <tr>
        <td>Value:</td>
        <td><input type="text" name="value"></td>
    </tr>
    <tr>
        <td colspan="2"><input type="submit" value="Add"></td>
    </tr>
</table>
</form>
<?php $_template = new Smarty_Internal_Template('inc_footer.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
