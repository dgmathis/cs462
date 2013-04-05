<?php

$username = '';
$userUrl = '#';
$loginStatus = 'login';
$loginUrl = ROOT . '/admin/login';

if(isset($_SESSION['admin'])) {
	$username = $_SESSION['admin']['username'];
	$userUrl = ROOT . '/admin';
	$loginStatus = 'logout';
	$loginUrl = ROOT . '/admin/logout';
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>CS462 Store site</title>
		<link rel="stylesheet" type="text/css" href="<?php echo SHARED; ?>/bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo SHARED; ?>/bootstrap/css/bootstrap-responsive.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo SHARED; ?>/bootstrap/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo SHARED; ?>/css/default.css" />
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo SHARED; ?>/bootstrap/js/bootstrap-timepicker.min.js"></script>
		<script type="text/javascript" src="<?php echo SHARED; ?>/bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="<?php echo ROOT; ?>">Flower Frenzy</a>
					<ul class="nav">
						<li>
							<a href="<?php echo ROOT . '/admin'; ?>">Admin</a>
						</li>
						<li>
							<a href="<?php echo ROOT . '/guilds'; ?>">Guilds</a>
						</li>
					</ul>
					<p class="navbar-text pull-right">
						<?php if(!empty($username)): ?><a href="<?php echo $userUrl; ?>"><?php echo $username; ?></a> | <?php endif; ?>
						<a href="<?php echo $loginUrl; ?>"><?php echo $loginStatus; ?></a> 
					</p>
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