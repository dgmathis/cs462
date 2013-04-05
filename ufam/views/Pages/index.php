
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
					<td><a href="<?php echo ROOT . DS . 'drivers' . DS . 'view' . DS . $activity['id']; ?>"><?php echo $activity['title']; ?></a></td>
					<td><?php echo $activity['date']; ?></td>
					<td><?php echo $activity['location']; ?></td>
					<td><?php echo $activity['description']; ?></td>
					<td>
						<a href="<?php echo ROOT . DS . 'drivers' . DS . 'edit' . DS . $activity['id']; ?>">Edit</a> | 
						<a href="<?php echo ROOT . DS . 'drivers' . DS . 'delete' . DS .$activity['id']; ?>">Delete</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<a class="btn btn-primary" href="<?php echo ROOT . DS . 'activitys' . DS . 'add'; ?>">Create New Activity</a>
</div>