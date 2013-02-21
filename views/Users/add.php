
<form method="POST" action="">
	<label>First name:</label><input name="firstname" /><br />
	<label>Last name:</label><input name="lastname" /><br />
	<label>Username:</label><input name="username" /><br />
	<label>Password:</label><input type="password" name="password" /><br />
	<input type="submit" value="Create Account" />
</form>
<br />
<div>
	<?php if (isset($driver)): print_r($driver); endif; ?>
	<?php if(isset($result) && $result == true): echo "<br />Saved!<br />"; endif; ?>
</div>
