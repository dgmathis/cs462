<a class="btn btn-primary pull-right" href="<?php echo ROOT . DS . 'guilds' . DS . 'edit' . DS . $guild['id']; ?>">Edit Guild</a>
<h3><?php echo $guild['name']; ?></h3>

<h4>Guild ESL</h4>
<p><?php echo $guild['esl']; ?></p>

<h4>Driver ESL For This Guild</h4>
<p><?php echo ESL . DS . 'guild' . DS . $guild['id']; ?></p>

