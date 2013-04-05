<?php Core::getFlash(); ?>

<h3>Drivers</h3>
<div class="mini-layout">
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Globally Unique ID</th>
			<th>Event Signal URL</th>
			<th>Rating</th>
			<th>Deliveries Completed</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($drivers as $driver): ?>
			<tr>
				<td><a href="<?php echo ROOT . DS . 'drivers' . DS . 'view' . DS . $driver['id']; ?>"><?php echo $driver['guid']; ?></a></td>
				<td><?php echo isset($driver['esl']) ? $driver['esl'] : '&nbsp;'; ?></td>
				<td><?php echo $driver['rating']; ?></td>
				<td><?php echo $driver['deliverys_completed']; ?></td>
				<td>
					<a href="<?php echo ROOT . DS . 'drivers' . DS . 'edit' . DS . $driver['id']; ?>">Edit</a> | 
					<a href="<?php echo ROOT . DS . 'drivers' . DS . 'delete' . DS .$driver['id']; ?>">Delete</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<a class="btn btn-primary" href="<?php echo ROOT . DS . 'drivers' . DS . 'add'; ?>">Register New Driver</a>
</div>