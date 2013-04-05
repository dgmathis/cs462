<?php Core::getFlash(); ?>

<h3>Admin Dashboard</h3>

<div>
	<h4>Guilds</h4>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>ESL</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($guilds as $guild): ?>
				<tr>
					<td><a href="<?php echo ROOT . DS . 'guilds' . DS . 'view' . DS . $guild['id']; ?>"><?php echo $guild['name']; ?></a></td>
					<td><?php echo $guild['esl']; ?></td>
					<td>
						<a href="<?php echo ROOT . DS . 'guilds' . DS . 'edit' . DS . $guild['id']; ?>">Edit</a> | 
						<a href="<?php echo ROOT . DS . 'guilds' . DS . 'delete' . DS .$guild['id']; ?>">Delete</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<a class="btn" href="<?php echo ROOT . '/guilds/add'; ?>">Add Guild</a> 
	<a class="btn" href="<?php echo ROOT . '/guilds/gen_esl'; ?>">Generate Guild ESL</a>
</div>
<br />
<!--

<div>
	<h4>Available Drivers</h4>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>ESL</th>
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
</div>
<br />

-->
<div>
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
</div>