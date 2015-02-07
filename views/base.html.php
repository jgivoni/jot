<!DOCTYPE html>
<html>
	<head>
		<title><? $p($title)->chData(); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
		<div class="top-bar"><a class="replanner" href="<? $p($url())->attrVal() ?>">re*planner</a> | Agenda | <a href="<? $p($url('tasks'))->attrVal(); ?>">List</a> | 
			<a href="<? $p($url('tasks/new'))->attrVal(); ?>">New task</a> | Settings</div>
		<div class="bottom-bar"><a href="<? $p($url('tasks/new'))->attrVal(); ?>">New task</a> | Delete task | Reorder tasks</div>
	</body>
</html>
