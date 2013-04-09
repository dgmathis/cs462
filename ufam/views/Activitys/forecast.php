<?php Core::getFlash(); ?>

<div class="mini-layout">
	<h3>7 Day Forecast</h3>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
			<?php foreach($forecast as $day): ?>
				<th class="text-center"><?php echo date('M j', $day['timestamp']); ?></th>
			<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<tr>
				<?php foreach($forecast as $day): ?>
					<td>
						<p><?php echo $day['maxTempF'] . '&deg;/' . $day['minTempF'] . '&deg;'; ?></p>
						<p><?php echo $day['weatherPrimary']; ?></p>
						<hr />
						<?php foreach($day['activities'] as $activity): ?>
							<p><a href="<?php echo ROOT . DS . 'activitys' . DS . 'view' . DS . $activity['id']; ?>"><?php echo $activity['title']; ?></a></p>
						<?php endforeach; ?>
					</td>
				<?php endforeach; ?>
			</tr>
		</tbody>
	</table>
</div>
