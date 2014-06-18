<div class="task-element">
	<p class="user"><? $p($task->getParentUser()->name)->chData() ?></p>
	<h3><? $p($task->getTitle())->chData(); ?></h3>
	<p><? $p($task->getDescription())->chData(); ?></p>
	<a class="edit" href="<? $p($task->getUrlPath())->attrVal(); ?>/edit">Edit</a>
	<a class="delete" href="<? $p($task->getUrlPath())->attrVal(); ?>/delete">Delete</a>
</div>