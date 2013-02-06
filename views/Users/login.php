
<?php if(isset($message)): ?><p><?php echo $message; ?></p><?php endif; ?>

<form method="POST" action="">
	<label>Username:</label><input name="username" /><br />
	<label>Password:</label><input name="password" type="password" /><br />
	<input type="submit" value="Login" />
</form>
<p>Don't have an account? <a href="<?php echo ROOT . DS . 'users' . DS . 'add'; ?>">Create one</a></p>