<?php Core::getFlash(); ?>

<h3>Create a New Activity</h3>

<form method="POST" action="">
	<label>Title:</label><input type="text" name="title" /><br />
	<label>Date (yyyy-mm-dd hh:mm:ss):</label><input type="text" name="date" /><br />
	<label>Location:</label><input type="text" name="location" /><br />
	<label>Description:</label><input type="text" name="description" /><br />
	<input class="btn btn-primary" type="submit" value="Create Activity" />
</form>
