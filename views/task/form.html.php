<form class="task <? $p($mode)->attrVal() ?>" method="post">
	<fieldset>
		<legend>Create new task</legend>
		<div class="title">
			<label>Title</label>
			<?
				$p($this->fragment('elements/textfield.html')->assign($fields->title))->html() 
//					->wrap('elements/inputblock.html'))->html();
			?>
		</div>
		<div class="description">
			<label>Description</label>
			<? $p($this->fragment('elements/textarea.html')->assign($fields->description))->html() ?>
		</div>
		<div class="position">
			<input type="text" name="<? $p($fields->position['name'])->attrVal() ?>" 
				   value="<? $p($fields->position['value'])->attrVal() ?>"/>
		</div>
		<div class="priority">
			<? $p($this->fragment('elements/select.html')->assign($fields->priority))->html() ?>
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