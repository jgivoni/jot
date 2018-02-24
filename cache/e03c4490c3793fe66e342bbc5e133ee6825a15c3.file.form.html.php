<?php /* Smarty version Smarty-3.0.8, created on 2012-05-02 23:35:27
         compiled from "/webdev/vessel-application/views/task/form.html" */ ?>
<?php /*%%SmartyHeaderCode:15574523204fa1a89f17f530-34638973%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e03c4490c3793fe66e342bbc5e133ee6825a15c3' => 
    array (
      0 => '/webdev/vessel-application/views/task/form.html',
      1 => 1335816183,
      2 => 'file',
    ),
    'd34f314d427ce8f27609440e96abb1fef7e8f4e0' => 
    array (
      0 => '/webdev/vessel-application/views/base.html',
      1 => 1335896338,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15574523204fa1a89f17f530-34638973',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/webdev/vessel-application/libs/smarty/plugins/modifier.escape.php';
?><!DOCTYPE html>
<html>
	<head>
		<title>Task list</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link type="text/css" rel="stylesheet" href="/static-assets/global.css"/>
		<link type="text/css" href="/static-assets/jquery-ui/css/humanity/jquery-ui-1.8.19.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="/static-assets/jquery-ui/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="/static-assets/jquery-ui/js/jquery-ui-1.8.19.custom.min.js"></script>
		
<link type="text/css" rel="stylesheet" href="/static-assets/task/form.css"/>

	</head>
	<body>
		<h2 class="application">re*planner</h2>
		
<form class="task <?php echo $_smarty_tpl->getVariable('mode')->originalValue;?>
" method="post">
	<fieldset>
		<legend>Create new task</legend>
		<div class="title">
			<label>Title</label>
			<input type="text" name="<?php echo $_smarty_tpl->getVariable('fields')->originalValue['title']['name'];?>
" placeholder="Type title here" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('fields')->originalValue['title']['value']);?>
"/>
		</div>
		<div class="description">
			<label>Description</label>
			<textarea name="<?php echo $_smarty_tpl->getVariable('fields')->originalValue['description']['name'];?>
" placeholder="Type description here"><?php echo smarty_modifier_escape($_smarty_tpl->getVariable('fields')->originalValue['description']['value']);?>
</textarea>
		</div>
		<div class="position">
			<input type="text" name="<?php echo $_smarty_tpl->getVariable('fields')->originalValue['position']['name'];?>
" value="<?php echo $_smarty_tpl->getVariable('fields')->originalValue['position']['value'];?>
"/>
		</div>
		<div class="priority">
			<select name="<?php echo $_smarty_tpl->getVariable('fields')->originalValue['priority']['name'];?>
">
				<option>high</option>
				<option>normal</option>
				<option>low</option>
			</select>
		</div>
		<button type="reset">Cancel</button>
		<button type="submit">Save</button>
	</fieldset>
</form>

		<p class="signature">Powered by Vessel 3.0</p>
		<div class="top-bar">Agenda | <a href="/tasks">List</a> | <a href="/tasks/new">New task</a> | Settings</div>
		<div class="bottom-bar"><a href="/tasks/new">New task</a> | Delete task | Reorder tasks</div>
	</body>
</html>
