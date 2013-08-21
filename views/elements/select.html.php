<?
/* @var $p \Ophp\ViewPrinter */
/* @var $field \Ophp\FormField */
?>
<select name="<? $p($field->getName())->attrVal() ?>">
	<? foreach ($field->getOptions() as $option) : ?>
		<option <? $p($option === $field->getValue() ? 'selected="selected"' : '')->html(); ?>>
			<? $p($option)->chData() ?>
		</option>
	<? endforeach; ?>
</select>
