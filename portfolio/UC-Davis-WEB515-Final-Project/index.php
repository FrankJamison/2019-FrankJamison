<?php

ob_start();

// Debug Flag
$debug = false;

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '0');
$error_text = "";

// Includes
require_once("./includes/constants.inc.php");
require_once("./includes/variables.inc.php");
require_once("./includes/login.inc.php");

// Connect to Database
$dbc = mysqli_connect($host, $web_user, $pwd, $dbname)
	or die("Error connecting to database server");

// User login function
userLogin($dbc, $error_text, $ROOT);

// Switch to HTML to Display Output
?>

<!DOCTYPE html>
<html lang="en">

<head>

	<title>Quest Keeper - Home Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- Main CSS -->
	<link href="<?= $ROOT ?>/css/style.css" rel="stylesheet" type="text/css" media="all" />

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	<!-- Bootstrap JS -->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<!-- Main JS -->
	<script type="text/javascript" src="<?= $ROOT ?>/js/script.js"></script>

</head>

<body>

	<!-- Page Header -->
	<header id="header">
		<div class="home-header">

			<!-- Left Header Navigation -->
			<div class="header-left">
				<nav class="home-nav-text">
					<p><a href="<?= $ROOT ?>/index.php" title="Return Home">Home</a></p>
				</nav>
			</div>

			<!-- Right Header Login Form -->
			<div class="header-right">
				<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" id="login-form">
					<table>
						<tr>
							<!-- Registration Link -->
							<td><a href="register.php" class="register">Register</a></td>

							<!-- Registration Form Error Text -->
							<td><?= $error_text ?></td>

							<!-- Registration Form Input -->
							<td><input name="loginUsername" type="text" value="<?= $loginUsername ?>"
									placeholder="Username" class="login-field"></td>
							<td><input name="loginPassword" type="password" value="<?= $loginPassword ?>"
									placeholder="Password" class="login-field"></td>
							<td><input name="login" id="login" type="submit" value="Login"></td>
						</tr>
					</table>
				</form>
			</div>
			<div class="clearfix"></div>

			<!-- Main Navigation -->
			<nav class="home-navigation">
				<div class="left-navigation">&nbsp;</div>
				<div class="center-navigation">
					<h1><a href="<?= $ROOT ?>/index.php"><span>Quest<br>Keeper</span></a></h1>
				</div>
				<div class="right-navigation">&nbsp;</div>
			</nav>
		</div>
	</header>

	<!-- Main Content -->
	<main id="content">
		<div class="title-info">
			<h4>Quest Keeper Character Tracker </h4>
			<p>An All-in-One D&amp;D 5e Character Tracking Tool </p>
		</div>
	</main>

	<!-- Footer -->
	<footer id="footer">
		<p class="copyright"></p>
	</footer>
</body>

</html>

<!-- Close Database Connection -->
<?php
mysqli_close($dbc);
ob_end_flush();
?>