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
		<div class="content">
			<? $p($content)->html(); ?>
		</div>

		<p class="signature">Powered by ophp</p>
	</body>
</html>
