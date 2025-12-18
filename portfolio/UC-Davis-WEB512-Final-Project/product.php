<?php

// Site Variables and Functions Includes
require_once("./includes/variables.inc.php");

// Connection to Database
$dbc = mysqli_connect($host, $web_user, $pwd, $dbname)
	or die('Error connecting to database server');

// Output Variable
$output = 'No Product Information';

// GET Product Information
if (isset($_GET['pid'])) {

	// Set Product Number
	$productNumber = trim($_GET['pid']);

	// Database Query
	$query = "SELECT * 
			FROM products 
			WHERE productCode = '$productNumber'";

	// Database Query Result
	$result = mysqli_query($dbc, $query)
		or die("Error querying database => $query");

	// Number of Rows in Query Results
	$numRows = mysqli_num_rows($result);

	// Create Page Content Code
	if ($numRows != 0) {

		while ($row = mysqli_fetch_array($result)) {

			// Product Variables
			$productCode = $row['productCode'];
			$productName = $row['productName'];
			$productLine = $row['productLine'];
			$productScale = $row['productScale'];
			$productVendor = $row['productVendor'];
			$productDescription = $row['productDescription'];
			$quantityInStock = $row['quantityInStock'];
			$butPrice = $row['buyPrice'];
			$msrp = $row['MSRP'];

			// Product Output Code
			$output = "<p><strong><em>Product:</em></strong> $productCode</p>
					<p><strong><em>Name:</em></strong> $productName</p>
					<p><strong><em>Product Line:</em></strong> $productLine</p>
					<p><strong><em>Product Scale:</em></strong> $productScale</p>
					<p><strong><em>Product Vendor:</em></strong> $productVendor</p>
					<p><strong><em>Product Description:</em></strong> $productDescription</p>";

		} // End Product Output While Statement

	} else { // No Match Found

		$output = "No Match Found.";

	} // End Page Content If/Else Statement

} // End If Isset
?>

<!DOCTYPE HTML>
<html>

<!-- HTML Head Include -->
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
					<li><a href="autorss.php?pl=classic">Classic RSS</a></li>
					<li><a href="autorss.php?pl=vintage">Vintage RSS</a></li>
					<li><a href="autorss.php?pl=motorcycle">Motorcycle RSS</a></li>
					<li><a href="createaccount.php">Create Account</a></li>
					<li><a href="login.php">Login</a></li>
				</ul>
			</div>

		</div>

		<div id="site_content">

			<!-- Page Content -->
			<div id="content">

				<h2>Product Details: <?= $productName ?></h2>

				<div>
					<?= $output ?>
				</div>
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