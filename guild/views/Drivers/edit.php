<?php Core::getFlash(); ?>

<h3>Edit Driver</h3>

<form method="POST" action="">
	<label>Globally Unique ID:</label><input name="guid" value="<?php echo isset($driver['guid']) ? $driver['guid'] : ''; ?>" /><br />
	<label>ESL:</label><input name="esl" value="<?php echo isset($driver['esl']) ? $driver['esl'] : ''; ?>" /><br /><br />
	<input class="btn btn-primary" type="submit" value="Edit Driver" />
</form>