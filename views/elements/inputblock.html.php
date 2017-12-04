<div class="input-block <? $p($field->getName())->attrVal() ?>">
	<label><? $p($field->getLabel())->chData() ?></label>
	<?
		if ($field->getType() === Ophp\FormField::TYPE_TEXT) {
			$p($this->fragment('elements/textfield.html')->assign($this->getParams()))->html();
		} elseif ($field->getType() === Ophp\FormField::TYPE_TEXTAREA) {
			$p($this->fragment('elements/textarea.html')->assign($this->getParams()))->html();
		} elseif ($field->getType() === Ophp\FormField::TYPE_SELECT) {
			$p($this->fragment('elements/select.html')->assign($this->getParams()))->html();
		}
	?>
	<? if ($field->hasExceptions()) : ?>
		<div class="field-errors">
			<? foreach ($field->getExceptions() as $exception) : ?>
				<p class="error"><? $p($exception->getMessage())->chData() ?></p>
			<? endforeach; ?>
		</div>
	<? endif; ?>
</div>