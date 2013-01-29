<?php /* Smarty version Smarty-3.0.8, created on 2012-05-07 21:52:38
         compiled from "/webdev/vessel-application/views/task/view.html" */ ?>
<?php /*%%SmartyHeaderCode:4142308554fa828062e92c0-30902620%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e488cfba4c30bde0c72c40a9b5c7e12413b87987' => 
    array (
      0 => '/webdev/vessel-application/views/task/view.html',
      1 => 1335648698,
      2 => 'file',
    ),
    'd34f314d427ce8f27609440e96abb1fef7e8f4e0' => 
    array (
      0 => '/webdev/vessel-application/views/base.html',
      1 => 1335896338,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4142308554fa828062e92c0-30902620',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
	<head>
		<title>View task</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link type="text/css" rel="stylesheet" href="/static-assets/global.css"/>
		<link type="text/css" href="/static-assets/jquery-ui/css/humanity/jquery-ui-1.8.19.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="/static-assets/jquery-ui/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="/static-assets/jquery-ui/js/jquery-ui-1.8.19.custom.min.js"></script>
		
<link type="text/css" rel="stylesheet" href="/static-assets/task/view.css"/>

	</head>
	<body>
		<h2 class="application">re*planner</h2>
		
<div class="task-element">
	<h3><?php echo $_smarty_tpl->getVariable('task')->value->getTitle();?>
</h3>
	<p><?php echo $_smarty_tpl->getVariable('task')->value->getDescription();?>
</p>
	<a class="edit" href="<?php echo $_smarty_tpl->getVariable('task')->value->getUrl();?>
/edit">Edit</a>
</div>

		<p class="signature">Powered by Vessel 3.0</p>
		<div class="top-bar">Agenda | <a href="/tasks">List</a> | <a href="/tasks/new">New task</a> | Settings</div>
		<div class="bottom-bar"><a href="/tasks/new">New task</a> | Delete task | Reorder tasks</div>
	</body>
</html>
