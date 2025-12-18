<?php

ob_start();

// Includes
require_once('../includes/constants.inc.php');
require_once('../includes/variables.inc.php');
require_once('../includes/session.inc.php');

// Set Local Member Name to Say Goodbye
$member_name = $_SESSION['memberUsername'];

// Clear All Session Variables
$_SESSION = array();

// Check for Session Cookie
if (isset($_COOKIE[session_name()])) {

	// Delete Session Cookie
	setcookie(session_name(), '', time() - 3600);
}

// Destroy Session
session_destroy();

// Redirect toPublic Page
header("Refresh: 8; $ROOT/index.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Quest Keeper - Logout</title>
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
					<p><a href="<?= $ROOT ?>/members/index.php" title="Return to Member Home">Home</a></p>
				</nav>
			</div>

			<!-- Right Header Login Form -->
			<div class="header-right"></div>
			<div class="clearfix"></div>

			<!-- Main Navigation -->
			<nav class="home-navigation">
				<div class="left-navigation">&nbsp;</div>
				<div class="center-navigation">
					<h1><a href="<?= $ROOT ?>/members/index.php"><span>Quest<br>Keeper</span></a></h1>
				</div>
				<div class="right-navigation">&nbsp;</div>
			</nav>
		</div>
	</header>

	<main id="content">
		<div class="title-info">
			<h4>Members Logout - Goodbye </h4>
			<p>Thank you for logging out <?= $member_name; ?> </p>
		</div>
	</main>

	<footer id="footer">
		<p class="copyright"></p>
	</footer>
</body>

</html>

<?php
ob_end_flush();
?>