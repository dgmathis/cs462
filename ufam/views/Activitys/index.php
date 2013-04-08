<?php Core::getFlash(); ?>

<div class="mini-layout">
	<h3>Activities</h3>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Title</th>
				<th>Date</th>
				<th>Location</th>
				<th>Description</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($activitys as $activity): ?>
				<tr>
					<td><a href="<?php echo ROOT . DS . 'activitys' . DS . 'view' . DS . $activity['id']; ?>"><?php echo $activity['title']; ?></a></td>
					<td><?php echo $activity['date']; ?></td>
					<td><?php echo $activity['location']; ?></td>
					<td><?php echo $activity['description']; ?></td>
					<td class="nowrap">
						<?php if(isset($_SESSION['team']) && $_SESSION['team']['id'] == $activity['owner_team_id']): ?>
						<a href="<?php echo ROOT . DS . 'activitys' . DS . 'edit' . DS . $activity['id']; ?>">Edit</a>  
						<a href="<?php echo ROOT . DS . 'activitys' . DS . 'delete' . DS .$activity['id']; ?>">Delete</a>
						<?php endif; ?>
						<?php if(isset($activity['already_joined']) && $activity['already_joined'] == true): ?>
						 <a href="<?php echo ROOT . DS . 'activitys' . DS . 'unjoin' . DS .$activity['id']; ?>">Unjoin</a>
						<?php elseif(isset($activity['already_joined']) && $activity['already_joined'] == false): ?> 
						 <a href="<?php echo ROOT . DS . 'activitys' . DS . 'join' . DS .$activity['id']; ?>">Join</a>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php if(!empty($_SESSION['team'])): ?>
		<a class="btn btn-primary" href="<?php echo ROOT . DS . 'activitys' . DS . 'add'; ?>">Create New Activity</a>
	<?php endif; ?>
</div>