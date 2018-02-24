<form class="task <? $p($mode)->attrVal() ?>" method="post">
	<fieldset>
		<legend>Create or edit task</legend>
		<? if ($form->hasExceptions()) : ?>
			<div class="form-errors">
			<? foreach ($form->getExceptions() as $exception) : ?>
				<p class="error"><? $p($exception->getMessage())->chData(); ?></p>
			<? endforeach; ?>
			</div>
		<? endif; ?>
		<?
			$p($this->fragment('elements/inputblock.html')->assign(array('field' => $form->getField('title'))))->html() 
		?>
		<?
			$p($this->fragment('elements/inputblock.html')->assign(array('field' => $form->getField('description'))))->html() 
		?>
		<?
			$p($this->fragment('elements/inputblock.html')->assign(array('field' => $form->getField('priority'))))->html() 
		?>
		<?
			$p($this->fragment('elements/inputblock.html')->assign(array('field' => $form->getField('parent'))))->html() 
		?>
		<button type="reset">Reset</button>
		<button type="submit">Save</button>
	</fieldset>
</form>
<script type="text/javascript">
	$('select[data-ui="typeahead"]').chosen();
</script>
<?
//$html->form()->_class('task')->_method('post')
//	->fieldset()
//		->legend()->text('Create new task')
//			->div()->_class('title')->end()
//			->div();
//$this->html(
//	$this->form($this->_class('task')->_method('post')
//		->fieldset(
//			$this->legend('Create new task')
//			->div($this->_class('title'))))
//	->div('test')));