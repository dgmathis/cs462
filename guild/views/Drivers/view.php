<a class="btn btn-primary pull-right" href="<?php echo ROOT . DS . 'drivers' . DS . 'edit' . DS . $driver['id']; ?>">Edit Driver</a>
<h3>Registered Driver</h3>

<h4>Globally Unique ID</h4>
<p><?php echo $driver['guid']; ?>

<h4>Guild ESL For This Driver</h4>
<p><?php echo ESL . DS . 'driver' . DS . $driver['id']; ?></p>

<?php if(!empty($driver['esl'])): ?>
<h4>Driver ESL</h4>
<p><?php echo $driver['esl']; ?></p>
<?php endif; ?>

<h4>Rating</h4>
<p><?php echo $driver['rating']; ?></p>

