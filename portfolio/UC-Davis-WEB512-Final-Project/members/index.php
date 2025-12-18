<?php

// Start and Check for Valid Session
require_once("../includes/session.inc.php");

?>

<!DOCTYPE HTML>
<html>

<!-- HTML Head Include -->
<?php require_once("../includes/memberhtmlhead.inc.php"); ?>

<body>
	<div id="main">

		<!-- Page Header -->
		<div id="header">

			<!-- Page Logo -->
			<?php require_once("../includes/logo.inc.php"); ?>

			<!-- Page Navigation -->
			<div id="menubar">
				<ul id="menu">
					<li class="selected"><a href="index.php">Home</a></li>
					<li><a href="addcustomer.php">Add Customer</a></li>
					<li><a href="creditlimits.php">Credit Limit Report</a></li>
					<li><a href="inventory.php">Product Inventory Report</a></li>
					<li><a href="logout.php">Log Out</a></li>
				</ul>
			</div>

		</div>

		<div id="site_content">

			<!-- Page Content -->
			<div id="content">
				<h2>Welcome to Frank's Classic Cars Employee Access Page</h2>
				<p>Hello <?= $_SESSION['member_name']; ?></p>
				<p>Use the main navigation to do any of the following tasks:</p>
				<ul>
					<li>Add a new customer to the database</li>
					<li>View a customer credit limit report</li>
					<li>View a product inventory report</li>
					<li>Log out of the employee access page</li>
				</ul>
			</div>

		</div>

		<!-- Page Footer -->
		<?php require_once("../includes/footer.inc.php"); ?>

	</div>
</body>

</html>