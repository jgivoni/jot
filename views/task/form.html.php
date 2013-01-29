<form class="task <?=$mode?>" method="post">
	<fieldset>
		<legend>Create new task</legend>
		<div class="title">
			<label>Title</label>
			<input type="text" name="<?=$fields->title['name']?>" placeholder="Type title here" value="<?=$fields->title['value']?>"/>
		</div>
		<div class="description">
			<label>Description</label>
			<textarea name="<?=$fields->description['name']?>" placeholder="Type description here"><?=$fields->description['value']?></textarea>
		</div>
		<div class="position">
			<input type="text" name="<?=$fields->position['name']?>" value="<?=$fields->position['value']?>"/>
		</div>
		<div class="priority">
			<select name="<?=$fields->priority['name']?>">
				<option>high</option>
				<option>normal</option>
				<option>low</option>
			</select>
		</div>
		<button type="reset">Reset</button>
		<button type="submit">Save</button>
	</fieldset>
</form>