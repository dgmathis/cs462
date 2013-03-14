<h3><?php echo $data['firstname'] . ' ' . $data['lastname']; ?></h3>

<h4>Driver ESL</h4>
<p><?php echo DRIVER_ESL; ?></p>
<?php if(!empty($data['last_checkin'])): ?>
<h4>Last Checkin</h4>
<div>
	<table class="table table-bordered">
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

<div>
	<h4>Foursquare Access Token</h4>
	<p><?php echo !empty($data['fs_access_token']) ? $data['fs_access_token'] : ''; ?></p>
	<a class="btn btn-primary" href="<?php echo ROOT . DS . 'settings' . DS . 'auth_foursquare'; ?>">Authenticate with Foursquare</a>
</div>

<div>
	<h4>Phone Number</h4>
	<p><?php echo isset($data['phonenumber']) ? $data['phonenumber'] : ''; ?></p>
	<a class="btn btn-primary" href="<?php echo ROOT . DS . 'pages' . DS . 'update_phone'; ?>">Update number</a>
</div>

<?php if(!empty($deliverys)): ?>
<h4>Delivery Requests</h4>
<div>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Store Id</th>
				<th>Pickup Time</th>
				<th>Pickup Address</th>
				<th>Delivery Time</th>
				<th>Delivery Address</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($deliverys as $delivery): ?>
			<tr>
				<td><?php echo $delivery['store_id']; ?>
				<td><?php echo $delivery['pickup_time']; ?>
				<td><?php echo $delivery['pickup_address']; ?>
				<td><?php echo $delivery['delivery_time']; ?>
				<td><?php echo $delivery['delivery_address']; ?>
				<td><?php echo $delivery['status']; ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>

