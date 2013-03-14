<?php if(isset($message)): ?>
<div class="alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?php echo $message; ?>
</div>
<?php endif; ?>

<h3>Request Delivery</h3>

<form method="POST" action="">
	<div>
		<label>Shop Address</label>
		<input type="text" name="pickup_address" />
	</div>
	<div class="input-append bootstrap-timepicker">
		<label>Pickup Time</label>
		<input type="text" name="pickup_time" class="input-small" />
		<span class="add-on"><i class="icon-time"></i></span>
	</div>
	<div>
		<label>Delivery Address</label>
		<input type="text" name="delivery_address" />
	</div>
	<div class="input-append bootstrap-timepicker">
		<label>Delivery Time</label>
		<input type="text" name="delivery_time" class="input-small" />
		<span class="add-on"><i class="icon-time"></i></span>
	</div>
	<div>
		<input type="submit" class="btn" value="Request Delivery" />
	</div>
</form>

<script type="text/javascript">
	$('input[name="pickup_time"], input[name="delivery_time"]').timepicker();
</script>