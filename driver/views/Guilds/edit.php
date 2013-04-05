<?php Core::getFlash(); ?>

<h3>Edit <?php echo $guild['firstname'] . ' ' . $guild['lastname']; ?></h3>

<form method="POST" action="">
	<label>Name:</label><input name="name" value="<?php echo isset($guild['name']) ? $guild['name'] : ''; ?>" /><br />
	<label>ESL:</label><input name="esl" value="<?php echo isset($guild['esl']) ? $guild['esl'] : ''; ?>" /><br /><br />
	<input class="btn" type="submit" value="Edit Account" />
</form>