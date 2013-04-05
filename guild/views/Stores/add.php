<?php Core::getFlash(); ?>

<h3>Register a Store</h3>

<form method="POST" action="">
	<label>Store Name:</label><input name="name" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>" /><br />
	<label>Latitude:</label><input name="lat" value="<?php echo isset($data['lat']) ? $data['lat'] : ''; ?>" /><br />
	<label>Longitude:</label><input name="lng" value="<?php echo isset($data['lng']) ? $data['lng'] : ''; ?>" /><br />
	<label>ESL:</label><input name="esl" value="<?php echo isset($data['esl']) ? $data['esl'] : ''; ?>" /><br /><br />
	<input class="btn btn-primary" type="submit" value="Register Store" />
</form>
<br />