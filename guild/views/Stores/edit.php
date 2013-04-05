<?php Core::getFlash(); ?>

<h3>Edit Store</h3>

<form method="POST" action="">
	<label>Store Name:</label><input name="name" value="<?php echo isset($store['name']) ? $store['name'] : ''; ?>" /><br />
	<label>Latitude:</label><input name="lat" value="<?php echo isset($store['lat']) ? $store['lat'] : ''; ?>" /><br />
	<label>Longitude:</label><input name="lng" value="<?php echo isset($store['lng']) ? $store['lng'] : ''; ?>" /><br />
	<label>ESL:</label><input name="esl" value="<?php echo isset($store['esl']) ? $store['esl'] : ''; ?>" /><br /><br />
	<input class="btn btn-primary" type="submit" value="Edit Store" />
</form>
<br />
