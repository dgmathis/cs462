<h3>Admin Dashboard</h3>

<h4>Available Drivers</h4>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
			<th>Event Signal URL</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($availableUsers as $driver): ?>
			<tr>
				<td><?php echo $driver['firstname'] . ' ' . $driver['lastname']; ?></td>
				<td><?php echo isset($driver['esl']) ? $driver['esl'] : '&nbsp;'; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<a class="btn" href="<?php echo ROOT . '/admin/request_delivery'; ?>">Submit Delivery Request</a>
