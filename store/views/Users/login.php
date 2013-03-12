<?php if(isset($message)): ?>
<div class="alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo $message; ?>
</div>
<?php endif; ?>

<h3>Driver Login</h3>

<form method="POST" action="">
	<label>Username:</label><input name="username" /><br />
	<label>Password:</label><input name="password" type="password" /><br />
	<input type="submit" class="btn btn-primary" value="Login" />
</form>
<p>Don't have an account? <a href="<?php echo ROOT . DS . 'users' . DS . 'add'; ?>">Create one</a></p>