<?php
$this->parent->addCssFile($this->parent->url->staticAssets('task/view.css'));
?>
<div class="task-element">
	<h3><? $p($task->getTitle())->chData(); ?></h3>
	<p><? $p($task->getDescription())->chData(); ?></p>
	<a class="edit" href="<? $p($task->getUrlPath())->attrVal(); ?>/edit">Edit</a>
	<a class="delete" href="<? $p($task->getUrlPath())->attrVal(); ?>/delete">Delete</a>
</div>