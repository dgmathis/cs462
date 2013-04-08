<?php Core::getFlash(); ?>

<?php if(!empty($_SESSION['team']) && $_SESSION['team']['id'] == $team['id']): ?>
	<a class="btn btn-primary pull-right" href="<?php echo ROOT . DS . 'teams' . DS . 'edit' . DS . $team['id']; ?>">Edit Team</a>
<?php endif; ?>
	
<div class="mini-layout">
	<h3><?php echo $team['name']; ?></h3>
	<table class="table table-bordered table-striped">
		<tbody>
			<tr>
				<td><b>Username:</b></td>
				<td><?php echo $team['username']; ?></td>
			</tr>
			<tr>
				<td><b>ESL:</b></td>
				<td><?php echo $team['esl']; ?></td>
			</tr>
			<tr>
				<td><b>ESL for this team:</b></td>
				<td><?php echo ESL . DS . 'team' . DS . $team['id']; ?></td>
			</tr>
		</tbody>
	</table>
</div>

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
					<td><a href="<?php echo ROOT . DS . 'activitys' . DS . 'view' . DS . $activity['activity_id']; ?>"><?php echo $activity['title']; ?></a></td>
					<td><?php echo $activity['date']; ?></td>
					<td><?php echo $activity['location']; ?></td>
					<td><?php echo $activity['description']; ?></td>
					<td>
						<?php if(isset($_SESSION['team']) && $_SESSION['team']['id'] == $team['id']): ?>
							<a href="<?php echo ROOT . DS . 'activitys' . DS . 'unjoin' . DS .$activity['activity_id']; ?>">Unjoin</a>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php if(isset($_SESSION['team']) && $_SESSION['team']['id'] == $team['id']): ?>
		<a class="btn btn-primary" href="<?php echo ROOT . DS . 'activitys' . DS . 'add'; ?>">Create New Activity</a>
	<?php endif; ?>
</div>



