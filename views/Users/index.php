<h3>Drivers</h3>
<div class="mini-layout">
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Username</th>
			<th>FourSquare Access Token</th>
			<th>Event Signal URL</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($users as $driver): ?>
			<tr>
				<td><a href="<?php echo ROOT . DS . 'users' . DS . 'view' . DS . $driver['id']; ?>"><?php echo $driver['firstname'] . ' ' . $driver['lastname']; ?></a></td>
				<td><?php echo $driver['username']; ?></td>
				<td><?php echo isset($driver['fs_access_token']) ? substr($driver['fs_access_token'], 0, 20) . '...' : '&nbsp;'; ?></td>
				<td><?php echo isset($driver['esl']) ? substr($driver['esl'], 0, 20) . '...' : '&nbsp;'; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>