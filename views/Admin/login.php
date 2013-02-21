<?php if(isset($message)): ?>
<div class="alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo $message; ?>
</div>
<?php endif; ?>

<h3>Admin Login</h3>

<form method="POST" action="">
	<label>Username:</label><input name="username" /><br />
	<label>Password:</label><input name="password" type="password" /><br />
	<input class="btn" type="submit" value="Login" />
</form>