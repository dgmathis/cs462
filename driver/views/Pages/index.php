<h3><?php echo $data['firstname'] . ' ' . $data['lastname']; ?></h3>

<?php if(!empty($data['last_checkin'])): ?>
<h4>Last Checkin</h4>
<div>
	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Latitude</th>
				<th>Longitude</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $data['last_checkin']['name']; ?></td>
				<td><?php echo $data['last_checkin']['lat']; ?></td>
				<td><?php echo $data['last_checkin']['lng']; ?></td>
			</tr>
		</tbody>
	</table>
</div>
<?php endif; ?>

<?php if(empty($data['fs_access_token'])): ?>
<a class="btn btn-primary" href="<?php echo ROOT . DS . 'settings' . DS . 'auth_foursquare'; ?>">Authenticate with Foursquare</a></p>
<?php else: ?>
<h4>Foursquare Access Token</h4>
<p><?php echo $data['fs_access_token']; ?></p>
<?php endif; ?>
