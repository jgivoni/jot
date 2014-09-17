<div class="task-element">
	<p class="user"><? $p($task->getParentUser()->name)->chData() ?></p>
	<h3><? $p($task->getTitle())->chData(); ?></h3>
	<p><? $p($task->getDescription())->chData(); ?></p>
	<a class="edit" href="<? $p($task->getUrlPath())->attrVal(); ?>/edit">Edit</a>
	<a class="delete" href="<? $p($task->getUrlPath())->attrVal(); ?>/delete">Delete</a>
</div>
<ul class="subtasks">
	<? foreach ($subtasks as $subtask) : ?>
		<li>
			<a href="<? $p($subtask['urlPath'])->attrVal() ?>">
				<?=$subtask['title']?>
			</a>
		</li>
	<? endforeach; ?>
</ul>
<div class="add-task">
	<a href="/tasks/new?parent=<? $p($task->taskId)->attrVal(); ?>">+ Add</a>
</div>