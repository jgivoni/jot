<h1>Cards view</h1>
<div class="cards">
	<div class="card add-task"><span class="icon">+</span></div>
	<? foreach ($tasks as $task) : ?>
	<div data-task-id="<? $p($task->taskId)->attrVal() ?>" class="card priority-<? $p($task->priority)->attrVal() ?>">
		<h2><? $p($task->title)->chData() ?></h2>
		<div class="description">
			<? $p($task->description)->chData() ?>
		</div>
		<a class="view" href="<? $p($task['urlPath'])->attrVal() ?>">
			(?)
		</a>
	</div>
	<? endforeach; ?>
</div>
<script type="text/javascript">
	Cards.initList();
</script>
