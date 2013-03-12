
<h3><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></h3>

<?php if(!empty($user['esl'])): ?>
<p>Event Signal URL: <?php echo $user['esl']; ?></p>
<?php endif; ?>

<?php if(!empty($checkins)): ?>
	<h4>Check-ins</h4>
	<table class="table table-bordered table-striped">
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

<?php if($allowFSAuth): ?>
<a class="btn btn-primary" href="<?php echo ROOT . DS . 'users' . DS . 'auth_foursquare'; ?>"><?php echo empty($user['fs_access_token']) ? 'Authenticate' : 'Re-authenticate'; ?> with Foursquare</a></p>
<?php endif; ?>

<?php if($allowRegisterESL): ?>
<a class="btn btn-primary" href="<?php echo ROOT; ?>/users/register_esl"><?php echo empty($user['esl']) ? 'Register' : 'Re-register'; ?> your event signal URL</a>
<?php endif; ?>

