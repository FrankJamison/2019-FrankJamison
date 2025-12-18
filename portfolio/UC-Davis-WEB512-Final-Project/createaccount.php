<?php

// Debug Flag
$debug = false;

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
$error_text = "\r";

// Variable Include
require_once("./includes/variables.inc.php");

// Connect to Database
$dbc = mysqli_connect($host, $web_user, $pwd, $dbname)
	or die('Error connecting to database server');

// Form display variable
$output_form = true;

// Form Input Variables
$employeeNumber = '';
$lastName = '';
$firstName = '';
$email = '';
$username = '';
$password = '';
$md5hashpwd = '';

if (isset($_POST['submit'])) { // data posted

	// If debug flag is set to true
	if ($debug) {

		// Display text input
		echo "<pre>";
		print_r($_POST);
		echo "</pre>";

		// die("temp stop point");
	} // End debug only

	// Get Form Input
	$employeeNumber = trim(mysqli_real_escape_string($dbc, $_POST['empnum']));
	$lastName = trim(mysqli_real_escape_string($dbc, $_POST['lname']));
	$firstName = trim(mysqli_real_escape_string($dbc, $_POST['fname']));
	$email = trim(mysqli_real_escape_string($dbc, $_POST['email']));
	$username = trim(mysqli_real_escape_string($dbc, $_POST['uname']));
	$password = trim(mysqli_real_escape_string($dbc, $_POST['pwd']));

	// Check for Empty Fields
	if (
		empty($_POST['empnum']) ||
		empty($_POST['lname']) ||
		empty($_POST['fname']) ||
		empty($_POST['email']) ||
		empty($_POST['uname']) ||
		empty($_POST['pwd'])
	) {

		// Error Text
		$error_text .= "\t\t\t\t\t<p>All fields are mandatory.</p>\r";

		// Display Form
		$output_form = true;

	} else {

		// Check for Existing Employee Number
		$queryEmployeeNumber = "SELECT * from employees where employeeNumber ='$employeeNumber'";
		$resultEmployeeNumber = mysqli_query($dbc, $queryEmployeeNumber);

		// Check for Existing Username
		$queryUsername = "SELECT * from employees where username ='$username'";
		$resultUsername = mysqli_query($dbc, $queryUsername);

		// If the employee numbe ror username are not unique, display error message
		if (mysqli_num_rows($resultEmployeeNumber) > 0 || mysqli_num_rows($resultUsername) > 0) {
			if (mysqli_num_rows($resultEmployeeNumber) > 0) {
				$error_text .= "\t\t\t\t\t<p>Employee number must be unique.</p>\r";
			}

			if (mysqli_num_rows($resultUsername) > 0) {
				$error_text .= "\t\t\t\t\t<p>Username must be unique.</p>\r";
			}

			// Display Form
			$output_form = true;

		} else { // Employee number and username are unique

			// Create MD5 Password Hash
			$md5hashpwd = md5($password);

			// Insert Query
			$sql = "INSERT INTO employees (employeeNumber, lastName, firstName, email, username, password) 
					VALUES ('$employeeNumber', '$lastName', '$firstName', '$email', '$username', '$md5hashpwd')";

			// Insert Form Data Into Database
			if (mysqli_query($dbc, $sql)) {
				echo "Records inserted successfully.";
			} else {
				echo "ERROR: Could not able to execute $sql. " . mysqli_error($dbc);
			}

			// Do not display form
			$output_form = false;

		} // End if/else duplicate field validation
	} // End if/else field validation
} // End isset($_POST['submit'])

// Switch to HTML to Display Output
?>
<!doctype html>
<html>
<!-- HTML Head Section Include -->
<?php require_once("./includes/htmlhead.inc.php"); ?>

<body>
	<div id="main">

		<!-- Page Header -->
		<div id="header">

			<!-- Page Logo -->
			<?php require_once("./includes/logo.inc.php"); ?>

			<!-- Page Navigation -->
			<div id="menubar">
				<ul id="menu">
					<li><a href="index.php">Home</a></li>
					<li class="selected"><a href="createaccount.php">Create Account</a></li>
					<li><a href="login.php">Login</a></li>
				</ul>
			</div>
		</div>

		<div id="site_content">

			<!-- Page Content -->
			<div id="content">

				<!-- Form Output -->
				<?php if ($output_form) { ?>

					<h2>New Employee Creation Form</h2>

					<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

						<?= $error_text ?>

						<br>

						<table>
							<tr>
								<td>Employee Number: </td>
								<td><input name="empnum" type="text" value="<?= $employeeNumber ?>"></td>
							</tr>

							<tr>
								<td>First Name: </td>
								<td><input name="fname" type="text" value="<?= $firstName ?>"></td>
							</tr>

							<tr>
								<td>Last Name: </td>
								<td><input name="lname" type="text" value="<?= $lastName ?>"></td>
							</tr>

							<tr>
								<td>Email: </td>
								<td><input name="email" type="email" value="<?= $email ?>"></td>
							</tr>

							<tr>
								<td>Username: </td>
								<td><input name="uname" type="text" value="<?= $username ?>"></td>
							</tr>

							<tr>
								<td>Password: </td>
								<td><input name="pwd" type="password" value="<?= $password ?>"></td>
							</tr>
						</table>

						<input name="submit" id="submit" type="submit">
					</form>

				<?php } else { // No Form Output ?>

					<h2>Thank you for adding yourself as an employee!</h2>

					<!-- Redirect to Login Page -->
					<?php header('Refresh: 5; ./login.php'); ?>

					<!-- End if/else Form Output -->
				<?php } ?>
			</div>

		</div>

		<!-- Page Footer -->
		<?php require_once("./includes/footer.inc.php"); ?>
	</div>
</body>

</html>

<?php
// Close Database Connection
mysqli_close($dbc);
?>