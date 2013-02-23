<form class="task <?= $mode ?>" method="post">
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
			<input type="text" name="<?= $fields->position['name'] ?>" value="<?= $fields->position['value'] ?>"/>
		</div>
		<div class="priority">
			<select name="<?= $fields->priority['name'] ?>">
				<option>high</option>
				<option>normal</option>
				<option>low</option>
			</select>
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