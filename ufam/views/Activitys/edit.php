<?php Core::getFlash(); ?>

<h3>Edit Activity</h3>

<form method="POST" action="">
	<label>Title:</label><input type="text" name="title" value="<?php echo isset($activity['title']) ? $activity['title'] : ''; ?>" /><br />
	<label>Date (yyyy-mm-dd hh:mm:ss):</label><input type="text" name="date" value="<?php echo isset($activity['date']) ? $activity['date'] : ''; ?>" /><br />
	<label>Location:</label><input type="text" name="location" value="<?php echo isset($activity['location']) ? $activity['location'] : ''; ?>" /><br />
	<label>Description:</label><input type="text" name="description" value="<?php echo isset($activity['description']) ? $activity['description'] : ''; ?>" /><br />
	<input class="btn btn-primary" type="submit" value="Edit Activity" />
</form>