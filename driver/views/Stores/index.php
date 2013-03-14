<h4>Stores</h4>

<div>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>lat</th>
				<th>lng</th>
				<th>esl</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($stores as $store): ?>
			<tr>
				<td><?php echo $store['name']; ?></td>
				<td><?php echo $store['lat']; ?></td>
				<td><?php echo $store['lng']; ?></td>
				<td><?php echo $store['esl']; ?></td>
				<td><a href="<?php echo ROOT . DS . 'stores' . DS . 'delete' . DS . $store['id']; ?>">Delete</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<a href="<?php echo ROOT . DS . 'stores' . DS . 'add'; ?>" class="btn btn-primary">Add Store</a>
</div>