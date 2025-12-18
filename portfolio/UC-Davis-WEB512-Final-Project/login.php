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
$username = '';
$password = '';
$md5hashpwd = '';

// Database Login Data Query
$query = "SELECT `username` , `password`
		FROM `employees`";
$result = mysqli_query($dbc, $query) or die('Error querying database');

// Database Variables
$stored_username = '';
$stored_password = '';

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
	$username = trim(mysqli_real_escape_string($dbc, $_POST['uname']));
	$password = trim(mysqli_real_escape_string($dbc, $_POST['pwd']));
	$md5hashpwd = md5($password);

	// Find Stored Username and Password
	while ($row = mysqli_fetch_array($result)) {
		if ($username == $row['username']) {
			$stored_username = $row['username'];
			$stored_password = $row['password'];
			break;
		}
	}

	// Check for authenticated user
	if ($username == $stored_username && $md5hashpwd == $stored_password) {

		// Start Session
		session_start();

		// Create Session Variables
		$_SESSION['member_name'] = $username;
		$_SESSION['member_id'] = $md5hashpwd;

		// Redirect to Members Area
		header('Location: ./members/index.php');
	}

	// Check for Empty Fields
	if (
		empty($_POST['uname']) ||
		empty($_POST['pwd'])
	) {

		// Error Text
		$error_text .= "\t\t\t\t\t<p>All fields are mandatory.</p>\r";

		// Display Form
		$output_form = true;

	} else { // Username/Password Mismatch

		// Error Text
		$error_text .= "\t\t\t\t\t<p>The username and password you entered do not match our records.</p>\r";

		// Do not display form
		$output_form = true;

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
					<li><a href="createaccount.php">Create Account</a></li>
					<li class="selected"><a href="login.php">Login</a></li>
				</ul>
			</div>
		</div>

		<div id="site_content">

			<!-- Page Content -->
			<div id="content">

				<!-- Form Output -->
				<?php if ($output_form) { ?>

					<h2>Login Page</h2>

					<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

						<?= $error_text ?>

						<br>

						<table>
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

				<?php } // End if Form Output ?>
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