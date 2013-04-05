<?php Core::getFlash(); ?>
<h3><?php echo $data['firstname'] . ' ' . $data['lastname']; ?></h3>

<div>
	<table class="table table-bordered">
		<tbody>
			<tr>
				<td><b>Globally Unique ID</b></td>
				<td><?php echo (!empty($data['guid'])) ? $data['guid'] : '&nbsp;'; ?></td>
				<td><a href="<?php echo ROOT . DS . 'pages' . DS . 'gen_guid'; ?>">Generate New ID</a></td>
			</tr>
			<tr>
				<td><b>Foursquare Access Token</b></td>
				<td><?php echo !empty($data['fs_access_token']) ? $data['fs_access_token'] : '&nbsp;'; ?></td>
				<td><a href="<?php echo ROOT . DS . 'settings' . DS . 'auth_foursquare'; ?>">Authenticate with Foursquare</a></td>
			</tr>
			<tr>
				<td><b>Phone Number</b></td>
				<td><?php echo isset($data['phonenumber']) ? $data['phonenumber'] : '&nbsp;'; ?></td>
				<td><a href="<?php echo ROOT . DS . 'pages' . DS . 'update_phone'; ?>">Update number</a></td>
			</tr>
		</tbody>
	</table>
</div>

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

<?php if(!empty($deliverys)): ?>
<h4>Deliveries</h4>
<div>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Pickup Time</th>
				<th>Pickup Address</th>
				<th>Delivery Time</th>
				<th>Delivery Address</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($deliverys as $delivery): ?>
			<?php $status = $delivery['status']; ?>
			<tr <?php if(isset($delivery['class'])): ?>class="<?php echo $delivery['class']; ?>"<?php endif; ?>>
				<td><?php echo $delivery['pickup_time']; ?></td>
				<td><?php echo $delivery['pickup_address']; ?></td>
				<td><?php echo $delivery['delivery_time']; ?></td>
				<td><?php echo $delivery['delivery_address']; ?></td>
				<td><?php echo $delivery['status']; ?></td>
				<td>
					<?php if($status == 'Bid awarded'): ?>
						<a href="<?php echo ROOT . DS . 'deliverys' . DS . 'complete_delivery' . DS . $delivery['id'];?>">Complete</a>
					<?php elseif($status == 'available'): ?>		
						<a href="<?php echo ROOT . DS . 'deliverys' . DS . 'place_bid' . DS . $delivery['id']; ?>">Place Bid</a>
					<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<br />
<?php endif; ?>

