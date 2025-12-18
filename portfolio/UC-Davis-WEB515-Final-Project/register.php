<?php

// Functions Include
require_once("./includes/constants.inc.php");
require_once("./includes/functions.inc.php");
require_once("./includes/login.inc.php");
require_once("./includes/variables.inc.php");
require_once("./includes/registration.inc.php");


// Debug Flag
$debug = false;

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '0');
$error_text = "";
$registration_error_text = "";

// Connect to Database
$dbc = mysqli_connect($host, $web_user, $pwd, $dbname)
	or die('Error connecting to database server');

// Form display variable
$login_form = true;
$registration_form = true;

userLogin($dbc, $error_text, $ROOT);

userRegistration($dbc, $registration_error_text, $registration_form);

// Switch to HTML to Display Output
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Quest Keeper - Member Registration</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
		integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Main CSS -->
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
	<header id="header">
		<div class="home-header">
			<div class="header-left">
				<div class="home-nav-text">
					<p><a href="<?= $ROOT ?>/index.php" title="Return Home">Home</a></p>
				</div>
			</div>

			<div class="header-right">
				<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" id="login-form">
					<table>
						<tr>
							<td><a href="register.php" class="register">Register</a></td>
							<td><?= $error_text ?></td>
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

	<main id="content">
		<div class="registration-info">
			<!-- Form Output -->
			<?php if ($registration_form) { ?>
				<h2>Registration Form</h2>

				<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

					<div class="errorText"><?= $registration_error_text ?></div>

					<br>

					<table>
						<tr>
							<td>First Name: </td>
							<td><input name="registrationFirstName" type="text" value="<?= $registrationFirstName ?>"></td>
						</tr>

						<tr>
							<td>Last Name: </td>
							<td><input name="registrationLastName" type="text" value="<?= $registrationLastName ?>"></td>
						</tr>

						<tr>
							<td>Email Address: </td>
							<td><input name="registrationEmailAddress" type="email"
									value="<?= $registrationEmailAddress ?>"></td>
						</tr>

						<tr>
							<td>Username: </td>
							<td><input name="registrationUsername" type="text" value="<?= $registrationUsername ?>"></td>
						</tr>

						<tr>
							<td>Password: </td>
							<td><input name="registrationPassword" type="password" value="<?= $registrationPassword ?>">
							</td>
						</tr>
					</table>

					<input name="register" id="register" type="submit" value="Register">
				</form>
			<?php } else { // No Form Output ?>

				<h2>Thank you for registering with Quest Keeper!</h2>

				<!-- Redirect to Login Page -->
				<?php header("Refresh: 5; $ROOT/index.php"); ?>

				<!-- End if/else Form Output -->
			<?php } ?>

		</div>
	</main>

	<footer id="footer">
		<p class="copyright">&copy; 2018 - Frank Jamison</p>
	</footer>
</body>

</html>