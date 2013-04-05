<?php Core::getFlash(); ?>

<h3>Create A Guild</h3>

<form method="POST" action="">
	<label>Name::</label><input name="name" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>" /><br />
	<label>ESL:</label><input name="esl" value="<?php echo isset($data['esl']) ? $data['esl'] : ''; ?>" /><br /><br />
	<input class="btn" type="submit" value="Register" />
</form>

