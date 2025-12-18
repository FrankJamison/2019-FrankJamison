<?php
// Start and Check for Valid Session
require_once("../includes/session.inc.php");

// Set Local Member Name to Say Goodbye
$member_name = $_SESSION['member_name'];

// Clear All Session Variables
$_SESSION = array();

// Check for Session Cookie
if (isset($_COOKIE[session_name()])) {

	// Delete Session Cookie
	setcookie(session_name(), '', time() - 3600);
}

// Destroy Session
session_destroy();

// Redirect to Public Page
header('Refresh: 8; ../index.php');
?>

<!DOCTYPE HTML>
<html>

<?php require_once("../includes/memberhtmlhead.inc.php"); ?>

<body>
	<div id="main">
		<div id="header">

			<!-- Page Logo -->
			<?php require_once("../includes/logo.inc.php"); ?>

			<div id="menubar">
				<ul id="menu">
					<li><a href="index.php">Home</a></li>
					<li><a href="addcustomer.php">Add Customer</a></li>
					<li><a href="creditlimits">Credit Limit Report</a></li>
					<li><a href="inventory.php">Product Inventory Report</a></li>
					<li class="selected"><a href="logout.php">Log Out</a></li>
				</ul>
			</div>

		</div>

		<div id="site_content">

			<!-- Page Content -->
			<div id="content">
				<h2>Employee Logout - Goodbye</h2>

				<div>
					<p>Thank you for logging out <?= $member_name; ?></p>
				</div>
			</div>

		</div>

		<!-- Page Footer -->
		<?php require_once("../includes/footer.inc.php"); ?>

	</div>
</body>

</html>