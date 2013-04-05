<?php Core::getFlash(); ?>

<?php if(isset($delivery['accepted_bid_id']) && $delivery['status'] != 'picked up' && $delivery['status'] != 'completed'): ?>
<div>
	<a class="btn btn-primary" href="<?php echo ROOT . DS . 'deliverys' . DS . 'picked_up' . DS . $delivery['id'] . DS . $delivery['accepted_bid_id']; ?>">Picked Up</a>
</div>
<?php endif; ?>

<div>
	<h4>Bids</h4>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>User Id</th>
				<th>Estimated Delivery Time</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($bids as $bid): ?>
			<tr>
				<td><?php echo $bid['driver_guid']; ?></td>
				<td><?php echo $bid['est_delivery_time']; ?></td>
				<td>
					<?php if(!isset($bid['accepted'])): ?>
					<a href="<?php echo ROOT . DS . 'deliverys' . DS . 'accept_bid' . DS . $bid['id']; ?>">Accept</a>
					<?php elseif($bid['accepted'] === true): ?>
					Accepted
					<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
