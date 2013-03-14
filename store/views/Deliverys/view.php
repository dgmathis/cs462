
<div>
	<h4>Bids</h4>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>User Id</th>
				<th>Estimated Delivery Time</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($bids as $bid): ?>
			<tr>
				<td><?php echo $bid['user_id']; ?></td>
				<td><?php echo $bid['est_delivery_time']; ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
