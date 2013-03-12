<h3><?php echo $data['firstname'] . ' ' . $data['lastname']; ?></h3>

<?php if(!empty($data['last_checkin_lat']) && !empty($data['last_checkin_lng'])): ?>
<div>
	<span>Last Checkin: </span>
	<span><?php echo $data['last_checkin_lat'] . ' ' . $data['last_checkin_lng']; ?></span>
</div>
<?php endif; ?>

<?php if(empty($data['fs_access_token'])): ?>
<a class="btn btn-primary" href="<?php echo ROOT . DS . 'settings' . DS . 'auth_foursquare'; ?>">Authenticate with Foursquare</a></p>
<?php endif; ?>
