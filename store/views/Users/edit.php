<?php Core::getFlash(); ?>

<h3>Edit <?php echo $user['firstname'] . ' ' . $user['lastname']; ?></h3>

<form method="POST" action="">
	<label>First name:</label><input name="firstname" value="<?php echo isset($user['firstname']) ? $user['firstname'] : ''; ?>" /><br />
	<label>Last name:</label><input name="lastname" value="<?php echo isset($user['lastname']) ? $user['lastname'] : ''; ?>" /><br />
	<label>ESL:</label><input name="esl" value="<?php echo isset($user['esl']) ? $user['esl'] : ''; ?>" /><br />
	<label>Username:</label><input name="username" value="<?php echo isset($user['username']) ? $user['username'] : ''; ?>" /><br />
	<label>Password:</label><input type="password" name="password" value="" /><br />
	<input class="btn btn-primary" type="submit" value="Edit Account" />
</form>