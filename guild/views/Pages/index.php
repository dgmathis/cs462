
<div>
	<h4>Stores</h4>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Esl</th>
				<th>Guild Esl For Store</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($stores as $store): ?>
			<tr>
				<td><?php echo $store['id']; ?></td>
				<td><a href="<?php echo ROOT . DS . 'stores' . DS . 'view' . DS . $store['id']; ?>"><?php echo $store['name']; ?></a></td>
				<td><?php echo $store['esl']; ?></td>
				<td><?php echo ESL . DS . 'store' . DS . $store['id']; ?></td>
				<td>
					<a href="<?php echo ROOT . DS . 'stores' . DS . 'edit' . DS . $store['id']; ?>">Edit</a> | 
					<a href="<?php echo ROOT . DS . 'stores' . DS . 'delete' . DS . $store['id']; ?>">Delete</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<a class="btn btn-primary" href="<?php echo ROOT . DS . 'stores' . DS . 'add'; ?>">Register New Store</a>
</div>
<br />
<div>
	<h4>Drivers</h4>
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
