
<?php $loginStatus = (isset($_SESSION['user'])) ? 'logout' : 'login'; ?>
<p><a href="<?php echo ROOT .DS . 'users' . DS . $loginStatus; ?>"><?php echo $loginStatus; ?></a></p>
<p><a href="<?php echo ROOT .DS . 'users' . DS . 'index'; ?>">view all users</a></p>
<br />
<h2><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></h2>

<?php if(!empty($checkins)): ?>
	<table>
		<thead>
			<tr>
				<th>Venue</th>
				<th>City</th>
				<th>State</th>
				<th>Time</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($checkins as $checkin) : ?>
			<tr>
				<td><?php echo $checkin['venue']['name']; ?></td>
				<td><?php echo $checkin['venue']['location']['city']; ?></td>
				<td><?php echo $checkin['venue']['location']['state']; ?></td>
				<td><?php echo date('M j, Y g:i:s', $checkin['createdAt']); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>

<?php if(isset($_SESSION['user']) && $_SESSION['user']['id'] == $user['id'] && empty($_SESSION['user']['fs_access_token'])): ?>
<p>Auth with Foursquare. <a href="<?php echo ROOT . DS . 'users' . DS . 'auth_foursquare'; ?>">click here</a></p>
<?php endif; ?>
