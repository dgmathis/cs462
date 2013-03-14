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

<h4>Deliveries</h4>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Pickup time</th>
			<th>Pickup address</th>
			<th>Delivery time</th>
			<th>Delivery address</th>
			<td>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($deliverys as $delivery): ?>
		<tr>
			<td><?php echo $delivery['pickup_time']; ?></td>
			<td><?php echo $delivery['pickup_address']; ?></td>
			<td><?php echo $delivery['delivery_time']; ?></td>
			<td><?php echo $delivery['delivery_address']; ?></td>
			<td><a href="<?php echo ROOT . DS . 'deliverys' . DS . 'view' . DS . $delivery['id']; ?>"><?php echo $delivery['status']; ?></a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<a class="btn" href="<?php echo ROOT . '/admin/request_delivery'; ?>">Submit Delivery Request</a>
