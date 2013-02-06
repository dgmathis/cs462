
<table>
	<thead>
		<tr>
			<th>Name</th>
			<th>Username</th>
			<th>FourSquare Access Token</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($users as $user): ?>
			<tr>
				<td><a href="<?php echo ROOT . DS . 'users' . DS . 'view' . DS . $user['id']; ?>"><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></a></td>
				<td><?php echo $user['username']; ?></td>
				<td><?php echo isset($user['fs_access_token']) ? substr($user['fs_access_token'], 0, 8) . '...' : '&nbsp;'; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<p>Authenticate with Foursquare.  <a href="<?php echo ROOT . DS . 'users' . DS . 'auth_foursquare'; ?>">Click Here</a>