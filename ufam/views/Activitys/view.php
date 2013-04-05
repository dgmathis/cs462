<a class="btn btn-primary pull-right" href="<?php echo ROOT . DS . 'activitys' . DS . 'edit' . DS . $activity['id']; ?>">Edit Activity</a>

<h3><?php echo $activity['title']; ?></h3>

<table class="table table-bordered table-striped">
	<tbody>
		<tr>
			<td><b>Date:</b></td>
			<td><?php echo $activity['date']; ?></td>
		</tr>
		<tr>
			<td><b>Location:</b></td>
			<td><?php echo $activity['location']; ?></td>
		</tr>
		<tr>
			<td><b>Description:</b></td>
			<td><?php echo $activity['description']; ?></td>
		</tr>
	</tbody>
</table>

<div class="mini-layout">
	<h3>Teams</h3>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($teams as $team): ?>
				<tr>
					<td><a href="<?php echo ROOT . DS . 'teams' . DS . 'view' . DS . $team['id']; ?>"><?php echo $team['name']; ?></a></td>
					<td>
						<?php if(isset($_SESSION['team']) && $_SESSION['team']['id'] == $team['team_id']): ?>
						<a href="<?php echo ROOT . DS . 'activitys' . DS . 'unjoin' . DS .$activity['id']; ?>">Unjoin</a>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php if(!isset($_SESSION['team'])): ?>
		<a class="btn btn-primary" href="<?php echo ROOT . DS . 'teams' . DS . 'add'; ?>">Register New Team</a>
	<?php endif; ?>
</div>
