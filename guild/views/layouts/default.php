<?php

$username = '';
$userUrl = '#';
$loginStatus = 'login';
$loginUrl = ROOT . '/users/login';

if(isset($_SESSION['user'])) {
	$username = $_SESSION['user']['username'];
	$userUrl = ROOT . '/users/view/' . $_SESSION['user']['id'];
	$loginStatus = 'logout';
	$loginUrl = ROOT . '/users/logout';
}
		
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>CS462 Guild site</title>
		<link rel="stylesheet" type="text/css" href="<?php echo SHARED; ?>/bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo SHARED; ?>/bootstrap/css/bootstrap-responsive.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo SHARED; ?>/bootstrap/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo SHARED; ?>/css/default.css" />
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo SHARED; ?>/bootstrap/js/bootstrap-timepicker.min.js"></script>
		<script type="text/javascript" src="<?php echo SHARED; ?>/bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="navbar navbar-grey navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="<?php echo ROOT; ?>">Guild Frenzy</a>
					<ul class="nav">
						<li>
							<a href="<?php echo ROOT . '/stores'; ?>">Stores</a>
						</li>
						<li>
							<a href="<?php echo ROOT . '/drivers'; ?>">Drivers</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
			<div class="span12">
				<?php echo $content_for_layout; ?>
			</div>
			</div>
		</div>
	</body>
	
</html>