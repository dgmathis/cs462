<?php

require_once('database.php');

if(!empty($_POST)) {
        $user['username'] = $_POST['username'];
        $user['password'] = sha1($_POST['password']);
        $user['firstname'] = $_POST['firstname'];
        $user['lastname'] = $_POST['lastname'];
	
	$db = Database::getInstance();

	$result = $db->addUser($user);
}

?>

<html>
        <head>
                <title>Create an account</title>
        </head>
        <body>
                <form method="POST" action="">
                        <label>First name:</label><input name="firstname" /><br />
                        <label>Last name:</label><input name="lastname" /><br />
                        <label>Username:</label><input name="username" /><br />
                        <label>Password:</label><input type="password" name="password" /><br />
                        <input type="submit" value="Create Account" />
                </form>
                <br />
                <div>
                        <?php if (isset($user)): print_r($user); endif; ?>
			<?php if(isset($result) && $result == true): echo "<br />Saved!<br />"; endif; ?>
                </div>
        </body>

</html>
