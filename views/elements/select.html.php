<select name="<? $p($name)->attrVal() ?>">
	<? foreach ($options as $option) : ?>
		<option><? $p($option)->chData() ?></option>
	<? endforeach; ?>
</select>