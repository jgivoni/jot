<?php 
namespace HtmlView;
$this->parent->addCssFile('/static/task/view.css');
?>
<div class="task-element">
	<h3><?=e($task->getTitle())?></h3>
	<p><?=e($task->getDescription())?></p>
	<a class="edit" href="<?=e($task->getUrlPath())?>/edit">Edit</a>
	<a class="delete" href="<?=e($task->getUrlPath())?>/delete">Delete</a>
</div>