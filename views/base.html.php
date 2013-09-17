<!DOCTYPE html>
<html>
	<head>
		<title><? $p($title)->chData(); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link type="text/css" rel="stylesheet" href="/static-assets/global.css"/>
		<link type="text/css" href="/static-assets/jquery-ui/css/humanity/jquery-ui-1.8.19.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="<? $p($url->staticAssets('jquery-ui/js/jquery-1.7.2.min.js'))->attrVal(); ?>"></script>
		<script type="text/javascript" src="/static-assets/jquery-ui/js/jquery-ui-1.8.19.custom.min.js"></script>
		<!-- History.js --> 
		<script src="/static-assets/jquery-ui/js/jquery.history.js"></script>
		<!-- This Gist -->
		<!--script defer src="http://gist.github.com/raw/854622/ajaxify-html5.js"></script-->  
		<?php foreach ($cssFiles as $path) : ?>
			<? $p($this->fragment('elements/link.html')->assign(['path' => $path]))->html(); ?>
		<?php endforeach; ?>
		<?php foreach ($jsFiles as $path) : ?>
			<? $p($this->fragment('elements/script.html')->assign(['path' => $path]))->html(); ?>
		<?php endforeach; ?>
	</head>
	<body>
		<div class="col1">
			<? $p($index)->html(); ?>
		</div>
		<div class="col2">
			<? $p($content)->html(); ?>
		</div>
		<div class="col3">
			<? $p($notifications)->html(); ?>
		</div>

		<p class="signature">Powered by ophp</p>
		<div class="top-bar"><span class="replanner">re*planner</span> | Agenda | <a href="<? $p($url('/tasks'))->attrVal(); ?>">List</a> | 
			<a href="<? $p($url('/tasks/new'))->attrVal(); ?>">New task</a> | Settings</div>
		<div class="bottom-bar"><a href="<? $p($url('tasks/new'))->attrVal(); ?>">New task</a> | Delete task | Reorder tasks</div>
	</body>
</html>
