<?php Core::getFlash(); ?>

<h3>Create an account!</h3>

<form method="POST" action="">
	<label>First name:</label><input name="firstname" value="<?php echo isset($action['firstname']) ? $action['firstname'] : ''; ?>" /><br />
	<label>Last name:</label><input name="lastname" value="<?php echo isset($action['lastname']) ? $action['lastname'] : ''; ?>" /><br />
	<label>Username:</label><input name="username" value="<?php echo isset($action['username']) ? $action['username'] : ''; ?>" /><br />
	<label>Password:</label><input type="password" name="password" value="<?php echo isset($action['password']) ? $action['password'] : ''; ?>" /><br />
	<input class="btn btn-primary" type="submit" value="Create Account" />
</form>
