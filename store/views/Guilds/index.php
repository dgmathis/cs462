<?php Core::getFlash(); ?>

<div>
	<h3>Guilds</h3>
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