<ul class="tasks">
	<?php foreach ($tasks as $task) : ?>
		<li data-task-id="<?=$task['taskId']?>" class="priority_<?=$task['priority']?>">
			<span class="task-id"><?=$task['taskId']?></span>
			<a href="<? $p($task['urlPath'])->attrVal() ?>">
				<?=$task['title']?>
			</a>
			<span class="username">(<?=$task->getParentUser()->name?>)</span>
		</li>
	<?php endforeach; ?>
	<script type="text/javascript">
		Tasks.initList();
	</script>
</ul>