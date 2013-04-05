<?php Core::getFlash(); ?>

<h3>Guild Login</h3>

<form method="POST" action="">
	<label>Username:</label><input name="username" /><br />
	<label>Password:</label><input name="password" type="password" /><br />
	<input type="submit" class="btn btn-primary" value="Login" />
</form>
<p>Don't have an account? <a href="<?php echo ROOT . DS . 'guilds' . DS . 'add'; ?>">Create one</a></p>