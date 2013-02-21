<?php if(isset($message)): ?>
<div class="alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo $message; ?>
</div>
<?php endif; ?>

<h3>Create A Driver Account</h3>

<form method="POST" action="">
	<label>First name:</label><input name="firstname" value="<?php echo isset($data['firstname']) ? $data['firstname'] : ''; ?>" /><br />
	<label>Last name:</label><input name="lastname" value="<?php echo isset($data['lastname']) ? $data['lastname'] : ''; ?>" /><br />
	<label>Username:</label><input name="username" value="<?php echo isset($data['username']) ? $data['username'] : ''; ?>" /><br />
	<label>Password:</label><input type="password" name="password" value="<?php echo isset($data['password']) ? $data['password'] : ''; ?>" /><br />
	<input class="btn btn-primary" type="submit" value="Create Account" />
</form>
<br />
<div>
	<?php if (isset($driver)): print_r($driver); endif; ?>
	<?php if(isset($result) && $result == true): echo "<br />Saved!<br />"; endif; ?>
</div>
