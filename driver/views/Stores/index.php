<h4>Stores</h4>

<div>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>Driver ESL For This Store</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($stores as $store): ?>
			<tr>
				<td><?php echo $store['name']; ?></td>
				<td><?php echo DRIVER_ESL . DS . $store['id']; ?></td>
				<td>
					<a href="<?php echo ROOT . DS . 'stores' . DS . 'view' . DS . $store['id']; ?>">View</a> |
					<a href="<?php echo ROOT . DS . 'stores' . DS . 'delete' . DS . $store['id']; ?>">Delete</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<a href="<?php echo ROOT . DS . 'stores' . DS . 'add'; ?>" class="btn btn-primary">Add Store</a>
</div>