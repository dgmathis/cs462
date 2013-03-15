<?php Core::getFlash(); ?>

<h3>Drivers</h3>
<div class="mini-layout">
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Name</th>
			<th>Username</th>
			<th>FourSquare Access Token</th>
			<th>Event Signal URL</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($users as $driver): ?>
			<tr>
				<td><a href="<?php echo ROOT . DS . 'users' . DS . 'view' . DS . $driver['id']; ?>"><?php echo $driver['firstname'] . ' ' . $driver['lastname']; ?></a></td>
				<td><?php echo $driver['username']; ?></td>
				<td><?php echo isset($driver['fs_access_token']) ? substr($driver['fs_access_token'], 0, 20) . '...' : '&nbsp;'; ?></td>
				<td><?php echo isset($driver['esl']) ? substr($driver['esl'], 0, 20) . '...' : '&nbsp;'; ?></td>
				<td>
					<?php if(isset($_SESSION['user']) && $_SESSION['user']['id'] == $driver['id']): ?>
					<a href="<?php echo ROOT . DS . 'users' . DS . 'edit' . DS . $driver['id']; ?>">Edit</a> | 
					<a href="<?php echo ROOT . DS . 'users' . DS . 'delete' . DS .$driver['id']; ?>">Delete</a>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>