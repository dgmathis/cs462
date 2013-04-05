<?php Core::getFlash(); ?>

<h3>Create a Team Account</h3>

<form method="POST" action="">
	<label>Name:</label><input type="text" name="name" value="<?php echo isset($team['name']) ? $team['name'] : ''; ?>" /><br />
	<label>ESL:</label><input type="text" name="esl" value="<?php echo isset($team['esl']) ? $team['esl'] : ''; ?>" /><br />
	<label>Username:</label><input type="text" name="username" value="<?php echo isset($team['username']) ? $team['username'] : ''; ?>" /><br />
	<label>Password:</label><input type="password" name="password" value="<?php echo isset($team['password']) ? $team['password'] : ''; ?>" /><br />
	<input class="btn btn-primary" type="submit" value="Create Account" />
</form>
