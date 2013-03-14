<h4>Stores</h4>

<div>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>esl</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($stores as $store): ?>
			<tr>
				<td><?php echo $store['name']; ?>
				<td><?php echo $store['esl']; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<a href="<?php echo ROOT . DS . 'stores' . DS . 'add'; ?>" class="btn btn-primary">Add Store</a>
</div>