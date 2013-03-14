<h3>Update Phone Number</h3>

<form method="POST" action="">
	<label>Phone Number (ex. 18885554444):</label><input type="text" name="phone_number" value="<?php echo isset($data['phone_number']) ? $data['phone_number'] : ''; ?>" /><br />
	<input class="btn btn-primary" type="submit" value="Update Number" />
</form>