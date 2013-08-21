<form class="task <? $p($mode)->attrVal() ?>" method="post">
	<fieldset>
		<legend>Create new task</legend>
		<div class="title">
			<label>Title</label>
			<?
				$p($this->fragment('elements/textfield.html')->assign(array('field' => $form->getField('title'))))->html() 
//					->wrap('elements/inputblock.html'))->html();
			?>
		</div>
		<div class="description">
			<label>Description</label>
			<? $p($this->fragment('elements/textarea.html')->assign(array('field' => $form->getField('description'))))->html() ?>
		</div>
		<div class="position">
			<input type="text" name="<? $p($form->getField('position')->getName())->attrVal() ?>" 
				   value="<? $p($form->getField('position')->getValue())->attrVal() ?>"/>
		</div>
		<div class="priority">
			<? $p($this->fragment('elements/select.html')->assign(array('field' => $form->getField('priority'))))->html() ?>
		</div>
		<button type="reset">Reset</button>
		<button type="submit">Save</button>
	</fieldset>
</form>

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