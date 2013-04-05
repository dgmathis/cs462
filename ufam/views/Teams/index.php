<?php Core::getFlash(); ?>

<div class="mini-layout">
	<h3>Teams</h3>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>Username</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($teams as $team): ?>
				<tr>
					<td><a href="<?php echo ROOT . DS . 'teams' . DS . 'view' . DS . $team['id']; ?>"><?php echo $team['name']; ?></a></td>
					<td><?php echo $team['username']; ?></td>
					<td>
						<?php if(isset($_SESSION['team']) && $_SESSION['team']['id'] == $team['id']): ?>
						<a href="<?php echo ROOT . DS . 'teams' . DS . 'edit' . DS . $team['id']; ?>">Edit</a> | 
						<a href="<?php echo ROOT . DS . 'teams' . DS . 'delete' . DS .$team['id']; ?>">Delete</a>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php if(!isset($_SESSION['team'])): ?>
		<a class="btn btn-primary" href="<?php echo ROOT . DS . 'teams' . DS . 'add'; ?>">Register New Team</a>
	<?php endif; ?>
</div>