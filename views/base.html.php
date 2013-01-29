<?php

namespace HtmlView;
?><!DOCTYPE html>
<html>
	<head>
		<title><?= e($title) ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link type="text/css" rel="stylesheet" href="/static-assets/global.css"/>
		<link type="text/css" href="/static-assets/jquery-ui/css/humanity/jquery-ui-1.8.19.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="<?= e($url->static_assets('jquery-ui/js/jquery-1.7.2.min.js')) ?>"></script>
		<script type="text/javascript" src="/static-assets/jquery-ui/js/jquery-ui-1.8.19.custom.min.js"></script>
		<!-- History.js --> 
		<script defer src="http://balupton.github.com/history.js/scripts/bundled/html4+html5/jquery.history.js"></script>
		<!-- This Gist -->
		<!--script defer src="http://gist.github.com/raw/854622/ajaxify-html5.js"></script-->  
		<?php foreach ($head as $line) : ?>
			<?= $line ?>
		<?php endforeach; ?>
	</head>
	<body>
		<div class="col1">
			<?= $index ?>
		</div>
		<div class="col2">
			<?= $content ?>
		</div>
		<div class="col3">
			<?= $notifications ?>
		</div>

		<p class="signature">Powered by Vessel 3.0</p>
		<div class="top-bar"><span class="replanner">re*planner</span> | Agenda | <a href="/tasks">List</a> | <a href="/tasks/new">New task</a> | Settings</div>
		<div class="bottom-bar"><a href="<?= e($url('tasks/new')) ?>">New task</a> | Delete task | Reorder tasks</div>
	</body>
</html>
